<?php

namespace Guindy\GuindyTester\Core;

use Illuminate\Support\Facades\File;
use Guindy\GuindyTester\Contracts\TesterInterface;
use Guindy\GuindyTester\Results\TestError;
use Guindy\GuindyTester\Results\TestResultFormatter;
use Guindy\GuindyTester\Helpers\HttpHelper;

class RestTester implements TesterInterface
{
    protected string $controllerPath;
    protected array $dbInfo;
    protected array $errors = [];
    protected array $createdEntities = [];
    protected array $entitiesToTest = []; // Ajout

    public function __construct(array $entitiesToTest = [])
    {
        $this->controllerPath = app_path('Http/Controllers');
        $this->dbInfo = config('guindytester_db_info') ?? [];
        $this->entitiesToTest = $entitiesToTest;
    }

    public function runTests(): void
    {
        $controllers = $this->getControllers();

        foreach ($controllers as $controller) {
            $entity = $this->extractEntityName($controller);
            $tableInfo = $this->dbInfo[$entity] ?? [];

            echo " [$entity] Début du test (REST: POST & PUT) ...\n";

            $payload = $this->generateFakeData($entity);
            $this->handleForeignKeys($entity, $payload);

            // CREATE
            $postRoute = "/$entity/save";
            $postResponse = HttpHelper::post($postRoute, $payload);

            $createdId = $postResponse->json()['id'] ?? null;

            if ($postResponse->successful() && $createdId) {
                echo "[$entity] Création réussie (ID: $createdId).\n";
                $this->createdEntities[$entity] = $createdId;
            } else {
                echo "[$entity] Échec de la création.\n";
                $this->logError($entity, 'POST', $postRoute, $payload, $postResponse);
                continue;
            }

            // UPDATE
            $updateRoute = "/$entity/update/$createdId";
            $updatePayload = $payload;
            $updatePayload['nom'] .= ' (modifié)';
            $putResponse = HttpHelper::put($updateRoute, $updatePayload);

            if ($putResponse->successful()) {
                echo "[$entity] Mise à jour réussie.\n";
            } else {
                echo "[$entity] Échec de la mise à jour.\n";
                $this->logError($entity, 'PUT', $updateRoute, $updatePayload, $putResponse);
            }
        }
    }

    public function runDeleteAfterGraphQL(): void
    {
        echo "\n🧹 Suppression des entités après tests GraphQL...\n";

        foreach ($this->createdEntities as $entity => $id) {
            $deleteRoute = "/$entity/delete/$id";
            $deleteResponse = HttpHelper::delete($deleteRoute);

            if ($deleteResponse->successful()) {
                echo " [$entity] Suppression réussie.\n";
            } else {
                echo " [$entity] Échec de la suppression.\n";
                $this->logError($entity, 'DELETE', $deleteRoute, [], $deleteResponse);
            }
        }

        TestResultFormatter::logErrors($this->errors);
    }

    public function cleanup(): void
    {
        $this->runDeleteAfterGraphQL();
    }

    protected function getControllers(): array
    {
        $allControllers = File::files($this->controllerPath);
        $filtered = [];

        foreach ($allControllers as $controller) {
            $entity = $this->extractEntityName($controller->getFilename());
            if (empty($this->entitiesToTest) || in_array($entity, $this->entitiesToTest)) {
                $filtered[] = $controller;
            }
        }
        return $filtered;
    }

    protected function extractEntityName(string $controllerFile): string
    {
        return strtolower(str_replace('Controller.php', '', $controllerFile));
    }

    protected function generateFakeData(string $entity): array
    {
        return ['nom' => ucfirst($entity) . ' Test'];
    }

    protected function handleForeignKeys(string $entity, array &$payload): void
    {
        $foreignKeys = $this->dbInfo[$entity]['foreignids'] ?? [];

        foreach ($foreignKeys as $foreignKey => $foreignEntity) {
            $id = $this->ensureForeignEntityExists($foreignEntity);
            $payload[$foreignKey] = $id;
        }
    }

    protected function ensureForeignEntityExists(string $entity): int
    {
        $sample = ['nom' => ucfirst($entity) . ' dépendance'];
        $route = "/$entity/save";

        $response = HttpHelper::post($route, $sample);

        if ($response->failed()) {
            echo " Erreur lors de la création de '$entity' (clé étrangère)\n";
            return 0;
        }

        return $response->json()['id'] ?? 1;
    }

    protected function logError(string $entity, string $method, string $route, array $payload, $response): void
    {
        $this->errors[] = new TestError(
            route: $route,
            method: $method,
            errorMessage: $response->body(),
            statusCode: $response->status(),
            payload: $payload
        );
    }
}
