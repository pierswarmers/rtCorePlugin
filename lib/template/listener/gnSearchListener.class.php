<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnSearchListener runs preDelete and postSave logic on objects enabled with the GnSearch
 * behavior. It provides a simple search indexing logic with multilinguage stopword and
 * stemming support.
 *
 * @package    gumnut
 * @subpackage template
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnSearchListener extends Doctrine_Record_Listener
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
   * Index saving logic, run after the object has been saved.
   * 
   * @param Doctrine_Event $event
   * @return     void
   */
  public function postSave(Doctrine_Event $event)
  {
    $table = Doctrine::getTable('gnIndex');
    $object = $event->getInvoker();
    $words = $object->getSearchIndexArray();
    $conn = Doctrine_Manager::connection();
    $dbh = $conn->getDbh();

    Doctrine::getTable('gnIndex')->clearIndexForObject($event->getInvoker());

    if(count($words) === 0)
    {
      return;
    }

    $values = array();

    foreach($words as $word) {
      $values[] = sprintf('("%s", "%s", "%s", "%s")', $word, get_class($object), $object->id, $object->getLang());
    }

    $dbh->exec(sprintf('INSERT INTO %s (keyword, model, model_id, lang) VALUES %s', $table->getTableName(), implode(',', $values)));
  }

 /**
  * Clean index when an object is being deleted.
  *
  * @see GnSearchListener::clearIndexForObject()
  * @param      Doctrine_Event  $event
  * @return     void
  */
  public function preDelete(Doctrine_Event $event)
  {
    Doctrine::getTable('gnIndex')->clearIndexForObject($event->getInvoker());
  }
}