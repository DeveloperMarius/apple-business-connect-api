<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "xxlarge": {
 * "pixelHeight": 1200,
 * "pixelWidth": 1200,
 * "url": "http://goodpartner.com/images/malibuicecream/3887887.jpg"
 * },
 * thumbnail
 * small
 * medium
 * large
 * xlarge
 * xxlarge
 * original
 * }
 *
 * @see https://businessconnect.apple.com/docs/data-specification/v1.3/location_asset/properties#photos
 *
 *
 * Key          Minimum Length    Maximum Length    File Format
 * thumbnail    >= 100              =< 330          JPEG or PNG
 * small        >= 200              =< 660           -As above-
 * medium        >= 400              =< 1320         -As above-
 * large        >= 600               =< 1980            -As above-
 * xlarge       >= 800               =< 2640            -As above-
 * xxlarge       >= 1200             =< 3960         -As above-
 * original      >= 100             =< 4864            -As above-
 */
class AppleLocationAssetPhotos extends DataClass
{

    protected ?AppleLocationAssetPhoto $thumbnail = null;
    protected ?AppleLocationAssetPhoto $small = null;
    protected ?AppleLocationAssetPhoto $medium = null;
    protected ?AppleLocationAssetPhoto $large = null;
    protected ?AppleLocationAssetPhoto $xlarge = null;
    protected ?AppleLocationAssetPhoto $xxlarge = null;
    protected ?AppleLocationAssetPhoto $original = null;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'thumbnail' => AppleLocationAssetPhoto::class,
            'small' => AppleLocationAssetPhoto::class,
            'medium' => AppleLocationAssetPhoto::class,
            'large' => AppleLocationAssetPhoto::class,
            'xlarge' => AppleLocationAssetPhoto::class,
            'xxlarge' => AppleLocationAssetPhoto::class,
            'original' => AppleLocationAssetPhoto::class,
        ));
    }

    public function toArray(bool $cleanData = false): array
    {
        $data =  parent::toArray($cleanData);
        foreach ($data as $key => $value) {
            if($value === null)
                unset($data[$key]);
        }
        return $data;
    }
}