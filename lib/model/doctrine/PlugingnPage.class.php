<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PlugingnPage
 *
 * @package    gumnut
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PlugingnPage extends BasegnPage
{
  /**
   * Undelete a soft deleted object.
   *
   * @param Doctrine_Connection $conn
   * @return void
   */
  public function undelete(Doctrine_Connection $conn = null)
  {
    $this->setDeletedAt(null);
    parent::save($conn);
  }
}