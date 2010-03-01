<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PlugingnIndexTable
 *
 * @package    gumnut
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class PlugingnIndexTable extends Doctrine_Table
{
  /**
   * Performs a search in the index table. If no language is supplied, this method will use
   * the default.
   *
   * @param mixed $keywords a search string or an array of search terms
   * @param string $lang
   * @return array
   */
  public function getSearchResultsAsArray($keywords, $lang = null, Doctrine_Query $q = null)
  {
    return $this->getBaseSearchQuery($keywords, $this->getLang(), $q)->fetchArray();
  }

  /**
   * Performs a search in the index table. If no language is supplied, this method will use
   * the default.
   *
   * @param mixed $keywords a search string or an array of search terms
   * @param string $lang
   * @return Doctrine_Collection
   */
  public function getSearchResults($keywords, $lang = null, Doctrine_Query $q = null)
  {
    return $this->getBaseSearchQuery($this->getSearchKeywords($keywords), $this->getLang(), $q)->execute();
  }

  /**
   * Hydrate the results so that there target objects are instanciated and stored.
   *
   * @param Doctrine_Collection $results
   * @return Doctrine_Collection
   */
  public function hydrateResults(Doctrine_Collection $results)
  {
    $models_types = $this->getResultModels($results);

    $models = array();

    foreach($models_types as $model_type)
    {
      $models[$model_type] = $this->getResultModelsForType($results, $model_type);
    }

    // Now hydrate the collection
    for($i=0; $i < count($results); $i++)
    {
      $object = $models[$results[$i]->getModel()][$results[$i]->getModelId()];
      $results[$i]->setObject($object);
    }

    return $results;
  }

  /**
   * Return the model types in an array.
   *
   * @param Doctrine_Collection $results
   * @return array
   */
  private function getResultModels(Doctrine_Collection $results)
  {
    $models = array();
    foreach ($results as $gn_index)
    {
      if (!in_array($gn_index->getModel(), $models))
      {
        $models[] = $gn_index->getModel();
      }
    }
    return $models;
  }

  /**
   * Return the target objects from a collection which have a specified model type.
   *
   * @param string
   * @param Doctrine_Collection $results
   * @return array
   */
  private function getResultModelsForType(Doctrine_Collection $results, $model_type)
  {
    $objects = array();
    foreach ($results as $gn_index)
    {
      if($gn_index->getModel() === $model_type)
      {
        $model = $gn_index->getModel();

        if(substr(get_class($model), -11) === 'Translation')
        {
          $model = substr($model, 0, -11);
        }

        $objects[$gn_index->getModelId()] = Doctrine::getTable($model)->findOneById($gn_index->getModelId());
      }
    }
    return $objects;
  }

  /**
   * Add a search query based on a set of keyword values.
   *
   * @param mixed $keywords
   * @param Doctrine_Query $q
   * @return Doctrine_Query
   */
  public function getBaseSearchQuery($keywords, $lang = null, Doctrine_Query $q = null)
  {
    if(is_string($keywords))
    {
      $keywords = GnIndexToolkit::getStemmedWordsFromString($keywords, $this->getLang());
    }

    $q = $this->getQuery($q);
    //$q->leftJoin('b.Keywords s');
    $q->select('i.model, model_id, lang, count(i.keyword) AS relevance');
    $q->addGroupBy('i.model_id');
    $q->addGroupBy('i.model');
    $q->andWhere('i.lang = ?', $this->getLang($lang));
    $q->andWhereIn('i.keyword', $keywords);
    $q->orderBy('relevance DESC');
    return $q;
  }

  /**
   * Return the language to use, alternatively setting to the configured default if
   * no language is specified.
   *
   * @param string $lang
   * @return string
   */
  public function getLang($lang = null)
  {
    if (is_null($lang))
    {
      $lang = sfConfig::get('sf_default_culture');
    }
    return $lang;
  }

  public function getSearchKeywords($keywords)
  {
    if(is_string($keywords))
    {
      $keywords = GnIndexToolkit::getStemmedWordsFromString($keywords, $this->getLang());
    }
    return $keywords;
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
      $q = $this->getQueryObject()->from($this->getComponentName() .' i');
    }

    return $q;
  }

 /**
  * Run delete logic for objects index items.
  *
  * @param      Doctrine_Event  $event
  * @return     void
  */
  public function clearIndexForObject(Doctrine_Record $object)
  {
    $class = array(get_class($object));
    $lang = trim($object->getLang());

    if($object->hasRelation('Translation'))
    {
      $class[] = get_class($object).'Translation';
      $lang = null;
    }

    $this->runClearIndexForObject($object->id, $class, $lang);
  }

 /**
  * Run delete on index given: class, id and lang values.
  *
  * @param string $id
  * @param mixed $class
  * @param string $lang
  * @return void
  */
  private function runClearIndexForObject($id, $class, $lang = null)
  {
    $q = Doctrine::getTable($this->getComponentName())->createQuery()
      ->delete()
      ->addWhere('model_id = ?', $id);

    if(!is_array($class))
    {
      $class[] = $class;
    }

    $q->andWhereIn('model', $class);

    if(!is_null($lang))
    {
      $q->andWhere('lang = ?', $lang);
    }
    $q->execute();
  }
}