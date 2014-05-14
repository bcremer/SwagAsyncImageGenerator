<?php
namespace ShopwarePlugins\SwagAsyncImageGenerator\Thumbnail\Generator;

use Shopware\Components\Thumbnail\Generator\GeneratorInterface;
use ShopwarePlugins\SwagJobQueue\JobQueue\Job;
use ShopwarePlugins\SwagJobQueue\JobQueue\Queue;

class AsyncGenerator implements GeneratorInterface
{
    /**
     * @var \ShopwarePlugins\SwagJobQueue\JobQueue\Queue
     */
    private $jobQueue;

    /**
     * @param Queue $jobQueue
     */
    public function __construct(Queue $jobQueue)
    {
        $this->jobQueue = $jobQueue;
    }

    /**
     * {@inheritdoc}
     */
    public function createThumbnail($image, $destination, $width, $height)
    {
        $job = new Job(
            'create_thumbnail',
            array(
                'image'       => $image,
                'destination' => $destination,
                'width'       => $width,
                'height'      => $height,
            )
        );
        $this->jobQueue->addJob($job);
    }
}
