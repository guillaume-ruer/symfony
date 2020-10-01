<?php
// src/Controller/Dealcontroller.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DealController extends AbstractController {
   /**
     * @Route("/deal/list", name="deal_list", methods="GET")
     * @Route("/", methods="GET")
    */
    public function indexAction() {
        $response = new Response('Deal', Response::HTTP_OK);
        return $response;
    }
    /**
     * @Route("/deal/show/{index}", name="deal_show", requirements={"index":"\d+"}, defaults={"index": 1}, methods="GET")
     */ 
    public function showAction($index) {
        if(!ctype_digit($index)){
            $this->createNotFoundException();
        }
        return new Response('Index : '.$index, Response::HTTP_OK);
    }

    /**
     * @Route("/deal/toggle/{dealId}", name="deal_toggle", requirements={"index":"\d+"})
     */
    public function toggleEnableAction($dealId) {
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
        return new Response('Deal : '.$deal->getName()." Enabled : ".$deal->getEnable(), Response::HTTP_OK);
    }

    /**
     * @Route("/deal/show/all", name="show_all_deal")
     */
    public function showDealsAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App:Category')->findAll();
        $deals = $em->getRepository('App:Deal')->findAll();
        return $this->render(
            '/deal/index.html.twig',
            array('categories' => $categories, 'deals' => $deals)
        );
    }
}
