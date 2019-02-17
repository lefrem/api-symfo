<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use App\Entity\Card;
use App\Repository\CardRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Doctrine\ORM\EntityManagerInterface;

class CardController extends AbstractFOSRestController
{
    private $cardRepository;
    public function __construct(CardRepository $cardRepository, EntityManagerInterface $em)
    {
        $this->cardRepository = $cardRepository ;
        $this->em = $em;
    }

    /**
    * @Rest\Get("/api/cards")
    */
    public function getApiCards(){
        $cards = $this->cardRepository ->findAll();
        return $this->view($cards);
    }

    /**
    * @Rest\Post("/api/cards")
    * @ParamConverter("card", converter="fos_rest.request_body")
    */
    public function postApiCard(Card $card){
        $this->em->persist($card);
        $this->em->flush();
        return $this->view($card);
    }

}
