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
    if(!sfConfig::get('app_rt_comment_active', true))
    {
      throw new sfException('Comment module can\'t be used unless configured to be active i.e. app_rt_comment_active = true');
    }
    
    sfConfig::set('app_rt_node_title', 'Comment');
    rtTemplateToolkit::setFrontendTemplateDir();
  }

  /**
   * Display comment success message
   *
   * @param sfWebRequest $request
   */
  public function executeSaved(sfWebRequest $request)
  {
    $this->model = $request->getParameter('model');
    $this->model_id = $request->getParameter('model_id');
    $this->object = Doctrine::getTable($this->model)->findOneById($this->model_id);
  }

  /**
   * Display comment form incase of validation issues
   *
   * @param sfWebRequest $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $form = $this->getForm();

    if($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT))
    {
      $request_params = $request->getParameter($form->getName());

      if(sfConfig::get('app_rt_comment_recaptcha_enabled', false))
      {
        $captcha = array(
          'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
          'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
        );
        $request_params['captcha'] = $captcha;
      }

      $form->bind($request_params);

      if($form->isValid())
      {
        if(sfConfig::get('app_rt_comment_moderation', false) && !$this->getUser()->isAuthenticated())
        {
          $form->save();
          $this->notifyAdministrator($form->getObject());
        }
        else
        {
          $form->getObject()->setIsActive(true);
          $form->save();
          
          $routes = $this->getContext()->getRouting()->getRoutes();
          $route_name = Doctrine_Inflector::tableize($form->getObject()->getModel()).'_show';
          
          if(isset($routes[$route_name]))
          {
            $target_object = $form->getObject()->getObject();
            $cache_class = $form->getObject()->getModel() . 'CacheToolkit';

            if(class_exists($cache_class))
            {
              call_user_func($cache_class.'::clearCache', $target_object);
            }

            $this->redirect($this->getContext()->getRouting()->generate($route_name, $target_object));
          }
        }
        $this->redirect(sprintf('rtComment/saved?model=%s&model_id=%s', $form->getObject()->getModel(),$form->getObject()->getModelId()));
      }
      else
      {
        $this->getUser()->setFlash('default_error', true, false);
      }
    }

    $this->form = $form;
  }

  /**
   * Notify the administrator about new classified
   *
   * @param rtComment $comment
   */
  protected function notifyAdministrator($comment)
  {    
    if(!sfConfig::has('app_rt_comment_moderation_email'))
    {
      return;
    }
    
    $from = $comment->getAuthorEmail();
    $to = sfConfig::get('app_rt_comment_moderation_email', 'from@noreply.com');
    $subject = 'New comment requires activation!';
    $body  = sprintf('A new comment was created by %s (%s)', $comment->getAuthorName(),$comment->getAuthorEmail()) . ":\n\n";
    $body .= '--'."\n\n";
    $body .= strip_tags($comment->getContent()) . "\n\n";
    $body .= '--'."\n\n";
    $body .= 'Click here if you would like to activate this comment:' . "\n";
    $body .= $this->generateUrl('rt_comment_enable', array('id' => $comment->getId()), true);
    $this->getMailer()->composeAndSend($from, $to, $subject, $body);
  }

  /**
   * @return rtCommentForm
   */
  protected function getForm()
  {
    return new rtCommentPublicForm(new rtComment);
  }
}