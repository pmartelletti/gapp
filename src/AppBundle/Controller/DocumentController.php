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
        
    }
    
    /**
     * New Document entities.
     *
     * @Route("admin/document/new", name="document_new")
     */
    public function newDocumentAction(Request $request)
    {
        $document  = new Document();
        $form  = $this->createCreateForm($document);
        $type  = 'new';
        $label = '    CREAR    ';
        return $this->forward('AppBundle:Document:form', ['form'=>$form, 'document'=>$document, 'label'=>$label, 'type'=>$type]);
    }
    
    
    /**
     * form Document entities.
     *
     */
    public function formAction(Request $request, $form, $document, $label, $type)
    {
        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $em = $this->getDoctrine()->getManager();

                $em->persist($document);
                $em->flush();
                
                $this->get('session')->getFlashBag()->set('update_info', 'Se actualizo el registro');
                return $this->redirect($this->generateUrl('doc_list'));
            }
        }
        return $this->render('AppBundle:Document:form.html.twig', ['form'=>$form->createView(), 'label'=>$label, 'type'=>$type]);
    }
    
    
    
    
    /**
     * Creates a form to create a Doccument entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity) {
        $form = $this->createForm(new DocumentType('document_appbundle_document'), $entity, array(
            'action' => $this->generateUrl('document_new'),
            'method' => 'POST',
        ));
        
        return $form;
    }
}
