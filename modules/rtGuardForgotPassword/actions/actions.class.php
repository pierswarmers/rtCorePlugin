<?php
/*
 * This file is part of the Reditype package.
 *
 * (c) 2009-2010 digital Wranglers <info@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../../../../sfDoctrineGuardPlugin/modules/sfGuardForgotPassword/lib/BasesfGuardForgotPasswordActions.class.php');

/**
 * rtGuardForgotPasswordActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGuardForgotPasswordActions extends BasesfGuardForgotPasswordActions
{
  public function preExecute()
  {
    sfConfig::set('app_rt_node_title', 'Users');
    rtTemplateToolkit::setFrontendTemplateDir();
    parent::preExecute();
  }

  public function executeIndex($request)
  {
    $this->form = new sfGuardRequestForgotPasswordForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $this->user = Doctrine_Core::getTable('sfGuardUser')
          ->retrieveByUsernameOrEmailAddress($this->form->getValue('email_address'));

        Doctrine_Core::getTable('sfGuardForgotPassword')
          ->deleteByUser($this->user);

        $forgotPassword = new sfGuardForgotPassword();
        $forgotPassword->user_id = $this->user->id;
        $forgotPassword->unique_key = md5(rand() + time());
        $forgotPassword->expires_at = new Doctrine_Expression('NOW()');
        $forgotPassword->save();

        $this->notifySendRequest($this->user, $forgotPassword);

        $this->getUser()->setFlash('notice', 'Check your e-mail! You should receive something shortly!');

        $this->redirect(sfConfig::get('app_sf_guard_plugin_password_request_url', '@sf_guard_signin'));
      } else {
        $this->getUser()->setFlash('error', 'Invalid e-mail address!');
      }
    }
  }

  public function executeChange($request)
  {
    $this->forgotPassword = $this->getRoute()->getObject();
    $this->user = $this->forgotPassword->User;
    $this->form = new sfGuardChangeUserPasswordForm($this->user);

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $this->form->save();

        $this->_deleteOldUserForgotPasswordRecords();

        $this->notifyNewPassword($this->user, $request['sf_guard_user']['password']);

        $this->getUser()->setFlash('notice', 'Password updated successfully!');
        $this->redirect('@sf_guard_signin');
      }
    }
  }

  /**
   * Notify the user of the activated account.
   *
   * @param sfGuardUser $user
   */
  private function notifySendRequest(sfGuardUser $user, $forgot_password)
  {


//$message = Swift_Message::newInstance()
//          ->setFrom(sfConfig::get('app_sf_guard_plugin_default_from_email', 'from@noreply.com'))
//          ->setTo($this->form->user->email_address)
//          ->setSubject('Forgot Password Request for '.$this->form->user->username)
//          ->setBody($this->getPartial('sfGuardForgotPassword/send_request', array('user' => $this->form->user, 'forgot_password' => $forgotPassword)))
//          ->setContentType('text/html')
//        ;
//
//        $this->getMailer()->send($message);


    $vars = array('user' => $user, 'forgot_password' => $forgot_password);

    if(isset($password))
    {
      $vars['password'] = $password;
    }

    $message_html = $this->getPartial('rtGuardForgotPassword/email_send_request_html', $vars);
    $message_html = $this->getPartial('rtEmail/layout_html', array('content' => $message_html));

    $message_plain = $this->getPartial('rtGuardForgotPassword/email_send_request_plain', $vars);
    $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => html_entity_decode($message_plain)));

    $message = Swift_Message::newInstance()
            ->setFrom($this->getAdminEmail())
            ->setTo($user->getEmailAddress())
            ->setSubject('Forgot Password Request for '.$user->username)
            ->setBody($message_html, 'text/html')
            ->addPart($message_plain, 'text/plain');

    $this->getMailer()->send($message);
  }

  /**
   * Notify the user of the activated account.
   *
   * @param sfGuardUser $user
   */
  private function notifyNewPassword(sfGuardUser $user, $password)
  {
//        $message = Swift_Message::newInstance()
//          ->setFrom(sfConfig::get('app_sf_guard_plugin_default_from_email', 'from@noreply.com'))
//          ->setTo($this->user->email_address)
//          ->setSubject('New Password for '.$this->user->username)
//          ->setBody($this->getPartial('sfGuardForgotPassword/new_password', array('user' => $this->user, 'password' => $request['sf_guard_user']['password'])))
//        ;
//
//        $this->getMailer()->send($message);

    $vars = array('user' => $user, 'password' => $password);

    $message_html = $this->getPartial('rtGuardForgotPassword/email_new_password_html', $vars);
    $message_html = $this->getPartial('rtEmail/layout_html', array('content' => $message_html));

    $message_plain = $this->getPartial('rtGuardForgotPassword/email_new_password_plain', $vars);
    $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => html_entity_decode($message_plain)));

    $message = Swift_Message::newInstance()
            ->setFrom($this->getAdminEmail())
            ->setTo($user->getEmailAddress())
            ->setSubject('New Password for '.$user->username)
            ->setBody($message_html, 'text/html')
            ->addPart($message_plain, 'text/plain');

    $this->getMailer()->send($message);
  }

  /**
   * Get the admin email address.
   *
   * @return string
   */
  private function getAdminEmail()
  {
    return sfConfig::get('app_rt_registration_admin_email', sfConfig::get('app_rt_admin_email'));
  }

  private function _deleteOldUserForgotPasswordRecords()
  {
    Doctrine_Core::getTable('sfGuardForgotPassword')
      ->createQuery('p')
      ->delete()
      ->where('p.user_id = ?', $this->user->id)
      ->execute();
  }
}
