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
 * rtCategoryListener runs preDelete and postSave logic on objects enabled with the rtCategory
 * behavior.
 *
 * @package    rtCorePlugin
 * @subpackage template
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtCategoryListener extends Doctrine_Record_Listener
{
  /**
   * Array of timestampable options
   *
   * @var string
   */
  protected $_options = array();

  /**
   * @param array $options
   */
  public function __construct(array $options)
  {
    $this->_options = $options;
  }

 /**
  * Clean assets attached when an object is deleted.
  *
  * @param      Doctrine_Event  $event
  * @return     void
  */
  public function preDelete(Doctrine_Event $event)
  {
      $object = $event->getInvoker();

      Doctrine::getTable('rtCategoryToObject')->createQuery()
        ->delete()
        ->addWhere('model_id = ?', $object->id)
        ->addWhere('model = ?', get_class($object))
        ->execute();
  }
}