<?php

namespace App\Controller;

use App\Repository\ProdutoRepository;
use App\Entity\Produto;
use App\Form\ProdutoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ProdutoController extends AbstractController
{

    /**
    * @Route("/produto", name="produto")
    */
    public function index(EntityManagerInterface $em, ProdutoRepository $produtoRepository)
    {
        $data['produtos'] = $produtoRepository->findAll();
        $data['title'] = 'Gerenciar produtos';

        return $this->render('produto/index.html.twig', $data);

    }

    /**
    * @Route("/produto/adicionar", name="adicionar_produto")
    */
    public function adicionar(Request $request, EntityManagerInterface $em) : Response
    {
        $msg = " ";
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // salvar o novo produto no DB
            $em->persist($produto);
            $em->flush();
            $msg = "Produto adiconado com sucesso!";
        }

        $form = $this->createForm(ProdutoType::class);
        $data['title'] = 'Adicionar novo Produto';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('produto/form.html.twig', $data);
    }

    /**
     * @Route("/produto/editar/{id}", name="editar_produto")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ProdutoRepository $produtoRepository) : Response
    {
        $msg = "";
        $produto = $produtoRepository->find($id); // retorna categoria pelo id
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush(); // Faz o update par ao DB
            $msg = 'Produto atualizado com sucesso!';
        }

        $data['title'] = 'Editar produto';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('produto/form.html.twig', $data);
    }

    /**
    * @Route("/produto/excluir/{id}", name="excluir_produto")
    */
    public function excluir($id, EntityManagerInterface $em, ProdutoRepository $produtoRepository) : Response
    {

        $produto = $produtoRepository->find($id);
        $em->remove($produto); //Excluir 
        $em->flush(); // Efe

        return $this->redirectToRoute('produto');
    }
}