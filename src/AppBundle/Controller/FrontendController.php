<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class FrontendController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Frontend:index.html.twig');
    }
    
    /**
     * @Route("members/login", name="members_login")
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
        
        return $this->render('AppBundle:Frontend:login.html.twig', ['error'=> $error]); 
    }
    
    /**
     * @Route("members/login_check", name="members_login_check")
     */
    public function login_checkAction(Request $request)
    {
        
    }  
    
    /**
     * @Route("members/logout", name="members_logout")
     */
    public function logoutAction()
    {
        
    }  
    
    
    /**
     * @Route("members/document", name="members_document")
     */
    public function getDocumentByUser(Request $request)
    {
        echo 'ok';
        exit();
    }
}
