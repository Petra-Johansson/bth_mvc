<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameControllerJson extends AbstractController
{
    // kör i temrinal med: curl http://localhost:8888/api/deck
    #[Route('/api/deck', name:"api_deck", methods: ['GET'])]
    public function deck(
        SessionInterface $session
    ): JsonResponse {
        $deck = new DeckOfCards();
        $session->set("deck", $deck);

        return $this->json($deck->getCards());
    }

    // kör i temrinal med: curl -c cookies.txt -X POST http://localhost:8888/api/deck/shuffle
    // måste spara med cookies pga med curl sparas ej session-cookies mellan kommandon
    #[Route('api/deck/shuffle', name:"api_deck_shuffle", methods: ['POST'])]
    public function shuffle(
        SessionInterface $session
    ): JsonResponse {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set("deck", $deck);

        return $this->json($deck->getCards());
    }

    // kör sedan i terminal: curl -b cookies.txt http://localhost:8888/api/deck/shuffled
    #[Route('api/deck/shuffled', name:"api_deck_shuffled", methods: ['GET'])]
    public function shuffledDeck(
        SessionInterface $session
    ): JsonResponse {
        $deck = $session->get("deck");

        if (!$deck) {
            return $this->json(["error" => "No deck found in session."], 400);
        }

        return $this->json([
            "deck" => $deck->getCards(),
            "count" => count($deck->getCards())
        ]);
    }

    // kör i temrinal med: curl -b cookies.txt -X POST http://localhost:8888/api/deck/draw
    #[Route('api/deck/draw', name:"api_draw_one", methods: ['POST'])]
    public function drawOne(
        SessionInterface $session
    ): JsonResponse {
        $deck = $session->get("deck") ?? new DeckOfCards();
        $card = $deck->drawCard();
        $session->set("deck", $deck);

        $session->set("last_drawn_cards", [$card]);

        $history = $session->get("draw_history", []);
        $history[] = $card;
        $session->set("draw_history", $history);

        return $this->json([
            'drawn' => [$card],
            'remaining' => count($deck->getCards()),
        ]);
    }

    // kör i temrinal med: curl -b cookies.txt -X POST http://localhost:8888/api/deck/draw/5
    #[Route('api/deck/draw/{number<\d+>}', name:"api_draw_multi", methods: ['POST'])]
    public function drawMulti(
        SessionInterface $session,
        int $number
    ): JsonResponse {
        $deck = $session->get("deck") ?? new DeckOfCards();
        $remaining = count($deck->getCards());

        if ($number > $remaining) {
            return $this->json([
                "error" => "Cannot draw {$number} cards, only {$remaining} left in the deck. Try again!"
            ], 400);
        }

        $drawn = $deck->drawCards($number);
        $session->set("deck", $deck);

        $session->set("last_drawn_cards", $drawn);

        $history = $session->get("draw_history", []);
        $history = array_merge($history, $drawn);
        $session->set("draw_history", $history);

        return $this->json([
            "drawn_cards" => $drawn,
            "drawn_count" => count($drawn),
            "remaning_in_deck" => count($deck->getCards())
        ]);
    }

    // kör i temrinal med: curl -b cookies.txt http://localhost:8888/api/deck/drawn
    #[Route('api/deck/drawn', name:"api_drawn_cards", methods: ['GET'])]
    public function drawnCards(
        SessionInterface $session
    ): JsonResponse {
        $deck = $session->get("deck");
        if (!$deck) {
            return $this->json(["error" => "No deck in session."], 400);
        }

        return $this->json([
            "latest_drawn" => $session->get("last_drawn_cards", []),
            "remaining" => count(($session->get("deck")?->getCards() ?? []))
        ]);
    }
}
