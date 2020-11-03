<?php


namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    const SHOP_ICON = 'shop_image';

    private $uploadsPath;

    public function __construct( string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadShopIcon(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsPath.'/shop_image';

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename.'-'.uniqid();
        $uploadedFile->move(
            $destination,
            $newFilename
        );
        return $newFilename;
    }

    public static function getPublicPath(string $path): string
    {
        return 'uploads/'.$path;
    }
}