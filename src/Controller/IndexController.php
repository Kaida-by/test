<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function index(): Response
    {
        return new Response('123456');
        //return $this->render('index.html.twig');
    }
}
