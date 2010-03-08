<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/listener/GnSearchListener.class.php');

/**
 * gnSearchListener defines some base helpers.
 *
 * @package    gumnut
 * @subpackage template
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnAttachableTemplate extends Doctrine_Template
{
  protected $_options = array(
    'gnAsset'         => 'gnAsset',
    'assetAlias'      => 'Assets',
    'cascadeDelete'   => true,
    'fields'          => array()
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
    $this->addListener(new gnAttachableListener($this->_options));
  }

  /**
   * Fetch an collection of assets attached to this object.
   */
  public function getAssets()
  {
    $holder = $this->getAssetsHolder();

    if (!isset($holder) || !$holder->hasNamespace('saved_assets'))
    {
      $assets = Doctrine::getTable('gnAsset')->getAssetsForObject($this->getInvoker());

      $holder->set('saved_assets', $assets);
    }
    
    return $holder->get('saved_assets');
  }

  /**
   * Get and/or set the parameter holder.
   * 
   * @return sfNamespacedParameterHolder
   */
  public function getAssetsHolder()
  {
    if ((!isset($object->_tags)) || ($object->_tags == null))
    {
      $object = $this->getInvoker();
      $parameter_holder = new sfNamespacedParameterHolder;
      $object->mapValue('_assets', new $parameter_holder());
    }
    return $object->_assets;
  }
}