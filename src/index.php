<?php

use lib\adapters\TmhEntityAdapter;
use lib\adapters\TmhHtmlEntityAdapter;
use lib\adapters\TmhRouteAdapter;
use lib\adapters\TmhServerAdapter;
use lib\core\TmhDomain;
use lib\core\TmhEntity;
use lib\core\TmhJson;
use lib\core\TmhLocale;
use lib\core\TmhRoute;
use lib\transformers\TmhDomainTransformer;
use lib\transformers\TmhHtmlEntityTransformer;
use lib\transformers\TmhRouteTransformer;
use lib\transformers\TmhSiblingTransformer;

require_once('lib/adapters/TmhEntityAdapter.php');
require_once('lib/adapters/TmhHtmlEntityAdapter.php');
require_once('lib/adapters/TmhRouteAdapter.php');
require_once('lib/adapters/TmhServerAdapter.php');
require_once('lib/core/TmhDomain.php');
require_once('lib/core/TmhEntity.php');
require_once('lib/core/TmhJson.php');
require_once('lib/core/TmhLocale.php');
require_once('lib/core/TmhRoute.php');
require_once('lib/transformers/TmhDomainTransformer.php');
require_once('lib/transformers/TmhHtmlEntityTransformer.php');
require_once('lib/transformers/TmhRouteTransformer.php');
require_once('lib/transformers/TmhSiblingTransformer.php');

$json = new TmhJson();
$serverAdapter = new TmhServerAdapter();
$domainTransformer = new TmhDomainTransformer($serverAdapter);
$domain = new TmhDomain($domainTransformer, $json, $serverAdapter);
$locale = new TmhLocale($domain, $json);
$routeTransformer = new TmhRouteTransformer($locale);
$route = new TmhRoute($routeTransformer, $json, $serverAdapter);
$routeAdapter = new TmhRouteAdapter($route);
$entity = new TmhEntity($json);
$entityAdapter = new TmhEntityAdapter($routeTransformer, $entity, $routeAdapter);

$siblingTransformer = new TmhSiblingTransformer($domain, $locale);
$htmlEntityTransformer = new TmhHtmlEntityTransformer($siblingTransformer);
$htmlEntityAdapter = new TmhHtmlEntityAdapter($entityAdapter, $htmlEntityTransformer);
echo "<pre>";
print_r($htmlEntityAdapter->get());
echo "</pre>";