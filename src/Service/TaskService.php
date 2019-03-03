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

        $key_out=  0;
        $key_in = 0;
        $i = 0;
        $size = sizeof($data);

        foreach ($data as $k => $v) {
            $out = $i;
            $in = $i;

            if ($key_in + $key_out >= $size) {
                break;
            }

            if ($data[$key_in] === $num) {
                $in++;
            }

            if ($data[$size - $key_out - 1] !== $num) {
                $out++;
            }

            if ($in > $out) {
                $key_out++;
                continue;
            }

            if ($in < $out) {
                $key_in++;
                continue;
            }

            $key_in++;
            $key_out++;

            $i = $in;
        }

        return $i ? $key_in: -1;
    }
}