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
 * rtWidgetFormSelectAUState
 *
 * @package    rtCorePlugin
 * @subpackage widget
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtWidgetFormSelectAUState extends sfWidgetFormSelect
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
    $this->addOption('add_empty', false);
    $this->addOption('full', true);

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

    $choices = array_merge($choices, self::getStates());

    if(!$this->getOption('full')) {
      $choices_new = array();

      foreach($choices as $k => $v) {
        $choices_new[$k] = $k;
      }

      $choices = $choices_new;
    }

    return $choices;
  }

  /**
   * Returns an associative array of US states.
   *
   * @return array
   */
  static public function getStates()
  {
    return self::$states;
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

  /**
   * Returns an array of state abbreviations.
   *
   * @return array
   */
  static public function getStateAbbreviations()
  {
    return array_keys(self::$states);
  }
  
  static protected $states = array(
    'ACT' => 'Australian Capital Territory',
    'NSW' => 'New South Wales',
    'NT' => 'Northern Territory',
    'QLD' => 'Queensland',
    'SA' => 'South Australia',
    'TAS' => 'Tasmania',
    'VIC' => 'Victoria',
    'WA' => 'Western Australia'
  );
}
