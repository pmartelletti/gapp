<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity("email")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    protected $lastname;
    
    /**
     * @var string $email
     * @Assert\Email()
     */
    protected $email;
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}