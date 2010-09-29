<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtCommentPublicForm
 *
 * @package    reditype
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtCommentPublicForm extends PluginrtCommentForm
{
  public function setup()
  {
    parent::setup();
    
    $this->useFields(array('author_name', 'author_email', 'author_website', 'content'));

    //$this->setValidator('author_name', new sfValidatorString(array('required' => true,'max_length' => 255),array('max_length' => 'Author name is too long (%max_length% characters max.)')));

    $this->disableLocalCSRFProtection();
    //$this->enableCSRFProtection();
  }
}