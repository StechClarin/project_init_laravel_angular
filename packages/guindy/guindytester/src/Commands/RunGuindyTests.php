<?php

namespace Guindy\GuindyTester\Commands;

use Illuminate\Console\Command;
use Guindy\GuindyTester\Core\RestTester;
use Guindy\GuindyTester\Core\GraphQLTester;
use Exception;

class RunGuindyTests extends Command
{
    /**
     * Nom de la commande artisan.
     *
     * @var string
     */
    protected $signature = 'guindytester:run {--only=} {--with-debug}';

    /**
     * Description de la commande.
     *
     * @var string
     */
    protected $description = 'Lance les tests automatisés GuindyTester sur les routes REST';

    /**
     * Exécution de la commande.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Lancement des tests GuindyTester...');

        try {
            $only = $this->option('only');
            $debug = $this->option('with-debug');

            $modifiedFiles = explode("\n", trim(shell_exec('git diff --name-only HEAD~1 HEAD')));
            $entitiesToTest = [];

            foreach ($modifiedFiles as $file) {
                if (preg_match('#app/Http/Controllers/(\w+)Controller\.php$#', $file, $matches)) {
                    $entitiesToTest[] = strtolower($matches[1]);
                }
            }

            $restTester = new RestTester($entitiesToTest);
            $restTester->runTests();

            $graphqlTester = new GraphQLTester(/* ...arguments si besoin... */);
            $graphqlTester->runTests();



            $this->info(' Tous les tests REST & GraphQL ont été exécutés avec succès.');
        } catch (Exception $e) {
            $this->error(' Erreur pendant les tests : ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
