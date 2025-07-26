<?php

declare(strict_types=1);

namespace App\UserInterface\CLI;

use App\Domain\Model\Promotion\Promotion;
use App\Domain\Model\Promotion\PromotionRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name:'app:import-promotions-from-json',
    description: 'Given a JSON file, import promotions into the database, if no filepath is provided, it will use storage/promotions.json by default',
    hidden: false
)]
class ImportPromotionsFromJsonCommand extends Command
{
    const FILEPATH = 'filepath';
    const DEFAULT_FILE = '/promotions.json';

    public function __construct(
        #[Autowire('%kernel.project_dir%/storage')]
        private string $storagePath,
        private PromotionRepository $promotionRepository,
    ){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(self::FILEPATH, InputArgument::OPTIONAL, 'promotions filepath');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filepath = $input->getArgument(self::FILEPATH) ?: $this->storagePath. self::DEFAULT_FILE;

        $data = json_decode(file_get_contents($filepath), true)['promotions'] ?? [];

        if (empty($data)) {
            $output->writeln("<error>No promotions found or bad format in $filepath</error>");
        }

        $itemsCount = count($data);
        $progressBar = new ProgressBar($output, $itemsCount);
        $progressBar->start();

        foreach($data as $item) {
            $promotion = Promotion::createFromPrimitives(
                $item['type'],
                $item['applicable_to'],
                $item['percentage']
            );

            try {
                $this->promotionRepository->save($promotion);
            } catch (\Throwable $e) {
                $item = json_encode($item);
                $output->writeln("<error>Error saving $item \n:> {$e->getMessage()}</error>");
            }
            $progressBar->advance();
            }

        $progressBar->finish();
        $output->writeln("\n<info>Done!</info>");
        return Command::SUCCESS;
    }
}
