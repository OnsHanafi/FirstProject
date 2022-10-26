<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher/{name}', name: 'app_teacher')]
    public function showTeacher(string $name): Response
    {

        return new Response ($name);
        return $this->render('teacher/showTeacher.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }
}
