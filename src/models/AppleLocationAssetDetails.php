<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;
use utils\Time;

/**
 * Example: {
 *  "partnersAssetId": "9090909090",
 *  "dateAdded": "2022-09-10T12:45:34.000Z",
 *  "intent": "GALLERY",
 *  "captions": [
 *  {
 *  "title": "Exterior View",
 *  "altText": "Storefront and and outdoor patio with tables and chairs",
 *  "locale": "en-US"
 *  }
 *  ],
 *  "source": "USER",
 *  "capturedBy": "Jane D.",
 *  "classifications": [
 *  "exterior",
 *  "outdoors"
 *  ],
 *  "coordinates": {
 *  "latitude": "30.2210519",
 *  "longitude": "-97.7199035"
 *  },
 *  "photos": {
 *  "xxlarge": {
 *  "pixelHeight": 1200,
 *  "pixelWidth": 1200,
 *  "url": "http://goodpartner.com/images/malibuicecream/3887887.jpg"
 *  }
 *  }
 *  }
 */
class AppleLocationAssetDetails extends DataClass
{

    protected string $partnersAssetId;
    protected string $dateAdded;
    protected AppleLocationAssetIntent $intent;
    /**
     * @var AppleLocationAssetCaption[] $captions
     */
    protected array $captions;
    protected AppleLocationAssetSource $source;
    protected ?string $capturedBy = null;
    /**
     * @var string[] $classifications
     */
    protected array $classifications;
    protected ?AppleCoordinates $coordinates = null;
    protected AppleLocationAssetPhotos $photos;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'intent' => AppleLocationAssetIntent::class,
            'source' => AppleLocationAssetSource::class,
            'coordinates' => AppleCoordinates::class,
            'photos' => AppleLocationAssetPhotos::class,
            'captions' => AppleLocationAssetCaption::class,
        ));
    }

    public function getPartnersAssetId(): string
    {
        return $this->partnersAssetId;
    }

    public function setPartnersAssetId(string $partnersAssetId): void
    {
        $this->partnersAssetId = $partnersAssetId;
    }

    public function getDateAdded(): string
    {
        return $this->dateAdded;
    }

    public function setDateAdded(string $dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }

    public function getIntent(): AppleLocationAssetIntent
    {
        return $this->intent;
    }

    public function setIntent(AppleLocationAssetIntent $intent): void
    {
        $this->intent = $intent;
    }

    public function getCaptions(): array
    {
        return $this->captions;
    }

    public function setCaptions(array $captions): void
    {
        $this->captions = $captions;
    }

    public function getSource(): AppleLocationAssetSource
    {
        return $this->source;
    }

    public function setSource(AppleLocationAssetSource $source): void
    {
        $this->source = $source;
    }

    public function getCapturedBy(): string
    {
        return $this->capturedBy;
    }

    public function setCapturedBy(string $capturedBy): void
    {
        $this->capturedBy = $capturedBy;
    }

    public function getClassifications(): array
    {
        return $this->classifications;
    }

    public function setClassifications(array $classifications): void
    {
        $this->classifications = $classifications;
    }

    public function getCoordinates(): ?AppleCoordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(?AppleCoordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function getPhotos(): AppleLocationAssetPhotos
    {
        return $this->photos;
    }

    public function setPhotos(AppleLocationAssetPhotos $photos): void
    {
        $this->photos = $photos;
    }

    public function toArray(bool $cleanData = false): array
    {
        $data = parent::toArray($cleanData);
        if($this->getCoordinates() === null)
            unset($data['coordinates']);
        return $data;
    }

    /**
     * @param string $partnersAssetId
     * @param Time $dateAdded - format: "YYYY-MM-DDTHH:MM:SS.000Z"
     * @param AppleLocationAssetIntent $intent
     * @param AppleLocationAssetCaption $caption
     * @param AppleLocationAssetSource $source
     * @param string[] $classifications
     * @param AppleLocationAssetPhotos $photos
     * @param string|null $capturedBy
     * @param AppleCoordinates|null $coordinates
     * @return AppleLocationAssetDetails
     */
    public static function create(string $partnersAssetId, Time $dateAdded, AppleLocationAssetIntent $intent, AppleLocationAssetCaption $caption, AppleLocationAssetSource $source, array $classifications, AppleLocationAssetPhotos $photos, ?string $capturedBy = null, ?AppleCoordinates $coordinates = null): AppleLocationAssetDetails{
        return new AppleLocationAssetDetails(array(
            'partnersAssetId' => $partnersAssetId,
            'dateAdded' => $dateAdded->format(DATE_RFC3339_EXTENDED),
            'intent' => $intent,
            'captions' => array(
                $caption
            ),
            'source' => $source,
            'capturedBy' => $capturedBy,
            'classifications' => $classifications,
            'coordinates' => $coordinates,
            'photos' => $photos
        ));
    }

}