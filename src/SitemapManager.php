<?php

declare(strict_types=1);

namespace DevBG\SeoSitemap;

use DevBG\SeoSitemap\Contracts\WriterInterface;
use DevBG\SeoSitemap\Generators\SitemapGenerator;
use DevBG\SeoSitemap\Generators\SitemapIndexGenerator;
use DevBG\SeoSitemap\Renderers\FileWriter;

/**
 * High-level facade for managing multiple sitemaps and a sitemap index.
 *
 * Usage:
 *   $manager = new SitemapManager('https://example.com', '/var/www/public');
 *   $manager->sitemap('main')
 *           ->addUrl(new SitemapUrl('https://example.com/'));
 *   $manager->write();
 */
final class SitemapManager
{
    /** @var array<string, SitemapGenerator> */
    private array $sitemaps = [];

    private WriterInterface $writer;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $outputPath,
        ?WriterInterface $writer = null,
        private readonly bool $prettyPrint = false,
        private readonly bool $gzip = false,
    ) {
        $this->writer = $writer ?? new FileWriter();
    }

    public function sitemap(string $name): SitemapGenerator
    {
        if (!isset($this->sitemaps[$name])) {
            $this->sitemaps[$name] = new SitemapGenerator($this->prettyPrint);
        }

        return $this->sitemaps[$name];
    }

    /**
     * Write all sitemaps and generate a sitemap index file.
     */
    public function write(): void
    {
        $indexGenerator = new SitemapIndexGenerator($this->prettyPrint);
        $now = new \DateTimeImmutable();

        foreach ($this->sitemaps as $name => $generator) {
            $filename = "sitemap-{$name}.xml" . ($this->gzip ? '.gz' : '');
            $filePath = rtrim($this->outputPath, '/') . "/{$filename}";
            $fileUrl  = rtrim($this->baseUrl, '/') . "/{$filename}";

            $generator->writeTo($this->writer, $filePath);
            $indexGenerator->addSitemap($fileUrl, $now);
        }

        $indexPath = rtrim($this->outputPath, '/') . '/sitemap.xml';
        $indexGenerator->writeTo($this->writer, $indexPath);
    }
}
