<?php 
// src/Controller/HelloController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends AbstractController {
   /**
     * @Route("/hello/{name}", name="hello")
    */
    public function indexAction($name) {
        if(!ctype_alpha($name)){
            throw new \Exception("Ce n'est pas alphabétique.");
        }
        return new Response('<html><body>Hello ' . $name . '!</body></html>');
     }
}