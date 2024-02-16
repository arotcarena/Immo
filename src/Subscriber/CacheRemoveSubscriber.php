<?php
namespace App\Subscriber;

use App\Entity\Picture;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;

class CacheRemoveSubscriber implements EventSubscriberInterface
{

    private CacheManager $cacheManager;

    private UploaderHelper $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }


    public function getSubscribedEvents()
    {
        return [
            'preRemove'
        ];
    }
    public function preRemove(LifecycleEventArgs $args)
    {
        if($args->getObject() instanceof Picture)
        {
           $this->cacheManager->remove($this->uploaderHelper->asset($args->getObject(), 'imageFile'), 'thumb');
        }
    }
}