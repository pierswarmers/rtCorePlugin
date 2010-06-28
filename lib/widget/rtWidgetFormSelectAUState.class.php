<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtWidgetFormSelectAUState
 *
 * @package    gumnut
 * @subpackage widgets
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtWidgetFormSelectAUState extends sfWidgetFormSelectUSState
{
  /**
   * @see sfWidget
   */
  public function __construct($options = array(), $attributes = array())
  {
    $options['choices'] = new sfCallable(array($this, 'getChoices'));

    $this->setStates(self::$states);

    parent::__construct($options, $attributes);
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
