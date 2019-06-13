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
        $vmArray = array();

        $servers = $this->getDoctrine()
            ->getRepository(Server::class)
            ->findByIdUser($user = $this->getUser());

        foreach ($servers as $server) {

            $formatArray = array(
                "name" => $user->getUsername() .'-'. $server->getBaseOs() .'-'. $user->getId() .'-'.$server->getIdServer(),
                "os" => $server->getBaseOs(),
                "idServer" => $server->getIdServer()
            );

            array_push($vmArray, $formatArray);
        }

        return $this->render('default/history.html.twig', [
            'vms' => $vmArray
        ]);
    }

    /**
     * @Route("/history/ajax", name="history_ajax")
     * @param Request $request
     * @return JsonResponse
     */
    public function displayAjax(Request $request)
    {
        if ($request->request->get('vmName')) {

            $vmName = $request->request->get('vmName');

            exec('gcloud compute instances delete --quiet '. $vmName);

            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository(Server::class)->find($request->request->get('idServer'));
            $em->remove($entity);
            $em->flush();

            return new JsonResponse("VM destroy", 200);

        } else
            return new JsonResponse("VM name not found", 404);
    }

}