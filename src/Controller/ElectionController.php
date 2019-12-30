<?php

namespace App\Controller;

use App\Entity\Choice;
use App\Entity\Election;
use App\Repository\ElectionRepository;
use App\Service\HashGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ElectionController extends AbstractController
{
    /**
     * @Route("api/electrion/{hash}", name="get-election", methods={"GET"})
     */
    public function getElection($hash, ElectionRepository $electionRepository)
    {
        $election = $electionRepository->findByHash($hash);

        if (!$election) {
            return new Response('Not Found', 404);
        }

        return $this->json($election);
    }

    /**
     * @Route("api/election", name="create-election", methods={"POST"})
     */
    public function createElection(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        HashGenerator $generator,
        ElectionRepository $electionRepository,
        EntityManagerInterface $em
    )
    {
        $election = $serializer->deserialize($request->getContent(), Election::class, 'json');

        $errors = $validator->validate($election);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return $this->json(['error' => $errorsString], 400);
        }

        $hash = $generator->generate(8);

        while ($electionRepository->findByHash($hash)) {
            $hash = $generator->generate(10);
        }

        $election->setHash($hash);
        $em->persist($election);
        $em->flush();

        return $this->json(
            [
                'url' => $this->generateUrl('get-election', ['hash' => $hash])
            ],
            201
        );
    }

    /**
     * @Route("api/election/{election}", methods={"PUT"})
     */
    public function vote(
        Election $election,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    )
    {
        $choicesArray = $serializer->normalize($request->getContent(), 'json');

        foreach ($choicesArray as $choice) {
            $choice = $serializer->denormalize($choice, Choice::class);
            $election->vote($choice);
        }

        $entityManager->persist($election);
        $entityManager->flush();

        return new Response(null, 200);
    }

}
