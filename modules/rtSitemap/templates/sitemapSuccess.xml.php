<?xml version="1.0" encoding="UTF-8"?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php if(isset($routes['rt_site_page_index'])): ?>
  <?php foreach($site_pages as $site_page): ?>
  <url>
    <loc><?php echo url_for('rt_site_page_show', array('id' => $site_page['id'], 'slug' => $site_page['slug']), true) ?></loc>
    <changefreq>daily</changefreq>
    <lastmod><?php
      $dt = new DateTime($site_page['updated_at']);
      echo $dt->format(DateTime::W3C);
    ?></lastmod>
  </url>
  <?php endforeach; ?>
<?php endif; ?>

<?php if(isset($routes['rt_blog_page_index'])): ?>
  <?php foreach($blog_pages as $blog_page): ?>
    <?php $published_from = $blog_page['published_from']; ?>
    <?php if(!is_null($published_from) && $published_from != '' && $published_from != 0): ?>
      <url>
        <loc><?php echo url_for('rt_blog_page_show', array('id' => $blog_page['id'], 'slug' => $blog_page['slug'], 'year' => date('Y',strtotime($published_from)), 'month' => date('m',strtotime($published_from)), 'day' => date('d',strtotime($published_from))), true) ?></loc>
        <changefreq>daily</changefreq>
        <lastmod><?php
          $dt = new DateTime($blog_page['updated_at']);
          echo $dt->format(DateTime::W3C);
        ?></lastmod>
      </url>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>

<?php if(isset($routes['rt_wiki_page_index'])): ?>
  <?php foreach($wiki_pages as $wiki_page): ?>
  <url>
    <loc><?php echo url_for('rt_wiki_page_show', array('id' => $wiki_page['id'], 'slug' => $wiki_page['slug']), true) ?></loc>
    <changefreq>daily</changefreq>
    <lastmod><?php
      $dt = new DateTime($wiki_page['updated_at']);
      echo $dt->format(DateTime::W3C);
    ?></lastmod>
  </url>
  <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($routes['rt_shop_product_show'])): ?>
  <?php foreach($shop_products as $shop_product): ?>
  <url>
    <loc><?php echo url_for('rt_shop_product_show', array('id' => $shop_product['id'], 'slug' => $shop_product['slug']), true) ?></loc>
    <changefreq>daily</changefreq>
    <lastmod><?php
      $dt = new DateTime($shop_product['updated_at']);
      echo $dt->format(DateTime::W3C);
    ?></lastmod>
  </url>
  <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($routes['rt_shop_category_index'])): ?>
  <?php foreach($shop_categories as $shop_category): ?>
  <url>
    <loc><?php echo url_for('rt_shop_category_show', array('id' => $shop_category['id'], 'slug' => $shop_category['slug']), true) ?></loc>
    <changefreq>daily</changefreq>
    <lastmod><?php
      $dt = new DateTime($shop_category['updated_at']);
      echo $dt->format(DateTime::W3C);
    ?></lastmod>    
  </url>
  <?php endforeach; ?>
<?php endif; ?>

</urlset>