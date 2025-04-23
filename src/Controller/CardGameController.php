<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController {
    #[Route("/session", name: "game_session")]
    public function session(): Response
    {
        return $this->render('/session.html.twig');
    }

    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render("card/card.html.twig");
    }
    
}
