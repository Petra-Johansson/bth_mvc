<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportControllerJson
{
    #[Route("/api/index")]
    public function index(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Yohoho! :)',
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/quote")]
    public function todaysQuote(): Response
    {
        $quotes = [
            "My imagination is a twisted place.",
            "I had the time of my life fighting dragons with you",
            "Living for the thrill of hitting you where it hurts",
            "Once upon a time, the planets and the fates and all the stars aligned",
            "Sleep in half the day just for old times' sake",
            "I'm not asleep, my mind is alive"
        ];

        $todaysQuote = $quotes[array_rand($quotes)];
        $now = date('Y-m-d H:i:s');

        $data = [
            'quote' => $todaysQuote,
            'generated_at' => $now,
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
