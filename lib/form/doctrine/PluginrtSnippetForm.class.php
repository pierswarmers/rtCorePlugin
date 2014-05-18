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

        if ($this->getObject()->getMode() === 'gallery') {
            unset($this['content']);
        } else {
            $this->setWidget('content', $this->getWidgetFormTextarea());
        }

        $targets = array('_self', '_blank', '_parent', '_top');
        $this->setWidget('uri_target', new sfWidgetFormSelect(array('choices' => array_combine($targets, $targets))));

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
            $rt_site = Doctrine::getTable('rtSite')->findOneByDomain(rtSiteToolkit::getCurrentDomain());
            if($rt_site && $this->isNew())
            {
                $this->setDefault('site_id', $rt_site->getId());
            }
        }

        return $this;
    }

    protected function getWidgetFormTextarea($options = array(), $attributes = array())
    {
        $options['object_id'] = $this->isNew() ? null : $this->getObject()->getId();
        $options['object_class'] = $this->isNew() ? null : get_class($this->getObject());

        $class = sfConfig::get('app_rt_widget_form_textarea_class', 'rtWidgetFormTextareaMarkdown');

        return new $class($options, $attributes);
    }

}
