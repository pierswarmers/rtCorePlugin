<?php

/**
 * PluginrtAddress form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginrtAddressForm extends BasertAddressForm
{
  public function setup()
  {
    parent::setup();

    $object = $this->getOption('object');

    if (!$object)
    {
      throw new InvalidArgumentException('You must provide a parent object.');
    }

    $this->setWidget('model', new sfWidgetFormInputHidden(array('default' => get_class($object))));
    $this->setWidget('model_id', new sfWidgetFormInputHidden(array('default' => $object->getId())));
  }
}
