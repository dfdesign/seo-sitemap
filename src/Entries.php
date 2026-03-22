<?php

declare(strict_types=1);

namespace DevBG\SeoSitemap;

use DateTimeInterface;

final class ImageEntry
{
    public function __construct(
        private readonly string $loc,
        private readonly ?string $caption = null,
        private readonly ?string $title = null,
        private readonly ?string $license = null,
        private readonly ?string $geoLocation = null,
    ) {}

    public function getLoc(): string        { return $this->loc; }
    public function getCaption(): ?string   { return $this->caption; }
    public function getTitle(): ?string     { return $this->title; }
    public function getLicense(): ?string   { return $this->license; }
    public function getGeoLocation(): ?string { return $this->geoLocation; }
}

final class VideoEntry
{
    public function __construct(
        private readonly string $thumbnailLoc,
        private readonly string $title,
        private readonly string $description,
        private readonly ?string $contentLoc = null,
        private readonly ?string $playerLoc = null,
        private readonly ?int $duration = null,
        private readonly ?DateTimeInterface $expirationDate = null,
        private readonly ?float $rating = null,
        private readonly ?int $viewCount = null,
        private readonly ?DateTimeInterface $publicationDate = null,
        private readonly bool $familyFriendly = true,
        private readonly bool $requiresSubscription = false,
        private readonly bool $live = false,
    ) {}

    public function getThumbnailLoc(): string           { return $this->thumbnailLoc; }
    public function getTitle(): string                  { return $this->title; }
    public function getDescription(): string            { return $this->description; }
    public function getContentLoc(): ?string            { return $this->contentLoc; }
    public function getPlayerLoc(): ?string             { return $this->playerLoc; }
    public function getDuration(): ?int                 { return $this->duration; }
    public function getExpirationDate(): ?DateTimeInterface { return $this->expirationDate; }
    public function getRating(): ?float                 { return $this->rating; }
    public function getViewCount(): ?int                { return $this->viewCount; }
    public function getPublicationDate(): ?DateTimeInterface { return $this->publicationDate; }
    public function isFamilyFriendly(): bool            { return $this->familyFriendly; }
    public function isRequiresSubscription(): bool      { return $this->requiresSubscription; }
    public function isLive(): bool                      { return $this->live; }
}

final class NewsEntry
{
    public function __construct(
        private readonly string $publicationName,
        private readonly string $publicationLanguage,
        private readonly DateTimeInterface $publicationDate,
        private readonly string $title,
        private readonly ?string $access = null,
        private readonly ?string $genres = null,
        private readonly ?string $keywords = null,
        private readonly ?string $stockTickers = null,
    ) {}

    public function getPublicationName(): string        { return $this->publicationName; }
    public function getPublicationLanguage(): string    { return $this->publicationLanguage; }
    public function getPublicationDate(): DateTimeInterface { return $this->publicationDate; }
    public function getTitle(): string                  { return $this->title; }
    public function getAccess(): ?string                { return $this->access; }
    public function getGenres(): ?string                { return $this->genres; }
    public function getKeywords(): ?string              { return $this->keywords; }
    public function getStockTickers(): ?string          { return $this->stockTickers; }
}
