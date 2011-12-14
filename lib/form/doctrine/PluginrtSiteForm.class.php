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
 * PluginrtSiteForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PluginrtSiteForm extends BasertSiteForm
{
  public function setup()
  {
    parent::setup();

    $this->useFields(array(
      'title', 'domain', 'reference_key', 'content', 'published', 'ga_code', 'ga_domain', 'facebook_url', 'flickr_url',
      'twitter_url', 'devour_url', 'tumblr_url', 'youtube_url', 'email_signature'
    ));

    $this->setWidget('content',     $this->getWidgetFormTextarea());
  }


  protected function getWidgetFormTextarea($options = array(), $attributes = array())
  {
    $class = sfConfig::get('app_rt_widget_form_textarea_class', 'rtWidgetFormTextareaMarkdown');

    return new $class($options, $attributes);
  }
}
