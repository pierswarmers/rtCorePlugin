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
 * rtCommentRatingPublicForm handles commenting/rating form attached to things like posts.
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtCommentRatingPublicForm extends PluginrtCommentForm
{
  public function setup()
  {
    parent::setup();
    
    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    $this->useFields(array('author_name', 'author_email', 'author_website', 'content', 'model', 'model_id', 'rating'));

    // Widgets
    $this->setWidget('model_id', new sfWidgetFormInputHidden);
    $options = sfConfig::get('app_rt_comment_rating_increments', array('0' => '0/5',
                                                                       '0.1' => '0.5/5',
                                                                       '0.2' => '1/5',
                                                                       '0.3' => '1.5/5',
                                                                       '0.4' => '2/5',
                                                                       '0.5' => '2.5/5',
                                                                       '0.6' => '3/5',
                                                                       '0.7' => '3.5/5',
                                                                       '0.8' => '4/5',
                                                                       '0.9' => '4.5/5',
                                                                       '1' => '5/5'));
    
    $class = sfConfig::get('app_rt_comment_rating_widget', 'rtWidgetFormRating');

    $this->setWidget('rating', new $class(array('choices' => $options)));

    $this->setDefault('rating', '1');
    
    // Validators
    $this->setValidator('model',          new sfValidatorChoice( array('required' => true,   'choices' => sfConfig::get('app_rt_comment_models', array('rtBlogPage')))));
    $this->setValidator('model_id',       new sfValidatorInteger(array('required' => true),  array()));
    $this->setValidator('author_name',    new sfValidatorString( array('required' => true,   'max_length' => 100),array('max_length' => 'Author name is too long (%max_length% characters max.)')));
    $this->setValidator('content',        new sfValidatorString( array('required' => true),  array('required' => 'Please enter a comment.')));
    $this->setValidator('author_email',   new sfValidatorEmail(  array('required' => true),  array('invalid' => 'Please enter a valid email address.')));
    $this->setValidator('author_website', new sfValidatorUrl(    array('required' => false), array('invalid' => 'Please enter a valid website address.')));
    $this->setValidator('rating',         new sfValidatorNumber(array('min' => 0, 'max' => 1),array()));
    
    // Custom messages and labels
    $this->widgetSchema->setLabel('content',        'Comment');
    $this->widgetSchema->setHelp( 'author_name',    'Required');
    $this->widgetSchema->setLabel('author_name',    'Name');
    $this->widgetSchema->setHelp( 'author_email',   'Required, will not be published');
    $this->widgetSchema->setLabel('author_email',   'Email');
    $this->widgetSchema->setHelp( 'author_website', 'Must start with: http:// or https://');
    $this->widgetSchema->setLabel('author_website', 'Website');
    $this->widgetSchema->setLabel('rating',         'Rating');

    // This interferes with the caching of pages.
    $this->disableCSRFProtection();

    // Optionally configured Captcha widget and validator.
    if(sfConfig::get('app_rt_captcha_enabled', true))
    {
      $this->widgetSchema['captcha'] = new rtWidgetFormCaptcha();
      $this->widgetSchema->setLabel('captcha', 'Are you human');
      $this->setValidator('captcha', new rtValidatorCaptcha(array('required' => true), array('required' => 'This question is required, please try again.','invalid' => 'The answer you entered didn\'t pass validation, please try again.')));
    }

    // Optionally configured Honeypot widget and validator.
    if(sfConfig::get('app_rt_honeypot_enabled', true))
    {
      $this->widgetSchema['special_name'] = new rtWidgetFormHoneypot();
      $this->setValidator('special_name', new rtValidatorHoneypot(array('required' => false),array()));
    }
  }
}