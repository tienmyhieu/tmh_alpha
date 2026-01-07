<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use lib\adapters\TmhHtmlEntityAdapter;
use lib\core\TmhDatabase;
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
use lib\transformers\TmhTransformerFactory;
use lib\translators\TmhHtmlEntityTranslator;
use lib\translators\TmhTranslatorFactory;

require_once('lib/TmhAlpha.php');
require_once('lib/adapters/TmhHtmlEntityAdapter.php');

require_once('lib/core/TmhDatabase.php');
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
require_once('lib/transformers/TmhEntityListItemTransformer.php');
require_once('lib/transformers/TmhEntityListsTransformer.php');
require_once('lib/transformers/TmhImageTransformer.php');
require_once('lib/transformers/TmhHtmlEntityTransformer.php');
require_once('lib/transformers/TmhMetadataTransformer.php');
require_once('lib/transformers/TmhRouteTransformer.php');
require_once('lib/transformers/TmhSiblingTransformer.php');
require_once('lib/transformers/TmhTopicsTransformer.php');
require_once('lib/transformers/TmhTransformerFactory.php');

require_once('lib/translators/TmhTranslator.php');
require_once('lib/translators/TmhTranslatorFactory.php');
require_once('lib/translators/TmhHtmlEntityTranslator.php');
require_once('lib/translators/TmhRouteTranslator.php');

//echo "<pre>";
$json = new TmhJson();
$database = new TmhDatabase($json);
$server = new TmhServer();
$domain = new TmhDomain($json, $server);
$locale = new TmhLocale($domain, $json);
$route = new TmhRoute($locale, $json, $server);
$transformerFactory = new TmhTransformerFactory($database, $route, $server);
$entity = new TmhEntity($json, $route, $transformerFactory);
$entityTmp = $entity->get();
//print_r($entityTmp);

$translatorFactory = new TmhTranslatorFactory($locale, $server);
$ancestorTransformer = new TmhAncestorTransformer($locale, $route);
$metadataTransformer =  new TmhMetadataTransformer($domain, $locale);
$siblingTransformer = new TmhSiblingTransformer($domain, $locale, $route);
$htmlEntityTransformer = new TmhHtmlEntityTransformer($ancestorTransformer, $metadataTransformer, $siblingTransformer);
$htmlEntityAdapter = new TmhHtmlEntityAdapter($entity, $htmlEntityTransformer, $translatorFactory);
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
