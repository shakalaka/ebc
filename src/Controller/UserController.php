<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{

    /**
     * Репозиторий для работы с пользователями
     *
     * @var UserRepository
     */
    private $repository;

    /**
     * UserController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Регистрирует пользователя
     *
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function register(Request $request) : Response
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $this->repository->register([
            'username' => $username,
            'password' => $password
        ]);

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }
}
