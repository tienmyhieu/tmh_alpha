<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use lib\adapters\TmhEntityAdapter;
use lib\adapters\TmhHtmlEntityAdapter;
use lib\core\TmhDomain;
use lib\core\TmhEntity;
use lib\core\TmhJson;
use lib\core\TmhLocale;
use lib\core\TmhRoute;
use lib\core\TmhServer;
use lib\html\component\TmhHtmlComponentFactory;
use lib\html\TmhHtmlDocumentFactory;
use lib\html\TmhHtmlElementFactory;
use lib\html\TmhHtmlNodeFactory;
use lib\html\TmhHtmlNodeTransformer;
use lib\TmhAlpha;
use lib\transformers\TmhAncestorTransformer;
use lib\transformers\TmhHtmlEntityTransformer;
use lib\transformers\TmhMetadataTransformer;
use lib\transformers\TmhSiblingTransformer;
use lib\translators\TmhHtmlEntityTranslator;
use lib\translators\TmhRouteTranslator;
use lib\translators\TmhTranslatorFactory;

require_once('lib/TmhAlpha.php');
require_once('lib/adapters/TmhEntityAdapter.php');
require_once('lib/adapters/TmhHtmlEntityAdapter.php');

require_once('lib/core/TmhDomain.php');
require_once('lib/core/TmhEntity.php');
require_once('lib/core/TmhJson.php');
require_once('lib/core/TmhLocale.php');
require_once('lib/core/TmhRoute.php');
require_once('lib/core/TmhServer.php');

require_once('lib/html/TmhHtmlDocumentFactory.php');
require_once('lib/html/TmhHtmlElementFactory.php');
require_once('lib/html/TmhHtmlNodeFactory.php');
require_once('lib/html/TmhHtmlNodeTransformer.php');
require_once('lib/html/component/TmhHtmlComponent.php');
require_once('lib/html/component/TmhAncestorsHtmlComponent.php');
require_once('lib/html/component/TmhHtmlComponentFactory.php');
require_once('lib/html/component/TmhSiblingsHtmlComponent.php');
require_once('lib/html/component/TmhTitlesHtmlComponent.php');
require_once('lib/html/component/TmhTopicsHtmlComponent.php');

require_once('lib/transformers/TmhTransformer.php');
require_once('lib/transformers/TmhAncestorTransformer.php');
require_once('lib/transformers/TmhHtmlEntityTransformer.php');
require_once('lib/transformers/TmhMetadataTransformer.php');
require_once('lib/transformers/TmhSiblingTransformer.php');

require_once('lib/translators/TmhTranslator.php');
require_once('lib/translators/TmhTranslatorFactory.php');
require_once('lib/translators/TmhHtmlEntityTranslator.php');
require_once('lib/translators/TmhRouteTranslator.php');

//echo "<pre>";
$json = new TmhJson();
$server = new TmhServer();
$domain = new TmhDomain($json, $server);
$locale = new TmhLocale($domain, $json);
$route = new TmhRoute($locale, $json, $server);
$entity = new TmhEntity($json);
$entityAdapter = new TmhEntityAdapter($route, $entity);
$entity = $entityAdapter->find();
//print_r($entity);

$translatorFactory = new TmhTranslatorFactory($locale, $server);
$ancestorTransformer = new TmhAncestorTransformer($locale, $route);
$metadataTransformer =  new TmhMetadataTransformer($domain, $locale);
$siblingTransformer = new TmhSiblingTransformer($domain, $locale, $route);
$htmlEntityTransformer = new TmhHtmlEntityTransformer($ancestorTransformer, $metadataTransformer, $siblingTransformer);
$htmlEntityAdapter = new TmhHtmlEntityAdapter($entityAdapter, $htmlEntityTransformer, $translatorFactory);
$htmlEntity = $htmlEntityAdapter->get();
//print_r($htmlEntity);

$nodeFactory = new TmhHtmlNodeFactory();
$elementFactory = new TmhHtmlElementFactory($nodeFactory);
$componentFactory = new TmhHtmlComponentFactory($elementFactory);
$nodeTransformer = new TmhHtmlNodeTransformer();
$documentFactory = new TmhHtmlDocumentFactory($elementFactory, $componentFactory, $nodeTransformer);
$entityTranslator = new TmhHtmlEntityTranslator($locale, $route, $translatorFactory);
$alpha = new TmhAlpha($documentFactory, $htmlEntityAdapter, $entityTranslator);
//echo "</pre>";
echo $alpha->toHtml();
