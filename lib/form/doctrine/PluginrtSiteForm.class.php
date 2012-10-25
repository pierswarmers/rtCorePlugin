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
    /**
     * @see rtSiteForm
     */
    public function setup()
    {
        parent::setup();

        $this->useFields(array(
                'title',
                'domain',
                'reference_key',
                'content',
                'published',
                'html_snippet_suffix',
                'facebook_url',
                'twitter_url',
                'youtube_url',
                'tumblr_url',
                'google_plus_url',
                'email_signature',
                'public_url',
                'position',
                'content_summery',
                'email_contact_address',
                'email_contact_response',
                'email_booking_address',
                'email_booking_response'
            ));


        $this->setWidget('content', $this->getWidgetFormTextarea());
        $this->widgetSchema->setLabel('content','Description');

        $this->setWidget('content_summery', new sfWidgetFormTextarea());
        $this->widgetSchema->setLabel('content_summery','Brief Description');

        $this->widgetSchema->setLabel('public_url','Public URL');

        $this->setWidget('email_contact_response', new sfWidgetFormTextarea());
        $this->widgetSchema->setLabel('email_contact_address','Email Address');
        $this->widgetSchema->setLabel('email_contact_response','Response');

        $this->setWidget('email_booking_response', new sfWidgetFormTextarea());
        $this->widgetSchema->setLabel('email_booking_address','Email Address');
        $this->widgetSchema->setLabel('email_booking_response','Response');

        $this->widgetSchema->setLabel('facebook_url','Facebook URL');
        $this->setValidator('facebook_url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Must be a valid URL, eg. https://www.facebook.com/...')));

        $this->widgetSchema->setLabel('twitter_url','Twitter URL');
        $this->setValidator('twitter_url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Must be a valid URL, eg. https://twitter.com/...')));

        $this->widgetSchema->setLabel('google_plus_url','Google+ URL');
        $this->setValidator('google_plus_url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Must be a valid URL, eg. https://plus.google.com/b/...')));

        $this->widgetSchema->setLabel('tumblr_url','Tumblr URL');
        $this->setValidator('tumblr_url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Must be a valid URL, eg. https://plus.google.com/b/...')));

        $this->widgetSchema->setLabel('youtube_url','YouTube URL');
        $this->setValidator('youtube_url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Must be a valid URL, eg. http://www.youtube.com/user/...')));

        $this->setWidget('html_snippet_suffix', new sfWidgetFormTextarea());
        $this->widgetSchema->setLabel('html_snippet_suffix','Included HTML');

        // Populate position dropdown
        $query = Doctrine::getTable('rtSite')->getQuery()
            ->andWhere('site.position is not null');

        if (!$this->isNew()) {
            $query->andWhere('site.id != ?', $this->getObject()->getId());
        }

        $query->orderBy('site.position ASC');

        $site_positions = array();
        $site_positions[1] = 'First';
        $i = 2;
        foreach ($query->execute() as $tw_job)
        {
            $site_positions[$i] = 'Below ' . $tw_job->getTitle();
            $i++;
        }

        // Widgets
        $this->widgetSchema['position'] = new sfWidgetFormSelect(array('choices' => $site_positions));

        $this->setValidator('public_url', new sfValidatorUrl(array('required' => false), array('invalid' => 'Must be a valid URL, eg. http://example.com')));

        $this->setEmbeddedForms();
    }


    public function getModelName()
    {
        return 'rtSite';
    }

    protected function getWidgetFormTextarea($options = array(), $attributes = array())
    {
        $options['object_id'] = $this->isNew() ? null : $this->getObject()->getId();
        $options['object_class'] = $this->isNew() ? null : get_class($this->getObject());

        $class = sfConfig::get('app_rt_widget_form_textarea_class', 'rtWidgetFormTextareaMarkdown');

        return new $class($options, $attributes);
    }

    public function updateObject($values = null)
    {
        if (null === $values)
        {
            $values = $this->values;
        }

        $values = $this->processValues($values);

        $this->adjustPosition($values);

        $this->doUpdateObject($values);

        // embedded forms
        $this->updateObjectEmbeddedForms($values);

        return $this->getObject();
    }

    /**
     * Adjust postions of object items
     *
     * @param Array $values
     */
    private function adjustPosition($values)
    {
        if($this->getObject()->getPosition() == $values['position'])
        {
            return;
        }

        if($this->isNew() || is_null($this->getObject()->getPosition()))
        {
            $this->shiftBy('+', $values['position']);
        }
        elseif($values['position'] < $this->getObject()->getPosition())
        {
            $this->shiftBy('+', $values['position'], $this->getObject()->getPosition());
        }
        else
        {
            $this->shiftBy('-', $this->getObject()->getPosition(), $values['position']);
        }
    }

    /**
     * Shift postions of items up or down
     *
     * @param String $direction
     * @param String $from
     * @param String $to
     */
    private function shiftBy($direction, $from = null, $to = null)
    {
        $q = Doctrine_Query::create()
            ->update('rtSite site')
            ->set('site.position', 'site.position '. $direction .' 1');

        if(!is_null($from))
        {
            $q->andWhere('site.position >= ?', $from);
        }

        if(!is_null($to))
        {
            $q->andWhere('site.position <= ?', $to);
        }

        $q->execute();
    }



    /**
     * Set the address forms.
     *
     * @return void
     */
    protected function setEmbeddedForms()
    {
        $this->setEmbeddedAddressForm('billing_address', 'billing');
    }

    /**
     * Embed a single address form.
     *
     * @param  string $name
     * @param  string $type
     * @param  array  $options
     * @return void
     */
    protected function setEmbeddedAddressForm($name, $type, $options = array())
    {
        $options['object'] = isset($options['object']) ? $options['object'] : $this->object;
        $options['is_optional'] = isset($options['is_optional']) ? $options['is_optional'] : sfConfig::get('app_rt_account_address_is_optional_for_' . $type, true);;

        $address = new rtAddress;
        $address->setType($type);

        $address->setModel('rtSite');

        if(!$this->isNew())
        {
            $tmp_address = Doctrine::getTable('rtAddress')->getAddressForObjectAndType($this->getObject(), $type);
            if($tmp_address)
            {
                $address = $tmp_address;
            }
            $address->setModelId($this->object->getId());
        }

        $this->embedForm($name, $this->getAddressForm($address, $options));
    }

    /**
     * Return an instanciated address form.
     *
     * @param rtAddress $address
     * @param array $options
     * @return rtAddressForm
     */
    protected function getAddressForm(rtAddress $address, $options = array())
    {
        return new rtAddressForm($address, $options);
    }

    /**
     * Save the embedded forms but removing empty addresses.
     *
     * @param $con
     * @param $forms
     * @return mixed
     */
    public function saveEmbeddedForms($con = null, $forms = null)
    {
        if (null === $forms)
        {
            $forms = $this->embeddedForms;

            foreach(array('billing_address', 'shipping_address') as $name)
            {
                if(isset($forms[$name]))
                {
                    $forms[$name]->object->setModelId($this->object->getId());
                }

                $address = $this->getValue($name);

                if (!isset($address['address_1']) || $address['address_1'] === '')
                {
                    unset($forms[$name]);
                }
            }
        }

        return parent::saveEmbeddedForms($con, $forms);
    }
}
