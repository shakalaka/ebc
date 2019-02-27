<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\TaskRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class TaskService
{

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * TaskService constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Точка входа для выполнения тестовой задачи
     *
     * @param int   $num  Целое число
     * @param array $data Массив чисел
     * @param User  $user Пользователь
     * @return int
     */
    public function process($num, $data, $user = null) : int
    {
        $result = $this->taskCalc($num, $data);

        $task = [
            'input' => json_encode([
                'num' => $num,
                'data' => $data
            ]),
            'output' => $result,
            'user_id' => $user !== null ? $user->getId() : null
        ];

        try {
            $this->taskRepository->log($task);
        } catch (OptimisticLockException $e) {
            return $e->getMessage();
        } catch (ORMException $e) {
            return $e->getMessage();
        }

        return $result;
    }

    /**
     * Производит вычисления
     *
     * @param int   $num  Целое число
     * @param array $data Массив чисел
     * @return int
     */
    private function taskCalc($num, $data) : int
    {

        $out = 0;
        $in = 0;
        $size = sizeof($data);
        foreach ($data as $k => $v) {
            if ($v !== $num) {
                $out += 1;
            } else {
                $in += 1;
            }

            if ($k % ceil($size / 2) === 0 && $in > 1 && $out > 1) {
                return $k;
            }
        }

        return -1;
    }
}