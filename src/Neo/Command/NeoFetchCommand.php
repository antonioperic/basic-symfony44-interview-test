<?php

namespace App\Neo\Command;

use App\Neo\Manager\NasaManager;
use App\Neo\Nasa\NasaService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NeoFetchCommand extends Command
{
    protected static $defaultName = 'neo:fetch';

    /**
     * @var NasaService
     */
    private $nasaService;
    /**
     * @var NasaManager
     */
    private $nasaManager;


    public function __construct(NasaService $nasaService, NasaManager $nasaManager, string $name = null)
    {
        parent::__construct($name);

        $this->nasaService = $nasaService;
        $this->nasaManager = $nasaManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addOption('since', null, InputOption::VALUE_REQUIRED, 'Option description', '-3days');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->nasaManager->updateFeed($input->getOption('since'));

        return 0;
    }
}
