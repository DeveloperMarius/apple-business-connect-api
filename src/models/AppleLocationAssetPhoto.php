<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "pixelHeight": 1200,
 *  "pixelWidth": 1200,
 *  "url": "http://goodpartner.com/images/malibuicecream/3887887.jpg"
 *  }
 */
class AppleLocationAssetPhoto extends DataClass
{

    protected int $pixelHeight;
    protected int $pixelWidth;
    protected string $url;

    public function __construct(array $data){
        parent::setProperties($data);
    }

    public static function create(int $pixelHeight, int $pixelWidth, string $url): AppleLocationAssetPhoto
    {
        return new AppleLocationAssetPhoto(array(
            'pixelHeight' => $pixelHeight,
            'pixelWidth' => $pixelWidth,
            'url' => $url
        ));
    }
}