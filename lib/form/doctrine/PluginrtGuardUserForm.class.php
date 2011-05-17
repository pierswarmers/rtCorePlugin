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
 * PluginrtGuardUserForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PluginrtGuardUserForm extends BasertGuardUserForm
{
  /**
   * @see sfForm
   */
  public function setup()
  {
    parent::setup();

    unset(
      $this['last_login'],
      $this['created_at'],
      $this['updated_at'],
      $this['salt'],
      $this['algorithm']
    );

    $this->widgetSchema['groups_list']->setLabel('Groups');
    $this->widgetSchema['permissions_list']->setLabel('Permissions');

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', false);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];

    $this->widgetSchema->moveField('password_again', 'after', 'password');

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));

    $years = range(date('Y') - sfConfig::get('app_rt_user_age_year_buffer', 100), date('Y'));

    $options = array(
      'format' => '%day%/%month%/%year%',
      'years' => array_combine($years, $years)
    );

    $this->widgetSchema['url']->setLabel('Website URL');
    $this->setValidator('url', new sfValidatorUrl(array('required' => false)));
    $this->setWidget('date_of_birth',  new sfWidgetFormDate($options));
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off'));
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off'));
    $this->setWidget('groups_list', new sfWidgetFormDoctrineChoice(array('expanded' => true ,'multiple' => true, 'model' => 'sfGuardGroup')));
    $this->setWidget('permissions_list', new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'sfGuardPermission')));

    $billing_address = new rtAddress;
    $billing_address->setType('billing');
    $billing_address->setModel('rtGuardUser');

    $shipping_address = new rtAddress;
    $shipping_address->setType('shipping');
    $shipping_address->setModel('rtGuardUser');

    if(!$this->isNew())
    {
      $tmp_address_1 = Doctrine::getTable('rtAddress')->getAddressForObjectAndType($this->getObject(), 'shipping');
      if($tmp_address_1)
      {
        $shipping_address = $tmp_address_1;
      }
      $tmp_address_2 = Doctrine::getTable('rtAddress')->getAddressForObjectAndType($this->getObject(), 'billing');
      if($tmp_address_2)
      {
        $billing_address = $tmp_address_2;
      }
      $billing_address->setModelId($this->object->getId());
      $shipping_address->setModelId($this->object->getId());
    }

    $this->embedForm('billing_address', new rtAddressForm($billing_address, array('object' => $this->object, 'is_optional' => true)));
    $this->embedForm('shipping_address', new rtAddressForm($shipping_address, array('object' => $this->object, 'is_optional' => true)));
  }

  public function saveEmbeddedForms($con = null, $forms = null)
  {
    if (null === $forms)
    {
      $forms = $this->embeddedForms;

      foreach(array('billing_address', 'shipping_address') as $name)
      {
        $address = $this->getValue($name);

        if (!isset($address['address_1']) || $address['address_1'] === '')
        {
          unset($forms[$name]);
        }
      }
    }

    return parent::saveEmbeddedForms($con, $forms);
  }

//  public function bind(array $taintedValues = null, array $taintedFiles = null)
//  {
//    parent::bind($taintedValues, $taintedFiles);
//
//    foreach(array('billing_address', 'shipping_address') as $name)
//    {
//      $form = $this->getEmbeddedForm($name)->setStateWidget($taintedValues[$name]['country']);
//    }
//  }
}
