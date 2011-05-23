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
 * PluginrtAddressTable
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class PluginrtAddressTable extends Doctrine_Table
{
  /**
   * Return addresses for a given record object.
   *
   * @param Doctrine_Record $object
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   * @see PluginrtAddressTable::getAddressesForModelAndId()
   */
  public function getAddressesForObject(Doctrine_Record $object, Doctrine_Query $q = null)
  {
    return $this->getAddressesForModelAndId(get_class($object), $object->getId(), $q);
  }

  /**
   * Return address for a given record class, id and type.
   *
   * @param Doctrine_Record $object
   * @param string $type
   * @param Doctrine_Query $q
   * @return rtAddress
   * @see PluginrtAddressTable::getAddressesForModelAndId()
   */
  public function getAddressForObjectAndType(Doctrine_Record $object, $type, Doctrine_Query $q = null)
  {
    return $this->getAddressForModelAndIdAndType(get_class($object), $object->getId(), $type, $q);
  }

  /**
   * Return addresses for a given record class and id.
   *
   * @param string $model
   * @param string $model_id
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   */
  public function getAddressesForModelAndId($model, $model_id, Doctrine_Query $q = null)
  {
    $q = $this->getQueryForModelAndId($model, $model_id, $q);
    return $q->execute();
  }

  /**
   * Return address for a given record class, id and type.
   *
   * @param string $model
   * @param string $type
   * @param string $model_id
   * @param Doctrine_Query $q
   * @return rtAddress
   */
  public function getAddressForModelAndIdAndType($model, $model_id, $type, Doctrine_Query $q = null)
  {
    $q = $this->getQueryForModelAndId($model, $model_id, $q);
    $q->andWhere('address.type = ?', $type);
    return $q->fetchOne();
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
    $q->andWhere('address.model = ?', $model)
      ->andWhere('address.model_id = ?', $model_id);
    return $q;
  }

  /**
   * Returns an instance of this class.
   *
   * @return object PluginrtAddressTable
   */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('PluginrtAddress');
  }

  /**
   * Return query for addresses in defined radius
   * 
   * @param type $lat    Latitude
   * @param type $long   Longitude
   * @param type $radius Distance from current location in kilometres
   * @param Doctrine_Query $q
   * @return Doctrine_Query
   */
  public function getAddressesByDistanceQuery($lat, $long, $radius, Doctrine_Query $q = null)
  {
    $q = $this->getQuery($q);
    $q->select('*,(((acos(sin(('.$lat.'*PI()/180)) * sin((address.latitude*PI()/180))+cos(('.$lat.'*PI()/180))  * cos((address.latitude*PI()/180)) * cos((('.$long.'-address.longitude)*PI()/180))))*180/PI())*60*1.1515*1.609344) as distance');
    $q->andWhere('address.latitude != 0 AND address.latitude IS NOT NULL');
    $q->andWhere('address.longitude != 0 AND address.longitude IS NOT NULL');
    $q->having('distance <= '.$radius);
    $q->groupBy('address.model_id, address.model');
    $q->orderBy('distance ASC');
    return $q;    
  }
  
  /**
   * Return list of closest addresses
   * 
   * @param type $lat    Latitude
   * @param type $long   Longitude
   * @param type $radius Distance from current location in kilometres
   * @param Doctrine_Query $q
   * @return Doctrine_Collection
   */
  public function getClosestAddressesByDistance($lat, $long, $radius, Doctrine_Query $q = null)
  {
    $q = $this->getQuery($q);
    $q = $this->getAddressesByDistanceQuery($lat, $long, $radius, $q);
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
      $q = $this->getQueryObject()->from($this->getComponentName() .' address');
    }

    return $q;
  }
}