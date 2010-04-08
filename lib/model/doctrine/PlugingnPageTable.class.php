<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PlugingnPageTable
 *
 * @package    gumnut
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class PlugingnPageTable extends Doctrine_Table
{
  public function findAllPublished(Doctrine_Query $query = null)
  {
    $query = $this->addPublishedQuery($query);
    return $query->andWhere('page.deleted_at IS NULL')->execute();
  }

  public function findAllPages(Doctrine_Query $query = null)
  {
    return $this->addNotDeletedQuery()->execute();
  }

  public function addNotDeletedQuery(Doctrine_Query $query = null)
  {
    return $this->getQuery($query)->andWhere('page.deleted_at IS NULL');
  }

  public function addPublishedQuery(Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query->andWhere('(page.published_from < ? OR page.published_from IS NULL)', date('Y-m-d H:i:s', time()));
    $query->andWhere('(page.published_to > ? OR page.published_to IS NULL)', date('Y-m-d H:i:s', time()));
    $query->andWhere('page.published = 1');
    return $query;
  }

  /**
   * Return a query object, creting a new one if needed.
   *
   * @param Doctrine_Query $query
   * @param string $alias
   * @return Doctrine_Query
   */
  public function getQuery(Doctrine_Query $query = null)
  {
    if(is_null($query))
    {
      return parent::createQuery('page');
    }
    return $query;
  }
}