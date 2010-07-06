<?php

/**
 * sfGuardRegisterForm for registering new users
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: BasesfGuardChangeUserPasswordForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class rtGuardRegisterForm extends sfGuardRegisterForm
{
  /**
   * @see sfForm
   */
  public function configure()
  {
  }

  public function getModelName()
  {
    return 'rtGuardUser';
  }
}