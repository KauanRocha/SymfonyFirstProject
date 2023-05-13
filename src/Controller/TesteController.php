<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;



class TesteController extends AbstractController
{
    /**
    * @Route("/teste", name="teste")
    */
    public function index() : Response
    {
        $data['paragrafo'] = "Um paragrafo qualquer";
        $data['title'] = "Página de testes";
        $data['frutas'] = [
            [
            'nome' => 'banana',
            'valor' => 1.99
            ],
            [
            'nome' => 'laranja',
            'valor' => 1.49
            ]
            ];
        return $this->render('teste/index.html.twig', $data);
    }

    public function detalhes($id) : Response
    {
        $data['titulo'] = 'Detalhes da página';
        $data['id'] = $id;
        return $this->render('teste/detalhes.html.twig', $data);
    }
}