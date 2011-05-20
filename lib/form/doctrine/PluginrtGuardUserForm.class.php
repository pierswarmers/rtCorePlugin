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
 * The following form manages the user profile administration. That is to say, it includes both sfDoctrineGuard and
 * address components to provide a single point of managment.
 *
 * It's base intention is for usage in an administration context, thus has a fairly verbose set of fields. It is extended
 * by it's public version rtGuardUserPublicForm.
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

    $this->setEmbeddedForms();
  }

  /**
   * Set the address forms.
   * 
   * @return void
   */
  protected function setEmbeddedForms()
  {
    $this->setEmbeddedAddressForm('billing_address', 'billing');
    $this->setEmbeddedAddressForm('shipping_address', 'shipping');
  }

  /**
   * Embed a single address form.
   * 
   * @param  string $name
   * @param  string $type
   * @return void
   */
  protected function setEmbeddedAddressForm($name, $type)
  {
    $address = new rtAddress;
    $address->setType($type);
    $address->setModel('rtGuardUser');

    if(!$this->isNew())
    {
      $tmp_address = Doctrine::getTable('rtAddress')->getAddressForObjectAndType($this->getObject(), $type);
      if($tmp_address)
      {
        $address = $tmp_address;
      }
      $address->setModelId($this->object->getId());
    }

    $this->embedForm($name, $this->getAddressForm($address, array('object' => $this->object, 'is_optional' => true)));
  }

  /**
   * Return an instanciated address form.
   * 
   * @param rtAddress $address
   * @param array $options
   * @return rtAddressForm
   */
  protected function getAddressForm(rtAddress $address, $options = array())
  {
    return new rtAddressForm($address, $options);
  }

  /**
   * Save the embedded forms but removing empty addresses.
   * 
   * @param $con
   * @param $forms
   * @return mixed
   */
  public function saveEmbeddedForms($con = null, $forms = null)
  {
    if (null === $forms)
    {
      $forms = $this->embeddedForms;
      
      foreach(array('billing_address', 'shipping_address') as $name)
      {
        if(isset($forms[$name]))
        {
          $forms[$name]->object->setModelId($this->object->getId());
        }
        
        $address = $this->getValue($name);

        if (!isset($address['address_1']) || $address['address_1'] === '')
        {
          unset($forms[$name]);
        }
      }
    }

    return parent::saveEmbeddedForms($con, $forms);
  }
}
