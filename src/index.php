<?php

use lib\adapters\TmhServerAdapter;
use lib\core\TmhDomain;
use lib\core\TmhJson;
use lib\core\TmhLocale;
use lib\transformers\TmhDomainTransformer;

require_once('lib/adapters/TmhServerAdapter.php');
require_once('lib/core/TmhDomain.php');
require_once('lib/core/TmhJson.php');
require_once('lib/core/TmhLocale.php');
require_once('lib/transformers/TmhDomainTransformer.php');

$json = new TmhJson();
$serverAdapter = new TmhServerAdapter();
$domainTransformer = new TmhDomainTransformer($serverAdapter);
$domain = new TmhDomain($domainTransformer, $json, $serverAdapter);
$locale = new TmhLocale($domain, $json);
//echo "<pre>";
//print_r($locale->locales());
//echo "</pre>";