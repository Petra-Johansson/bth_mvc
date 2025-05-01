<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'api_index')]
    public function index(RouterInterface $router): JsonResponse
    {
        $routes = $router->getRouteCollection();
        $data = [];

        $descriptions = [
            'app_reportcontrollerjson_index' => 'Visar en index-sida för API:et. (Denna sida)',
            'app_reportcontrollerjson_todaysquote' => 'Returnerar dagens Taylor Swift citat i JSON-format.',
            'api_deck' => 'Returnerar kortleken sorterad.',
            'api_deck_shuffle' => 'Blandar kortleken.',
            'api_deck_shuffled' => 'Returnerar den blandade kortleken',
            'api_draw_one' => 'Drar ett kort.',
            'api_draw_multi' => 'Drar flera kort.',
            'api_drawn_cards' => 'Returnerar de dragna korten samt visar hur många som återstår.'
        ];

        foreach ($routes as $name => $route) {
            $path = $route->getPath();

            if (str_starts_with($path, '/api') && $path !== '/api') {
                $data[] = [
                    'name' => $name,
                    'path' => $path,
                    'description' => $descriptions[$name]
                ];
            }
        }
        return $this->json([
            'api_routes' => $data,
            'count_routes' => count($data),
        ]);
    }
}
