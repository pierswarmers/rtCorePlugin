<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PluginrtCommentTable
 *
 * @package    reditype
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class PluginrtCommentTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object PluginrtCommentTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('PluginrtComment');
  }

  /**
   * Return comments for a given record object.
   *
   * @param Doctrine_Record $object
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   * @see PluginrtCommentTable::getCommentsForModelAndId()
   */
  public function getCommentsForObject(Doctrine_Record $object, Doctrine_Query $q = null)
  {
    return $this->getCommentsForModelAndId(get_class($object), $object->getId(), $q);
  }

  /**
   * Return comments for a given record class and id.
   *
   * @param string $model
   * @param string $model_id
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   */
  public function getCommentsForModelAndId($model, $model_id, Doctrine_Query $q = null)
  {
    $q = $this->getQueryForModelAndId($model, $model_id, $q);
    $q->orderBy('c.created_at DESC');
    return $q->execute();
  }

  /**
   * Add the model and model_id query components.
   *
   * @param string $model
   * @param string $model_id
   * @param Doctrine_Query $q
   * @return Doctrine_Query
   */
  public function getQueryForModelAndId($model, $model_id, Doctrine_Query $q = null)
  {
    $q = $this->getQuery($q);
    $q->andWhere('c.model = ?', $model)
      ->andWhere('c.model_id = ?', $model_id);
    return $q;
  }

  /**
   * Returns a Doctrine_Query object.
   *
   * @param Doctrine_Query $q
   * @return Doctrine_Query
   */
  public function getQuery(Doctrine_Query $q = null)
  {
    if (is_null($q))
    {
      $q = $this->getQueryObject()->from($this->getComponentName() .' c');
    }

    return $q;
  }
}