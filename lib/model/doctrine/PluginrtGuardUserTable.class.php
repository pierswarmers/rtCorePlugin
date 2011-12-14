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
 * PluginrtGuardUserTable
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class PluginrtGuardUserTable extends sfGuardUserTable
{
  /**
   * Returns an instance of this class.
   *
   * @return object PluginrtGuardUserTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('PluginrtGuardUser');
  }

   /**
   * Return a query with birthday condition
   *
   * @param  date            $from   Start date of birthday range
   * @param  date            $to     End date of birthday range
   * @param  Doctrine_Query  $query  an optional query object
   * @return Doctrine_Query
   */
  public function getBirthdayRestrictionQuery($from, $to, Doctrine_Query $q = null)
  {
    $q = $this->getQuery($q);
    $q->andWhere('(u.date_of_birth >= ?)', $from);
    $q->andWhere('(u.date_of_birth <= ?)', $to);
    return $q;
  }

  /**
   * Return a query with users the hold a certain permission
   *
   * @param  String $permission
   * @param  Doctrine_Query  $query  an optional query object
   * @return Doctrine_Query
   */
  public function getUsersArrayByPermissionQuery($permission, Doctrine_Query $q = null)
  {
    $q = $this->getQuery($q);
    $q->leftJoin('u.Permissions p');
    $q->andWhere('p.name = ?',$permission);
    $q->andWhere('u.is_active = ?',true);
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
      $q = $this->getQueryObject()->from($this->getComponentName() .' u');
    }

    return $q;
  }
}