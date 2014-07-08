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
     * Retrieve a Doctrine_Query instance for querying tagged model objects.
     *
     * Example:
     *
     * $q = PluginTagTable::getObjectTaggedWithQuery('Article', array('tag1', 'tag2'));
     * $q->orderBy('posted_at DESC');
     * $q->limit(10);
     * $this->articles = $q->execute();
     *
     * @param string $model
     * @param string $categorySlug
     * @param Doctrine_Query $q
     * @param array $options
     * @return Doctrine_Query
     * @throws sfDoctrineException
     */
    public static function getObjectCategorizedWithQuery($model, $categorySlug, Doctrine_Query $q = null, $options = array())
    {
        if (!class_exists($model) || !PluginTagTable::isDoctrineModelClass($model))
        {
            throw new sfDoctrineException(sprintf('The class "%s" does not exist, or it is not a model class.', $model));
        }

        if (!$q instanceof Doctrine_Query)
        {
            $q = Doctrine_Query::create()->from($model);
        }

        $taggings = self::getCategoryLinks($categorySlug, array_merge(array('model' => $model), $options));
        $tagging = isset($taggings[$model]) ? $taggings[$model] : array();

        if (empty($tagging))
        {
            $q->where('false');
        }
        else
        {
            $q->whereIn($model . '.id', $tagging);
        }

        return $q;
    }


    /**
     * Returns the links associated to one category.
     *
     * The second optionnal parameter permits to restrict the results with
     * different criterias
     *
     * @param string $categorySlug
     * @param array $options
     * @return array
     * @throws Doctrine_Query_Exception
     * @throws sfDoctrineException
     */
    protected static function getCategoryLinks($categorySlug, $options = array())
    {
        $q = Doctrine_Query::create()
            ->select('DISTINCT c.id')
            ->from('rtCategory c INDEXBY c.id')
            ->andWhere('c.slug = ?', $categorySlug);

        $cat_ids = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

        if (0 == count($cat_ids))
        {
            // if not tag has been found, then there will be no tagging
            return array();
        }

        $q = Doctrine_Query::create()
            ->select('cto.model_id')
            ->from('rtCategoryToObject cto')
            ->whereIn('cto.category_id', array_keys($cat_ids))
            ->groupBy('cto.model_id');

        // Taggable model class option
        if (isset($options['model']))
        {
            if (!class_exists($options['model'])) // TODO: add a test to that's a doctrine model...
            {
                throw new sfDoctrineException(sprintf('The class "%s" does not exist, or it is not a model class.',
                        $options['model']));
            }

            $q->addWhere('cto.model = ?', $options['model']);
        }
        else
        {
            $q->addSelect('cto.model')->addGroupBy('cto.model');
        }

        $results = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

        $ctos = array();

        foreach($results as $rs)
        {
            if(isset($options['model']))
            {
                $model = $options['model'];
            }
            else
            {
                $model = $rs['model'];
            }

            if (!isset($ctos[$model]))
            {
                $ctos[$model] = array();
            }

            $ctos[$model][] = $rs['model_id'];
        }

        return $ctos;
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