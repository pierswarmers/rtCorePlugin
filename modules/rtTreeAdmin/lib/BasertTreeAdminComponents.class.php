<?php
/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Heavily based on the workings in sfJqueryTreeDoctrineManager.
 *
 * Many thanks to the hard work of:
 * - Gregory Schurgast <michkinn@gmail.com> and,
 * - Gordon Franke <info@nevalon.de>
 *
 * Copyright (c) 2009-2010 Gregory Schurgast
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associateddocumentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 */

/**
 * BasertTreeAdminComponents.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertTreeAdminComponents extends sfComponents
{
  public function executeManager()
  {
    $this->records = $this->executeControl();
		if ($this->records)
    {
      $this->hasManyRoots = $this->modelHasManyRoots();
			$request = $this->getRequest();

			if (!$request->hasParameter('root') && !$this->modelHasManyRoots())
      {
				$this->getController()->redirect(url_for(  $request->getParameter('module') . '/'. $request->getParameter('action') .'?root=1'), true);
				return sfView::NONE;
			}
			elseif (!$request->hasParameter('root') && $this->modelHasManyRoots())
      {
				$this->roots = $this->getRoots( $this->model );
			}
			else
      {
				$this->records = $this->getTree($this->model, $request->getParameter('root'));
			}
		}
	}

  /**
   * return exception if Model is not defined as NestedSet
   */
  private function executeControl()
  {
    if (!Doctrine_Core::getTable($this->model)->isTree())
    {
      throw new Exception('Model "'.$this->model.'" is not a NestedSet');
      return false;
    }
    return true;
  }


	/*
	* Returns the roots
	*/
	private function getRoots($model){
        $tree = Doctrine_Core::getTable($model)->getTree();
        return $tree->fetchRoots();
    }

    private function getTree($model, $rootId = null){
        $tree = Doctrine_Core::getTable($model)->getTree();
        $options = array();
        if($rootId !== null)
        {
            $options['root_id'] = $rootId;
        }
        return $tree->fetchTree($options);
    }

	private function modelIsNestedSet(){
		return $this->options['treeImpl'] == 'NestedSet';
	}

	private function modelHasManyRoots(){
		$template = Doctrine_Core::getTable($this->model)->getTemplate('NestedSet');
        $options = $template->option('treeOptions');
        return isset($options['hasManyRoots']) && $options['hasManyRoots'];
	}
}
