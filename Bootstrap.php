<?php
use Shopware\Recovery\Common\DependencyInjection\Container;
use ShopwarePlugins\SwagAsyncImageGenerator\Thumbnail\Generator\AsyncGenerator as QueuedImageGenerator;
use ShopwarePlugins\SwagAsyncImageGenerator\Worker\ImageGeneratorWorker;

class Shopware_Plugins_Core_SwagAsyncImageGenerator_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0-dev';
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return array(
            'version'     => $this->getVersion(),
            'autor'       => 'Benjamin Cremer',
            'copyright'   => 'Copyright (c) 2014, Benjamin Cremer',
            'label'       => 'SwagAsyncImageGenerator',
            'description' => 'Example Job Queue implementation for shopware',
            'license'     => 'The MIT License (MIT) (http://opensource.org/licenses/MIT)',
            'link'        => 'https://github.com/bcremer/SwagAsyncImageGenerator',
        );
    }

    /**
     * @return bool
     */
    public function install()
    {
        $this->subscribeEvent(
            'SwagJobQueue_Add_Worker',
            'onAddWorker'
        );

        $this->subscribeEvent(
            'Enlight_Bootstrap_InitResource_Thumbnail_Manager',
            'onInitResourceThumnailManager'
        );

        return true;
    }

    /**
     * @param  Enlight_Event_EventArgs                $args
     * @return \Shopware\Components\Thumbnail\Manager
     */
    public function onInitResourceThumnailManager(Enlight_Event_EventArgs $args)
    {
        /** @var Container $container */
        $container = $this->Application()->Container();

        /** @var ShopwarePlugins\SwagJobQueue\JobQueue\Queue $jobQueue */
        $jobQueue = $container->get('SwagJobQueue_Queue');
        $imageGenerator = new QueuedImageGenerator($jobQueue);

        return new \Shopware\Components\Thumbnail\Manager(
            $imageGenerator,
            $container->getParameter('kernel.root_dir'),
            $this->get('events')
        );
    }

    /**
     * @param  Enlight_Event_EventArgs $args
     * @return ImageGeneratorWorker
     */
    public function onAddWorker(Enlight_Event_EventArgs $args)
    {
        $imageGenerator = $this->get('thumbnail_generator_basic');

        return new ImageGeneratorWorker($imageGenerator);
    }

    /**
     * Register Plugin namespace in autoloader
     */
    public function afterInit()
    {
        /** @var Enlight_Loader $loader */
        $loader = $this->get('loader');
        $loader->registerNamespace(
            'ShopwarePlugins\\SwagAsyncImageGenerator',
            __DIR__ . '/'
        );
    }
}
