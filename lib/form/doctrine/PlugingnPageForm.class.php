<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PlugingnPageForm
 *
 * @package    gumnut
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PlugingnPageForm extends BasegnPageForm
{
  public function setup()
  {
    parent::setup();
    unset($this['deleted_at'], $this['published_from'], $this['published_to'], $this['comment_count']);
    $this->widgetSchema['searchable']->setLabel('Make this page available to search engine robots');
    $this->widgetSchema['slug']->setLabel('URL Slug');
    $this->enableCSRFProtection();
    $this->embedI18n(array('en'));
  }
}
