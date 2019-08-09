<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetcherService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetch(string $url): string
    {
        try {
            $response = json_decode($this->client->request(Request::METHOD_GET, $url)->getContent());
        } catch (\Exception $exception) {

            throw new \Exception($exception->getMessage());
        }

        return $response;
    }
}
