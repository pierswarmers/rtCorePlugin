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
 * PluginrtAddress
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PluginrtAddress extends BasertAddress
{
  protected $_object;
  
  public function save(Doctrine_Connection $conn = null)
  {
    if(sfConfig::get('app_rt_address_geo_coords_enabled', false))
    {
      $coords = GoogleMaps::getCoords(
        array(
             $this->address_1,
             $this->address_2,
             $this->town,
             $this->state,
             $this->country,
             $this->postcode
        )
      );

      if(is_array($coords))
      {
        $this->setLatitude($coords['latitude']);
        $this->setLongitude($coords['longitude']);
      }
      else
      {
        $this->setLatitude(0.0);
        $this->setLongitude(0.0);
      }
    }
    
    parent::save($conn);
  }
  
  public function getObject()
  {
    if(is_null($this->_object))
    {
      $this->_object = Doctrine::getTable($this->getModel())->findOneById($this->getModelId());
    }
    
    return $this->_object;
  }
}