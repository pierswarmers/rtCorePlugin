<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

$t = new lime_test(10);

$configuration = ProjectConfiguration::getApplicationConfiguration( 'frontend', 'test', true);

new sfDatabaseManager($configuration);

class Tester extends Doctrine_Record
{
    public function setTableDefinition()
    {
      $this->hasColumn('title', 'string', 255);
      $this->hasColumn('content', 'string', null);
    }
    public function setUp()
    {
      parent::setUp();
      $search = new rtSearchTemplate(array('fields' =>array('title','content')));
      $this->actAs($search);
    }
}

Doctrine_Core::dropDatabases();
Doctrine_Core::createDatabases();
Doctrine_Core::createTablesFromArray(array('Tester', 'rtIndex'));

$tester = new Tester();
$tester['title'] = 'Hello, this is a test object, a balloon is great!';
$tester['content'] = 'Balloons really are great. Infact, ninety-nine of them make a wonderful song.';
$tester->save();

$table = Doctrine::getTable('rtIndex');

$t->is($table->getSearchResultsAsArray('19283hd'), false, '->getSearchResultsAsArray() returns false for a search on something which isn\'t in the index.');

$r = $table->getSearchResultsAsArray('balloon');

$t->is(is_array($r), true, '->getSearchResultsAsArray() returns an array for a valid search.');

$t->is(count($r), 1, '->getSearchResultsAsArray() returns correct no. of rows.');

$row_comparison = array (
  'id' => '4',
  'model' => 'Tester',
  'model_id' => '1',
  'lang' => 'en',
  'relevance' => '2',
);

$t->is($r[0], $row_comparison, '->getSearchResultsAsArray() rows are the correct structure.');

$tester2 = new Tester();
$tester2['title'] = 'Colours';
$tester2['content'] = 'Red, green, blue and yellow are just a few of the colours.';
$tester2->save();

$tester3 = new Tester();
$tester3['title'] = 'Party';
$tester3['content'] = 'Ribbons, balloons, wine, some good food. Got it!';
$tester3->save();

$r = $table->getSearchResultsAsArray('balloon, object');

$t->is(count($r), 2, '->getSearchResultsAsArray() returns correct no. of rows... after new items added.');

$r = $table->getSearchResults('balloon, object');

$t->is(count($r), 2, '->getSearchResults() returns correct no. of rows... after new items added.');

$t->isa_ok($r, Doctrine_Collection, '->getSearchResults() returns a Doctrine_Collection object.');

$t->diag('Test some rtIndex object usage.');

$t->isa_ok($r[0]->getObject(), Tester, '->getObject() returns a Tester object.');

$r = $table->getSearchResults('balloon, object');
$r = $table->hydrateResults($r);

$t->is(count($r), 2, '->hydrateResults() returns correct no. of rows... after new items added.');

$t->isa_ok($r, Doctrine_Collection, '->hydrateResults() returns a Doctrine_Collection object.');
