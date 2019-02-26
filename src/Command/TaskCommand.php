<?php

namespace App\Command;

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
     * TaskCommand constructor.
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;

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

        try {
            $result = $this->taskService->process($int, $data, $user);
            $io->success(sprintf('Результат выполнения задачи: %d', $result));
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }
    }
}
