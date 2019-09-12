<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SkillRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var SkillRepository
     */
    private $skillRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        SkillRepository $skillRepository
    )
    {
        $this->entityManager=$entityManager;
        $this->userRepository=$userRepository;
        $this->skillRepository=$skillRepository;
    }

    /**
     * @return Response
     * @Route("/users", methods={"GET"})
     */
    public function getAllUsers(): Response
    {
        return new JsonResponse($this->userRepository->findAll(),Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/user/{id}", methods={"GET"})
     */
    public function getOneUser(int $id): Response
    {
        $thisUser = $this->userRepository->find($id);
        if(is_null($thisUser)){
            return new Response('',Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($thisUser,Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/register", methods={"POST"})
     */
    public function newUser(Request $request): Response
    {
        $newUser = json_decode($request->getContent());

        $skillId = $newUser->skillId;
        $skill = $this->skillRepository->find($skillId);
        $user = new User();
        $user
            ->setUsername($newUser->username)
            ->setEmail($newUser->email)
            ->setPassword($newUser->password)
            ->setSkill($skill);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @Route ("/user/{id}/update", methods={"PUT"})
     */

    public function updateUser(Request $request, int $id): Response
    {
        $newUser = json_decode($request->getContent());

        $skillId = $newUser->skillId;

        $skill = $this->skillRepository->find($skillId);
        $existingUser = $this->userRepository->find($id);
        if(is_null($existingUser)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        $existingUser
            ->setUsername($newUser->username)
            ->setEmail($newUser->email)
            ->setPassword($newUser->password)
            ->setSkill($skill);

        $this->entityManager->persist($existingUser);
        $this->entityManager->flush();
        return new JsonResponse($existingUser, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/user/delete/{id}", methods={"DELETE"})
     */
    public function deleteUser(int $id): Response
    {
        $user = $this->userRepository->find($id);
        if(is_null($user)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $skill_id
     * @return Response
     * @Route("/skill/{skill_id}/users", methods={"GET"})
     */
    public function usersBySkill(int $skill_id): Response
    {
        $users= $this->userRepository->findBy([
            'Skill' => $skill_id
        ]);


        return new JsonResponse($users,Response::HTTP_OK);
    }
}
