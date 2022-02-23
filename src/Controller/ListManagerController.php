<?php

namespace App\Controller;

use App\Entity\ListManager;
use App\Entity\Task;
use App\Form\ListManagerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class ListManagerController extends AbstractController {

    /**
     * @Route("/create-list", name="create_list")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $listManager = new ListManager();

        $form = $this->createForm(ListManagerType::class, $listManager);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('success', 'Liste enregistrée !');
            $em->getRepository(ListManager::class);
            $em->persist($listManager);
            $em->flush();
            return $this->redirectToRoute("read_all");
        }
        

        return $this->render("list_Manager/create.html.twig", [
            "form"=>$form->createView()
        ]);

        

    }


    /**
     * @Route("/", name="read_all")
     */
    public function readAll(EntityManagerInterface $em): Response
    {
       $repo  = $em->getRepository(ListManager::class);
       $lists = $repo->findAll();

       return $this->render("list_Manager/index.html.twig", [
        "lists"=> $lists
    ]);
    }

    /**
     * @Route("/update-list/{id}", name="update_list")
     */
    public function update(ListManager $list, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ListManagerType::class, $list);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->getRepository(ListManager::class);
            $em->flush();
            return $this->redirectToRoute("read_all");
        }

        return $this->render("list_Manager/create.html.twig", [
            "form"=>$form->createView(),
            "list"=>$list
        ]);
    }

    /**
     * @Route("/delete-list/{id}", name="delete")
     */
    public function delete(ListManager $list, EntityManagerInterface $em): Response
    {
    
        $em->getRepository(ListManager::class);
        $em->remove($list);
        $em->flush();

            return $this->redirectToRoute("read_all");
    
    }

}