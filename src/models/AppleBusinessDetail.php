<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:{
 *     "partnersBusinessId": "1",
 * "partnersBusinessVersion": "PBV01",
 * "countryCodes": [ "DE" ],
 * "displayNames": [
 * {
 * "name": "Test Business 1",
 * "locale": "de",
 * "primary": true
 * }
 * ],
 * "categories": [ "food.desserts", "food.gelato" ],
 * "urls": [
 * {
 * "url": "https://example.com",
 * "type": "HOMEPAGE"
 * }
 * ]
 * }
 */
class AppleBusinessDetail extends DataClass{

    protected string $partnersBusinessId;
    protected string $partnersBusinessVersion;
    protected array $countryCodes;
    /**
     * @var AppleDisplayName[] $displayNames
     */
    protected array $displayNames;
    /**
     * @var AppleCategory[] $categories
     */
    protected array $categories;
    /**
     * @var AppleUrl[] $urls
     */
    protected array $urls;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'displayNames' => AppleDisplayName::class,
            'categories' => AppleCategory::class,
            'urls' => AppleUrl::class
        ));
    }

    public function getPartnersBusinessId(): string
    {
        return $this->partnersBusinessId;
    }

    public function getPartnersBusinessVersion(): string
    {
        return $this->partnersBusinessVersion;
    }

    public function getCountryCodes(): array
    {
        return $this->countryCodes;
    }

    public function getDisplayNames(): array
    {
        return $this->displayNames;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getUrls(): array
    {
        return $this->urls;
    }

    /**
     * @param AppleCategory[] $categories
     * @param AppleUrl[] $urls
     * @return AppleBusinessDetail
     */
    public static function create(string $partner_business_id, string $display_name, array $categories, array $urls, string $partner_business_version, array $country_codes = array('DE')): AppleBusinessDetail
    {
        return new AppleBusinessDetail(array(
            'partnersBusinessId' => $partner_business_id,
            'partnersBusinessVersion' => $partner_business_version,
            'countryCodes' => $country_codes,
            'displayNames' => array(
                AppleDisplayName::create($display_name)
            ),
            'categories' => $categories,
            'urls' => $urls
        ));
    }

}