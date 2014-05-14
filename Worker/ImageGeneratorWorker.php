<?php
namespace ShopwarePlugins\SwagAsyncImageGenerator\Worker;

use Shopware\Components\Thumbnail\Generator\GeneratorInterface;
use ShopwarePlugins\SwagJobQueue\JobQueue\Worker;
use ShopwarePlugins\SwagJobQueue\JobQueue\Job;
use Symfony\Component\Console\Output\OutputInterface;

class ImageGeneratorWorker implements Worker
{
    /**
     * @var GeneratorInterface
     */
    private $imageGenerator;

    /**
     * @param GeneratorInterface $imageGenerator
     */
    public function __construct(GeneratorInterface $imageGenerator)
    {
        $this->imageGenerator = $imageGenerator;
    }

    /**
     * @param  Job  $job
     * @return bool
     */
    public function canHandle(Job $job)
    {
        return $job->getName() === 'create_thumbnail';
    }

    /**
     * @param Job             $job
     * @param OutputInterface $output
     */
    public function handle(Job $job, OutputInterface $output)
    {
        $args = $job->getArgs();

        $output->writeln(sprintf("Create thumbnail %s", $args['destination']));

        try {
            $this->imageGenerator->createThumbnail(
                $args['image'],
                $args['destination'],
                $args['width'],
                $args['height']
            );
        } catch (\Exception $e) {
            $output->writeln("Got error . " . $e->getMessage());
        }
    }
}
