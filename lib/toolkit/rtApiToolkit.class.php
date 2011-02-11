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
 * rtApiToolkit
 *
 * @package    rtCorePlugin
 * @subpackage rtCorePluginTools
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtApiToolkit
{
  /**
   * Authenticate API access
   *
   * @param  String  $key
   * @return Boolean True for access granted
   */
  public static function grantApiAccess($key)
  {
    if(!sfConfig::has('app_rt_api_key') || $key !== sfConfig::get('app_rt_api_key'))
    {
      return false;
    }
    return true;
  }
}