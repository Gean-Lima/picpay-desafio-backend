<?php

namespace Neo\PicpayDesafioBackend\Http;

class Response
{
    private string $content;
    private int $code;
    private array $headers;

    public function __construct(string $content, int $code = 200, array $headers = [])
    {
        $this->content = $content;
        $this->code = $code;
        $this->headers = $headers;
    }

    public function render(): void
    {
        foreach($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }

        http_response_code($this->code);

        echo $this->content;
    }

    public static function json(mixed $content, int $code = 200): Response
    {
        $contentJson = json_encode($content);

        return new Response($contentJson, $code, [
            'Content-Type' => 'application/json'
        ]);
    }
}
