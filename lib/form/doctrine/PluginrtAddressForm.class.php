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
 * PluginrtAddressForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PluginrtAddressForm extends BasertAddressForm
{
  public function setup()
  {
    parent::setup();

    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    // Variables
    $is_optional = (!is_null($this->getOption('is_optional'))) ? $this->getOption('is_optional') : true;
    $object      = $this->getOption('object');

    $this->setWidget('type', new sfWidgetFormInputHidden());

    if(!$this->getOption('use_names', false))
    {
      unset($this['first_name'], $this['last_name']);
    }
    
    unset($this['care_of'], $this['created_at'], $this['updated_at'], $this['model_id'], $this['longitude'], $this['latitude']);

    if (!$object)
    {
      throw new InvalidArgumentException('You must provide a parent object.');
    }

    $this->setWidget('country', new rtWidgetFormSelectCountry());

    $this->setWidget('state',        new rtWidgetFormSelectRegion(array('add_empty' => '--', 'country' => $this->getObject()->getCountry())));
    $this->setWidget('instructions', new sfWidgetFormInput());
    $this->setWidget('model',        new sfWidgetFormInputHidden());

    $this->widgetSchema->moveField('country', 'before', 'state');

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'type'          => new sfValidatorChoice(array('choices' => array(0 => 'billing', 1 => 'shipping'), 'required' => false)),
      'care_of'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'address_1'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'address_2'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'town'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'state'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'postcode'      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'country'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'model'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'instructions'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'first_name'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'last_name'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'phone'         => new sfValidatorString(array('max_length' => 20, 'required' => false))
    ));

    $this->validatorSchema->setPostValidator(new rtAddressValidator(array('use_names' => $this->getOption('use_names', false), 'is_optional' => $is_optional)));
    $this->widgetSchema->setHelp('phone', 'Please include your area code.');
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    parent::bind($taintedValues, $taintedFiles);
    $this->setWidget('state', new rtWidgetFormSelectRegion(array('add_empty' => '--', 'country' => $taintedValues['country'])));
  }
}
