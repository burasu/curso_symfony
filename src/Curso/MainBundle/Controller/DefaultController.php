<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CursoMainBundle:Default:index.html.twig', array('name' => $name));
    }

    public function ayudaAction($tema)
    {
    	return $this->render("CursoMainBundle:Default:ayuda.html.twig", array("tema" => $tema));
        //return new Response("<html><body>Esta es la ayuda sobre el tema " . $tema . "</body></html>");
    }
}
