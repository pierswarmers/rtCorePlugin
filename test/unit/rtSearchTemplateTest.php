<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

$t = new lime_test(13);

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

$t->is($tester->getSearchFields(), array('title','content'), '->getSearchFields() returns an array of configured fields');

$title = 'Hello, this is a test object!';
$content = 'It really doesn\'t do too much. Just a little bit of text to hold and save for testing.';

$tester['title'] = $title;
$tester['content'] = $content;

$t->is($tester->getSearchBlob(), $title . ' ' .$content, '->getSearchBlob() returns a combined string');

$blob_array =   array('hello','test','object','realli','doesnt','text','hold','save','test');

$t->is(array_values($tester->getSearchIndexArray()), $blob_array, '->getSearchIndexArray() returns a stemmed array of words');

Doctrine_Core::createTablesFromArray(array('Tester'));

//$t->is($tester->getLanguages(), false, '->getLanguages() returns false for non i18n doctrine models');

class I18NTester extends Doctrine_Record
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
      $i18n = new Doctrine_Template_I18N(array('fields' => array('title','content')));
      $i18n->addChild($search);
      $this->actAs(new rtSearchTemplate);
      $this->actAs($i18n);
    }

    public function delete(Doctrine_Connection $conn = null)
    {
      $configuration = ProjectConfiguration::getApplicationConfiguration( 'frontend', 'test', true);
      sfContext::createInstance($configuration)->getLogger()->err('{I18NTester} delete() called!');
      parent::delete($conn);
    }
}

$t->diag('Test a more complex I18N object.');

Doctrine_Core::createTablesFromArray(array('I18NTester'));

$i18n_tester = new I18NTester();

$title = 'Hello, balloons are green blue and sometime red!';
$content = 'It really doesn\'t do too much. Just a little bit of text to hold and save for testing.';

$i18n_tester->Translation['en']->title = $title;
$i18n_tester->Translation['en']->content = $content;

$t->is($i18n_tester->Translation['en']->getSearchBlob(), $title . ' ' .$content, '->getSearchBlob() returns a combined string');

$t->is($i18n_tester->Translation['en']->getLang(), 'en', '->getLang() returns the correct value for en Translation');

$title = 'Bon jour, ca va?';
$content = "Les mots vides (ou stop words, en anglais) sont des mots qui sont tellement communs qu'il est inutile de les indexer ou de les utiliser dans une recherche.";

$i18n_tester->Translation['fr']->title = $title;
$i18n_tester->Translation['fr']->content = $content;

$t->is($i18n_tester->Translation['fr']->getSearchBlob(), $title . ' ' .$content, '->getSearchBlob() returns a combined string');

$t->is($i18n_tester->Translation['fr']->getLang(), 'fr', '->getLang() returns the correct value for fr Translation');

$i18n_tester->save();

$i18n_tester_id = $i18n_tester->Translation['fr']->id;
$i18n_tester_class = get_class($i18n_tester->Translation['fr']);

$index_items = Doctrine::getTable('rtIndex')->getQueryObject()
      ->from('rtIndex i')
      ->andWhere('i.model_id = ?', $i18n_tester_id)
      ->andWhere('i.model = ?', $i18n_tester_class)
      ->execute();

$total_expected = count($i18n_tester->Translation['en']->getSearchIndexArray()) + count($i18n_tester->Translation['fr']->getSearchIndexArray());

$t->is(count($index_items), $total_expected, 'A count of index items from that object returns the correct number.');

$tester->save();

$t->is(count($index_items), $total_expected, 'Correct index count after other object is saved.');

$index_items = Doctrine::getTable('rtIndex')->getQueryObject()
      ->from('rtIndex i')
      ->andWhere('i.model_id = ?', $tester->id)
      ->andWhere('i.model = ?', get_class($tester))
      ->execute();

$t->is(count($index_items), count($tester->getSearchIndexArray()), 'Correct index count for original test object.');

$i18n_tester->Translation['en']->title = 'Second title: has the word horse in it.';
$i18n_tester->save();

//$i18n_tester->Translation['en']->delete();
//$i18n_tester->Translation['fr']->delete();
$i18n_tester->delete();

$index_items = Doctrine::getTable('rtIndex')->getQueryObject()
      ->from('rtIndex i')
      ->andWhere('i.model_id = ?', $tester->id)
      ->andWhere('i.model = ?', get_class($tester))
      ->execute();

$t->is(count($index_items), count($tester->getSearchIndexArray()), 'Correct index count for original test object after deletion of other object has taken place.');

$index_items = Doctrine::getTable('rtIndex')->getQueryObject()
      ->from('rtIndex i')
      ->andWhere('i.model_id = ?', $i18n_tester_id)
      ->andWhere('i.model = ?', $i18n_tester_class)
      ->execute();

$t->is(count($index_items), 0, 'The deletion correctly removed all index items.');

$tester->delete();

$index_items = Doctrine::getTable('rtIndex')->getQueryObject()
      ->from('rtIndex i')
      ->andWhere('i.model_id = ?', $tester->id)
      ->andWhere('i.model = ?', get_class($tester))
      ->execute();

$t->is(count($index_items), 0, 'Index items removed for simple object after its been deleted.');
