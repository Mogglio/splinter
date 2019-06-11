<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Server;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ImageBuilderController extends Controller
{
    /**
     * @Route("/imagebuilder", name="imagebuilder")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/imagebuilder.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/confirm", name="confirm")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmAction(Request $request)
    {
        return $this->render('default/confirm.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/generate", name="generate")
     */
    public function generateAction(Request $request) {

        if ($request->getMethod() == Request::METHOD_POST) {
            $image_os = $request->request->get('image_os');

            $dockerFileGenerated = $this->generateScriptFile($image_os);
        }

        return $this->redirectToRoute('confirm');
    }

    public function generateScriptFile($image_os) {
        $user = $this->getUser();
        $id_server = $this->createNewImageForUser($image_os);
        $tmp_user_dir = 'sh_'. $user->getId() .'_'.$id_server;

        mkdir($this->get('kernel')->getProjectDir().'/web/scripts/'.$tmp_user_dir, 0777);

        $content = '
        #! /bin/bash
        sudo su -
        
        apt-get update && apt-get install -y openssh-server sudo nano
        
        adduser --quiet --disabled-password --shell /bin/bash --home /home/'.$user->username.' --gecos "'.$user->username.'" '.$user->username.'
        echo "'.$user->username.':insset" | chpasswd
        adduser '.$user->username.' sudo
        
        sed -n \'H;${x;s/\PasswordAuthentication no/PasswordAuthentication yes/;p;}\' /etc/ssh/sshd_config > tmp_sshd_config
        cat tmp_sshd_config > /etc/ssh/sshd_config
        rm tmp_sshd_config
        /etc/init.d/ssh restart';

        // gcloud compute instances create name-vm --image-family debian-9 --image-project debian-cloud --metadata-from-file startup-script=script.sh

        $handle = fopen($this->get('kernel')->getProjectDir().'/web/scripts/'.$tmp_user_dir.'/script.sh', 'w') or die('Cannot open file: Dockerfile');

        fwrite ($handle, $content);

        exit;
        return true;
    }

    public function createNewImageForUser($image_os)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $server = new Server();
        $server->setIdUser($user->getId());
        $server->setBaseOs($image_os);
        $entityManager->persist($server);
        $entityManager->flush();

        return $server->getIdServer();
    }
}