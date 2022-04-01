<?php

namespace App\Command;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateClientCommand extends Command
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UserPasswordHasherInterface $hasher
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('client:create')
            ->setDescription("Create a new client")
            ->setHelp('This command allows you to create a client');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();

        $helper = $this->getHelper('question');

        $question = new Question(
            '<question>Please type email</question>: ',
        );

        $client->setMail($helper->ask($input, $output, $question));

        $question = new Question(
            '<question>Please type password</question>: ',
        );

        $password = $helper->ask($input, $output, $question);
        $client->setPassword($this->hasher->hashPassword($client, $password));

        $question = new Question(
            '<question>Please type firstname</question>: ',
        );

        $client->setFirstname($helper->ask($input, $output, $question));

        $question = new Question(
            '<question>Please type lastname</question>: ',
        );

        $client->setLastname($helper->ask($input, $output, $question));

        $question = new Question(
            '<question>Please type patronymic(not required)</question>: ',
        );

        $client->setPatronymic($helper->ask($input, $output, $question));

        $question = new Question(
            '<question>Please type phone(not required)</question>: ',
        );

        $client->setPhone($helper->ask($input, $output, $question));

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}