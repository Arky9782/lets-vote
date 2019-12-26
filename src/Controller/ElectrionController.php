<?php

namespace App\Controller;

use App\Repository\ElectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElectrionController extends AbstractController
{
    /**
     * @Route("api/electrion/{hash}", name="electrion", methods={"GET"})
     */
    public function getElection($hash, ElectionRepository $electionRepository)
    {
        $election = $electionRepository->findByHash($hash);

        if (!$election) {
            return new Response('Not Found', 404);
        }

        return $this->json($election);
    }

}
