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
 * rtCommentPublicForm handles commenting form attached to things like posts.
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtCommentPublicForm extends rtCommentRatingPublicForm
{
  public function setup()
  {
    parent::setup();
    
    unset($this['rating']);
  }
}