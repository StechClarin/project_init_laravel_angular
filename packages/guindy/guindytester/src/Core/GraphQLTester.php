<?php

namespace Guindy\GuindyTester\Core;

use Illuminate\Support\Facades\File;
use Guindy\GuindyTester\Contracts\TesterInterface;
use Guindy\GuindyTester\Helpers\HttpHelper;
use Guindy\GuindyTester\Results\TestError;
use Guindy\GuindyTester\Results\TestResultFormatter;

class GraphQLTester implements TesterInterface
{
    protected string $queryPath;
    protected string $typePath;
    protected array $errors = [];
    protected string $endpoint;
    protected array $dbInfo;

    public function __construct()
    {
        $this->queryPath = app_path('GraphQL/Queries');
        $this->typePath = app_path('GraphQL/Types');
        $this->endpoint = config('guindytester.graphql_endpoint', '/graphql');
        $this->dbInfo = config('guindytester_db_info');
    }

    public function runTests(): void
    {
        foreach ($this->dbInfo as $entity => $info) {
            $queryClass = ucfirst($entity) . 'Query.php';
            $typeClass = ucfirst($entity) . 'Type.php';

            if (!File::exists("{$this->queryPath}/{$queryClass}") || !File::exists("{$this->typePath}/{$typeClass}")) {
                echo "Skip $entity (Query ou Type manquant)\n";
                continue;
            }

            echo "\n🔍 Test GraphQL: $entity (list & filteredList)...\n";
            $this->testGraphQLQuery("{$entity}s", 'list', $entity);
            $this->testGraphQLQuery("filtered{$entity}s", 'filteredList', $entity);
        }

        // À la fin, centralise le reporting :
        TestResultFormatter::logErrors($this->errors);
    }

    protected function testGraphQLQuery(string $queryName, string $label, string $entity): void
    {
        $fields = $this->extractFieldsFromType($entity);

        $query = [
            'query' => "query { {$queryName}(first: 3, page: 1) { data { {$fields} } } }"
        ];

        $response = HttpHelper::post($this->endpoint, $query);

        if ($response->successful()) {
            echo "[$entity → $label] OK\n";
        } else {
            echo "[$entity → $label] FAIL\n";
            $error = new TestError(
                route: $this->endpoint,
                method: 'POST',
                errorMessage: $response->body(),
                statusCode: $response->status(),
                payload: $query
            );
            // Lorsqu'une erreur est détectée :
            $this->errors[] = $error;
        }
    }

    protected function extractFieldsFromType(string $entity): string
    {
        $typeFile = "{$this->typePath}/" . ucfirst($entity) . 'Type.php';

        if (!File::exists($typeFile)) {
            return 'id';
        }

        $content = File::get($typeFile);
        preg_match_all("/->name\(['\"](.*?)['\"]\)/", $content, $matches);

        return implode(' ', $matches[1] ?? ['id']);
    }

    public function cleanup(): void
    {
        // Ajoute ici la logique de nettoyage si besoin
    }
}
