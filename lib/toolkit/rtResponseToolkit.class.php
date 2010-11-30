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
    $data['robots'] = $rt_page->getSearchable();
    $data['keywords'] = $rt_page->getTags();
    $data['title'] = $rt_page->getTitle();
    $data['description'] = $rt_page->getDescription();
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
    if(isset($data['searchable']))
    {
      $sf_response->addMeta('robots', $data['searchable'] ? 'index, follow' : 'NONE');
    }

    if(isset($data['keywords']))
    {
      $sf_response->addMeta('keywords', is_array($data['keywords']) ? implode(', ', $data['keywords']) : $data['keywords']);
    }

    if(isset($data['title']))
    {
      $sf_response->addMeta('title', $data['title']);
    }

    if(isset($data['title']))
    {
      $sf_response->addMeta('description', $data['description']);
    }
  }
}