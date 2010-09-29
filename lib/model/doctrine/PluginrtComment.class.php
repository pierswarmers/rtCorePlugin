<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PluginrtComment
 *
 * @package    reditype
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
abstract class PluginrtComment extends BasertComment
{
  /**
   * Retrieve the attached parent object.
   *
   * @return Doctrine_Record returns the parent object
   */
  public function getObject()
  {
    $object = Doctrine::getTable($this->getModel())->findOneById($this->getModelId());

    return $object;
  }
}