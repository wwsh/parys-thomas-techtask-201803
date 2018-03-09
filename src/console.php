<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$console = new Application('My Silex TechTask', 'n/a');
$console->getDefinition()
    ->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev'));
$console->setDispatcher($app['dispatcher']);
$console
    ->register('hello-command')
    ->setDescription('Hello World description')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $output->writeln('Hello World! Use /lunch to get your lunch!');
    });

return $console;
