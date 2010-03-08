<?php
/**
 */
class PlugingnAssetTable extends Doctrine_Table
{
  /**
   * Return assets for a given record object.
   *
   * @param Doctrine_Record $object
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   * @see PlugingnAssetTable::getAssetsForModelAndId()
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