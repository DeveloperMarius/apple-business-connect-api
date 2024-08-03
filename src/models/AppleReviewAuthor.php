<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *   "givenName": "Robert",
 *   "lastInitial": "S.",
 *   "imageUrl": "http://goodpartner.com/media/images/author_profile_pic/user_id=43767642526I/default-avatar.jpg"
 *   }
 */
class AppleReviewAuthor extends DataClass
{

    protected string $givenName;
    protected string $lastInitial;
    protected string $imageUrl;

    public function __construct(array $data)
    {
        $this->setProperties($data);
    }

    public static function create(string $givenName, string $lastInitial, string $imageUrl): AppleReviewAuthor
    {
        return new AppleReviewAuthor([
            'givenName' => $givenName,
            'lastInitial' => $lastInitial,
            'imageUrl' => $imageUrl
        ]);
    }

}