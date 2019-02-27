<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(RegistryInterface $registry, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($registry, User::class);
        $this->encoder = $encoder;
    }

    /**
     * Добавляет пользователя в базу
     *
     * @param $credentials
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function register($credentials) : User
    {
        $em = $this->getEntityManager();

        $user = new User($credentials['username']);
        $user->setPassword($this->encoder->encodePassword($user, $credentials['password']));
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
