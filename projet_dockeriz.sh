# ───────────────────────────────────────────────────────────────
# Script : projet_dockeriz.sh
# But    : adapter.env pour docker, generer docker-compose.yml & Dockerfile
# Exemple d'utilisation :
#    chmod +x projet_dockeriz.sh
#   ./projet_dockeriz.sh mon_projet 8080 5432 6379
# 
# ───────────────────────────────────────────────────────────────

# ─── Vérification des arguments ───────────────────────────────
if [ "$#" -ne 4 ]; then
  echo "Usage: $0 nom_projet port_http port_pg port_redis"
  exit 1
fi

PROJET="$1"
PORT_HTTP="$2"
PORT_PG="$3"
PORT_REDIS="$4"

ENV_FILE=".env"
COMPOSE_FILE="docker-compose.yml"
DOCKERFILE="Dockerfile"

# ─── verification dde.env ───────────────────────────────────────
if [ ! -f "$ENV_FILE" ]; then
  echo " Fichier .env introuvable !"
  exit 1
fi

# Modification des variables dans le .env
sed -i "s|^APP_URL=.*|APP_URL=http://localhost:$PORT_HTTP/|" $ENV_FILE
sed -i "s|^DB_HOST=.*|DB_HOST=${PROJET}_pgsql|" $ENV_FILE
sed -i "s|^REDIS_HOST=.*|REDIS_HOST=${PROJET}_redis|" $ENV_FILE



# ─── Déterminer la version PHP requise ─────────────────────────
PHP_VERSION="7.3"
COMPOSER_JSON="composer.json"
if [ -f "$COMPOSER_JSON" ]; then
  REQUIRED=$(grep -Po '"php":\s*"\^?([^"]+)"' "$COMPOSER_JSON" | head -1 | grep -Po '[0-9]+\.[0-9]+')
  if [[ "$REQUIRED" == "7.3"* ]]; then
    PHP_VERSION="7.3"
  elif [[ "$REQUIRED" == "7.4"* ]]; then
    PHP_VERSION="7.4"
  elif [[ "$REQUIRED" == "8.0"* ]]; then
    PHP_VERSION="8.0"
  elif [[ "$REQUIRED" == "8.1"* ]]; then
    PHP_VERSION="8.1"
  elif [[ "$REQUIRED" == "8.2"* ]]; then
    PHP_VERSION="8.2"
  elif [[ "$REQUIRED" == "8.3"* ]]; then
    PHP_VERSION="8.3"
  fi
fi

# ─── Commnter track_errors dans php.ini si PHP > 7.4 ────────────
PHP_INI_LOCAL="./php.ini"

if dpkg --compare-versions "$PHP_VERSION" "gt" "7.4"; then
  echo "🔧 PHP version $PHP_VERSION > 7.4 → on commente track_errors dans php.ini"
  if [ -f "$PHP_INI_LOCAL" ]; then
    sed -i 's/^track_errors=On/;track_errors=On/' "$PHP_INI_LOCAL"
  fi
fi


# ─── Génération du docker-compose.yml ──────────────────────────
cat > $COMPOSE_FILE <<EOF
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: ${PROJET}_laravel_app
    ports:
      - "$PORT_HTTP:80"
    volumes:
      - .:/var/www/html
      - storage_data:/var/www/html/storage
      - bootstrap_cache:/var/www/html/bootstrap/cache
    depends_on:
      - postgres

  postgres:
    image: postgres:14
    container_name: ${PROJET}_pgsql
    restart: unless-stopped
    environment:
      POSTGRES_DB: ${PROJET}
      POSTGRES_USER: postgres
      POSTGRES_PASSWORD: root
    ports:
      - "$PORT_PG:5432"
    volumes:
      - pgdata:/var/lib/postgresql/data

  redis:
    image: redis:alpine
    container_name: ${PROJET}_redis
    ports:
      - "$PORT_REDIS:6379"
    restart: unless-stopped

  node:
    image: node:14
    container_name: ${PROJET}_node
    working_dir: /app
    volumes:
      - .:/app
    command: tail -f /dev/null
    tty: true

volumes:
  pgdata:
  storage_data:
  bootstrap_cache:
EOF

