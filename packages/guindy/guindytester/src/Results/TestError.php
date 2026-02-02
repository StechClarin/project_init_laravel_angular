<?php
namespace Guindy\GuindyTester\Results;

class TestError
{
    public string $route;
    public string $method;
    public string $errorMessage;
    public int $statusCode;
    public array $payload;
    public ?string $chatgptExplanation = null;
    public ?string $committer = null;

    public function __construct(
        string $route,
        string $method,
        string $errorMessage,
        int $statusCode,
        array $payload,
        ?string $chatgptExplanation = null,
        ?string $committer = null
    ) {
        $this->route = $route;
        $this->method = $method;
        $this->errorMessage = $errorMessage;
        $this->statusCode = $statusCode;
        $this->payload = $payload;
        $this->chatgptExplanation = $chatgptExplanation;
        $this->committer = $committer ?? self::resolveCommitter();
    }

    public static function resolveCommitter(): string
    {
        return trim(shell_exec("git log -1 --pretty=format:'%an'"));
    }

    public function toArray(): array
    {
        return [
            'route' => $this->route,
            'method' => $this->method,
            'errorMessage' => $this->errorMessage,
            'statusCode' => $this->statusCode,
            'payload' => $this->payload,
            'chatgptExplanation' => $this->chatgptExplanation,
            'committer' => $this->committer,
        ];
    }
}
