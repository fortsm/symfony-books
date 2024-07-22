<?php

namespace App\Command;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:delete-authors',
    description: 'Удаляет авторов без книг.',
    hidden: false,
)]
class DeleteAuthorsWithoutBooksCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setHelp('Эта команда удалит всех авторов, у которых нет ни одной книги.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $authors = $this->entityManager->getRepository(Author::class)->withoutBooks();

        $count = count($authors);

        if ($count > 0) {
            foreach ($authors as $author) {
                $this->entityManager->remove($author);
            }
            $this->entityManager->flush();

            $output->writeln("Удалено {$count} авторов.");
        } else {
            $output->writeln('Авторы без книг не найдены.');
        }

        return Command::SUCCESS;

    }
}
