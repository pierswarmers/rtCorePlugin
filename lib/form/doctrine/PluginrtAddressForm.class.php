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

    // start countries >>>
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
    // <<< end countries



    $this->setWidget('state',        new rtWidgetFormSelectRegion(array('add_empty' => '--', 'country' => $this->getObject()->getCountry())));
    $this->setWidget('instructions', new sfWidgetFormInput());
    $this->setWidget('model',        new sfWidgetFormInputHidden());

    $this->widgetSchema->moveField('country', 'before', 'state');

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
    $this->widgetSchema->setHelp('phone', 'Please include your area code.');
  }

  /**
   * Renders the widget schema associated with this form.
   *
   * @param  array  $attributes  An array of HTML attributes
   *
   * @return string The rendered widget schema
   */
  public function render($attributes = array())
  {
    return $this->getCountryEnhancement() . $this->getFormFieldSchema()->render($attributes);
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    parent::bind($taintedValues, $taintedFiles);
    $this->setWidget('state', new rtWidgetFormSelectRegion(array('add_empty' => '--', 'country' => $taintedValues['country'])));
  }

  public function getCountryEnhancement()
  {
    $form_name = $this->getName();

    return "

<script type=\"text/javascript\">
  $(function() {
    $('#". $form_name ."_country').change(function() {

      var holder =  $('#". $form_name ."_state').parent();

      holder.html('<span class=\"loading\">Loading states...</span>');
      $('#". $form_name ."_state').remove();
      $.ajax({
        type: 'POST',
        url: '/rtAdmin/stateInput',
        data: ({
          country : $(this).find('option:selected').attr('value'),
          id      : '". $form_name ."_state',
          name    : '". $form_name ."[state]'
        }),
        dataType: 'html',
        success: function(data) {
          holder.html(data);
        }
      });
    });
  });
</script>

";
  }
}
