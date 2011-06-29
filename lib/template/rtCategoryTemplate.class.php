<?php
/*
 * This file is part of the Reditype package.
 *
 * (c) 2009-2010 digital Wranglers <info@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/listener/rtCategoryListener.class.php');

/**
 * rtCategoryTemplate defines some base helpers.
 *
 * @package    rtCorePlugin
 * @subpackage template
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtCategoryTemplate extends Doctrine_Template
{
  protected $_options = array(
    'rtCategory'       => 'rtCategory',
    'categoryAlias'    => 'Categories',
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
    $this->addListener(new rtCategoryListener($this->_options));
  }

  /**
   * Fetch an collection of categories attached to this object.
   *
   * @return array
   */
  public function getCategories()
  {
    $holder = $this->getCategoriesHolder($this->getInvoker());

    if (!isset($holder) || !$holder->hasNamespace('saved_categories'))
    {
      $comments = Doctrine::getTable('rtCategory')->getCategoriesForObject($this->getInvoker());
      $holder->add($comments, 'saved_categories');
    }

    return $holder->getAll('saved_categories');
  }
  
  /**
   * Get and/or set the parameter holder.
   * 
   * @param  $object
   * @return sfNamespacedParameterHolder
   */
  private function getCategoriesHolder($object)
  {
    if ((!isset($object->_categories)) || ($object->_categories == null))
    {
      $parameter_holder = new sfNamespacedParameterHolder;
      $object->mapValue('_categories', new $parameter_holder());
    }
    return $object->_categories;
  }
}