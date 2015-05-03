<?php

namespace VP\LayoutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function HomePageAction()
    {
       return $this->render("VPLayoutBundle:Home:HomePage.html.twig");}

    /**
     * @Route("/intro")
     * @Template()
     */
    public function IntroAction()
    {
       return $this->render("VPLayoutBundle:Home:Intro.html.twig");}

}
