<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class AdminController extends Controller
{
    /**
     * @Route("admin/login", name="admin_login")
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
 
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return $this->render('AppBundle:Admin:login.html.twig', ['error'=> $error]);
    }
    
    /**
     * @Route("/admin/menu", name="admin_menu")
     */
    public function menuAction()
    {
        return $this->render('AppBundle:Admin:menu.html.twig');
    }   
    
    /**
     * @Route("/login_check", name="login_check")
     */
    public function login_checkAction(Request $request)
    {
        
    }  
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        
    }  
}

