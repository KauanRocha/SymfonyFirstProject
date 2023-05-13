<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoriaRepository;



class CategoriaController extends AbstractController
{

    /**
    * @Route("/categoria", name="categoria")
    */
    public function index(CategoriaRepository $categoriaRepository) : Response
    {
        $data['title'] = 'Gerenciar Categorias';
        $data['categorias'] = $categoriaRepository->findAll();
    
        return $this->render('categoria/index.html.twig', $data);
    }

    /**
    * @Route("/categoria/adicionar", name="adicionar_categoria")
    */
    public function adicionar(Request $request, EntityManagerInterface $em) : Response
    {
        $msg = " ";
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // salvar a nota categoria no DB
            $em->persist($categoria);
            $em->flush();
            $msg = "Categoria adiconada com sucesso!";
        }

        $data['title'] = 'Adicionar nova categoria';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('categoria/form.html.twig', $data);
    }

    /**
    * @Route("/categoria/editar/{id}", name="editar_categoria")
    */
    public function editar($id, Request $request, EntityManagerInterface $em, CategoriaRepository $categoriaRepository) : Response
    {
        $msg = "";
        $categoria = $categoriaRepository->find($id); // retorna categoria pelo id
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush(); // Faz o update par ao DB
            $msg = 'Produto atualizado com sucesso!';
        }

        $data['title'] = 'Editar categoria';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('categoria/form.html.twig', $data);
    }

    /**
    * @Route("/categoria/excluir/{id}", name="excluir_categoria")
    */
    public function excluir($id, EntityManagerInterface $em, CategoriaRepository $categoriaRepository) : Response
    {

        $categoria = $categoriaRepository->find($id);
        $em->remove($categoria); //Excluir 
        $em->flush(); // Efe

        return $this->redirectToRoute('categoria');
    }
}