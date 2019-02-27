<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Service\TaskService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TaskCommand extends Command
{
    protected static $defaultName = 'task:run';

    /**
     * @var TaskService
     */
    private $taskService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * TaskCommand constructor.
     * @param TaskService $taskService
     * @param UserRepository $userRepository
     */
    public function __construct(TaskService $taskService, UserRepository $userRepository)
    {
        $this->taskService = $taskService;
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    /**
     * Конфигурация команды
     */
    protected function configure()
    {
        $this
            ->setDescription('Делит входной массив по определенному правилу и возвращает индекс числа перед которым ставится разделитель')
            ->addArgument('n', InputArgument::REQUIRED, 'Целое число')
            ->addArgument('data', InputArgument::REQUIRED, 'Массив целых чисел')
            ->addArgument('user', InputArgument::OPTIONAL, 'Идентификатор пользователя', null)
        ;
    }

    /**
     * Выполнение команды
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $int = $input->getArgument('n');
        $data = $input->getArgument('data');
        $user = $input->getArgument('user');

        $io->note(sprintf("\r\nВы ввели следующие данные:\n\rn: %s\n\rdata: %s\n\ruser: %s", $int, $data, $user ? $user : '-'));
        $data = explode(',', $data);
        if ($user !== null) {
            $userData = $this->userRepository->findOneBy(['id' => $user]);
        }

        try {
            $result = $this->taskService->process($int, $data, $userData);
            $io->success(sprintf('Результат выполнения задачи: %d', $result));
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }
    }
}
