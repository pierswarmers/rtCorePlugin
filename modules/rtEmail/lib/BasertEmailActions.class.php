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
 * BasertEmailActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class BasertEmailActions extends sfActions
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