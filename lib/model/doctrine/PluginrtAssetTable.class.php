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
 * PluginrtAssetTable
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class PluginrtAssetTable extends Doctrine_Table
{
  /**
   * Return assets for a given record object.
   *
   * @param Doctrine_Record $object
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   * @see PluginrtAssetTable::getAssetsForModelAndId()
   */
  public function getAssetsForObject(Doctrine_Record $object, Doctrine_Query $q = null)
  {
    return $this->getAssetsForModelAndId(get_class($object), $object->getId(), $q);
  }

  /**
   * Return assets for a given record class and id.
   * 
   * @param string $model
   * @param string $model_id
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   */
  public function getAssetsForModelAndId($model, $model_id, Doctrine_Query $q = null)
  {
    $q = $this->getQueryForModelAndId($model, $model_id, $q);
    $q->orderBy('a.position');
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
    $q->andWhere('a.model = ?', $model)
      ->andWhere('a.model_id = ?', $model_id);
    return $q;
  }
  
  /**
   * Returns a Doctrine_Query object.
   *
   * @param Doctrine_Query $q
   * @return Doctrine_Query
   */
  private function getQuery(Doctrine_Query $q = null)
  {
    if (is_null($q))
    {
      $q = $this->getQueryObject()->from($this->getComponentName() .' a');
    }

    return $q;
  }
}