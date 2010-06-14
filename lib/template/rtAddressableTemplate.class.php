<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/listener/rtAddressableListener.class.php');

/**
 * rtAddressableTemplate
 *
 * @package    readitype
 * @subpackage template
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtAddressableTemplate extends Doctrine_Template
{
  protected $_options = array(
    'addressAlias'      => 'Addresses',
    'cascadeDelete'   => true
  );
  
  public function __construct(array $options = array())
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);

    if (!isset($this->_options['connection']))
    {
      $this->_options['connection'] = Doctrine_Manager::connection();
    }
  }
  
  public function setTableDefinition()
  {
    $this->addListener(new rtAddressableListener($this->_options));
  }

  /**
   * Return the first address found in the address list, matching a type value.
   *
   * @return Doctrine_Record
   */
  public function getAddress($type = 'billing')
  {
    foreach($this->getAddresses() as $address)
    {
      if($address->getType() === $type)
      {
        return $address;
      }
    }
    return false;
  }

  /**
   * Fetch an collection of addresses attached to this object.
   */
  public function getAddresses()
  {
    $holder = $this->getAddressHolder($this->getInvoker());

    if (!isset($holder) || !$holder->hasNamespace('saved_addresses'))
    {
      $addresses = Doctrine::getTable('rtAddress')->getAddressesForObject($this->getInvoker());
      $holder->add($addresses, 'saved_addresses');
    }

    return $holder->getAll('saved_addresses');
  }

  /**
   * Get and/or set the parameter holder.
   * 
   * @return sfNamespacedParameterHolder
   */
  private function getAddressHolder($object)
  {
    if ((!isset($object->_addresses)) || ($object->_addresses == null))
    {
      $parameter_holder = new sfNamespacedParameterHolder;
      $object->mapValue('_addresses', new $parameter_holder());
    }
    return $object->_addresses;
  }
}