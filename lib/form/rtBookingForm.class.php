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
 * rtContactForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtBookingForm extends rtContactForm
{
    public function setup()
    {
        parent::setup();

        $this->widgetSchema['arrival_date'] = new sfWidgetFormInput(array('type' => 'date'));
        $this->widgetSchema['number_of_people'] = new sfWidgetFormInput(array('type' => 'number'));

        $this->widgetSchema->setLabel('arrival_date', "Arrival Date:");
        $this->widgetSchema->setLabel('number_of_people', "Number of People:");

        $this->setValidator('arrival_date', new sfValidatorString(array('required' => true), array('required' => 'Please add your expected arrival date',)));
        $this->setValidator('number_of_people', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->moveField('arrival_date', sfWidgetFormSchema::AFTER, 'phone');
        $this->widgetSchema->moveField('number_of_people', sfWidgetFormSchema::AFTER, 'arrival_date');


//        $this->widgetSchema->setNameFormat('bd_basic_form[%s]');
//        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }
}