<?php

namespace App\Card;

class Card
{
    private string $value;
    private string $suit;

    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }
    public function getValue(): string
    {
        return $this->value;
    }

    public function getGraphics(): string
    {
        $map = [
            'Spades' => [
                'A' => '🂡',
                '2' => '🂢',
                '3' => '🂣',
                '4' => '🂤',
                '5' => '🂥',
                '6' => '🂦',
                '7' => '🂧',
                '8' => '🂨',
                '9' => '🂩',
                '10' => '🂪',
                'J' => '🂫',
                'Q' => '🂭',
                'K' => '🂮',
            ],
            'Hearts' => [
                'A' => '🂱',
                '2' => '🂲',
                '3' => '🂳',
                '4' => '🂴',
                '5' => '🂵',
                '6' => '🂶',
                '7' => '🂷',
                '8' => '🂸',
                '9' => '🂹',
                '10' => '🂺',
                'J' => '🂻',
                'Q' => '🂽',
                'K' => '🂾',
            ],
            'Clubs' => [
                'A' => '🃑',
                '2' => '🃒',
                '3' => '🃓',
                '4' => '🃔',
                '5' => '🃕',
                '6' => '🃖',
                '7' => '🃗',
                '8' => '🃘',
                '9' => '🃙',
                '10' => '🃚',
                'J' => '🃛',
                'Q' => '🃝',
                'K' => '🃞',
            ],
            'Diamonds' => [
                'A' => '🃁',
                '2' => '🃂',
                '3' => '🃃',
                '4' => '🃄',
                '5' => '🃅',
                '6' => '🃆',
                '7' => '🃇',
                '8' => '🃈',
                '9' => '🃉',
                '10' => '🃊',
                'J' => '🃋',
                'Q' => '🃍',
                'K' => '🃎',
            ],
            'Joker' => [
                'Black' => '🃏'
            ]
            ];
        return $map[$this->suit][$this->value] ?? "$this->value of $this->suit";
    }

    public function __toString(): string
    {
        return $this->getGraphics();
    }

    public function __serialize(): array
    {
        return [$this->suit, $this->value];
    }

    public function __unserialize(array $data): void
    {
        [$this->suit, $this->value] = $data;
    }
}
