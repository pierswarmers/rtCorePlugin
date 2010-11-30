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
 * PluginrtPageForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PluginrtPageForm extends BasertPageForm
{
  public function setup()
  {
    parent::setup();
    
    unset($this['deleted_at'], $this['version'], $this['profile'], $this['created_at'], $this['updated_at'], $this['comment_count']);

    if(!rtSiteToolkit::isMultiSiteEnabled())
    {
      // Delete this widget unless we are in a multi-site installation.
      unset($this['site_id']);
    }
    else
    {
      $this->setValidator('site_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('rtSite'), 'required' => true), array('required' => 'Please select a site for this item to be attached to.')));
    }
    // set the widgets
    $this->setWidget('title',       new sfWidgetFormInputText(array(), array('class' => 'title')));
    $this->setWidget('content',     new rtWidgetFormTextareaMarkdown(array(), array()));
    $this->setWidget('tags',        new sfWidgetFormInput(array(), array('class' => 'tag-input')));
    $this->setWidget('description', new sfWidgetFormInputText(array(), array()));

    // inject the tags into the default value
    $this->setDefault('tags', implode(', ', $this->getObject()->getTags()));

    // set the validators
    $this->setValidator('tags',     new sfValidatorString(array('required' => false)));
    $this->setValidator('title',    new sfValidatorString(array('max_length' => 255, 'required' => true), array('required' => 'Please enter a descriptive title.')));
    $this->setValidator('content',  new sfValidatorString(array('required' => false), array('required' => 'Please enter some content.')));

    $this->widgetSchema->setHelp('description', 'A short description of this item.');
    $this->widgetSchema['searchable']->setLabel('Searchable');
    $this->widgetSchema->setHelp('searchable', 'Make this item available to search engine robots');
    $this->widgetSchema['slug']->setLabel('URL Slug');
    $this->widgetSchema->setHelp('slug', 'The URL component of this item, in simple, lowercase, dash seperated ("my-page") values. ');
    $this->enableCSRFProtection();
//    $this->embedI18N(array('en'));
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

    if(rtSiteToolkit::isMultiSiteEnabled())
    {
//      $rt_site = Doctrine::getTable('rtSite')->findOneByDomain(rtSiteToolkit::getCurrentDomain());
//      if($rt_site && $this->isNew())
//      {
//        $this->setDefault('site_id', $rt_site->getId());
//      }
    }

    return $this;
  }
}