# ─── génération du Dockerfile basique ───────────────
if [ ! -f "$DOCKERFILE" ]; then
cat > $DOCKERFILE <<EOF
FROM php:$PHP_VERSION-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        mbstring \
        zip \
        gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

COPY apache/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY . .

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache
EOF

    # Ajout conditionnel de php.ini
    if [ -f "php.ini" ]; then
        echo "COPY php.ini /usr/local/etc/php/conf.d/99-custom.ini" >> $DOCKERFILE
        echo "✅ php.ini détecté et intégré dans le Dockerfile."
    else
        echo "⚠️ Aucun php.ini trouvé, ligne COPY ignorée."
    fi

    echo "EXPOSE 80" >> $DOCKERFILE
fi


# ─── Génération du fichier de configuration Apache ──────────────
VHOST_FILE="apache/vhost.conf"
mkdir -p apache

if [ ! -f "$VHOST_FILE" ]; then
cat > "$VHOST_FILE" <<EOF
<VirtualHost *:80>
    ServerName localhost
    ServerAdmin webmaster@localhostsudo systemctl stop docker

    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF
    echo "Fichier apache/vhost.conf généré automatiquement."
else
    echo "apache/vhost.conf existe déjà, non modifié."
fi

# ─── Build Docker ───────────────────────────────────────────────
echo "\n Construction de l'image Docker..."
docker compose up -d --build


# ─── Génération du .gitlab-ci.yml ──────────────────────────── 
CIFILE=".gitlab-ci.yml"

if [ ! -f "$CIFILE" ]; then
cat > "$CIFILE" <<EOF
stages:
  - install
  - test
  - build
  - deploy

variables:
  DOCKER_DRIVER: overlay2
  DB_CONNECTION: pgsql
  DB_HOST: postgres
  DB_PORT: 5432
  DB_DATABASE: ${PROJET}
  DB_USERNAME: postgres
  DB_PASSWORD: root

install:
  stage: install
  image: php:${PHP_VERSION}
  script:
    - composer install --no-interaction --prefer-dist
    - npm install

test_rest:
  stage: test
  image: php:${PHP_VERSION}
  services:
    - postgres:14
  script:
    - php artisan migrate --env=testing
    - php artisan guindytester:run --only=rest || exit 1
  only:
    changes:
      - app/Http/Controllers/**
      - routes/web.php
      - tests/Feature/RestTest.php

test_graphql:
  stage: test
  image: php:${PHP_VERSION}
  services:
    - postgres:14
  script:
    - php artisan migrate --env=testing
    - php artisan guindytester:run --only=graphql || exit 1
  only:
    changes:
      - app/GraphQL/**
      - routes/graphql.php
      - tests/Feature/GraphQLTest.php

build:
  stage: build
  image: docker:latest
  services:
    - docker:dind
  script:
    - docker build -t ${PROJET}_app .

deploy:
  stage: deploy
  image: alpine:latest
  script:
    - echo "Déploiement sur serveur de staging..."
    # - ssh user@staging-server 'cd /path/to/${PROJET} && git pull && php artisan migrate'
EOF

echo "✅ Fichier .gitlab-ci.yml généré avec logique de tests optimisés."
else
echo "ℹ️ .gitlab-ci.yml existe déjà, non modifié."
fi




# ─── Résumé ─────────────────────────────────────────────────────
echo "\n Projet Dockerisé: $PROJET"
echo "Accès Laravel:     http://localhost:$PORT_HTTP/"
echo "PostgreSQL:        localhost:$PORT_PG (DB = $PROJET)"
echo "Redis:             localhost:$PORT_REDIS"
echo "Docker Compose:    $COMPOSE_FILE"
echo "Dockerfile:        $DOCKERFILE"
echo "PHP utilisé:       php:$PHP_VERSION-apache"

echo "Conteneurs générés:"
echo "   -- ${PROJET}_laravel_app"
echo "   -- ${PROJET}_pgsql"
echo "   -- ${PROJET}_redis"
echo "   -- ${PROJET}_node"

echo "\n Pour entrer dans le conteneur Laravel :"
echo "   docker exec -it ${PROJET}_laravel_app bash"
echo "\n Vous serez dans : /var/www/html"
echo "   Si la commande fonctionne, tout est prêt !"

