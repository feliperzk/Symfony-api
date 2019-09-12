<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillsController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SkillRepository
     */
    private $skillRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SkillRepository $skillRepository
    )
    {
        $this->entityManager=$entityManager;
        $this->skillRepository=$skillRepository;
    }

    /**
     * @return Response
     * @Route("/skills", name="skills", methods={"GET"})
     */
    public function getAllSkills(): Response
    {
        $skillList = $this->skillRepository->findAll();

        return new JsonResponse($skillList, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/skill/{id}", methods={"GET"})
     */
    public function getOneSkill(int $id): Response
    {
        $skill = $this->skillRepository->find($id);
        if(is_null($skill)){
            return new Response('',Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($skill, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/skill/new", methods={"POST"})
     */
    public function newSkill(Request $request): Response
    {
        $reqData = $request->getContent();

        $newSkill = json_decode($reqData);

        $skill = new Skill();
        $skill
            ->setSkillDesc($newSkill->skillDesc);

        $this->entityManager->persist($skill);
        $this->entityManager->flush();

        return new JsonResponse($skill, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/skill/{id}/update", methods={"PUT"})
     */
    public function updateSkill(int $id, Request $request): Response
    {
        $newSkill = json_decode($request->getContent());

        $skill = $this->skillRepository->find($id);
        if(is_null($skill)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $skill
            ->setSkillDesc($newSkill->skillDesc);

        $this->entityManager->persist($skill);
        $this->entityManager->flush();

        return new JsonResponse($skill,Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/skill/delete/{id}", methods={"DELETE"})
     */
    public function removeSkill(int $id): Response
    {

        $skill = $this->skillRepository->find($id);
        if(is_null($skill)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($skill);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

}
