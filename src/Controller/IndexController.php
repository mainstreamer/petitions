<?php

namespace App\Controller;

use App\Form\PetitionFieldsType;
use App\Services\FetcherService;
use App\Services\SorterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(Request $request, SorterService $sorter, FetcherService $fetcher, SerializerInterface $serializer): Response
    {
        $response = $fetcher->fetch(getenv('URL'));
        $form = $this->createForm(PetitionFieldsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $csv = $serializer->serialize($response->petitions, 'csv', $form->getData());
            ($response = new Response($csv))->headers->set('Content-Type', 'text/csv');
            return $response;
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'petitions' => $sorter->sort($response->petitions),
            'form' => $form->createView(),
        ]);
    }
}
