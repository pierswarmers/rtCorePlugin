<?php

require_once(dirname(__FILE__).'/../../../../sfDoctrineGuardPlugin/modules/sfGuardForgotPassword/lib/BasesfGuardForgotPasswordActions.class.php');

/**
 * sfGuardForgotPassword actions.
 * 
 * @package    sfGuardForgotPasswordPlugin
 * @subpackage sfGuardForgotPassword
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class gnGuardForgotPasswordActions extends BasesfGuardForgotPasswordActions
{
  public function preExecute()
  {
    sfConfig::set('app_gn_node_title', 'Users');
    gnTemplateToolkit::setFrontendTemplateDir();
    parent::preExecute();
  }
}
