<?php

use lib\adapters\TmhServerAdapter;
use lib\core\TmhDomain;
use lib\core\TmhJson;
use lib\transformers\TmhDomainTransformer;

require_once('lib/adapters/TmhServerAdapter.php');
require_once('lib/core/TmhDomain.php');
require_once('lib/core/TmhJson.php');
require_once('lib/transformers/TmhDomainTransformer.php');

$json = new TmhJson();
$serverAdapter = new TmhServerAdapter();
$domainTransformer = new TmhDomainTransformer($serverAdapter);
$domain = new TmhDomain($domainTransformer, $json, $serverAdapter);
//echo "<pre>";
//print_r($domain->domains());
//echo "</pre>";