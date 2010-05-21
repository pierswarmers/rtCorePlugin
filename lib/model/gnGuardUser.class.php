<?php

/**
 * User model.
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage model
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: PluginsfGuardUser.class.php 25605 2009-12-18 18:55:55Z Jonathan.Wage $
 */
class gnGuardUser extends PluginsfGuardUser
{
    public function setTableDefinition()
    {
      parent::setTableDefinition();
    }

    public function setUp()
    {
        parent::setUp();

        $gnsearchtemplate0 = new gnSearchTemplate(array(
             'fields' =>
             array(
              0 => 'first_name',
              1 => 'last_name',
              2 => 'email_address',
              2 => 'username',
             ),
             ));
        $this->actAs($gnsearchtemplate0);
    }
    
    public function getTypeNice()
    {
      return 'Person';
    }
}
