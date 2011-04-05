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
 * BasertContactActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class BasertContactActions extends sfActions
{
  /**
   * Executes an application defined process prior to execution of this sfAction object.
   */
  public function preExecute()
  {
    sfConfig::set('app_rt_node_title', 'Contact');
    rtTemplateToolkit::setFrontendTemplateDir();
  }

  /**
   * Executes the base contact
   *
   * @param sfWebRequest $request
   */
  public function executeContact(sfWebRequest $request)
  {
    $class = sfConfig::get('app_rt_contact_form_class', 'rtContactForm');

    $this->form = new $class;

    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT))
    {
      $this->form->bind($request->getParameter($this->form->getName()));

      if($this->form->isValid())
      {
        $vars = array('values' => $this->form->getValues());
        $message_html = $this->getPartial('rtContact/email_contact_admin_html', $vars);
        $message_plain = $this->getPartial('rtContact/email_contact_admin_plain', $vars);

        try {
          $this->notifyAdministrator($this->form->getValues(),$message_html,$message_plain);
        } catch (Exception $e) {

        }
        $this->redirect('rt_contact_confirmation');
      }
      $this->getUser()->setFlash('default_error', true, false);
    }
  }

  /**
   * Execute confirmation page
   * 
   * @param sfWebRequest $request 
   */
  public function executeConfirmation(sfWebRequest $request)
  {

  }

  /**
   * Notify the administrator
   *
   * @param array $form_values
   * @param html $html_partial
   * @param html $plain_partial
   */
  protected function notifyAdministrator($form_values, $html_partial, $plain_partial)
  {
    if(!sfConfig::has('app_rt_admin_email'))
    {
      return;
    }

    $message_html = $html_partial;
    $message_html = $this->getPartial('rtEmail/layout_html', array('content' => $message_html));

    $message_plain = $plain_partial;
    $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => html_entity_decode($message_plain)));

    $admin_address = sfConfig::get('app_rt_admin_email', 'from@noreply.com');

    $message = Swift_Message::newInstance()
            ->setFrom($form_values['email'])
            ->setTo($admin_address)
            ->setSubject("Contact form enquiry")
            ->setBody($message_html, 'text/html')
            ->addPart($message_plain, 'text/plain');

    $this->getMailer()->send($message);
  }
}