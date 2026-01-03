<?php

use lib\adapters\TmhEntityAdapter;
use lib\adapters\TmhRouteAdapter;
use lib\adapters\TmhServerAdapter;
use lib\core\TmhDomain;
use lib\core\TmhEntity;
use lib\core\TmhJson;
use lib\core\TmhLocale;
use lib\core\TmhRoute;
use lib\transformers\TmhDomainTransformer;
use lib\transformers\TmhRouteTransformer;

require_once('lib/adapters/TmhEntityAdapter.php');
require_once('lib/adapters/TmhRouteAdapter.php');
require_once('lib/adapters/TmhServerAdapter.php');
require_once('lib/core/TmhDomain.php');
require_once('lib/core/TmhEntity.php');
require_once('lib/core/TmhJson.php');
require_once('lib/core/TmhLocale.php');
require_once('lib/core/TmhRoute.php');
require_once('lib/transformers/TmhDomainTransformer.php');
require_once('lib/transformers/TmhRouteTransformer.php');

$json = new TmhJson();
$serverAdapter = new TmhServerAdapter();
$domainTransformer = new TmhDomainTransformer($serverAdapter);
$domain = new TmhDomain($domainTransformer, $json, $serverAdapter);
$locale = new TmhLocale($domain, $json);
$routeTransformer = new TmhRouteTransformer($locale);
$route = new TmhRoute($routeTransformer, $json, $serverAdapter);
$routeAdapter = new TmhRouteAdapter($route);
$entity = new TmhEntity($json);
$entityAdapter = new TmhEntityAdapter($entity, $routeAdapter);
//echo "<pre>";
//print_r($entityAdapter->find());
//echo "</pre>";