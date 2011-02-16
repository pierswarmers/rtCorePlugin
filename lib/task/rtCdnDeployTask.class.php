<?php
/*
 * This file is part of the steercms package.
 * 
 * (c) digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtCdnDeployTask provides a cli task to syncronise static files with a static file server
 * or CDN. This task inherits all functions of the sfProjectDeployTask class, extending only
 * the execute method to include writing a syncronisation tag file and a restriction of the web
 * directory only.
 *
 * @package    Reditype
 * @subpackage task
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @see        sfProjectDeployTask
 */
class rtCdnDeployTask extends sfProjectDeployTask
{
  protected function configure()
  {
//    $this->addArguments(array(
//      new sfCommandArgument('server', sfCommandArgument::REQUIRED, 'The server name'),
//    ));
//
    $this->addOptions(array(
      new sfCommandOption('go', null, sfCommandOption::PARAMETER_NONE, 'Do the deployment'),
      new sfCommandOption('rsync-dir', null, sfCommandOption::PARAMETER_REQUIRED, 'The directory where to look for rsync*.txt files', 'config'),
      new sfCommandOption('rsync-options', null, sfCommandOption::PARAMETER_OPTIONAL, 'To options to pass to the rsync executable', '-azC --force --delete --progress'),
    ));

    $this->namespace = 'rt';
    $this->name = 'cdn-deploy';
    $this->briefDescription = 'Deploys a project to another server';

    $this->detailedDescription = <<<EOF
The [project:deploy|INFO] task deploys a project on a server:

  [./symfony project:deploy production|INFO]

The server must be configured in [config/properties.ini|COMMENT]:

  [[cdn]
    host=www.example.com
    port=22
    user=fabien
    dir=/var/www/sfblog/
    type=rsync|INFO]

To automate the deployment, the task uses rsync over SSH.
You must configure SSH access with a key or configure the password
in [config/properties.ini|COMMENT].

By default, the task is in dry-mode. To do a real deployment, you
must pass the [--go|COMMENT] option:

  [./symfony project:deploy --go|INFO]

Files and directories configured in [config/rsync_exclude.txt|COMMENT] are
not deployed:

  [.svn
  /web/uploads/*
  /cache/*
  /log/*|INFO]

You can specify the options passed to the rsync executable, using the
[rsync-options|INFO] option (defaults are [-azC --force --delete --progress|INFO]):

  [./symfony project:deploy --go --rsync-options=-avz|INFO]
EOF;
  }
  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $env = 'cdn';

    $ini = sfConfig::get('sf_config_dir').'/properties.ini';
    if (!file_exists($ini))
    {
      throw new sfCommandException('You must create a config/properties.ini file');
    }

    $properties = parse_ini_file($ini, true);

    if (!isset($properties[$env]))
    {
      throw new sfCommandException(sprintf('You must define the configuration for server "%s" in config/properties.ini', $env));
    }

    $properties = $properties[$env];

    if (!isset($properties['host']))
    {
      throw new sfCommandException('You must define a "host" entry.');
    }

    if (!isset($properties['dir']))
    {
      throw new sfCommandException('You must define a "dir" entry.');
    }

    $host = $properties['host'];
    $dir  = $properties['dir'];
    $user = isset($properties['user']) ? $properties['user'].'@' : '';

    if (substr($dir, -1) != '/')
    {
      $dir .= '/';
    }

    $ssh = 'ssh';

    if (isset($properties['port']))
    {
      $port = $properties['port'];
      $ssh = '"ssh -p'.$port.'"';
    }

    if (isset($properties['parameters']))
    {
      $parameters = $properties['parameters'];
    }
    else
    {
      $parameters = $options['rsync-options'];
      if (file_exists($options['rsync-dir'].'/rsync_exclude.txt'))
      {
        $parameters .= sprintf(' --exclude-from=%s/rsync_exclude.txt', $options['rsync-dir']);
      }

      if (file_exists($options['rsync-dir'].'/rsync_include.txt'))
      {
        $parameters .= sprintf(' --include-from=%s/rsync_include.txt', $options['rsync-dir']);
      }

      if (file_exists($options['rsync-dir'].'/rsync.txt'))
      {
        $parameters .= sprintf(' --files-from=%s/rsync.txt', $options['rsync-dir']);
      }
    }

    $dryRun = $options['go'] ? '' : '--dry-run';

    $web_dir = sfConfig::get('sf_web_dir') . '/';

    $command = "rsync $dryRun $parameters -e -L $ssh $web_dir $user$host:$dir";

    $this->getFilesystem()->execute($command, $options['trace'] ? array($this, 'logOutput') : null, array($this, 'logErrors'));

    $this->clearBuffers();

    $tag = rtAssetToolkit::getCdnTagFilename();

    if(is_file($tag)) {
      unlink($tag);
    }

    file_put_contents($tag, time());

    chmod($tag, 0775);
    chown($tag, fileowner(sfConfig::get('sf_data_dir')));
    chgrp($tag, filegroup(sfConfig::get('sf_data_dir')));
  }
}