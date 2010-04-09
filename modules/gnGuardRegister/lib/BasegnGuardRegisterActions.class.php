<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../../../../sfDoctrineGuardPlugin/modules/sfGuardRegister/lib/BasesfGuardRegisterActions.class.php');

/**
 * gnGuardRegisterActions
 *
 * Extends the base sfGuardRegistration module by implementing a very basic activation workflow
 * which can be enabled via configuration.
 *
 * @package    gnCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasegnGuardRegisterActions extends BasesfGuardRegisterActions
{
  public function preExecute() {
    parent::postExecute();
    sfConfig::set('app_gn_node_title', 'Users');
  }

  /**
   * Overide parent method by introducing a set of security modes which can be envoked to restrict
   * the way registration is handled.
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->getUser()->setFlash('notice', 'You are already registered and signed in!');
      $this->redirect('@homepage');
    }

    $this->form = new sfGuardRegisterForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        if(sfConfig::get('app_gn_registration_is_administered', true))
        {
          $this->form->getObject()->setIsActive(false);
          $user = $this->form->save();
          $this->notifyAdministrator($user);
          $this->redirect('@sf_guard_register_success');
        }
        
        $user = $this->form->save();
        $this->getUser()->signIn($user);
        $this->redirect('@homepage');
      }
    }
  }

  /**
   * Account created success page. Only used if account activation is pending approval.
   *
   * @param sfWebRequest $request
   */
  public function executePending(sfWebRequest $request)
  {
    // nothing to do here.
  }

  /**
   * Confirm an account and activate it.
   * 
   * @param sfWebRequest $request
   */
  public function executeConfirm(sfWebRequest $request)
  {
    $user = Doctrine::getTable('sfGuardUser')->find($request->getParameter('id'));
    $this->forward404Unless($user);
    $user->setIsActive(true);
    $user->save();
    $this->notifyUser($user);
    $this->user = $user;
  }

  /**
   * Notify the administrator of the pending user activation.
   *
   * @param sfGuardUser $user
   */
  function notifyAdministrator(sfGuardUser $user)
  {
    $from = $user->getEmailAddress();
    $to = $this->getAdminEmail();
    $subject = sprintf('[%s] Registration request for: %s', $this->generateUrl('homepage', array(), true), $user->getName());
    $body  = 'A new user has registered but will need to be activated before they can log in.' . "\n\n";
    $body .= sprintf('The details they entered were: %s (%s)', $user->getName(),$user->getEmailAddress()) . "\n\n";
    $body .= 'If you wish to automatically activate this user, you can do so by simply clicking on this link:' . "\n";
    $body .= $this->generateUrl('sf_guard_register_confirm', array('id' => $user->getId()), true) . "\n";
    $this->getMailer()->composeAndSend($from, $to, $subject, $body);
  }
  
  /**
   * Notify the user of the activated account.
   *
   * @param sfGuardUser $user
   */
  function notifyUser(sfGuardUser $user)
  {
    $from = $this->getAdminEmail();;
    $to = $user->getEmailAddress();
    $subject = sprintf('[%s] Registration confirmed!', $this->generateUrl('homepage', array(), true));
    $body  = 'Hi ' .  $user->getFirstName() . ",\n\n";
    $body .= 'Your registration has been approved and you\'re now able to login:' . "\n";
    $body .= $this->generateUrl('sf_guard_signin', array('id' => $user->getId()), true) . "\n";
    $this->getMailer()->composeAndSend($from, $to, $subject, $body);
  }

  /**
   * Get the admin email address.
   *
   * @return string
   */
  private function getAdminEmail()
  {
    return sfConfig::get('app_gn_registration_admin_email', sfConfig::get('app_gn_admin_email'));;
  }

  public function formatMessageBody($body)
  {
    return $body . "\n\n--\n" . sfConfig::get('app_gn_title');
  }
}
