<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use AppBundle\Form\ChangePasswordType;

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
    public function getDocumentByUserAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        
        $document = $em->getRepository('AppBundle:Document')->getDocumentByUserId($user->getId());
        
        return $this->render('AppBundle:Frontend:document.html.twig', ['document'=>$document]); 
    }
    
    /**
     * @Route("members/perfil", name="members_perfil")
     */
    public function profileAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
         $user = $this->container->get('security.context')->getToken()->getUser();
         
         $user_object = $em->getRepository('AppBundle:User')->findOneById($user->getId());
         
         $form =  $this->createForm(new ChangePasswordType('change_password_appbundle'), $user_object);
         
         if($request->isMethod('POST')){
             
             $form->handleRequest($request);
             
             if ($form->isValid()) {
                 $data = $request->get('change_password_appbundle');
                 
                 $user_object->setPlainPassword($data['password']['first']);
                 
                 $em->persist($user);
                 $em->flush();
                 
                 $this->get('session')->getFlashBag()->set('update_info', 'Se actualizo el perfil');
                 return $this->redirect($this->generateUrl('members_perfil'));
             }
         }
         return $this->render('AppBundle:Frontend:profile.html.twig', ['form'=>$form->createView()]);  
    }
}
