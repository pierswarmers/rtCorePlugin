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
 * rtGuardRegisterActions
 *
 * Extends the base sfGuardRegistration module by implementing a very basic activation workflow
 * which can be enabled via configuration.
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertGuardRegisterActions extends BasesfGuardRegisterActions
{
  private $_rt_shop_cart_manager;
  
  public function preExecute()
  {
    sfConfig::set('app_rt_node_title', 'Users');
    rtTemplateToolkit::setFrontendTemplateDir();
    parent::preExecute();
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

    $this->form = new rtGuardRegisterForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        if(sfConfig::get('app_rt_registration_is_administered', true))
        {
          $this->form->getObject()->setIsActive(false);
          $user = $this->form->save();
          $this->notifyAdministrator($user);
          $this->redirect('@sf_guard_register_success');
        }
        
        $user = $this->form->save();
        $this->getUser()->signIn($user);
        $this->getUser()->setFlash('notice', 'You are registered and signed in!');
        $this->getUser()->setAttribute('registration_success', true);
        $this->notifyUser($user, $this->form->getValue('password'));
        
        $signinUrl = sfConfig::get('app_sf_guard_plugin_success_register_url', $this->getUser()->getReferer($request->getReferer()));

        return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
      }
    }
    else
    {
      $this->getUser()->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());
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
    $body  = 'A new user has registered but will need to be activated before they can sign in.' . "\n\n";
    $body .= sprintf('The details they entered were: %s (%s)', $user->getName(),$user->getEmailAddress()) . "\n\n";
    $body .= 'If you wish to automatically activate this user, you can do so by simply clicking on this link:' . "\n";
    $body .= $this->generateUrl('sf_guard_register_confirm', array('id' => $user->getId()), true) . "\n\n";
    $body .= 'Please note: you will need to be signed in to complete this action.' . "\n";
    $this->getMailer()->composeAndSend($from, $to, $subject, $body);
  }
  
  /**
   * Notify the user of the activated account.
   *
   * @param sfGuardUser $user
   */
  private function notifyUser(sfGuardUser $user, $password = null)
  {
    $vars = array('user' => $user, 'voucher' => $this->getGenerateVouchure($user));

    if(isset($password))
    {
      $vars['password'] = $password;
    }

    $message_html = $this->getPartial('rtGuardRegister/email_registration_success_html', $vars);
    $message_html = $this->getPartial('rtEmail/layout_html', array('content' => $message_html));
    
    $message_plain = $this->getPartial('rtGuardRegister/email_registration_success_plain', $vars);
    $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => html_entity_decode($message_plain)));

    $message = Swift_Message::newInstance()
            ->setFrom($this->getAdminEmail())
            ->setTo($user->getEmailAddress())
            //->setSubject(sprintf('[%s] Registration confirmed!', $this->generateUrl('homepage', array(), true)))
            ->setSubject('Registration confirmed!')
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

  private function getGenerateVouchure($user)
  {
    if(!sfConfig::has('app_rt_shop_registration_voucher'))
    {
      return false;
    }
    
    $config = sfConfig::get('app_rt_shop_registration_voucher');

    $config['title'] = isset($config['title']) ? $config['title'] : 'Welcome Voucher';

    $voucher = new rtShopVoucher;
    $voucher->setCount(1);
    $voucher->setTitle($config['title']);
    $voucher->setReductionType(isset($config['reduction_type']) ? $config['reduction_type'] : 'dollarOff');
    $voucher->setReductionValue(isset($config['reduction_value']) ? $config['reduction_value'] : '0');
    $voucher->setStackable(isset($config['stackable']) ? $config['stackable'] : false);

    if(isset($config['date_from']))
    {
      $voucher->setDateFrom($config['date_from']);
    }
    if(isset($config['date_to']))
    {
      $voucher->setDateTo($config['date_to']);
    }

    if(isset($config['total_from']))
    {
      $voucher->setTotalFrom($config['total_from']);
    }
    if(isset($config['total_to']))
    {
      $voucher->setTotalTo($config['total_to']);
    }

    $voucher->setComment(sprintf('Created for: %s %s (%s)', $user->getFirstName(), $user->getLastName(), $user->getEmailAddress()));
    $voucher->save();
    $user->setAttribute('registration_success', false);
    $this->getCartManager()->setVoucherCode($voucher->getCode());
    $this->getCartManager()->getOrder()->save();
    return $voucher;
//    $this->notifyUserOfgenerateVouchure($user, $voucher, $config);
  }

  /**
   * Notify the user of the activated voucher.
   *
   * @param sfGuardUser $user
   * @param rtShopVoucher $voucher
   * @param array $config
   */
  private function notifyUserOfgenerateVouchure(sfGuardUser $user, rtShopVoucher $voucher, $config = null)
  {
    return;
    $vars = array('user' => $user, 'voucher' => $voucher);

    if(is_null($config))
    {
      $config = array();
    }

    $config['title'] = isset($config['title']) ? $config['title'] : 'Welcome Voucher';

    $message_html = $this->getPartial('rtShopOrder/email_voucher_success_html', $vars);
    $message_html = $this->getPartial('rtEmail/layout_html', array('content' => $message_html));

    $message_plain = $this->getPartial('rtShopOrder/email_voucher_success_plain', $vars);
    $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => html_entity_decode($message_plain)));

    $message = Swift_Message::newInstance()
            ->setFrom($this->getAdminEmail())
            ->setTo($user->getEmailAddress())
            ->setSubject($config['title'])
            ->setBody($message_html, 'text/html')
            ->addPart($message_plain, 'text/plain');

    $this->getMailer()->send($message);
  }

  /**
   * Get cart manager object
   *
   * @return rtShopCartManager
   */
  public function getCartManager()
  {
    if(is_null($this->_rt_shop_cart_manager))
    {
      $this->_rt_shop_cart_manager = new rtShopCartManager();
    }

    return $this->_rt_shop_cart_manager;
  }

  public function formatMessageBody($body)
  {
    return $body . "\n\n--\n" . sfConfig::get('app_rt_title');
  }
}
