<?php

/**
 * PlugingnGuardUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PlugingnGuardUserForm extends BasegnGuardUserForm
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

    $years = range(date('Y') - sfConfig::get('app_gn_user_age_year_buffer', 50), date('Y'));

    $options = array(
      'format' => '%day%/%month%/%year%',
      'years' => array_combine($years, $years)
    );

    $this->widgetSchema['url']->setLabel('Website URL');
    $this->setValidator('url', new sfValidatorUrl());
    $this->setWidget('date_of_birth',  new sfWidgetFormDate($options));
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off'));
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off'));
    $this->setWidget('groups_list', new sfWidgetFormDoctrineChoice(array('expanded' => true ,'multiple' => true, 'model' => 'sfGuardGroup')));
    $this->setWidget('permissions_list', new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'sfGuardPermission')));
  }
}
