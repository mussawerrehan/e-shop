<?php


namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    const SHOP_ICON = '/shop_image';
    const PRODUCT_IMAGE = '/product_image';
    const CATEGORY_ICON = '/category_image';

    private $uploadsPath;

    public function __construct( string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadImage(UploadedFile $uploadedFile, string $imageDir): string
    {
        $destination = $this->uploadsPath.$imageDir;

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