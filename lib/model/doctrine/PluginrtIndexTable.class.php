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
 * PluginrtIndexTable
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class PluginrtIndexTable extends Doctrine_Table
{
  /**
   * Performs a search in the index table. If no language is supplied, this method will use
   * the default.
   *
   * @param mixed $keywords a search string or an array of search terms
   * @param string $lang
   * @return array
   */
  public function getSearchResultsAsArray($keywords, $lang = null, Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    return $this->getBaseSearchQuery($keywords, $this->getLang(), $query)->fetchArray();
  }

  /**
   * Performs a search in the index table. If no language is supplied, this method will use
   * the default.
   *
   * @param mixed $keywords a search string or an array of search terms
   * @param string $lang
   * @return Doctrine_Collection
   */
  public function getSearchResults($keywords, $lang = null, Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    return $this->getBaseSearchQuery($this->getSearchKeywords($keywords), $this->getLang(), $query)->execute();
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
    foreach ($results as $rt_index)
    {
      if (!in_array($rt_index->getModel(), $models))
      {
        $models[] = $rt_index->getModel();
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
    foreach ($results as $rt_index)
    {
      if($rt_index->getModel() === $model_type)
      {
        $model = $rt_index->getModel();

        if(substr(get_class($model), -11) === 'Translation')
        {
          $model = substr($model, 0, -11);
        }

        $objects[$rt_index->getModelId()] = Doctrine::getTable($model)->findOneById($rt_index->getModelId());
      }
    }
    return $objects;
  }

  /**
   * Add a search query based on a set of keyword values.
   *
   * @param mixed $keywords
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function getBasePublicSearchQuery($keywords, $lang = null, Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query = $this->getBaseSearchQuery($keywords, $lang, $query);
    $query = $this->getPublishedQuery($query);
    $query = $this->getPublicModelsQuery($query);
    return $query;
  }

  /**
   * Return a query with the public model restriction.
   * 
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function getPublicModelsQuery(Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query->andWhereIn('i.model', sfConfig::get('app_rt_search_public_models', array('rtShopProduct','rtShopCategory','rtBlogPage', 'rtSitePage', 'rtWikiPage')));
    return $query;
  }
  
  /**
   * Add a search query based on a set of keyword values.
   *
   * @param mixed $keywords
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function getBaseSearchQuery($keywords, $lang = null, Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query = $this->getStandardSearchComponentInQuery($keywords, $lang, $query);
    $query->select('i.model, model_id, count(i.keyword) AS relevance');
    $query->orderBy('relevance DESC');
    return $query;
  }

  /**
   * Return the most common and basic of the search query values.
   * 
   * @param string $keywords
   * @param sting $lang
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function getStandardSearchComponentInQuery($keywords, $lang = null, Doctrine_Query $query = null)
  {
    if(is_string($keywords))
    {
      $keywords = rtIndexToolkit::getStemmedWordsFromString($keywords, $this->getLang());
    }
    $query = $this->getQuery($query);
    $query->addGroupBy('i.model_id');
    $query->addGroupBy('i.model');
    $query->andWhereIn('i.keyword', $keywords);
    return $query;
  }

  /**
   * Adds a check for pages which have been published.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function getPublishedQuery(Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query->andWhere('(i.published_from < ? OR i.published_from IS NULL)', date('Y-m-d H:i:s', time()));
    $query->andWhere('(i.published_to > ? OR i.published_to IS NULL)', date('Y-m-d H:i:s', time()));
    $query->andWhere('i.published = 1');
    return $query;
  }

  /**
   * Return the number of results a search would provide.
   *
   * @param mixed $keywords
   * @param Doctrine_Query $query
   * @return integer
   */
  public function getNumberOfMatchedResults($keywords, $lang = null, Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query = $this->getStandardSearchComponentInQuery($keywords, $lang, $query);
    $query->select('count(DISTINCT i.model) AS count');
    $r = $query->fetchArray();
    return count($r);
  }

  /**
   * Return the number of results a search would provide.
   *
   * @param mixed $keywords
   * @param Doctrine_Query $query
   * @return integer
   */
  public function getNumberOfPublicMatchedResults($keywords, $lang = null, Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query = $this->getStandardSearchComponentInQuery($keywords, $lang, $query);
    $query = $this->getPublicModelsQuery($query);
    $query->select('count(DISTINCT i.model) AS count');
    $r = $query->fetchArray();
    return count($r);
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
      $keywords = rtIndexToolkit::getStemmedWordsFromString($keywords, $this->getLang());
    }
    return $keywords;
  }

  /**
   * Returns a Doctrine_Query object.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  private function getQuery(Doctrine_Query $query = null)
  {
    if (is_null($query))
    {
      $query = $this->getQueryObject()->from($this->getComponentName() .' i');
    }

    return $query;
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

    $q->execute();
  }
}