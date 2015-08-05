<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        return $this->render('AppBundle:Admin:login.html.twig');
    }
    
    /**
     * @Route("/admin/menu", name="admin_menu")
     */
    public function menuAction()
    {
        return $this->render('AppBundle:Admin:menu.html.twig');
    }        
}

