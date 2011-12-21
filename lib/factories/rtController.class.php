<?php

/**
 * ...
 *
 * @author    Piers Warmers <piers@wranglers.com.au>
 * @copyright Copyright (c) 2011, digital Wranglers <info@wranglers.com.au>
 * @license   This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.
 */
class rtController extends sfActions
{
  /**
   * Executes an application defined process prior to execution of this sfAction object.
   *
   * By default, this method is empty.
   */
  public function preExecute()
  {
    exit;
  }
}
