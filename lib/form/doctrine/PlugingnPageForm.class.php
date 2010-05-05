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

    if(!gnSiteToolkit::isMultiSiteEnabled())
    {
      // Delete this widget unless we are in a multi-site installation.
      unset($this['site_id']);
    }
    
    $this->widgetSchema['searchable']->setLabel('Make this page available to search engine robots');
    $this->widgetSchema['slug']->setLabel('URL Slug');
    $this->enableCSRFProtection();
    $this->embedI18n(array('en'));
  }

  /**
   * Extends the default handling to include logic to handle
   *
   * @param array $defaults An array of default values
   *
   * @return sfForm The current form instance
   */
  public function setDefaults($defaults)
  {
    parent::setDefaults($defaults);

    if(gnSiteToolkit::isMultiSiteEnabled())
    {
      $gn_site = Doctrine::getTable('gnSite')->findOneByDomain(gnSiteToolkit::getCurrentDomain());
      if($gn_site)
      {
        $this->setDefault('site_id', $gn_site->getId());
      }
    }

    return $this;
  }
}
