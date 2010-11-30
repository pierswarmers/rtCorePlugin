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
 * PluginrtSnippetForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
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
