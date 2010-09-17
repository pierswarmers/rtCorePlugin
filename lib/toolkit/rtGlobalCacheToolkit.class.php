<?php

/*
 * This file is part of the steercms package.
 * (c) digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtGlobalCacheToolkit provides cache cleaning logic.
 *
 * @package    reditype
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGlobalCacheToolkit
{
  public static function clearCache()
  {
    $cache = sfContext::getInstance()->getViewCacheManager();

    if ($cache)
    {
      $cache->remove('rtSitemap/index?sf_format=*');
    }
  }
}