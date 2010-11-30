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
 * rtTemplateToolkit provides a generic set template handling methods for frontend and backend mangement.
 *
 * Note: "mode" is used to reference the frontend / backend profile types for the templates.
 *
 * @package    rtCorePlugin
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtTemplateToolkit
{
  const MODE_BACKEND  = 'backend';
  const MODE_FRONTEND = 'frontend';

  /**
   * Set the template directory to the rtCorePlugin template
   */
  static public function setTemplateDirToDefault()
  {
    self::setTemplateDir(self::getrtPluginTemplateDir());
  }

  /**
   * Get the rtCorePlugin template directory for a given mode.
   * 
   * @param string $mode should be either frontend or backend
   * @return string
   */
  static public function getrtPluginTemplateDir($mode = self::MODE_FRONTEND)
  {
    return sfConfig::get('sf_plugins_dir') .
        DIRECTORY_SEPARATOR . 'rtCorePlugin' .
        DIRECTORY_SEPARATOR . 'templates';
  }

  /**
   * Set the template directory to a fully qualified path.
   *
   * @param string $dir
   */
  static public function setTemplateDir($dir)
  {
    sfConfig::set('sf_app_template_dir', $dir);
  }

  /**
   * Set the frontend template.
   */
  static public function setFrontendTemplateDir()
  {
    self::setTemplateForMode(self::MODE_FRONTEND);
  }

  /**
   * Set the backend template.
   */
  static public function setBackendTemplateDir()
  {
    self::setTemplateForMode(self::MODE_BACKEND);
  }

  /**
   * Set the template for a given mode, first checking for a configured overide.
   *
   * For example:
   * 
   * rt:
   *   template_dir_frontend: "/var/www/my_project/apps/frontend/templates"
   *
   * @param string $mode
   */
  static public function setTemplateForMode($mode)
  {
    if($mode === self::MODE_BACKEND)
    {
      return  self::setTemplateDir(self::getrtPluginTemplateDir($mode));
    }

    if($mode === self::MODE_FRONTEND && sfConfig::has('app_rt_template_dir'))
    {
      return self::setTemplateDir(sfConfig::get('sf_root_dir') . sfConfig::get('app_rt_template_dir'));
    }
  }
}