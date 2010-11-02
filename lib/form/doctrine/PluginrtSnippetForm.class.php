<?php

/**
 * PluginrtSnippet form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginrtSnippetForm extends BasertSnippetForm
{
  public function setup()
  {
    parent::setup();

    unset($this['version'], $this['created_at'], $this['updated_at']);

    $this->widgetSchema->setHelp('collection', 'The collection decides where this snippet should be displayed.');
    $this->widgetSchema->setHelp('position', 'Optional position value to set the order for collections of snippets.');

    $this->setValidator('title', new sfValidatorString(array('max_length' => 255, 'required' => true)));
    $this->setValidator('collection', new sfValidatorString(array('max_length' => 255, 'required' => true)));

    if(!rtSiteToolkit::isMultiSiteEnabled())
    {
      // Delete this widget unless we are in a multi-site installation.
      unset($this['site_id']);
    }
    else
    {
      $this->setValidator('site_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('rtSite'), 'required' => true), array('required' => 'Please select a site for this item to be attached to.')));
    }
    
    $this->setWidget('content',     new rtWidgetFormTextareaMarkdown(array(), array()));

  }
}
