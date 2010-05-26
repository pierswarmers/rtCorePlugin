<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../plugins/rtCorePlugin/lib/toolkit/rtIndexToolkit.class.php';

$t = new lime_test(29);

$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
$string_dirty = 'a,b.c-d&e-f_g;h:i=j k]l[m(n)o|p\\q?r/s!t@u#v$w%x^y*z';
$string_clean = 'a b c d e f g h i j k l m n o p q r s t u v w x y z';

$t->is(rtIndexToolkit::getCleanedString($string), strtolower($string), '::getCleanedString() - alpha numerics are preserved');
$t->is(rtIndexToolkit::getCleanedString($string_dirty), $string_clean, '::getCleanedString() - non-alphanumerics are removed cleanly');
$t->is(rtIndexToolkit::getCleanedString('one     two'), 'one two', '::getCleanedString() - multiple spaces are converted to a single space');

$string = 'One, two, three - off we go!';
$string_as_array = array('one','two','three','off','we','go');

$t->is(is_array(rtIndexToolkit::getWordsFromString($string)), true, '::getWordsFromString() - returns an array');
$t->is(count(rtIndexToolkit::getWordsFromString($string)), 6, '::getWordsFromString() - returns an array of the correct length');
$t->is(rtIndexToolkit::getWordsFromString($string), $string_as_array, '::getWordsFromString() - returns an array containing each of the words');

$t->is(rtIndexToolkit::getIndexCleanerClass('blah'), false, '::getIndexCleanerClass() - returns false for unknown languages');
$t->is(rtIndexToolkit::getIndexCleanerClass('de'), 'rtIndexCleanerDe', '::getIndexCleanerClass() - [de] returns correct class');
$t->is(rtIndexToolkit::getIndexCleanerClass('en'), 'rtIndexCleanerEn', '::getIndexCleanerClass() - [en] returns class for known languages');
$t->is(rtIndexToolkit::getIndexCleanerClass('es'), 'rtIndexCleanerEs', '::getIndexCleanerClass() - [es] returns class for known languages');
$t->is(rtIndexToolkit::getIndexCleanerClass('fr'), 'rtIndexCleanerFr', '::getIndexCleanerClass() - [fr] returns class for known languages');

$string = 'Stoppwörter nennt man im Information Retrieval Wörter, die bei einer Volltextindexierung nicht beachtet werden, da sie sehr häufig auftreten und gewöhnlich keine Relevanz für die Erfassung des Dokumentinhalts besitzen.';
$string_as_array = array('stoppworter','nennt','man','information','retrieval','worter','volltextindexierung','beachtet','sehr','haufig','auftreten','gewohnlich','keine','relevanz','fur','erfassung','dokumentinhalts','besitzen');

$t->is(array_values(rtIndexToolkit::getCleanedWordsFromString($string, 'de')), $string_as_array, '::getCleanedWordsFromString() - [de] returns an array, stop words removed');

$string = 'Stop words is the name given to words which are filtered out prior to, or after, processing of natural language data (text).';
$string_as_array = array('stop','words','given','words','filtered','prior','processing','natural','language','data','text');

$t->is(array_values(rtIndexToolkit::getCleanedWordsFromString($string, 'en')), $string_as_array, '::getCleanedWordsFromString() - [en] returns an array, stop words removed');

$string = 'Palabras vacías es el nombre que reciben las palabras sin sirtificado como artículos, pronombres, preposiciones, etc. que son filtradas antes o después del procesamiento de datos en lenguaje natural (texto).';
$string_as_array = array('palabras','vacias','nombre','que','reciben','palabras','sirtificado','articulos','pronombres','preposiciones','etc','que','son','filtradas','despues','del','procesamiento','de','datos','lenguaje','natural','texto');

$t->is(array_values(rtIndexToolkit::getCleanedWordsFromString($string, 'es')), $string_as_array, '::getCleanedWordsFromString() - [en] returns an array, stop words removed');

