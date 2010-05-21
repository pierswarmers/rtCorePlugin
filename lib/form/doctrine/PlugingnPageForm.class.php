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
    
    unset($this['deleted_at'], $this['version'], $this['profile'], $this['created_at'], $this['updated_at'], $this['comment_count']);

    if(!gnSiteToolkit::isMultiSiteEnabled())
    {
      // Delete this widget unless we are in a multi-site installation.
      unset($this['site_id']);
    }
    // set the widgets
    $this->setWidget('title',       new sfWidgetFormInputText(array(), array('class' => 'title')));
    $this->setWidget('content',     new gnWidgetFormTextareaMarkdown(array(), array()));
    $this->setWidget('tags',        new sfWidgetFormInput(array(), array('class' => 'tag-input')));
    $this->setWidget('description', new sfWidgetFormInputText(array(), array()));

    // inject the tags into the default value
    $this->setDefault('tags', implode(', ', $this->getObject()->getTags()));

    // set the validators
    $this->setValidator('tags',     new sfValidatorString(array('required' => false)));
    $this->setValidator('title',    new sfValidatorString(array('max_length' => 255, 'required' => true), array('required' => 'please enter a descriptive title.')));
    $this->setValidator('content',  new sfValidatorString(array('required' => true), array('required' => 'please enter some content.')));

    $this->widgetSchema->setHelp('description', 'As short description describing this page.');
    $this->widgetSchema['searchable']->setLabel('Searchable');
    $this->widgetSchema->setHelp('searchable', 'Make this page available to search engine robots');
    $this->widgetSchema['slug']->setLabel('URL Slug');
    $this->enableCSRFProtection();
//    $this->embedI18n(array('en'));
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
