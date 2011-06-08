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
 * BasertCommentComponents
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class BasertCommentComponents extends sfComponents
{
  public function executeForm(sfWebRequest $request)
  {
    if(!isset($this->form))
    {
      $comment = new rtComment;
      $comment->setModel($this->model);
      $comment->setModelId($this->model_id);
      $this->form = new rtCommentPublicForm($comment, array());
    }
  }

  public function executeList(sfWebRequest $request)
  {
    $this->comments = Doctrine::getTable('rtComment')->getCommentsForModelAndId($this->model,$this->model_id);
  }

  public function executePanel(sfWebRequest $request)
  {
    $this->comments = Doctrine::getTable('rtComment')->getCommentsForModelAndId($this->model,$this->model_id);

    if(!isset($this->form))
    {
      $comment = new rtComment;
      $comment->setModel($this->model);
      $comment->setModelId($this->model_id);
      $this->form = new rtCommentPublicForm($comment, array());
    }
  }
}