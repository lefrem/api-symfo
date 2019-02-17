<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Doctrine\ORM\EntityManagerInterface;

class UserController extends  AbstractFOSRestController
{

    /**
     * @Groups("user")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    private $userRepository;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository ;
        $this->em = $em;
    }

    /**
    * @Rest\Get("/api/users/{email}")
    */
    public function getApiUser(User $user){
        return $this->view($user);
    }

    /**
    * @Rest\Get("/api/users")
    */
    public function getApiUsers(){
        $users = $this->userRepository ->findAll();
        return $this->view($users);
        // "get_users"
    }

    /**
    * @Rest\Post("/api/users")
    * @ParamConverter("user", converter="fos_rest.request_body")
    */
    public function postApiUser(User $user){
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }

    /**
    * @Rest\Patch("/api/users/{email}")
    */
    public function patchApiUser(User $user){
        // $request->get('firstname');
    }

    /**
    * @Rest\Delete("/api/users/{email}")
    */
    public function deleteApiUser(User $user){}

    
}
