<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Doctrine\ORM\EntityManagerInterface;

class SubscriptionController extends AbstractController
{

    private $subscriptionRepository;
    public function __construct(SubscriptionRepository $subscriptionRepository, EntityManagerInterface $em)
    {
        $this->subscriptionRepository = $subscriptionRepository ;
        $this->em = $em;
    }

    /**
    * @Rest\Get("/api/subscriptions")
    */
    public function getApiSubscriptions(){
        $subscriptions = $this->subscriptionRepository ->findAll();
        return $this->view($subscriptions);
    }

    /**
    * @Rest\Post("/api/subscriptions")
    * @ParamConverter("subscription", converter="fos_rest.request_body")
    */
    public function postApiSubscription(Subscription $subscription){
        $this->em->persist($subscription);
        $this->em->flush();
        return $this->view($subscription);
    }

}
