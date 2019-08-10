<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception;

class FetcherService
{
    private $client;

    private $bag;

    public function __construct(HttpClientInterface $client, FlashBagInterface $bag)
    {
        $this->client = $client;
        $this->bag = $bag;
    }

    /**
     * @param string $url
     * @return array
     * @throws Exception\ClientExceptionInterface
     * @throws Exception\RedirectionExceptionInterface
     * @throws Exception\ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function fetch(string $url): array
    {
        try {
            $payload = $this->retrieve($url);
            $response = $this->decode($payload);
        } catch (\Exception $e) {
            $this->bag->add('error', $e->getMessage());
        }

        return $response->petitions ?? [];
    }

    /**
     * @param string $url
     * @return string
     * @throws Exception\ClientExceptionInterface
     * @throws Exception\RedirectionExceptionInterface
     * @throws Exception\ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function retrieve(string $url): string
    {
        return $this->client->request(Request::METHOD_GET, $url)->getContent();
    }

    /**
     * @param string $data
     * @return object|null
     */
    private function decode(string $data): ?object
    {
        return json_decode($data);
    }
}
