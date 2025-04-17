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

        foreach ($routes as $name => $route) {
            $path = $route->getPath();

            if(str_starts_with($path, '/api') && $path !== '/api') {
                $data[] = [
                    'name' => $name,
                    'path' => $path,
                ];
            }
        }
        return $this->json([
            'api_routes' => $data,
            'count_routes' => count($data),
        ]);
    }
}
