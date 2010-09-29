<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertCommentComponents
 *
 * @package    reditype
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class BasertCommentComponents extends sfComponents
{
  public function executeComments(sfWebRequest $request)
  {
    $model = 'rtBlogPage';
    $model_id = 1;

    //Use model and model_id to get comments
    $this->comments = Doctrine::getTable('rtComment')->getCommentsForModelAndId($model,$model_id);    

    // Form
    $comment = new rtComment;
    $this->form = new rtCommentPublicForm($comment, array());
  }
}