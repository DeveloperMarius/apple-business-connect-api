<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 * {
 *  "imageId": "5154f9da-c079-4ea6-a145-8e53341a463d",
 *  "partnersAssetId": "business_asset_10101",
 *  "intent": "PLACECARD_LOGO",
 *  "altTexts": [
 *  {
 *  "text": "A barista preparing a cafe latte",
 *  "locale": "de-DE"
 *  }
 *  ]
 *  }
 */
class AppleBusinessAssetDetails extends DataClass
{

    protected string $imageId;
    protected string $partnersAssetId;
    protected AppleBusinessAssetIntent $intent;
    /**
     * @var AppleText[] $altTexts
     */
    protected array $altTexts;

    public function __construct(array $data){
        parent::setProperties($data, array(
            'intent' => AppleBusinessAssetIntent::class,
            'altTexts' => AppleText::class
        ));
    }

    public function getImageId(): string
    {
        return $this->imageId;
    }

    public function setImageId(string $imageId): void
    {
        $this->imageId = $imageId;
    }

    public function getPartnersAssetId(): string
    {
        return $this->partnersAssetId;
    }

    public function setPartnersAssetId(string $partnersAssetId): void
    {
        $this->partnersAssetId = $partnersAssetId;
    }

    public function getIntent(): AppleBusinessAssetIntent
    {
        return $this->intent;
    }

    public function setIntent(AppleBusinessAssetIntent $intent): void
    {
        $this->intent = $intent;
    }

    public function getAltTexts(): array
    {
        return $this->altTexts;
    }

    public function setAltTexts(array $altTexts): void
    {
        $this->altTexts = $altTexts;
    }

    public static function create(string $image_id, string $partners_asset_id, AppleBusinessAssetIntent $intent, string $alt_text): AppleBusinessAssetDetails
    {
        return new AppleBusinessAssetDetails(array(
            'imageId' => $image_id,
            'partnersAssetId' => $partners_asset_id,
            'intent' => $intent,
            'altTexts' => array(
                AppleText::create($alt_text)
            )
        ));
    }

}