<?php

namespace App\Controller;

//use App\Card\Card;
//use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "game_session")]
    public function session(
        SessionInterface $session
    ): Response {

        $deck = $session->get("deck");
        $remaining = $deck ? count($deck->getCards()) : null;

        return $this->render('card/session.html.twig', [
            'remaining' => $remaining,
            'last_drawn_cards' => $session->get('last_drawn_cards', []),
            'draw_history' => $session->get('draw_history', []),
            'hand' => $session->get('card_hand', [])
        ]);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function deleteSession(
        SessionInterface $session
    ): Response {
        $session->clear();

        $this->addFlash('notice', 'The Session is deleted!');

        return $this->redirectToRoute('game_session');
    }

    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render("card/card.html.twig");
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(
        SessionInterface $session
    ): Response {
        $deck = $this->checkDeck($session);

        return $this->render("card/deck.html.twig", [
            "cards" => $deck->getCards(),
            "title" => "Deck of cards(sorted)"
        ]);
    }


    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set("deck", $deck);

        $data = [
            "cards" => $deck->getCards(),
            "title" => "Deck of Cards shuffled"
        ];

        return $this->render("card/deck.html.twig", $data);
    }

    #[Route("/card/deck/sort", name: "card_deck_sort")]
    public function sortDeck(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("deck", $deck);

        return $this->redirectToRoute("card_deck");
    }

    #[Route("/card/deck/draw", name: "card_draw_one")]
    public function drawOne(
        SessionInterface $session
    ): Response {
        $deck = $this->checkDeck($session);
        $card = $deck->drawCard();
        $session->set("deck", $deck);

        $hand = $session->get("card_hand", []);
        $hand[] = $card;
        $session->set("card_hand", $hand);

        $history = $session->get("draw_history", []);
        $history[] = $card;
        $session->set("draw_history", $history);

        $session->set("last_drawn_cards", [$card]);

        $data = [
            "cards" => [$card],
            "remaining" => count($deck->getCards()),
            "hand" => $hand
        ];

        return $this->render("card/draw.html.twig", $data);
    }


    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_num")]
    public function drawMultiple(
        SessionInterface $session,
        int $num
    ): Response {

        if ($num > 52) {
            throw new \Exception("You can't draw more than 52 cards!");
        }
        $deck = $this->checkDeck($session);
        $cards = $deck->drawCards($num);
        $session->set("deck", $deck);


        $hand = $session->get("card_hand", []);
        $hand = array_merge($hand, $cards);
        $session->set("card_hand", $hand);

        $history = $session->get("draw_history", []);
        $history = array_merge($history, $cards);
        $session->set("draw_history", $history);

        $session->set("last_drawn_cards", $cards);

        $data = [
            "cards" => $cards,
            "remaining" => count($deck->getCards()),
            "drawn" => $num,
            "hand" => $hand
        ];

        return $this->render("card/draw.html.twig", $data);
    }


    #[Route("/card/deck/draw-post", name: "card_draw_post", methods: ['POST'])]
    public function drawPost(
        Request $request,
        SessionInterface $session
    ): Response {
        $num = $request->request->getInt('num', 1);

        $deck = $this->checkDeck($session);
        $cards = $deck->drawCards($num);
        $session->set("deck", $deck);

        $hand = $session->get("card_hand", []);
        $hand = array_merge($hand, $cards);
        $session->set("card_hand", $hand);

        $history = $session->get("draw_history", []);
        $history = array_merge($history, $cards);
        $session->set("draw_history", $history);

        $session->set("last_drawn_cards", $cards);

        return $this->redirectToRoute("card_draw_show");
    }

    #[Route("/card/deck/draw/show", name: "card_draw_show", methods: ['GET'])]
    public function showDrawnCards(
        SessionInterface $session
    ): Response {
        $cards = $session->get("last_drawn_cards", []);
        $deck = $session->get("deck");

        $data = [
            "cards" => $cards,
            "remaining" => $deck ? count($deck->getCards()) : 0
        ];

        return $this->render("card/draw.html.twig", $data);
    }

    // hjälpmetod för att eliminiera repetativ kod 
    private function checkDeck(
        Sessioninterface $session
    ): DeckOfCards {
        $deck = $session->get("deck");
        if(!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }
        return $deck;
    }
}
