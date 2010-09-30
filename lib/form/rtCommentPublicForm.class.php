<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtCommentPublicForm
 *
 * @package    reditype
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtCommentPublicForm extends PluginrtCommentForm
{
  public function setup()
  {
    parent::setup();
    
    $this->useFields(array('author_name', 'author_email', 'author_website', 'content', 'model', 'model_id'));

    if(sfConfig::get('app_rt_comment_recaptcha_enabled', false))
    {
      $this->widgetSchema['captcha'] = new sfWidgetFormReCaptcha(array(
        'public_key' => sfConfig::get('app_recaptcha_public_key'),
        'theme' => sfConfig::get('app_recaptcha_public_theme', 'clean')
      ));
      $this->validatorSchema['captcha'] = new sfValidatorReCaptcha(array(
        'private_key' => sfConfig::get('app_recaptcha_private_key')
      ));
    }

    $this->setWidget('model', new sfWidgetFormInputHidden);
    $this->setWidget('model_id', new sfWidgetFormInputHidden);

    $this->setValidator('model', new sfValidatorString(array('required' => true)));
    $this->setValidator('model_id', new sfValidatorInteger(array('required' => true)));

    $this->setValidator('author_name', new sfValidatorString(array('required' => true,'max_length' => 255),array('max_length' => 'Author name is too long (%max_length% characters max.)')));
    $this->setValidator('author_email', new sfValidatorEmail(array('required' => true)));

    $this->enableCSRFProtection();
  }
}