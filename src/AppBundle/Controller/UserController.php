<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Model\UserInterface;

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
        return $this->render('AppBundle:User:list.html.twig');
    }
    
    /**
     * New User entities.
     *
     * @Route("admin/user/new", name="user_new")
     * @Method("GET")
     */
    public function newUserAction(Request $request)
    {
        return $this->forward('AppBundle:User:form');
    }
    
    
    /**
     * form User entities.
     *
     */
    public function formAction(Request $request)
    {
        return $this->render('AppBundle:User:form.html.twig');
    }
}
