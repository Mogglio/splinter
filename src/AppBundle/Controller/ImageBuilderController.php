<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Server;
use AppBundle\Entity\Configuration;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
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
     * @Route("/generate", name="generate")
     */
    public function generateAction(Request $request) {

        $result_infos = array();
        if ($request->getMethod() == Request::METHOD_POST) {
            $image_os = $request->request->get('image_os');

            $machineType = $request->request->get('type-machine');

            $family_name = $this->getDoctrine()
                ->getRepository(Configuration::class)
                ->getConfigurationByBaseOs($image_os);

            $result_infos = $this->generateScriptFile($image_os, $family_name[0]->family_os, $machineType);
        }

        if (substr_count($request->getHttpHost(), 'localhost') > 0) {
            $base_url = 'localhost';
        } else {
            $base_url = $request->getHttpHost();
        }

        return $this->render('default/confirm.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'infos' => $result_infos,
            'base_url' => $base_url
        ]);
    }

    public function generateScriptFile($image_os, $family_name, $machine_type) {
        $result_infos = array();
        $user = $this->getUser();
        $mdp = $this->generatepwd();
        $id_server = $this->createNewImageForUser($image_os);
        $tmp_user_dir = $image_os.'-'. $user->getId() .'-'.$id_server;
        mkdir($this->get('kernel')->getProjectDir().'/web/scripts/'.$tmp_user_dir, 0777);
        $content = $this->getContentForScript($user, $family_name, $mdp);
        $handle = fopen($this->get('kernel')->getProjectDir().'/web/scripts/'.$tmp_user_dir.'/script.sh', 'w') or die('Cannot open file: Dockerfile');
        fwrite($handle, $content);
        exec('gcloud compute instances create '.$user->getUsername().'-'.$tmp_user_dir.' --image-family '.$image_os.' --image-project '.$family_name.' --machine-type '. $machine_type .' --metadata-from-file startup-script='.$this->get('kernel')->getProjectDir().'/web/scripts/'.$tmp_user_dir.'/script.sh', $output, $return_var);
        $output_string = explode(' ',$output[1]);

        foreach ($output_string as $vm_info) {
            if ($vm_info != '') {
                $result_infos[] = $vm_info;
            }
        }

        $this->sendMailForUser($result_infos, $user, $mdp);

//        dump($output);
//        dump($result_infos);
//        dump($return_var);
//        exit;
        return $result_infos;
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

    public function getContentForScript($user, $family_name, $mdp)
    {
        if ($family_name != 'centos-cloud') {
            $content = '
                #! /bin/bash
                sudo su -
                
                apt-get update && apt-get install -y openssh-server sudo
                
                adduser --quiet --disabled-password --shell /bin/bash --home /home/'.$user->getUsername().' --gecos "'.$user->getUsername().'" '.$user->getUsername().'
                echo "'.$user->getUsername().':'.$mdp.'" | chpasswd
                adduser '.$user->getUsername().' sudo
                
                sed -n \'H;${x;s/\PasswordAuthentication no/PasswordAuthentication yes/;p;}\' /etc/ssh/sshd_config > tmp_sshd_config
                cat tmp_sshd_config > /etc/ssh/sshd_config
                rm tmp_sshd_config
                /etc/init.d/ssh restart';
        } else {
            $content = '
                #! /bin/bash
                sudo su -
                
                yum update && yum install -y openssh-server
                
                adduser --shell /bin/bash --home /home/'.$user->getUsername().' '.$user->getUsername().'
                echo "'.$user->getUsername().':'.$mdp.'" | chpasswd
                usermod -aG wheel '.$user->getUsername().'
                
                sed -n \'H;${x;s/\#PasswordAuthentication yes/PasswordAuthentication yes/;p;}\' /etc/ssh/sshd_config > tmp_sshd_config
                cat tmp_sshd_config > /etc/ssh/sshd_config
                rm -f tmp_sshd_config
                service sshd restart';
        }
        return $content;
    }

    private function generatepwd(){
        $characts= 'abcdefghijklmnopqrstuvwxyz';
        $characts.= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characts.= '1234567890';
        $code_aleatoire= '';
        $modele = "[0-9]";
        for ($i=0;$i < 8;$i++){
            $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
        }

        return $code_aleatoire;
    }

    private function sendMailForUser($result_infos, $user, $mdp)
    {
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
            ->setUsername('splintermastercloud@gmail.com')
            ->setPassword('O1*e#3nDfAx5^4AedpSw6MD')
        ;

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Votre machine est disponible'))
            ->setFrom(['splintermastercloud@gmail.com' => 'Splinter'])
            ->setTo([$user->getEmail()])
            ->setBody('Votre machine est disponible : 
        IP serveur : '.$result_infos[4].'
        Login : '.$user->getUsername().'
        mot de passe : '.$mdp.'
        ');

        $mailer->send($message);

        return new Response();
    }
}