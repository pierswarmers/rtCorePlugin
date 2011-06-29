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
 * PluginrtCategoryTable
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class PluginrtCategoryTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object PluginrtCategoryTable
   */
  public static function getInstance() 
  {
    return Doctrine_Core::getTable('PluginrtCategory');
  }
  
  /**
   * Return categories for a given record object.
   *
   * @param Doctrine_Record $object
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   * @see PluginrtAssetTable::getCategoriesForModelAndId()
   */
  public function getCategoriesForObject(Doctrine_Record $object, Doctrine_Query $q = null)
  {
    return $this->getCategoriesForModelAndId(get_class($object), $object->getId(), $q);
  }

  /**
   * Return categories for a given record object.
   *
   * @param Doctrine_Record $object
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   * @see PluginrtAssetTable::getCategoriesForModelAndId()
   */
  public function getCategoriesForClassnameVisibleInMenu($model, Doctrine_Query $q = null)
  {
    return $this->getCategoriesForModelVisibleInMenu($model, $q);
  }
  
  /**
   * Return categories for a given record class and id.
   * 
   * @param string $model
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   */
  public function getCategoriesForModelVisibleInMenu($model, Doctrine_Query $q = null)
  {
    $q = $this->getQueryForModel($model, $q);
    $q->andWhere('c.display_in_menu = ?',true);
    $q->orderBy('cto.position');
    return $q->execute();
  }
  
  /**
   * Return categories for a given record class and id.
   * 
   * @param string $model
   * @param string $model_id
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   */
  public function getCategoriesForModelAndId($model, $model_id, Doctrine_Query $q = null)
  {
    $q = $this->getQueryForModelAndId($model, $model_id, $q);
    $q->orderBy('cto.position');
    return $q->execute();
  }

  /**
   * Add the model query components.
   * 
   * @param string $model
   * @param Doctrine_Query $q
   * @return Doctrine_Query
   */
  public function getQueryForModel($model, Doctrine_Query $q = null)
  {
    $q = $this->getQuery($q);
    $q->leftJoin('c.rtCategoryToObject cto');
    $q->andWhere('cto.model = ?', $model);
    return $q;
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
    $q->leftJoin('c.rtCategoryToObject cto');
    $q->andWhere('cto.model = ?', $model)
      ->andWhere('cto.model_id = ?', $model_id);
    return $q;
  }  
  
  /**
   * Return a query object, creting a new one if needed.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function getQuery(Doctrine_Query $query = null)
  {
    if(is_null($query))
    {
      $query = parent::createQuery('c');
    }

    return $query;
  }  
}