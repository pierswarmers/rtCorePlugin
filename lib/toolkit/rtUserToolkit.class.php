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
 * rtUserToolkit
 *
 * @package    rtCorePlugin
 * @subpackage rtCorePluginTools
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */

class rtUserToolkit
{
  /**
   * Find user
   *
   * @param String $user Code
   * @return rtGuardUser
   */
  public static function find($value)
  {
    $user = Doctrine::getTable('rtGuardUser')->find($value);
    return $user;
  }
}