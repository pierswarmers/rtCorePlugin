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
 * rtWidgetFormSelectRegion
 *
 * @package    rtCorePlugin
 * @subpackage widget
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtWidgetFormSelectRegion extends sfWidgetFormSelect
{
  /**
   * @see sfWidget
   */
  public function __construct($options = array(), $attributes = array())
  {
    $options['choices'] = new sfCallable(array($this, 'getChoices'));

    parent::__construct($options, $attributes);
  }

  /**
   * @see sfWidget
   */
  protected function configure($options = array(), $attributes = array())
  {
    $country = (isset($options['country']) && $options['country'] != '') ? $options['country'] : sfConfig::get('app_rt_default_country','AU');

    $this->addOption('add_empty', false);
    $this->addOption('country', $country);

    parent::configure($options, $attributes);
  }

  /**
   * Returns choices for the current widget.
   *
   * @return array
   */
  public function getChoices()
  {
    $choices = array();
    if (false !== $this->getOption('add_empty'))
    {
      $choices[''] = true === $this->getOption('add_empty') ? '' : $this->getOption('add_empty');
    }
    $choices = array_merge($choices, self::getRegions());
    return $choices;
  }

  /**
   * Returns an associative array of US states.
   *
   * @return array
   */
  public function getRegions()
  {
    $file = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'rtCorePlugin/data/i18n/regions.xml';
    $xml = simplexml_load_file($file);

    $states = array();
    foreach ($xml->country as $country)
    {
      if($country['iso2'] == $this->getOption('country'))
      {
        foreach($country->state as $state)
        {
          $state = (string) $state;
          $states[$state] = $state;
        }
      }
    }
    asort($states,SORT_STRING);
    return $states;
  }

  /**
   * Sets the array of states.
   *
   * @param array $states
   */
  static public function setStates(array $states)
  {
    self::$states = $states;
  }
}