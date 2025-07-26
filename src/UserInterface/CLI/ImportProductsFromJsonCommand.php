<?php

declare(strict_types=1);

namespace App\UserInterface\CLI;

use App\Domain\Model\Price\Price;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name:'app:import-products-from-json',
    description: 'Given a JSON file, import products into the database, if no filepath is provided, it will use storage/products.json by default',
    hidden: false
)]
class ImportProductsFromJsonCommand extends Command
{
    const FILEPATH = 'filepath';
    public function __construct(
        #[Autowire('%kernel.project_dir%/storage')]
        private string                     $storagePath,
        private ProductRepository $productRepository,
    ){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(self::FILEPATH, InputArgument::OPTIONAL, 'products filepath');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filepath = $input->getArgument(self::FILEPATH) ?: $this->storagePath.'/products.json';

        $data = json_decode(file_get_contents($filepath), true)['products'] ?? [];
        $itemsCount = count($data);
        $progressBar = new ProgressBar($output, $itemsCount);
        $progressBar->start();
        foreach(array_chunk($data, 100) as $chunk) {
            foreach($chunk as $item) {
                /** @var Product $product */
                $product = Product::createFromPrimitives(
                    $item['name'],
                    $item['sku'],
                    $item['category']
                );
                $price = Price::createFromPrimitives(
                    $item['sku'],
                    $item['price'],
                );
                try {
                    $this->productRepository->saveWithPrice($product, $price);
                } catch (\Throwable $e) {
                    $sku = $item['sku'];
                    $output->writeln("<error>Error saving $sku: {$e->getMessage()}</error>");
                }
                $progressBar->advance();
            }
        }
        $progressBar->finish();
        $output->writeln("\n<info>Done!</info>");
        return Command::SUCCESS;
    }
}
