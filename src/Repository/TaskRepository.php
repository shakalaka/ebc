<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * Сохраняет результат выполнения задачи и её параметры
     *
     * @param $params
     * @return Task
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function log($params) : Task
    {
        $em = $this->getEntityManager();

        $task = new Task();
        $task->setInput($params['input']);
        $task->setOutput($params['output']);
        $task->setUserId($params['user_id']);
        $em->persist($task);
        $em->flush();

        return $task;
    }
}
