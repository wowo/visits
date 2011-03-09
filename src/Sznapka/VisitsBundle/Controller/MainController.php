<?php

namespace Sznapka\VisitsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('VisitsBundle:Main:index.html.twig');
    }
    
    public function welcomeAction()
    {
        return $this->render('VisitsBundle:Main:welcome.html.twig');
    }
}
