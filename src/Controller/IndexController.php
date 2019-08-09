<?php

namespace App\Controller;

use App\Form\PetitionFieldsType;
use App\Services\CSVConverterService;
use App\Services\FetcherService;
use App\Services\SorterService;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(Request $request, CSVConverterService $converter, SorterService $sorter, FetcherService $fetcher)
    {

        $response = $fetcher->fetch('https://www.thepetitionsite.com/servlets/petitions/feed.php?type=publisher&feedID=2372');

//        $client = new Client();
//        $url = "https://www.thepetitionsite.com/servlets/petitions/feed.php?type=publisher&feedID=2372";
//
//        try {
//            $response = json_decode($client->request(Request::METHOD_GET, $url)->getBody()->getContents());
//        } catch (\Exception $exception) {
//            $this->addFlash('error', 'Could not connect to server');
//
//            return $this->redirectToRoute('index');
//        }

        $form = $this->createForm(PetitionFieldsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $csv = $converter->convert($response, $form->getData());

            ($response = new Response($csv))->headers->set('Content-Type', 'text/csv');

            return $response;
        }


//        dd (new \DateTime($response->petitions[0]->stopdate) ==
//            new \DateTime($response->petitions[0]->stopdate) );
//        dd(new \DateTime($response->petitions[0]->stopdate));

//            ->getBody()->getContents();
//        $client->

//        dd(json_decode($response));

//        dd($client);
//
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'petitions' => $sorter->sort($response->petitions),
            'form' => $form->createView(),
        ]);
    }
}
