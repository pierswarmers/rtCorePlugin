<?php
/*
 * This file is part of the Reditype package.
 *
 * (c) 2009-2010 digital Wranglers <info@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertSitemapActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSitemapActions extends sfActions
{
  /**
   * Executes an application defined process prior to execution of this sfAction object.
   *
   * By default, this method is empty.
   */
  public function preExecute()
  {
    sfConfig::set('app_rt_node_title', 'Sitemap');
    rtTemplateToolkit::setFrontendTemplateDir();
  }

  /**
   * Executes index page and forwards to sitemap
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('rtSitemap', 'sitemap');
  }

  /**
   * Executes sitemap. Decides by sf_format to supply html or xml output
   *
   * @param sfWebRequest $request
   */
  public function executeSitemap(sfWebRequest $request)
  {
    if($request->getParameter('sf_format') == 'xml')
    {
      $this->site_pages = $this->getSitePages();
      $this->blog_pages = $this->getBlogPages();
      $this->wiki_pages = $this->getWikiPages();
      $this->shop_products = $this->getShopProducts();
      $this->shop_categories = $this->getShopCategories();
    }
  }

  /**
   * Returns pages as array
   *
   * @return array pages
   */
  protected function getSitePages()
  {
    return $this->getQuery('rtSitePage');
  }

  /**
   * Returns posts as array
   *
   * @return array posts
   */
  protected function getBlogPages()
  {
    return $this->getQuery('rtBlogPage');
  }

  /**
   * Returns wiki pages as array
   *
   * @return array wiki pages
   */
  protected function getWikiPages()
  {
    return $this->getQuery('rtWikiPage');
  }

  /**
   * Returns shop products as array
   *
   * @return array products
   */
  protected function getShopProducts()
  {
    return $this->getQuery('rtShopProduct');
  }

  /**
   * Returns shop categories as array
   *
   * @return array categories
   */
  protected function getShopCategories()
  {
    return $this->getQuery('rtShopCategory');
  }

  /**
   * Returns query for tablename supplied
   *
   * @return array
   */
  protected function getQuery($string)
  {
    $modules = sfConfig::get('sf_enabled_modules');
    
    if(!in_array($string, $modules))
    {
      return false;
    }
    $query = Doctrine::getTable($string)->addPublishedQuery();
    $query = Doctrine::getTable($string)->addSiteQuery($query);
    $query->andWhere('page.searchable = ?', true);
    return $query->fetchArray();
  }
}