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
 * rtWidgetFormTreeDoctrineChoice
 *
 * @package    rtCorePlugin
 * @subpackage widget
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtWidgetFormTreeDoctrineChoice extends sfWidgetFormDoctrineChoice
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * model:        The model class (required)
   *  * add_empty:    Whether to add a first empty value or not (false by default)
   *                  If the option is not a Boolean, the value will be used as the text value
   *  * method:       The method to use to display object values (__toString by default)
   *  * key_method:   The method to use to display the object keys (getPrimaryKey by default)
   *  * order_by:     An array composed of two fields:
   *                    * The column to order by the results (must be in the PhpName format)
   *                    * asc or desc
   *  * query:        A query to use when retrieving objects
   *  * multiple:     true if the select tag must allow multiple selections
   *  * table_method: A method to return either a query, collection or single object
   *
   * @see sfWidgetFormSelect
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('renderer_class', 'rtWidgetFormSelectCheckbox');
  }
  
  /**
   * Returns the choices associated to the model.
   *
   * @return array An array of choices
   */
  public function getChoices()
  {
    $choices = array();
    if (false !== $this->getOption('add_empty'))
    {
      $choices[''] = true === $this->getOption('add_empty') ? '' : $this->translate($this->getOption('add_empty'));
    }

    if (null === $this->getOption('table_method'))
    {
      $query = null === $this->getOption('query') ? Doctrine_Core::getTable($this->getOption('model'))->createQuery() : $this->getOption('query');
      if ($order = $this->getOption('order_by'))
      {
        $query->addOrderBy($order[0] . ' ' . $order[1]);
      }
      $objects = $query->execute();
    }
    else
    {
      $tableMethod = $this->getOption('table_method');
      $results = Doctrine_Core::getTable($this->getOption('model'))->$tableMethod();

      if ($results instanceof Doctrine_Query)
      {
        $objects = $results->execute();
      }
      else if ($results instanceof Doctrine_Collection)
      {
        $objects = $results;
      }
      else if ($results instanceof Doctrine_Record)
      {
        $objects = new Doctrine_Collection($this->getOption('model'));
        $objects[] = $results;
      }
      else
      {
        $objects = array();
      }
    }

    $method = $this->getOption('method');
    $keyMethod = $this->getOption('key_method');

    foreach ($objects as $object)
    {
      $choices[$object->$keyMethod()] = '<span class="rt-admin-tree rt-admin-tree-level-'.$object->level.'">' . $object->$method() .'</span>';
    }

    return $choices;
  }
}