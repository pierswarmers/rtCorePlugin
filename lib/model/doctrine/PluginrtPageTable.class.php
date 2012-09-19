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
 * PluginrtPageTable
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class PluginrtPageTable extends Doctrine_Table
{
  /**
   * Return all published pages.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Collection
   */
  public function findAllPublished(Doctrine_Query $query = null)
  {
    $query = $this->addPublishedQuery($query);
    $query = $this->addSiteQuery($query);
    return $query->execute();
  }

  /**
   * Return all pages pages which aren't deleted.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Collection
   */
  public function findAllPages(Doctrine_Query $query = null)
  {
    $query = $this->addSiteQuery($query);
    return $query->execute();
  }

  /**
   * Return a published page by a given ID.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Collection
   */
  public function findOnePublishedById($id, Doctrine_Query $query = null)
  {
    $query = $this->addSiteQuery($query);
    $query = $this->addPublishedQuery($query);
    return $this->findOneById($id);
  }

  /**
   * Adds a check for pages which have been published.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function addPublishedQuery(Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);
    $query->andWhere('(page.published_from < ? OR page.published_from IS NULL)', date('Y-m-d H:i:s', time()));
    $query->andWhere('(page.published_to > ? OR page.published_to IS NULL)', date('Y-m-d H:i:s', time()));
    $query->andWhere('page.published = 1');
    return $query;
  }

  /**
   * Adds a check for pages which belong to the current domain/site.
   *
   * Note: this will only be activated if the rt_enable_multi_site config value is set to true.
   *
   * @param Doctrine_Query $query
   * @return Doctrine_Query
   */
  public function addSiteQuery(Doctrine_Query $query = null)
  {
    $query = $this->getQuery($query);

    if(rtSiteToolkit::isMultiSiteEnabled())
    {
      $query->leftJoin('page.rtSite site')
            ->andWhere('site.domain = ?', rtSiteToolkit::getCurrentDomain());
    }

    return $query;
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
      $query = parent::createQuery('page');
    }

    return $query;
  }
}