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
use \Symfony\Contracts\HttpClient\Exception;

class IndexController extends AbstractController
{
    /**
     * @param Request $request
     * @param SorterService $sorter
     * @param FetcherService $fetcher
     * @param SerializerInterface $serializer
     * @return Response
     * @throws Exception\ClientExceptionInterface
     * @throws Exception\RedirectionExceptionInterface
     * @throws Exception\ServerExceptionInterface
     * @throws Exception\TransportExceptionInterface
     * @Route("/index", name="index")
     */
    public function index(
        Request $request,
        SorterService $sorter,
        FetcherService $fetcher,
        SerializerInterface $serializer
    ): Response
    {
        $petitions = $fetcher->fetch(getenv('URL'));
        $form = $this->createForm(PetitionFieldsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $csv = $serializer->serialize($petitions, 'csv', $form->getData());
            ($response = new Response($csv))->headers->set('Content-Type', 'text/csv');

            return $response;
        }

        return $this->render('index/index.html.twig', [
            'petitions' => $sorter->sort($petitions),
            'form' => $form->createView(),
        ]);
    }
}
