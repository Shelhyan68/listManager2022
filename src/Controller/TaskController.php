<?php

namespace App\Controller;

use App\Entity\ListManager;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends AbstractController
{
    /**
     * @Route("/create-task/{id}", name="create_task")
     */
    public function create(Request $request, EntityManagerInterface $em, ListManager $list): Response
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $task->setCompleted(0);
            $task->setList($list);
            $em->getRepository(ListManager::class);
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute("read_all");
        }

        return $this->render('task/create.html.twig', [
            "form"=>$form->createView()
        ]);
    }

        /**
     * @Route("/update-task/{id}", name="update_task")
     */
    public function update(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->getRepository(ListManager::class);
            $em->flush();
            return $this->redirectToRoute("read_all");
        }

        return $this->render("task/create.html.twig", [
            "form"=>$form->createView(),
            "task"=>$task
        ]);
    }

    /**
     * @Route("/delete-task/{id}", name="delete_task")
     */
    public function delete(Task $task, EntityManagerInterface $em): Response
    {
    
        $em->getRepository(ListManager::class);
        $em->remove($task);
        $em->flush();

            return $this->redirectToRoute("read_all");
    
    }

        /**
     * @Route("/update-task-status/{id}", name="update_task_status")
     */
    public function updateTaskStatus(Task $task, EntityManagerInterface $em): Response
    {
    
        $task->setCompleted(!$task->getCompleted());
        $em->getRepository(ListManager::class);
        $em->flush();

        return $this->redirectToRoute("read_all");
    }

}
