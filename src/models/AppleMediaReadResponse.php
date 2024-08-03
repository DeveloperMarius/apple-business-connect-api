<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "id": "b56e56f8-4c86-4bb5-bb8a-aab1532a4816",
 * "companyId": "1469747224475254784",
 * "createdDate": "2024-02-08T13:29:41.865Z",
 * "updatedDate": "2024-02-08T13:29:41.956Z",
 * "state": "SUBMITTED",
 * "filename": "pumpe.png",
 * "width": 800,
 * "height": 450,
 * "fileSize": 59427,
 * "contentType": "image/png"
 * }
 */
class AppleMediaReadResponse extends DataClass
{

    protected string $id;
    protected string $companyId;
    protected string $createdDate;
    protected string $updatedDate;
    protected AppleMediaState $state;
    protected ?string $filename = null;
    protected ?int $width = null;
    protected ?int $height = null;
    protected ?int $fileSize = null;
    protected ?string $contentType = null;

    public function __construct(array $data){
        parent::setProperties($data, array(
            'state' => AppleMediaState::class
        ));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function getUpdatedDate(): string
    {
        return $this->updatedDate;
    }

    public function getState(): AppleMediaState
    {
        return $this->state;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

}