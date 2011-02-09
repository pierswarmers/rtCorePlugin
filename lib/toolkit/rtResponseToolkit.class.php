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
 * rtResponseToolkit provides a set of worker methods for dealing with response objects.
 *
 * @package    rtCorePlugin
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtResponseToolkit
{
  /**
   * Update the response meta values with the data contained within a rtPage object.
   *
   * @param rtPage $rt_page
   * @param sfUser $sf_user
   * @param sfWebResponse $sf_response
   * @return void
   */
  public static function setCommonMetasFromPage(rtPage $rt_page, sfUser $sf_user, sfWebResponse $sf_response)
  {
    $data = array();
    $data['robots'] = $rt_page->getSearchable() ? 'index, follow' : 'NONE';
    $data['keywords'] = implode(', ', $rt_page->getTags());
    $data['title'] = $rt_page->getTitle();
    $data['description'] = $rt_page->getDescription();
    
    $data['og:title'] = $rt_page->getTitle();
    $data['og:type'] = self::getTypeFromObject($rt_page);
    $data['og:url'] = sfContext::getInstance()->getRouting()->generate('rt_shop_product_show', $rt_page, true);
    if($rt_page->getPrimaryImage())
    {
      $img_path = rtAssetToolkit::getThumbnailPath($rt_page->getPrimaryImage()->getSystemPath(), array('maxHeight' => 400, 'maxWidth' => 400));
      $data['og:image'] = rtSiteToolkit::getCurrentDomain(null, true).$img_path;
    }
    if(sfConfig::has('app_rt_title'))
    {
      $data['og:site_name'] = sfConfig::get('app_rt_title');
    }
    if($rt_page->getDescription() !== '')
    {
      $data['og:description'] = $rt_page->getDescription();
    }

    self::setCommonMetas($data, $sf_response);
  }
  
  /**
   * Update the response meta values with the data contained within an array.
   *
   * @param array $data
   * @param sfWebResponse $sf_response
   * @return void
   */
  public static function setCommonMetas(array $data, sfWebResponse $sf_response)
  {
    foreach($data as $key => $value)
    {
      $sf_response->addMeta($key, $value);
    }
  }

  /**
   * Return open graph type based on object
   *
   * @param rtPage $object
   * @return String
   */
  public static function getTypeFromObject(rtPage $object)
  {
    // Special open graph type defined in the model
    if(method_exists($object, 'getOpenGraphType'))
    {
      return $object->getOpenGraphType();
    }

    // General open graph types
    switch (get_class($object)) {
      case 'rtBlogPage':
        return 'article';
      case 'rtWikiPage':
        return 'article';
      case 'rtShopProduct':
        return 'product';
      default:
        return 'website';
    }
  }
}