$string = "Les mots vides (ou stop words, en anglais) sont des mots qui sont tellement communs qu'il est inutile de les indexer ou de les utiliser dans une recherche.";
$string_as_array = array ('mots','vides','stop','words','anglais','mots','communs','quil','inutile','de','indexer','de','utiliser','une','recherche');

$t->is(array_values(rtIndexToolkit::getCleanedWordsFromString($string, 'fr')), $string_as_array, '::getCleanedWordsFromString() - [en] returns an array, stop words removed');

$t->is(rtIndexToolkit::stemWordsInArray(array('äpfel'), 'de'), array('apfel'), '::stemWordsInArray() - [de] stemming works');
$t->is(rtIndexToolkit::stemWordsInArray(array('apfel'), 'de'), array('apfel'), '::stemWordsInArray() - [de] stemming works');
$t->is(rtIndexToolkit::stemWordsInArray(array('katze'), 'de'), array('katz'), '::stemWordsInArray() - [de] stemming works');
$t->is(rtIndexToolkit::stemWordsInArray(array('schlafen'), 'de'), array('schlaf'), '::stemWordsInArray() - [de] stemming works');

$t->is(rtIndexToolkit::stemWordsInArray(array('apples'), 'en'), array('appl'), '::stemWordsInArray() - [en] stemming works');
$t->is(rtIndexToolkit::stemWordsInArray(array('fishing'), 'en'), array('fish'), '::stemWordsInArray() - [en] stemming works');
$t->is(rtIndexToolkit::stemWordsInArray(array('translation'), 'en'), array('translat'), '::stemWordsInArray() - [en] stemming works');

$t->is(rtIndexToolkit::stemWordsInArray(array('manzanas'), 'es'), array('manzan'), '::stemWordsInArray() - [es] stemming works');
$t->is(rtIndexToolkit::stemWordsInArray(array('caminar'), 'es'), array('camin'), '::stemWordsInArray() - [es] stemming works');
$t->is(rtIndexToolkit::stemWordsInArray(array('manzanas'), 'es'), array('manzan'), '::stemWordsInArray() - [es] stemming works');

$t->is(rtIndexToolkit::stemWordsInArray(array('pommes'), 'fr'), array('pomm'), '::stemWordsInArray() - [fr] stemming works');
$t->is(rtIndexToolkit::stemWordsInArray(array('marche'), 'fr'), array('march'), '::stemWordsInArray() - [fr] stemming works');

$string = 'In linguistic morphology, stemming is the process for reducing inflected (or sometimes derived) words to their stem, base or root form ? generally a written word form.';
$string_as_array = array('linguist','morpholog','stem','process','reduc','inflect','sometim','deriv','word','stem','base','root','form','general','written','word','form');

$t->is(array_values(rtIndexToolkit::getStemmedWordsFromString($string, 'en')), $string_as_array, '::getStemmedWordsFromString() - [en] stemmed and cleaned words retrieved in array');

$string = 'Unter dem Begriff ?Deutsche Sprache? wird heute die auf der Grundlage von mitteldeutschen und oberdeutschen Mundarten entstandene deutsche Standardsprache (Standard-Hochdeutsch) verstanden sowie diejenigen Mundarten des kontinentalwestgermanischen Dialektkontinuums, die ganz oder teilweise von dieser überdacht werden.';
$string_as_array = array ('begriff','deutsch','sprach','heut','grundlag','mitteldeutsch','oberdeutsch','mundart','entstand','deutsch','standardsprach','standard','hochdeutsch','verstand','diejen','mundart','kontinentalwestgerman','dialektkontinuum','ganz','teilweis','uberdacht');

$t->is(array_values(rtIndexToolkit::getStemmedWordsFromString($string, 'de')), $string_as_array, '::getStemmedWordsFromString() - [de] stemmed and cleaned words retrieved in array');

