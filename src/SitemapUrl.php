<?php

declare(strict_types=1);

namespace DevBG\SeoSitemap;

use DateTimeInterface;
use InvalidArgumentException;

final class SitemapUrl
{
    public const CHANGE_FREQ_ALWAYS  = 'always';
    public const CHANGE_FREQ_HOURLY  = 'hourly';
    public const CHANGE_FREQ_DAILY   = 'daily';
    public const CHANGE_FREQ_WEEKLY  = 'weekly';
    public const CHANGE_FREQ_MONTHLY = 'monthly';
    public const CHANGE_FREQ_YEARLY  = 'yearly';
    public const CHANGE_FREQ_NEVER   = 'never';

    private const VALID_CHANGE_FREQ = [
        self::CHANGE_FREQ_ALWAYS,
        self::CHANGE_FREQ_HOURLY,
        self::CHANGE_FREQ_DAILY,
        self::CHANGE_FREQ_WEEKLY,
        self::CHANGE_FREQ_MONTHLY,
        self::CHANGE_FREQ_YEARLY,
        self::CHANGE_FREQ_NEVER,
    ];

    /** @var ImageEntry[] */
    private array $images = [];

    /** @var VideoEntry[] */
    private array $videos = [];

    /** @var NewsEntry|null */
    private ?NewsEntry $news = null;

    public function __construct(
        private readonly string $loc,
        private readonly ?DateTimeInterface $lastmod = null,
        private readonly ?string $changefreq = null,
        private readonly ?float $priority = null,
    ) {
        if (!filter_var($loc, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL: {$loc}");
        }

        if ($changefreq !== null && !in_array($changefreq, self::VALID_CHANGE_FREQ, true)) {
            throw new InvalidArgumentException("Invalid changefreq: {$changefreq}");
        }

        if ($priority !== null && ($priority < 0.0 || $priority > 1.0)) {
            throw new InvalidArgumentException("Priority must be between 0.0 and 1.0, got: {$priority}");
        }
    }

    public function getLoc(): string
    {
        return $this->loc;
    }

    public function getLastmod(): ?DateTimeInterface
    {
        return $this->lastmod;
    }

    public function getChangefreq(): ?string
    {
        return $this->changefreq;
    }

    public function getPriority(): ?float
    {
        return $this->priority;
    }

    public function addImage(ImageEntry $image): self
    {
        $clone = clone $this;
        $clone->images[] = $image;
        return $clone;
    }

    /** @return ImageEntry[] */
    public function getImages(): array
    {
        return $this->images;
    }

    public function addVideo(VideoEntry $video): self
    {
        $clone = clone $this;
        $clone->videos[] = $video;
        return $clone;
    }

    /** @return VideoEntry[] */
    public function getVideos(): array
    {
        return $this->videos;
    }

    public function withNews(NewsEntry $news): self
    {
        $clone = clone $this;
        $clone->news = $news;
        return $clone;
    }

    public function getNews(): ?NewsEntry
    {
        return $this->news;
    }
}
