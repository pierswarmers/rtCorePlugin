<?php
/**
 */
class PlugingnAssetTable extends Doctrine_Table
{
  public function getAssetsForObject($model, $model_id, Doctrine_Query $q = null)
  {
    $q = $this->getQuery($q);

    $q->andWhere('a.model = ?', $model)
      ->andWhere('a.model_id = ?', $model_id)
      ->orderBy('a.position, a.id');

    return $q->execute();
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