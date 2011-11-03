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
 * rtGuardUserPublicForm
 *
 * Intended for usage by individuals wanting to change their account details, this form is a stripped down version
 * of it's administration alternative rtGuardUserForm.
 *
 * There is also a couple of extended configuration available to alter it's mode:
 *
 * `app_rt_account_profile_is_simple` can be set to either: true or false
 * `app_rt_account_address_is_simple` can be set to either: true or false
 *
 * Both settings default to simple mode.
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGuardUserPublicForm extends rtGuardUserForm
{
  public function setup()
  {
    parent::setup();

    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    unset(
    $this['username'],
    $this['is_active'],
    $this['is_super_admin'],
    $this['groups_list'],
    $this['permissions_list']
    );

    if($this->isProfileModeSimple())
    {
      unset($this['url'], $this['date_of_birth']);
    }
    else
    {
      $this->widgetSchema->setLabel('url', 'Website');
      $this->widgetSchema->setHelp('url', 'Must start with: http:// or https://');
      $this->setValidator('url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Please enter a valid website address.')));
    }

    $this->widgetSchema->setHelp('first_name', '');
    $this->setValidator('first_name', new sfValidatorString(array('required' => true)));
    $this->widgetSchema->setHelp('last_name', '');
    $this->setValidator('last_name', new sfValidatorString(array('required' => true)));

    $this->widgetSchema->setHelp('email_address', '');
//    $this->widgetSchema->setHelp('username', 'Required');

    $this->widgetSchema->setHelp('password', '');
    $this->setValidator('password', new sfValidatorString(array('required' => false, 'min_length' => 6), array('min_length' => 'Your entered password is too short (%min_length% characters min).')));

    $this->widgetSchema->setHelp('password_again', 'Once again, just to be sure');

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('email_address')), array('invalid' => 'That email address is already taken.')),
//        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username')), array('invalid' => 'That username is already taken.')),
      ))
    );
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
    return new rtAddressPublicForm($address, $options);
  }

  /**
   * Is the form configured in
   *
   * @return bool
   */
  public function isProfileModeSimple()
  {
    return sfConfig::get('app_rt_account_profile_is_simple', true);
  }

  /**
   * Is the form configured in
   *
   * @return bool
   */
  public function isAddressModeSimple()
  {
    return sfConfig::get('app_rt_account_address_is_simple', true);
  }

  /**
   * Set the address forms.
   *
   * @return void
   */
  protected function setEmbeddedForms()
  {
    $this->setEmbeddedAddressForm('billing_address', 'billing');

    if(!$this->isAddressModeSimple())
    {
      $this->setEmbeddedAddressForm('shipping_address', 'shipping');
    }
  }
}
?>
