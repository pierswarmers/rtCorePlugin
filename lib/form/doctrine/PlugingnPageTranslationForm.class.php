<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PlugingnPageTranslationForm
 *
 * @package    gumnut
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PlugingnPageTranslationForm extends BasegnPageTranslationForm
{
  public function setup()
  {
    parent::setup();
    unset($this['slug'], $this['version'], $this['created_at'], $this['updated_at']);
    $this->setWidget('title',      new sfWidgetFormInputText(array(), array('class' => 'title')));
    $this->setValidator('title',   new sfValidatorString(array('max_length' => 255, 'required' => true), array('required' => 'please enter a descriptive title.')));
    $this->setValidator('content', new sfValidatorString(array('required' => true), array('required' => 'please enter some content.')));
  }
}
