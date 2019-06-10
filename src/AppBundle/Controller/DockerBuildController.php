<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Server;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DockerBuildController extends Controller
{
    /**
     * @Route("/dockerbuild", name="dockerbuild")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/dockerbuild.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function fetchImagesFromDockerHub($chosen_os)
    {
        $url = 'https://registry.hub.docker.com/v2/repositories/library/'.$chosen_os.'/tags?page_size=30';
        $header=array("content-type"=>"application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);

        curl_close($ch);
        $result = json_decode($result);
        return $result;
    }

    /**
     * @Route("/validate_os", name="validate_os")
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function ajaxValidateOSAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            $chosen_os = $_POST['chosen_os'];
            $os_versions = $this->fetchImagesFromDockerHub($chosen_os);

            return new JsonResponse($os_versions);
        }

        return new Response('This is not ajax!', 400);
    }

    /**
     * @Route("/generate", name="generate")
     */
    public function generateAction(Request $request) {

        if ($request->getMethod() == Request::METHOD_POST) {
            $image_os = $request->request->get('image_os');
            $os_version = $request->request->get('os_version');

            $dockerFileGenerated = $this->generateDockerFile($image_os, $os_version);
        }

        /**
         * TODO make route "you will receive an email"
         */
        return $this->redirectToRoute('dockerbuild');
    }

    public function generateDockerFile($image_os, $os_version) {
        $dockerfile = 'Dockerfile';
        $handle = fopen($this->get('kernel')->getProjectDir().'/web/dockerfiles/'.$dockerfile, 'w') or die('Cannot open file:  '.$dockerfile);

        fwrite ($handle ,'FROM ' . $image_os . ':' . $os_version);

        $this->createNewImageForUser($image_os,$os_version);

        dump('docker build -t simple '.$this->get('kernel')->getProjectDir().'/web/dockerfiles/');
        exec('docker build -t simple '.$this->get('kernel')->getProjectDir().'/web/dockerfiles/', $output, $return_var);
        dump($output);
        dump($return_var);

        exit;
        return true;
    }

    public function createNewImageForUser($image_os,$os_version)
    {

        var_dump($image_os, $os_version);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        dump($user->getId());
        $server = new Server();
        $server->setIdUser($user->getId());
        $server->setBaseOs($image_os);
        $server->setVersionOs($os_version);
        $entityManager->persist($server);
        $entityManager->flush();
    }
}