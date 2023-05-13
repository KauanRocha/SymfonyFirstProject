<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
    #[Route('/lucky/number', name: 'app_lucky_number')]
    public function number(int $max): Response
    {
        return new Response(
            '<html><body>Lucky number:</body></html>'
        );
    }
}