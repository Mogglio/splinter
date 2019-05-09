<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DockerBuildController extends Controller
{
    /**
     * @Route("/dockerbuild", name="dockerbuild")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/dockerbuild.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}