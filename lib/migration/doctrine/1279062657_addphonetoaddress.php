<?php

class Addphonetoaddress extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('rt_address', 'phone', 'string', '20', array());
  }

  public function down()
  {
    $this->removeColumn('rt_address', 'phone');
  }
}