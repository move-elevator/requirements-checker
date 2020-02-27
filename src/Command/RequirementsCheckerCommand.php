<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Command;

use InvalidArgumentException;
use MoveElevator\RequirementsChecker\RequirementsCheckerApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException as SymfonyInvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Exception\ParseException;

class RequirementsCheckerCommand extends Command
{
    // @codingStandardsIgnoreStart
    /**
     * @var string
     */
    private $commandPreRollText = <<<'PreRoll'
                             _                                     _                      _                  _               
    _ __  ___   __ _  _   _ (_) _ __  ___  _ __ ___    ___  _ __  | |_  ___          ___ | |__    ___   ___ | | __ ___  _ __ 
   | \'__|/ _ \ / _` || | | || || \'__|/ _ \| \'_ ` _ \  / _ \| \'_ \ | __|/ __| _____  / __|| \'_ \  / _ \ / __|| |/ // _ \| \'__|
   | |  |  __/| (_| || |_| || || |  |  __/| | | | | ||  __/| | | || |_ \__ \|_____|| (__ | | | ||  __/| (__ |   <|  __/| |   
   |_|   \___| \__, | \__,_||_||_|   \___||_| |_| |_| \___||_| |_| \__||___/        \___||_| |_| \___| \___||_|\_\\___||_|   
                  |_|
PreRoll;
    // @codingStandardsIgnoreEnd

    /**
     * @throws InvalidArgumentException
     * @throws SymfonyInvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setName('app:requirements-checker')
            ->addArgument('yamlFile', InputArgument::REQUIRED, 'The path to configuration yaml file.')
            ->setDescription('checks the requirement by given yaml file')
            ->setHelp('This command allows you to check requirements by given yaml file...');
    }

    /**
     * @throws InvalidArgumentException
     * @throws ParseException
     * @throws SymfonyInvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $yamlFilePath = $input->getArgument('yamlFile');
        if (false === is_string($yamlFilePath)) {
            throw new InvalidArgumentException('could not read yaml-file', 1573220919);
        }

        $yamlFilePath = realpath($yamlFilePath);
        if (false === $yamlFilePath || false === is_readable($yamlFilePath)) {
            throw new InvalidArgumentException(
                sprintf('given yaml file is not readable (given file: %s)', $yamlFilePath),
                1573220930
            );
        }

        $output->writeln($this->commandPreRollText);
        $output->writeln('<error>BEWARE: console applications can use different ini´s.</error>' . PHP_EOL);

        foreach ((new RequirementsCheckerApplication($yamlFilePath))->check() as $result) {
            $cssClass = 'error';
            if (true === $result->isSuccess()) {
                $cssClass = 'info';
            }

            $output->writeln(
                sprintf(
                    '<%s>%s:</%s> %s',
                    $cssClass,
                    $result->getName(),
                    $cssClass,
                    $result->getMessage()
                )
            );
        }

        return 0;
    }
}
