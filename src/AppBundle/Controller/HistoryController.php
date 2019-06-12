<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Server;
use AppBundle\Entity\Configuration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HistoryController extends Controller
{
    /**
     * @Route("/history", name="history")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $userData = $this->getUser();
        $vmArray = array();
        $vmObj = new \stdClass();

        $servers = $this->getDoctrine()
            ->getRepository(Server::class)
            ->findByIdUser($user = $this->getUser());

        foreach ($servers as $server) {

//            array_push($vmArray, $user->getUsername() .'-'. $server->getBaseOs() .'-'. $user->getId() .'-'.$server->getIdServer());
//            array_push($vmArray, $server->getBaseOs());

            $formatArray = array(
                "name" => $user->getUsername() .'-'. $server->getBaseOs() .'-'. $user->getId() .'-'.$server->getIdServer(),
                "os" => $server->getBaseOs()
            );

            array_push($vmArray, $formatArray);
        }

        dump($vmArray);

        return $this->render('default/history.html.twig', [
            'vms' => $vmArray
        ]);
    }
}