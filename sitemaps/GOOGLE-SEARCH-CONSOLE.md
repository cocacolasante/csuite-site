# Submitting CSuite Code to Google Search Console

## Sitemap URL to submit

```
https://csuitecode.com/sitemap_index.xml
```

That's the only sitemap you need to submit. It's a *sitemap index* that
automatically references the per-content-type sitemaps (currently just
`page-sitemap.xml`). When you add posts, products, or new content types,
they'll appear in the index without re-submission.

## Step-by-step submission

1. Go to <https://search.google.com/search-console>.
2. If `csuitecode.com` isn't a property yet, click **Add property**, pick
   **Domain** (not URL prefix), enter `csuitecode.com`, and verify ownership
   via the DNS TXT record Google gives you.
3. In the left sidebar, click **Sitemaps**.
4. Under **Add a new sitemap**, type:
   ```
   sitemap_index.xml
   ```
   (Google prepends your domain automatically.)
5. Click **Submit**. The status will move to **Success** within a few minutes.

## Other sitemaps available (you don't need to submit these separately)

- `https://csuitecode.com/page-sitemap.xml` - all 12 indexable pages
- `https://csuitecode.com/llms.txt` - AI-search manifest

## Cached snapshots

The files in this directory are point-in-time copies of what was live when
this commit was made:

- `sitemap_index.xml` - the index Google reads
- `page-sitemap.xml` - the per-page sitemap (12 URLs)
- `llms.txt` - the AI-search manifest

These are kept here only for historical reference. The authoritative versions
are always served live by Rank Math at the URLs above.

## Bing / IndexNow / other engines

The same sitemap URL works for Bing Webmaster Tools and Yandex. Rank Math is
configured to also push new/updated content to Bing IndexNow automatically.

## Re-fetching after changes

Whenever you significantly update the site (new pages, deleted pages), you
can trigger a re-crawl by:

1. Going to **Settings > Crawl > Submit sitemaps** in Search Console.
2. Clicking the three-dot menu next to your sitemap > **Refresh**.

Google generally re-fetches on its own every few days based on the `lastmod`
timestamps in the XML.
