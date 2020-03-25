<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 */
class IndexController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        ProductRepository $productRepository
    ) {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/")
     *
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->userRepository->find(8);
        $product = $this->productRepository->find(16);

        $user->removeProduct($product);

        $this->em->flush();

        return new Response('123456');
        //return $this->render('index.html.twig');
    }
}
