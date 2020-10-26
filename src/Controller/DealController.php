<?php
// src/Controller/Dealcontroller.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\DealType;
use App\Entity\Deal;
use Psr\Log\LoggerInterface;
use App\Services\RandomSlogan;


class DealController extends AbstractController
{
    /**
     * @Route("/deal/list", name="deal_list", methods="GET")
     * @Route("/", methods="GET")
     */
    public function indexAction(RandomSlogan $sloganGenerator)
    {
        $slogan = $sloganGenerator->getSlogan();
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App:Category')->findAll();
        $deals = $em->getRepository('App:Deal')->findAll();
        return $this->render(
            '/deal/index.html.twig',
            array('slogan' => $slogan, 'categories' => $categories, 'deals' => $deals)
        );
    }
    /**
     * @Route("/deal/show/{index}", name="deal_show", requirements={"index":"\d+"}, defaults={"index": 1}, methods="GET")
     */
    public function showAction($index)
    {
        if (!ctype_digit($index)) {
            $this->createNotFoundException();
        }
        return new Response('Index : ' . $index, Response::HTTP_OK);
    }

    /**
     * @Route("/deal/toggle/{dealId}", name="deal_toggle", requirements={"index":"\d+"})
     */
    public function toggleEnableAction($dealId)
    {
        $em = $this->getDoctrine()->getManager();
        $deal = $em->getRepository('App:Deal')->find($dealId);

        if (!$deal) {
            throw $this->createNotFoundException(
                'No deal found for id ' . $dealId
            );
        }
        if ($deal->getEnable()) {
            $deal->setEnable(FALSE);
        } else {
            $deal->setEnable(TRUE);
        }
        $em->flush();
        return new Response('Deal : ' . $deal->getName() . " Enabled : " . $deal->getEnable(), Response::HTTP_OK);
    }

    /**
     * @Route("/deal/new", name="deal_new")
     */
    public function newAction(Request $request, LoggerInterface $logger)
    {
        $deal = new Deal();
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $deal->setEnable(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($deal);
            $em->flush();

            $this->addFlash('notice', 'Deal ajouté !');
            $logger->info('Deal Ajouté');

            return $this->redirectToRoute('deal_list');
        }

        return $this->render(
            '/deal/new.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/category/{category}", name="category")
     */
    public function showCategory($category)
    {
        $em = $this->getDoctrine()->getManager();
        $deals = $em->getRepository('App:Deal')->findAll();
        $cat = $em->getRepository('App:Category')->findBy(['name' => $category]);
        return $this->render(
            '/deal/category.html.twig',
            array('category' => $cat, 'deals' => $deals)
        );
    }

    /**
     * @Route("/deal/book/{dealId}", name="book_deal")
     */
    public function dealBook($dealId)
    {
        $em = $this->getDoctrine()->getManager();
        $deal = $em->getRepository('App:Deal')->find($dealId);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $deal->setUser($user);
        $em->persist($deal);
        $em->flush();
        return $this->redirectToRoute('deal_list');
    }

    /**
     * @Route("/deal/user/{userId}", name="booked_deals")
     */
    public function showUserDeals($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $deals = $em->getRepository('App:Deal')->findBy(['user' => $userId]);
        return $this->render(
            '/deal/user.html.twig',
            array('deals' => $deals)
        );
    }

    /**
     * @Route("/book/delete/{dealId}", name="book_delete")
     */
    public function deleteBook($dealId)
    {
        $em = $this->getDoctrine()->getManager();
        $deal = $em->getRepository('App:Deal')->find($dealId);
        $deal->setUser(null);
        $em->persist($deal);
        $em->flush();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $userId = $user->getId();
        return $this->redirectToRoute("booked_deals", array('userId' => $userId));
    }
}
