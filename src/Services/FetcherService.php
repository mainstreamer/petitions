<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FetcherService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
//        dd($client);
    }

    public function fetch(string $url)
    {
//        $client = new Client();
//        $url = "https://www.thepetitionsite.com/servlets/petitions/feed.php?type=publisher&feedID=2372";
//

        $response = $this->client->request(Request::METHOD_GET, $url)->getContent();

        try {
            $response = json_decode($this->client->request(Request::METHOD_GET, $url)->getContent());
//            $response = json_decode($this->client->request(Request::METHOD_GET, $data['url'])->getBody()->getContents());
        } catch (\Exception $exception) {

            throw new \Exception($exception->getMessage());
//            $this->addFlash('error', 'Could not connect to server');

//            return $this->redirectToRoute('index');
        }

        return $response;
//        dd($response);
    }
}
