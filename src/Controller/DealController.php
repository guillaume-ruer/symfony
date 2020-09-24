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
            throw new \Exception("Index invalide");
        }
        return new Response('Index : '.$index, Response::HTTP_OK);
    }
}
