<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\MoviePosters;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchMoviePostersCommand extends Command
{
    protected static $defaultName = 'app:search_movie_posters';

    private MoviePosters $postersService;

    public function __construct(MoviePosters $postersService)
    {
        $this->postersService = $postersService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Look for movie posters');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting posters search');

        $count = $this->postersService->search();

        $output->writeln(sprintf('Found %d posters', $count));

        return Command::SUCCESS;
    }
}