<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project')]
    public function index(ProjectRepository $repository): Response
    {
        return $this->render('project/index.html.twig', [
            "projets"=>$repository->findAll()
        ]);
    }



    #[Route("/create",name: "app_project_create")]
    public function createProject(EntityManagerInterface $manager, Request $request):Response{

        $project = new Project();
        $projectForm = $this->createForm(ProjectType::class,$project);
        $projectForm->handleRequest($request);
        if ($projectForm->isSubmitted() && $projectForm->isValid()){

            $manager->persist($project);
            $manager->flush();

            return $this->redirectToRoute("app_project");

        }

        return $this->render("project/create.html.twig",[
            "projectForm"=>$projectForm
        ]);
    }

    #[Route("/show/{id}",name: "app_project_showproject")]
    public function showProject(Project $project):Response{

        return $this->render("project/show.html.twig",[
            "projet"=>$project
        ]);
    }


    #[Route("/project/{id}",name: "/app_project_addm1")]
    public function addM1(Project $project, EntityManagerInterface $manager):Response{

        $project->addM1($this->getUser());
        $manager->persist($project);
        $manager->flush();

        return $this->redirectToRoute("app_project_showproject",[
            "id"=>$project->getId()
        ]);
    }



    #[Route("/project/{id}",name: "app_project_addbachelor")]
    public function addBachelor(Project $project, EntityManagerInterface $manager):Response{

        $project->setBachelor($this->getUser());
        $manager->persist($project);
        $manager->flush();

        return $this->redirectToRoute("app_project_showproject",[
            "id"=>$project->getId()
        ]);
    }

    /**
    #[Route("/project/remove/{id}",name: "/app_project_removem1")]
    public function removeM1(Project $project, EntityManagerInterface $manager):Response{


        $project->removeM1($this->getUser());
        $manager->persist($project);
        $manager->flush();

        return $this->redirectToRoute("app_project_showproject",[
            "id"=>$project->getId()
        ]);
    }**/
}
