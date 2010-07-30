<?php

/**
 * PluginrtAddress form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginrtAddressForm extends BasertAddressForm
{
  public function setup()
  {
    parent::setup();
    $object = $this->getOption('object');

    $this->setWidget('type', new sfWidgetFormInputHidden());

    if(!$this->getOption('use_names', false))
    {
      unset($this['first_name'], $this['last_name']);
    }
    
    unset($this['care_of'], $this['created_at'], $this['updated_at'], $this['model_id']);

    if (!$object)
    {
      throw new InvalidArgumentException('You must provide a parent object.');
    }

    // Avert your eyes - nasty hack to remove regions from I18N country choices.
    // 
    // TODO: find better hack or at the very least, move this logic to a widget.
    //
    // start hack >>>
    // $countries = new sfWidgetFormI18nChoiceCountry(array('add_empty' => '--'));
    $c = new sfCultureInfo(sfContext::getInstance()->getUser()->getCulture());
    $countries = $c->getCountries();

    foreach($countries as $key => $value)
    {
      if(is_int($key))
      {
        unset($countries[$key]);
      }
    }

    unset($countries['ZZ']);

    $countries = array('' => '--') + $countries;
    $this->setWidget('country', new sfWidgetFormSelect(array('choices' => $countries)));
    // <<< end hack

    if(!$this->isNew())
    {
//      if($this->getObject()->getCountry() == 'AU')
//      {
//        $this->setWidget('state', new rtWidgetFormSelectAUState(array('add_empty' => '--')));
//      }
//      elseif($this->getObject()->getCountry() == 'US')
//      {
//        $this->setWidget('state', new sfWidgetFormSelectUSState(array('add_empty' => '--')));
//      }
//      $this->setStateWidget($this->getObject()->getCountry());
    }

    $this->setWidget('instructions', new sfWidgetFormInput());
    $this->setWidget('model', new sfWidgetFormInputHidden());

    $this->widgetSchema->moveField('country', 'before', 'state');

    if($this->getOption('is_optional', false))
    {
      $this->setValidators(array(
        'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
        'type'       => new sfValidatorChoice(array('choices' => array(0 => 'billing', 1 => 'shipping'), 'required' => false)),
        'care_of'    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
        'address_1'  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
        'address_2'  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
        'town'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
        'state'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
        'postcode'   => new sfValidatorString(array('max_length' => 10, 'required' => false)),
        'country'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
        'model'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
        'instructions'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
        'first_name'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
        'last_name'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
        'phone'        => new sfValidatorString(array('max_length' => 20, 'required' => false))
      ));

      $this->validatorSchema->setPostValidator(new rtAddressValidator(array('use_names' => $this->getOption('use_names', false))));
    }
    $this->widgetSchema->setHelp('phone', 'Please include your area code.');
  }

  public function setStateWidget($country)
  {
    if($country == 'AU')
    {
      $this->setWidget('state', new rtWidgetFormSelectAUState(array('add_empty' => '--')));
    }
    elseif($country == 'US')
    {
      $this->setWidget('state', new sfWidgetFormSelectUSState(array('add_empty' => '--')));
    }
  }
}
