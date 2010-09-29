<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PluginrtCommentReferenceTable
 *
 * @package    reditype
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class PluginrtCommentReferenceTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object PluginrtCommentReferenceTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('PluginrtCommentReference');
  }
}