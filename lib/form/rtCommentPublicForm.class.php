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
 * rtCommentPublicForm handles commenting form attached to things like posts.
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtCommentPublicForm extends PluginrtCommentForm
{
  public function setup()
  {
    parent::setup();
    
    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    $this->useFields(array('author_name', 'author_email', 'author_website', 'content', 'model', 'model_id'));

    $this->setWidget('model_id', new sfWidgetFormInputHidden);

    $this->setValidator('model',          new sfValidatorChoice( array('required' => true,   'choices' => sfConfig::get('app_rt_comment_models', array('rtBlogPage')))));
    $this->setValidator('model_id',       new sfValidatorInteger(array('required' => true),  array()));
    $this->setValidator('author_name',    new sfValidatorString( array('required' => true,   'max_length' => 100),array('max_length' => 'Author name is too long (%max_length% characters max.)')));
    $this->setValidator('content',        new sfValidatorString( array('required' => true),  array('required' => 'Please enter a comment.')));
    $this->setValidator('author_email',   new sfValidatorEmail(  array('required' => true),  array('invalid' => 'Please enter a valid email address.')));
    $this->setValidator('author_website', new sfValidatorUrl(    array('required' => false), array('invalid' => 'Please enter a valid website address.')));

    // Custom messages and labels
    $this->widgetSchema->setLabel('content',        'Comment');
    $this->widgetSchema->setHelp( 'author_name',    'Required');
    $this->widgetSchema->setLabel('author_name',    'Name');
    $this->widgetSchema->setHelp( 'author_email',   'Required, will not be published');
    $this->widgetSchema->setLabel('author_email',   'Email');
    $this->widgetSchema->setHelp( 'author_website', 'Must start with: http:// or https://');
    $this->widgetSchema->setLabel('author_website', 'Website');

    // This interferes with the caching of pages.
    $this->disableCSRFProtection();

    // Optionally configured ReCAPTCHA widget and validator.
    if(sfConfig::get('app_rt_comment_recaptcha_enabled', false))
    {
      $this->widgetSchema['captcha'] = new sfWidgetFormReCaptcha(array(
        'public_key' => sfConfig::get('app_recaptcha_public_key'),
        'theme' => sfConfig::get('app_recaptcha_theme', 'clean')
      ));
      $this->validatorSchema['captcha'] = new sfValidatorReCaptcha(array(
        'private_key' => sfConfig::get('app_recaptcha_private_key')
      ), array('captcha' => 'The captcha you entered didn\'t pass validation, please try again.'));
      $this->widgetSchema->setLabel('content', 'Your Comment');
    }
  }
}