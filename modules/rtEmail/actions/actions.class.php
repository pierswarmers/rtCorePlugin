<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of actions
 *
 * @author pierswarmers
 */
class rtEmailActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $address = sfConfig::get('app_rt_test_email', 'from@noreply.com');

    $message_html = $this->getPartial('rtEmail/layout_html', array('content' => '<p>Hello!</p><p>Some more text here...</p>'));

    $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => 'Simple text'."\r\n".'Hello'));

    $message = Swift_Message::newInstance()
            ->setFrom($address)
            ->setTo($address)
            ->setSubject('Test Email')
            ->setBody($message_html, 'text/html')
            ->addPart($message_plain, 'text/plain');

    $this->getMailer()->send($message);
  }
}
?>
