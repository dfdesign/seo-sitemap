# 🗺️ Savana Soft SEO Sitemap

A powerful, flexible PHP 8.1+ library for generating **SEO-optimized XML sitemaps** — supporting standard URLs, Images, Videos, News and Sitemap Index files, all compliant with [sitemaps.org](https://www.sitemaps.org) and [Google's sitemap extensions](https://developers.google.com/search/docs/crawling-indexing/sitemaps/overview).

---

## ✨ Features

- ✅ **Standard Sitemap** — `<loc>`, `<lastmod>`, `<changefreq>`, `<priority>`
- 🖼️ **Image Sitemap Extension** — Google image sitemap support
- 🎬 **Video Sitemap Extension** — Google video sitemap support
- 📰 **News Sitemap Extension** — Google News sitemap support
- 📂 **Sitemap Index** — Split large sites into multiple indexed sitemaps
- 🗜️ **Gzip Support** — Write compressed `.xml.gz` sitemaps
- 🛡️ **Validation** — Enforces 50,000 URL and 50MB limits automatically
- 🔒 **Immutable Value Objects** — Safe, fluent, side-effect-free API
- 🧪 **100% Tested** — PHPUnit test suite included

---

## 📦 Installation

```bash
composer require devbg/seo-sitemap
```

**Requirements:** PHP 8.1+, `ext-dom`, `ext-libxml`

---

## 🚀 Quick Start

### Simple sitemap

```php
use DevBG\SeoSitemap\SitemapUrl;
use DevBG\SeoSitemap\Generators\SitemapGenerator;
use DevBG\SeoSitemap\Renderers\FileWriter;

$generator = new SitemapGenerator(prettyPrint: true);

$generator->addUrl(new SitemapUrl(
    loc: 'https://example.com/',
    lastmod: new DateTimeImmutable(),
    changefreq: SitemapUrl::CHANGE_FREQ_DAILY,
    priority: 1.0,
));

$generator->addUrl(new SitemapUrl(
    loc: 'https://example.com/about',
    changefreq: SitemapUrl::CHANGE_FREQ_MONTHLY,
    priority: 0.5,
));

// Get XML as string
echo $generator->generate();

// Or write to file
$generator->writeTo(new FileWriter(), '/var/www/public/sitemap.xml');
```

### With Image extension

```php
use DevBG\SeoSitemap\ImageEntry;

$url = (new SitemapUrl('https://example.com/products/laptop'))
    ->addImage(new ImageEntry(
        loc: 'https://example.com/images/laptop-front.jpg',
        caption: 'Laptop front view',
        title: 'Premium Laptop',
        license: 'https://creativecommons.org/licenses/by/4.0/',
        geoLocation: 'Sofia, Bulgaria',
    ))
    ->addImage(new ImageEntry(
        loc: 'https://example.com/images/laptop-side.jpg',
        caption: 'Laptop side view',
    ));

$generator->addUrl($url);
```

### With News extension

```php
use DevBG\SeoSitemap\NewsEntry;

$url = (new SitemapUrl('https://example.com/news/ai-revolution-2024'))
    ->withNews(new NewsEntry(
        publicationName: 'Example News',
        publicationLanguage: 'en',
        publicationDate: new DateTimeImmutable('2024-11-01T09:00:00Z'),
        title: 'The AI Revolution Is Here',
        keywords: 'AI, machine learning, LLM, future',
        genres: 'PressRelease, Blog',
    ));

$generator->addUrl($url);
```

### With Video extension

```php
use DevBG\SeoSitemap\VideoEntry;

$url = (new SitemapUrl('https://example.com/videos/php-tutorial'))
    ->addVideo(new VideoEntry(
        thumbnailLoc: 'https://example.com/thumbnails/php-tutorial.jpg',
        title: 'PHP 8.3 for Beginners',
        description: 'A complete introduction to modern PHP development.',
        contentLoc: 'https://example.com/videos/php-tutorial.mp4',
        duration: 3600,
        rating: 4.8,
        viewCount: 15000,
        publicationDate: new DateTimeImmutable('2024-01-10'),
        familyFriendly: true,
    ));

$generator->addUrl($url);
```

---

## 📂 Sitemap Index (Large Sites)

For sites with more than 50,000 URLs, use multiple sitemaps and an index:

```php
use DevBG\SeoSitemap\Generators\SitemapIndexGenerator;
use DevBG\SeoSitemap\Renderers\FileWriter;

$index = new SitemapIndexGenerator(prettyPrint: true);

$index->addSitemap('https://example.com/sitemap-pages.xml', new DateTimeImmutable());
$index->addSitemap('https://example.com/sitemap-products.xml', new DateTimeImmutable());
$index->addSitemap('https://example.com/sitemap-blog.xml', new DateTimeImmutable());

$index->writeTo(new FileWriter(), '/var/www/public/sitemap.xml');
```

---

## 🧙 SitemapManager (Recommended for large projects)

The `SitemapManager` handles everything automatically — writes individual sitemap files and generates the index:

```php
use DevBG\SeoSitemap\SitemapManager;
use DevBG\SeoSitemap\SitemapUrl;

$manager = new SitemapManager(
    baseUrl: 'https://example.com',
    outputPath: '/var/www/public',
    prettyPrint: true,
);

// Add pages to named sitemaps
$manager->sitemap('pages')
    ->addUrl(new SitemapUrl('https://example.com/', priority: 1.0))
    ->addUrl(new SitemapUrl('https://example.com/about', priority: 0.8));

$manager->sitemap('blog')
    ->addUrl(new SitemapUrl('https://example.com/blog/post-1'))
    ->addUrl(new SitemapUrl('https://example.com/blog/post-2'));

// Writes:
//   /var/www/public/sitemap-pages.xml
//   /var/www/public/sitemap-blog.xml
//   /var/www/public/sitemap.xml  ← index
$manager->write();
```

---

## 🗜️ Gzip Compression

```php
use DevBG\SeoSitemap\Renderers\GzipWriter;

$generator->writeTo(new GzipWriter(), '/var/www/public/sitemap.xml.gz');
```

---

## 🔁 Change Frequency Constants

```php
SitemapUrl::CHANGE_FREQ_ALWAYS   // always
SitemapUrl::CHANGE_FREQ_HOURLY   // hourly
SitemapUrl::CHANGE_FREQ_DAILY    // daily
SitemapUrl::CHANGE_FREQ_WEEKLY   // weekly
SitemapUrl::CHANGE_FREQ_MONTHLY  // monthly
SitemapUrl::CHANGE_FREQ_YEARLY   // yearly
SitemapUrl::CHANGE_FREQ_NEVER    // never
```

---

## 🧪 Testing

```bash
composer test
```

---

## 📊 Limits (enforced automatically)

| Limit                    | Value                                       |
| ------------------------ | ------------------------------------------- |
| URLs per sitemap         | 50,000                                      |
| Max file size            | 50 MB                                       |
| Solution for large sites | `SitemapIndexGenerator` or `SitemapManager` |

---

## 🚀 Professional SEO & Web Design Services

This open-source project is maintained by our team. If you need a custom solution, a high-converting website, or an expert SEO strategy, feel free to reach out to us:

- **[Savana Soft]** – High-end [Ecommerce Web Design](https://savana-soft.com/izgrajdane-na-onlain-magazin/) and performance-driven [SEO Services](https://savana-soft.com/seo-optimisation/).
- **Expert SEO Audit** – Get a comprehensive [analysis of your website’s visibility](https://savana-soft.com/zaiavka-konsultacia-oferta/).
- **Custom Web Development** – Scalable PHP and JavaScript solutions tailored to your business needs.

**Let's build something great together:** 👉 [**https://savana-soft.com**](https://savana-soft.com)

---

## 📄 License

MIT — see [LICENSE](LICENSE) file.
