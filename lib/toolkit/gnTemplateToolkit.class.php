<?php

/*
 * This file is part of the steercms package.
 * (c) digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnTemplateToolkit provides a generic set template handling methods for frontend and backend mangement.
 *
 * Note: "mode" is used to reference the frontend / backend profile types for the templates.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnTemplateToolkit
{
  /**
   * Set the template directory to the gnCorePlugin template
   */
  static public function setTemplateDirToDefault()
  {
    self::setTemplateDir(self::getGnPluginTemplateDir());
  }

  /**
   * Get the gnCorePlugin template directory for a ginen mode.
   * 
   * @param string $mode should be either frontend or backend
   * @return string
   */
  static public function getGnPluginTemplateDir($mode = 'frontend')
  {
    return sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'gnCorePlugin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$mode;
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
    self::setTemplateForMode('frontend');
  }

  /**
   * Set the backend template.
   */
  static public function setBackendTemplateDir()
  {
    self::setTemplateForMode('backend');
  }

  /**
   * Set the template for a given mode, first checking for a configured overide.
   *
   * For example:
   * 
   * gn:
   *   template_dir_frontend: "/var/www/my_project/apps/frontend/templates"
   *
   * @param string $mode
   */
  static public function setTemplateForMode($mode)
  {
    $dir = '';
    
    if(sfConfig::has('app_gn_template_dir_'.$mode))
    {
      $dir = sfConfig::get('app_gn_template_dir_'.$mode);
    }
    else
    {
      $dir = self::getGnPluginTemplateDir($mode);
    }

    self::setTemplateDir($dir);
  }
}