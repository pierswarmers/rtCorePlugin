<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertAdminActions handles admin actions.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertAdminActions extends sfActions
{
  public function executeStateInput(sfWebRequest $request)
  {
    sfConfig::set('sf_debug', false);

    $this->id      = $request->getParameter('id');
    $this->name    = $request->getParameter('name');
    $this->country = $request->getParameter('country');

    if($this->country == 'AU')
    {
      $widget = new rtWidgetFormSelectAUState();
      $this->options = $widget->getStates();
    }
    elseif($this->country == 'US')
    {
      $widget = new sfWidgetFormSelectUSState();
      $this->options = $widget->getStates();
    }
  }
}