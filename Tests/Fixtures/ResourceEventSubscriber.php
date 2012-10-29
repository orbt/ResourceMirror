<?php

namespace Orbt\ResourceMirror\Tests\Fixtures;

use Orbt\ResourceMirror\Event\ResourceEvents;
use Orbt\ResourceMirror\Event\ResourceMaterializeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResourceEventSubscriber implements EventSubscriberInterface
{
    public $resources = array();

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(ResourceEvents::MATERIALIZE => 'onResourceMaterialize');
    }

    public function onResourceMaterialize(ResourceMaterializeEvent $e)
    {
        $this->resources[] = $e->getResource();
    }
}
