<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    private array $cards = [];

    public function __construct()
    {
        $this->generateDeck();
    }

    private function generateDeck(): void
    {
        $suits = ['Spades', 'Hearts', 'Clubs', 'Diamonds'];
        $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function drawCard(): ?Card
    {
        return array_pop($this->cards);
    }

    public function drawCards(int $number): array
    {
        $drawn = [];
        for ($i = 0; $i < $number && !empty($this->cards); $i++) {
            $drawn[] = $this->drawCard();
        }
        return $drawn;
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}
