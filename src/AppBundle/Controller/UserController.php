<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Utils\Commons;

class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("admin/user/list", name="user_list")
     * @Method("GET")
     */
    public function indexAction(Request $request) 
    { 
        $em = $this->getDoctrine()->getManager();
        $errorMessage = "";
        
        $province = Commons::getArrayProvince('Filtrar por Provincia');
        $zona     = Commons::getArrayZona('Filtrar por Zona');
        $type     = Commons::getArrayType('Filtrar por Tipo');

        $s_name = $request->get('s_name','');
        $s_zona = $request->get('s_zona','');
        $s_type = $request->get('s_type','');
        $document_id = $request->get('document_id','');
        $s_province = $request->get('s_province','');
        
        $entities = $em->getRepository('AppBundle:User')->findByRoleAttendant($s_name, $s_zona, $s_type, $s_province, $document_id);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $entities, $request->get('page', 1) /* page number */, 10
        );
        if (!$entities) {
            $errorMessage = 'No existen registros guardados';
        }
        
        return $this->render('AppBundle:User:list.html.twig',['entities' => $pagination, 
            'message'  => $errorMessage,
            'province' => $province,
            'zona' => $zona,
            'type' => $type,
            's_name'=>$s_name,
            's_zona'=>$s_zona,
            's_type'=>$s_type,
            's_province'=>$s_province,
            'document_id'=>$document_id]);
    }
    
    /**
     * New User entities.
     *
     * @Route("admin/user/new", name="user_new")
     */
    public function newUserAction(Request $request)
    {
        $user  = new User();
        $form  = $this->createCreateForm($user);
        $type  = 'new';
        $label = '    CREAR    ';
        return $this->forward('AppBundle:User:form', ['form'=>$form, 'user'=>$user, 'label'=>$label, 'type'=>$type]);
    }
    
    /**
     * Edit User entities.
     *
     * @Route("admin/user/{id}/edit", name="user_edit")
     */
    public function editUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($id);
        
        $form  = $this->createEditForm($user, $id);
        $type  = 'edit';
        $label = '    EDITAR    ';
        return $this->forward('AppBundle:User:form', ['form'=>$form, 'user'=>$user, 'label'=>$label, 'type'=>$type]);
        
    }
    
    
    /**
     * form User entities.
     *
     */
    public function formAction(Request $request, $form, $user, $label, $type)
    {
        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $data = $request->get('user_appbundle_user');
                
                $em = $this->getDoctrine()->getManager();
                $user->addRole("ROLE_CUSTOMER");
                $user->setUsername($data['email']);
                $user->setUsernameCanonical($data['email']);
                $user->setEnabled(1);

                $em->persist($user);
                $em->flush();
                
                $message = \Swift_Message::newInstance()
                ->setSubject('Recupera tu cuenta')
                ->setFrom($email)
                ->setTo('no-reply@gapp.com')
                ->setBody(
                    $this->renderView(
                        'AppBundle:Emails:registration.html.twig',
                        array('email' => $user->getEmail(), 'password'=>$data['plainPassword'])
                    ),
                    'text/html'
                );
                $this->get('mailer')->send($message);
                
                $this->get('session')->getFlashBag()->set('update_info', 'Se actualizo el registro');
                return $this->redirect($this->generateUrl('user_list'));
            }
        }
        return $this->render('AppBundle:User:form.html.twig', ['form'=>$form->createView(), 'label'=>$label, 'type'=>$type]);
    }
    
    /**
     * 
     * Delete User entities.
     *
     * @Route("admin/user/{id}/delete", name="user_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($id);
        
        if(!$user){return $this->redirect($this->generateUrl('user_list'));}
        
        foreach ($user->getDocument() AS $user_document){
            $user->removeDocument($user_document);
            $user_document->removeUser($user);
            $em->persist($user_document);
            $em->persist($user);
            $em->flush();
        }
        
        $em->remove($user);
        $em->flush();
        
        $this->get('session')->getFlashBag()->set('delete_info', 'Se elimino el registro');
        
        return $this->redirect($this->generateUrl('user_list'));
    }
    
    
    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity) {
        $form = $this->createForm(new UserType('user_userbundle_user'), $entity, array(
            'action' => $this->generateUrl('user_new'),
            'method' => 'POST',
        ));

        $form->add(
            'plainPassword', 'password', array(
                'label' => 'Contraseña',
                'attr' => array(
                    "class" => "celda3",
                    "maxlength" => 32 //Longitud máxima
                )
            )
        );
        
        return $form;
    }
    
    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity, $id) {
        $form = $this->createForm(new UserType('user_userbundle_user'), $entity, array(
            'action' => $this->generateUrl('user_edit', ['id'=>$id]),
            'method' => 'POST',
        ));

        return $form;
    }
}
