<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use AppBundle\Form\ChangePasswordType;

/**
 * @Route("/clientes")
 */
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
     * @Route("/login", name="members_login")
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
     * @Route("/login_check", name="members_login_check")
     */
    public function login_checkAction(Request $request)
    {
        
    }  
    
    /**
     * @Route("/logout", name="members_logout")
     */
    public function logoutAction()
    {
        
    }
    
    /**
     * @Route("/document", name="member_document")
     */
    public function getDocumentByUserAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        
        $document = $em->getRepository('AppBundle:Document')->getDocumentByUserId($user->getId());
        
        return $this->render('AppBundle:Frontend:document.html.twig', ['document'=>$document]); 
    }
    
    /**
     * @Route("/perfil", name="members_perfil")
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
                 
                 $em->persist($user_object);
                 $em->flush();
                 
                 $this->get('session')->getFlashBag()->set('update_info', 'Se envio un email con su nueva contraseña!!');
                 return $this->redirect($this->generateUrl('_login'));
             }
         }
         return $this->render('AppBundle:Frontend:profile.html.twig', ['form'=>$form->createView()]);  
    }
    
    /**
     * @Route("/recover-password", name="members_recover_password")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function recoverPasswordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $error = '';
        $email = $request->get('email','');
        
        if($request->isMethod('POST')){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $user_object = $em->getRepository('AppBundle:User')->findOneByEmail($email);
                if($user_object){
                    
                    $password = uniqid(time());
                    
                    $user_object->setPlainPassword($password);
                    
                    $em->persist($user_object);
                    $em->flush();
                    
                    $message = \Swift_Message::newInstance()
                    ->setSubject('Recupera tu cuenta')
                    ->setFrom($email)
                    ->setTo('no-reply@gapp.com')
                    ->setBody(
                        $this->renderView(
                            'AppBundle:Emails:recoverpassword.html.twig',
                            array('email' => $email, 'password'=>$password)
                        ),
                        'text/html'
                    );
                    $this->get('mailer')->send($message);
                    
                    $this->get('session')->getFlashBag()->set('update_info', 'Se envio un email con su nueva contraseña!!');
                    return $this->redirect($this->generateUrl('_perfils'));
                }else{
                    $error = 'El email no pertenece a un usuario registrado ';  
                }
            }else{
              $error = 'Formato de email incorrecto';  
            } 
        }
        
        return $this->render('AppBundle:Frontend:recoverpassword.html.twig', ['error'=>$error]);  
    }        
}
