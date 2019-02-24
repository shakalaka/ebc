<?php

namespace App\Controller;

use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{

    /**
     * @var TaskService
     */
    private $taskService;

    public function __construct(TaskService $service)
    {
        $this->taskService = $service;
    }

    /**
     * Метод выполняет тестовую задачу
     *
     * @param Request $request Запрос
     * @return Response
     */
    public function task(Request $request)
    {
        $num = $request->request->get('num', 0);
        $data = $request->request->get('data', []);

        return new Response($this->taskService->process($num, $data, $this->getUser()));
    }
}
