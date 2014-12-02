<?php

use \Gettext\Extractors\Po as PoExtractor;
use \Gettext\Generators\PhpArray as PhpArrayGenerator;
use \Gettext\Translator;

preg_match('~^\/([a-z]{2}).*~', $_SERVER['REQUEST_URI'], $matches);

if (file_exists(SYS_PATH . "l10n/{$matches[1]}/{$matches[1]}.po"))
	$translations = PoExtractor::extract(SYS_PATH . "l10n/{$matches[1]}/{$matches[1]}.po");
else {
	$translations = new \Gettext\Entries;
	$translations->setDomain($matches[1]);
	$translations->setLanguage($matches[1]);
}

PhpArrayGenerator::generateFile($translations, SYS_PATH . 'l10n/locate.php');

$t = new Translator();
$t->loadTranslations(SYS_PATH . 'l10n/locate.php');
__currentTranslator($t);
