<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Profile;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if (isset($_POST['submit'])) {
            $user = new User();
            $user->setEmail($request->request->get('email'));
            $user->setPassword($request->request->get('password'));

            $profile = new Profile();
            $profile->setUser($user);
            $format = "Y,m,d";
            $time = str_replace('-', ',', $request->request->get('birthdate'));
            $date = \DateTime::createFromFormat($format, $time);
            $profile->setBirthDate($date);
            $profile->setPhone($request->request->get('phone'));

            for ($i = 1; $i <= 5; $i++) {
                if (!empty($_POST['enable_' . $i]) &&
                    !empty($request->request->get('title_' . $i)) &&
                    !empty($request->request->get('description_' . $i))
                ) {
                    $product = new Product();
                    $product->setTitle($request->request->get('title_' . $i));
                    $product->setDescription($request->request->get('description_' . $i));
                    $user->addProduct($product);

                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($profile);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/new.html.twig');
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET", "POST"})
     */
    public function show(User $user): Response
    {
        $products = $user->getProduct();
        $profile = $user->getProfile();
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'products' => $products,
            'profile' => $profile
            ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $products = $user->getProduct();
        $profile = $user->getProfile();

        if (isset($_POST['submit'])) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setEmail($request->request->get('email'));
            $user->setPassword($request->request->get('password'));

            $profile = $entityManager->getRepository(Profile::class)->find($user->getId());
            $profile->setUser($user);
            $format = "Y,m,d";
            $time = "2009,2,26";
            $date = \DateTime::createFromFormat($format, $time);
            $profile->setBirthDate($request->request->get('birthdate'));
            $profile->setPhone($request->request->get('phone'));

            if (!empty($products)) {
                foreach ($products as $product) {
                    if (!empty($_POST['enable_' . $product->getId()]) &&
                        !empty($request->request->get('title_' . $product->getId())) &&
                        !empty($request->request->get('description_' . $product->getId()))
                    ) {
                        $product->setTitle($request->request->get('title_' . $product->getId()));
                        $product->setDescription($request->request->get('description_' . $product->getId()));

                    } else {
                        $user->removeProduct($product);
                    }
                    $numb = $user->count() + 1;
                    if (!empty($_POST['enable_' . $numb]) &&
                        !empty($request->request->get('title_' . $product->getId())) &&
                        !empty($request->request->get('description_' . $product->getId()))
                    ) {
                        $product = new Product();
                        $product->setTitle($request->request->get('title_' . $numb));
                        $product->setDescription($request->request->get('description_' . $numb));
                    }
                }
            }

            for ($i = 1; $i <= 5; $i++) {
                if (!empty($_POST['enableAdd_' . $i]) &&
                    !empty($request->request->get('title_' . $i)) &&
                    !empty($request->request->get('description_' . $i))
                ) {
                    $product = new Product();
                    $product->setTitle($request->request->get('title_' . $i));
                    $product->setDescription($request->request->get('description_' . $i));
                    $user->addProduct($product);
                }
            }

            $entityManager->persist($user);
            $entityManager->persist($profile);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'products' => $products,
            'profile' => $profile
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if (isset($_POST['submit'])) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
