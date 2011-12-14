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
 * BasertSocialActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSocialActions extends sfActions
{
  /**
   * Executes an application defined process prior to execution of this sfAction object.
   *
   * By default, this method is empty.
   */
  public function preExecute()
  {
    sfConfig::set('app_rt_node_title', 'Sitemap');
    rtTemplateToolkit::setFrontendTemplateDir();
  }

  /**
   * Execute share by email method
   * 
   * @param sfWebRequest $request
   */
  public function executeEmail(sfWebRequest $request)
  {
    $user                 = $this->getUser();
    $search_public_models = sfConfig::get('app_rt_search_public_models', array('rtShopProduct','rtShopCategory','rtBlogPage','rtSitePage','rtWikiPage'));
    $this->model          = $request->getParameter('model');
    $this->model_id       = $request->getParameter('model_id');
    $this->route_name     = sfInflector::tableize($this->model) . '_show';
    $this->object         = Doctrine_Core::getTable($this->model)->find(array($this->model_id));
    
    // Exception handling
    if(!in_array($this->model, $search_public_models) || !$this->object)
    {
      throw new sfException(sprintf('Object %s does not exist.', $this->model));
    }

    // Form
    $this->form = new rtSocialEmailPublicForm();

    if($this->getRequest()->isMethod('PUT') || $this->getRequest()->isMethod('POST'))
    {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

      if($this->form->isValid())
      {
        $form_values = $this->form->getValues();
        $this->notifyAudience($this->object,$form_values,$this->route_name);
      }
      else
      {
        $this->getUser()->setFlash('default_error', true, false);
      }
    }
  }

  /**
   * Return array with recipients based on comma separated string
   *
   * @param String $string
   * @return Mixed
   */
  protected function getRecipients($string)
  {
    if(strstr($string,','))
    {
      $recipients = explode(',',$string);
    }
    else
    {
      $recipients = $string;
    }

    if(count($recipients) > 10)
    {
      throw new sfException('Too many recipients.');
    }

    return $recipients;
  }

  /**
   * Send email to audience, and if requested copy to sender
   *
   * @param Doctrine_Collection $object
   * @param Array $form_values
   */
  protected function notifyAudience($object, $form_values, $route_name)
  {
    $user       = $this->getUser();
    $signed_in  = $user->isAuthenticated() ? true : false;
    $from_email = $form_values['from_email'];
    $to_email   = $this->getRecipients($form_values['to_email']);

    // Variables
    $vars = array('object' => $object);
    $vars['form_values'] = $form_values;
    $vars['route_name']  = $route_name;
    if($signed_in)
    {
      $vars['from_text'] = sprintf('%s %s (%s)',$user->getGuardUser()->getFirstName(),$user->getGuardUser()->getLastName(),$user->getGuardUser()->getEmailAddress());
    }
    else
    {
      $vars['from_text'] = sprintf('%s (%s)',$form_values['from_name'],$form_values['from_email']);
    }
    $vars['name']        = $object->getTitle() ? $object->getTitle() : __('Item Page');

    // Email templates
    $message_html = $this->getPartial('rtSocial/email_html', $vars);
    $message_html = $this->getPartial('rtEmail/layout_html', array('content' => $message_html));

    $message_plain = $this->getPartial('rtSocial/email_plain', $vars);
    $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => html_entity_decode($message_plain)));

    // Subject
    $subject_text = 'I thought you might be interested in this';
    $subject = $object->getTitle() ? sprintf('%s: %s',$subject_text,$object->getTitle()) : $subject_text.'...';

    // Email
    $message = Swift_Message::newInstance()
               ->setFrom($from_email)
               ->setTo($to_email)
               ->setSubject($subject)
               ->setBody($message_html, 'text/html')
               ->addPart($message_plain, 'text/plain');

    // Send copy to sender
    if($form_values['copy'] == true)
    {
      $message->setBcc($from_email);
    }

    $this->getMailer()->send($message);
  }
}