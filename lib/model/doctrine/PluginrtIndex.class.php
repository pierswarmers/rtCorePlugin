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
 * PluginrtIndex
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
abstract class PluginrtIndex extends BasertIndex
{
  /**
   * Holder for the attached object to this index record.
   *
   * @var Doctrine_Record
   */
  private $_object;

  /**
   * Return object as string
   *
   * @return object Object as string
   */
  public function  __toString()
  {
    return (string) $this->getObject();
  }

  /**
   * Retrieves the attached object and hydrates the $_object var with it.
   *
   * @return void
   */
  private function initObject()
  {
    $model = $this->getModel();

    if(substr($model, -11) === 'Translation')
    {
      $model = substr($model, 0, -11);
    }

    $this->_object = Doctrine::getTable($model)->findOneById($this->getModelId());
  }

  /**
   * Return the target object for this index record.
   *
   * @return Doctrine_Record
   */
  public function getObject()
  {
    if(is_null($this->_object))
    {
      $this->initObject();
    }
    return $this->_object;
  }

  /**
   * Sets the target object for this index record.
   *
   * @param Doctrine_Record
   * @return void
   */
  public function setObject(Doctrine_Record $object)
  {
    $this->_object = $object;
  }

  /**
   * Return the model value with translation suffix removed.
   *
   * @return string
   */
  public function getCleanModel()
  {
    if(substr($this['model'], -11) === 'Translation')
    {
      return substr($this['model'], 0, -11);
    }
    return $this['model'];
  }
}