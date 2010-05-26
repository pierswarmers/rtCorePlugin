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
class rtSearchListener extends Doctrine_Record_Listener
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
    $table = Doctrine::getTable('rtIndex');
    $object = $event->getInvoker();
    $words = $object->getSearchIndexArray();
    $conn = Doctrine_Manager::connection();
    $dbh = $conn->getDbh();

    Doctrine::getTable('rtIndex')->clearIndexForObject($event->getInvoker());

    if(count($words) === 0)
    {
      return;
    }

    $columns = array();
    $base_row = array();

    $test_for = array('site_id', 'admin_only', 'published', 'published_from', 'published_to');

    foreach($test_for as $test)
    {
      if(isset($object->$test) && !is_null($object->$test))
      {
        $columns[] = $test;
        $base_row[$test] = $object->$test;
      }
    }
    
    $columns[] = 'model';
    $base_row['model'] = get_class($object);
    
    $columns[] = 'model_id';
    $base_row['model_id'] = $object->id;
    
    $columns[] = 'keyword';
    

    foreach($words as $word) {
      $row = $base_row;
      $row['keyword'] = $word;

      $values[] = sprintf('("%s")', implode('", "', $row));
    }

    $dbh->exec(sprintf('INSERT INTO %s (%s) VALUES %s', $table->getTableName(), implode(', ', $columns), implode(',', $values)));
  }

 /**
  * Clean index when an object is being deleted.
  *
  * @see rtSearchListener::clearIndexForObject()
  * @param      Doctrine_Event  $event
  * @return     void
  */
  public function preDelete(Doctrine_Event $event)
  {
    Doctrine::getTable('rtIndex')->clearIndexForObject($event->getInvoker());
  }
}