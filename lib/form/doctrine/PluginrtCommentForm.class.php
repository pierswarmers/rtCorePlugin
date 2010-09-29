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

    $this->useFields(array('is_active', 'author_name', 'author_email', 'author_website', 'content', 'moderator_note'));

    // Labels
    $this->widgetSchema['is_active']->setLabel('Enabled');
    $this->widgetSchema['author_name']->setLabel('Your Name');
    $this->widgetSchema['author_email']->setLabel('Your Email');
    $this->widgetSchema['author_website']->setLabel('Website');
    $this->widgetSchema['content']->setLabel('Add your own comment');
  }
}