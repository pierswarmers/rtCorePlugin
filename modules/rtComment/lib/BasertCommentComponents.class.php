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
        $this->parent_object  = Doctrine::getTable($this->model)->find($this->model_id);
        $this->comments       = Doctrine::getTable('rtComment')->getCommentsForModelAndId($this->model,$this->model_id);
        $this->rating_enabled = isset($this->rating_enabled) ? $this->rating_enabled : false;

        if(!isset($this->form))
        {
            $comment = $this->getNewComment();
            $comment->setModel($this->model);
            $comment->setModelId($this->model_id);
            $this->form = $this->getForm($comment);
        }
    }

    protected function getNewComment()
    {
        $comment = new rtComment;

        if($this->getUser()->isAuthenticated()) {

            $this->getUser()->getGuardUser();

            $comment->setAuthorName($this->getUser()->getGuardUser()->getFirstName() . ' ' . $this->getUser()->getGuardUser()->getLastName());
            $comment->setAuthorEmail($this->getUser()->getGuardUser()->getEmailAddress());
        }

        return $comment;
    }


    protected function getForm($comment)
    {
        $comment_form = $this->rating_enabled ? 'rtCommentRatingPublicForm' : 'rtCommentPublicForm';
        return new $comment_form($comment, array());
    }
}