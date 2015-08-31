<?php
namespace AppBundle\Controller;

use AppBundle\Utils\Commons;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Form\DocumentType;
use AppBundle\Entity\Document;


class DocumentController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("admin/document/list", name="doc_list")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $errorMessage = "";

        $s_name = $request->get('s_name', '');

        $entities = $em->getRepository('AppBundle:Document')->getDocumentAllByFilter($s_name);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities, $request->get('page', 1) /* page number */, 10
        );
        if (!$entities) {
            $errorMessage = 'No existen registros guardados';
        }

        return $this->render('AppBundle:Document:list.html.twig', ['entities' => $pagination,
            'message' => $errorMessage,
            's_name' => $s_name]);
    }

    /**
     * New Document entities.
     *
     * @Route("admin/document/new", name="document_new")
     */
    public function newDocumentAction(Request $request)
    {
        $document = new Document();
        $form = $this->createCreateForm($document);
        $type = 'new';
        $label = '    CREAR    ';
        return $this->forward('AppBundle:Document:form', ['form' => $form, 'document' => $document, 'label' => $label, 'type' => $type]);
    }

    /**
     * Edit Document entities.
     *
     * @Route("admin/document/{id}/edit", name="document_edit")
     */
    public function editUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('AppBundle:Document')->findOneById($id);

        $form = $this->createEditForm($document, $id);
        $type = 'edit';
        $label = '    EDITAR    ';
        return $this->forward('AppBundle:Document:form', ['form' => $form, 'document' => $document, 'label' => $label, 'type' => $type]);

    }

    /**
     * form Document entities.
     *
     */
    public function formAction(Request $request, $form, $document, $label, $type)
    {
        $em = $this->getDoctrine()->getManager();

        $user_repository = $em->getRepository('AppBundle:User');

        $user = $user_repository->findAll();//$user_repository->findUserNotDocument($document->getUsers());

        $user_array_document = $user_repository->getArrayData($document->getUsers());

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            $to = $request->get('to', '');

            $user_to = $user_repository->getUsersInId($to);

            $user_array_document = $user_repository->getArrayData($user_to);

            if ($form->isValid()) {

                $em->persist($document);
                $em->flush();

                foreach ($document->getUsers() AS $user_document) {
                    $document->removeUser($user_document);
                    $user_document->removeDocument($document);
                    $em->persist($user_document);
                    $em->persist($document);
                    $em->flush();
                }

                foreach ($user_to AS $user) {
                    $document->addUser($user);
                    $user->addDocument($document);
                    $em->persist($user);
                    $em->persist($document);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->set('update_info', 'Se actualizo el registro');
                return $this->redirect($this->generateUrl('doc_list'));
            }
        }
        return $this->render('AppBundle:Document:form.html.twig', [
            'form' => $form->createView(),
            'provincias' => Commons::getArrayProvince('Todas las provincias'),
            'zonas' => Commons::getArrayZona('Todas las zonas'),
            'tipos' => Commons::getArrayType('Todos los usuarios'),
            'label' => $label,
            'type'=>$type,
            'users'=>$user,
            'user_array_document'=>$user_array_document,
            'document'=>$document
        ]);
    }


    /**
     *
     * Delete Document entities.
     *
     * @Route("admin/document/{id}/delete", name="document_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('AppBundle:Document')->findOneById($id);

        if (!$document) {
            return $this->redirect($this->generateUrl('document_list'));
        }

        foreach ($document->getUsers() AS $user_document) {
            $document->removeUser($user_document);
            $user_document->removeDocument($document);
            $em->persist($user_document);
            $em->persist($document);
            $em->flush();
        }

        $em->remove($document);
        $em->flush();

        $this->get('session')->getFlashBag()->set('delete_info', 'Se elimino el registro');

        return $this->redirect($this->generateUrl('document_list'));
    }

    /**
     *
     * suspend Document entities.
     *
     * @Route("admin/document/{id}/suspend", name="document_suspend")
     */
    public function suspendAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('AppBundle:Document')->findOneById($id);

        if (!$document) {
            return $this->redirect($this->generateUrl('document_list'));
        }

        $document->setEnable(0);

        $em->persist($document);
        $em->flush();

        $this->get('session')->getFlashBag()->set('delete_info', 'Se actualizo el registro');

        return $this->redirect($this->generateUrl('document_list'));
    }

    /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType('document_appbundle_document'), $entity, array(
            'action' => $this->generateUrl('document_new'),
            'method' => 'POST',
        ));

        $form->add(
            'file', 'file', array(
                'label' => 'Documento',
                "mapped" => TRUE,
                'required' => true,
                'attr' => array(
                    "class" => "celda3",
                )
            )
        );

        return $form;
    }

    /**
     * Creates a form to edit a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Document $entity, $id)
    {
        $form = $this->createForm(new DocumentType('document_appbundle_document'), $entity, array(
            'action' => $this->generateUrl('document_edit', ['id' => $id]),
            'method' => 'POST',
        ));

        $form->add(
            'file', 'file', array(
                'label' => 'Documento',
                "mapped" => true,
                'required' => FALSE,
                'attr' => array(
                    "class" => "celda3",
                )
            )
        );

        return $form;
    }
}
