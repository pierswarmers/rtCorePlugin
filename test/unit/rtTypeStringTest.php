<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../plugins/rtCorePlugin/lib/toolkit/rtIndexToolkit.class.php';

$t = new lime_test(11);

$s = new rtTypeString('hello');

$t->is($s->transform(), 'hello');