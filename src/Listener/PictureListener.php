<?php
namespace App\Listener;

use App\Entity\Picture;
use Imagine\Gd\Imagine;
use Vich\UploaderBundle\Storage\StorageInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Storage\FileSystemStorage;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class PictureListener
{   
    private CacheManager $cacheManager;

    private UploaderHelper $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function preRemove(Picture $picture)
    {
        $this->cacheManager->remove($this->uploaderHelper->asset($picture, 'imageFile'), 'thumb');
    }
}