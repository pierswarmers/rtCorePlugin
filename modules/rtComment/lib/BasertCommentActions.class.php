<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertCommentActions
 *
 * @package    reditype
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class BasertCommentActions extends sfActions
{
  /**
   * Executes an application defined process prior to execution of this sfAction object.
   */
  public function preExecute()
  {
    sfConfig::set('app_rt_node_title', 'Comment');
    rtTemplateToolkit::setFrontendTemplateDir();
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('rtComment/new');
  }

  /**
   * Executes the new page
   *
   * @param sfWebRequest $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $comment = new rtComment;
    $this->form = new rtCommentPublicForm($comment, array());

    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT))
    {
      $this->form->bind($request->getParameter($this->form->getName()));

      if($this->form->isValid()) {
        $this->form->save();
      }
      $this->getUser()->setFlash('default_error', true, false);
    }
    //$this->setLayout(false);
  }

  public function executeCreate(sfWebRequest $request)
  {
    // JSON

    // Send mail to admin

    return false;
  }

  /**
   * Notify the administrator about new classified
   *
   * @param sfGuardUser $user
   * @param bdClassified $classified
   */
  protected function notifyAdministrator(sfGuardUser $user, $comment)
  {
    if(!sfConfig::has('app_rt_comment_admin_email'))
    {
      return;
    }

    $vars = array('user' => $user);
    $vars['comment'] = $comment;

    $message_html = $this->getPartial('rtComment/email_newcomment_admin_html', $vars);
    $message_html = $this->getPartial('rtEmail/layout_html', array('content' => $message_html));

    $message_plain = $this->getPartial('rtComment/email_newcomment_admin_plain', $vars);
    $message_plain = $this->getPartial('rtEmail/layout_plain', array('content' => html_entity_decode($message_plain)));

    $admin_address = sfConfig::get('app_rt_comment_admin_email', 'from@noreply.com');

    $message = Swift_Message::newInstance()
            ->setFrom($admin_address)
            ->setTo($admin_address)
            ->setSubject("RediType: A new comment was added")
            ->setBody($message_html, 'text/html')
            ->addPart($message_plain, 'text/plain');

    $this->getMailer()->send($message);
  }
}