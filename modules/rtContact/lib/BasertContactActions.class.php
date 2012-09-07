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

    public function executeContact(sfWebRequest $request)
    {
        $site = rtSiteToolkit::getCurrentSite();

        if(!$site) {
            $this->forward404('No site configuration found for contact form request.');
        }

        $options = array(
            'to'            => $site->getEmailContactAddress(),
            'from'          => '',
            'subject'       => 'Contact Form Sent',
            'confirmation'  => $site->getEmailContactResponse(),
            'form_class'    => 'rtContactForm',
            'success_route' => 'rt_contact_confirmation',
            'partial_html'  => 'rtContact/email_contact_admin_html',
            'partial_plain' => 'rtContact/email_contact_admin_plain',
        );

        $this->processSubmission($request, $options);
    }

    public function executeContactConfirmation(sfWebRequest $request)
    {

    }

    public function executeBooking(sfWebRequest $request)
    {
        $site = rtSiteToolkit::getCurrentSite();

        if(!$site) {
            $this->forward404('No site configuration found for contact form request.');
        }

        $options = array(
            'to'            => $site->getEmailContactAddress(),
            'from'          => '',
            'subject'       => 'Contact Form Sent',
            'confirmation'  => $site->getEmailContactResponse(),
            'form_class'    => 'rtBookingForm',
            'success_route' => 'rt_contact_confirmation',
            'partial_html'  => 'rtContact/email_contact_admin_html',
            'partial_plain' => 'rtContact/email_contact_admin_plain',
        );

        $this->processSubmission($request, $options);
    }

    public function executeBookingConfirmation(sfWebRequest $request)
    {

    }

    /**
     * Executes the base contact
     *
     * @param sfWebRequest $request
     * @param string $form_class
     * @param string $success_route
     */
    public function processSubmission(sfWebRequest $request, $options)
    {
        $this->form = new $options['form_class'];

        if ($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)) {
            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {

                // Send primary message

                $vars = array('values' => $this->form->getValues());
                $message_html = $this->getPartial($options['partial_html'], $vars);
                $message_plain = $this->getPartial($options['partial_plain'], $vars);
                $values = $this->form->getValues();
                $this->sendEmail($options['to'], $values['email'], $options['subject'], $message_html, $message_plain);

                // Send confirmation message

                if(trim($options['confirmation']) !== '') {
                    $message_html = nl2br($options['confirmation']);
                    $message_plain = $options['confirmation'];
                    $values = $this->form->getValues();
                    $this->sendEmail($values['email'], $options['to'], $options['subject'], $message_html, $message_plain);
                }

                $this->redirect($options['success_route']);
            }

            $this->getUser()->setFlash('default_error', true, false);
        }
    }

    /**
     * Send the email.
     *
     * @param $to
     * @param $from
     * @param $subject
     * @param $html_message
     * @param $plain_message
     */
    protected function sendEmail($to, $from, $subject, $html_message, $plain_message)
    {
        if (!sfConfig::has('app_rt_admin_email')) {
            return;
        }

        $message_html = $html_message;
        $message_html = $this->getPartial('rtEmail/layout_html', array('content' => $message_html));

        $message_plain = $plain_message;
        $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => html_entity_decode($message_plain)));

        $message = Swift_Message::newInstance()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($message_html, 'text/html')
            ->addPart($message_plain, 'text/plain');

        $this->getMailer()->send($message);
    }
}