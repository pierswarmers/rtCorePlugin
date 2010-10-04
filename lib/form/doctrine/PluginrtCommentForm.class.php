<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PluginrtCommentForm
 *
 * @package    reditype
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
abstract class PluginrtCommentForm extends BasertCommentForm
{
  public function setup()
  {
    parent::setup();

    unset($this['created_at'], 
          $this['updated_at']);
    
    // Widgets
    $this->setWidget('user_id', new sfWidgetFormInputHidden);
    $this->setWidget('comment_id', new sfWidgetFormInputHidden);
    $this->setWidget('model', new sfWidgetFormInputHidden);
    $this->setWidget('model_id', new sfWidgetFormInputHidden);
  }
}