<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
    #[Route('/')]
    public function number(): Response
    {

        return new Response(
            '<html><body>
            HEJ HEJ :D </body></html>'
        );
    }

    #[Route("/lucky/hi")]
    public function hi(): Response
    {
        return new Response(
            '<html><body>Hi to you! :D</body></html>'
        );
    }
}
