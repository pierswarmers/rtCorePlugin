<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtSearchListener runs preDelete and postSave logic on objects enabled with the rtSearch
 * behavior. It provides a simple search indexing logic with multilinguage stopword and
 * stemming support.
 *
 * @package    gumnut
 * @subpackage template
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtAttachableListener extends Doctrine_Record_Listener
{
  /**
   * Array of timestampable options
   *
   * @var string
   */
  protected $_options = array();

  /**
   * __construct
   *
   * @param string $options
   * @return void
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

      Doctrine::getTable('rtAsset')->createQuery()
        ->delete()
        ->addWhere('model_id = ?', $object->id)
        ->addWhere('model = ?', get_class($object))
        ->execute();
  }
}