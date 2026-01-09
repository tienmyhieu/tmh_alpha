<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use lib\core\TmhDatabase;
use lib\core\TmhDomain;
use lib\core\TmhEntity;
use lib\core\TmhHtmlEntity;
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
use lib\transformers\TmhAncestorsTransformer;
use lib\transformers\TmhMetadataTransformer;
use lib\transformers\TmhSiblingTransformer;
use lib\transformers\TmhTransformerFactory;
use lib\translators\TmhTranslatorFactory;

require_once('lib/TmhAlpha.php');

require_once('lib/core/TmhDatabase.php');
require_once('lib/core/TmhDomain.php');
require_once('lib/core/TmhEntity.php');
require_once('lib/core/TmhHtmlEntity.php');
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
require_once('lib/html/component/TmhEntityListHtmlComponent.php');
require_once('lib/html/component/TmhEntityListsHtmlComponent.php');
require_once('lib/html/component/TmhHtmlComponentFactory.php');
require_once('lib/html/component/TmhSiblingsHtmlComponent.php');
require_once('lib/html/component/TmhTitleHtmlComponent.php');
require_once('lib/html/component/TmhTopicHtmlComponent.php');

require_once('lib/transformers/TmhTransformer.php');
require_once('lib/transformers/TmhAncestorsTransformer.php');
require_once('lib/transformers/TmhEntityListItemTransformer.php');
require_once('lib/transformers/TmhEntityListsTransformer.php');
require_once('lib/transformers/TmhImageTransformer.php');
require_once('lib/transformers/TmhMetadataTransformer.php');
require_once('lib/transformers/TmhRouteTransformer.php');
require_once('lib/transformers/TmhSiblingTransformer.php');
require_once('lib/transformers/TmhTransformerFactory.php');

require_once('lib/translators/TmhTranslator.php');
require_once('lib/translators/TmhTranslatorFactory.php');
require_once('lib/translators/TmhAncestorsTranslator.php');
require_once('lib/translators/TmhEntityListItemTranslator.php');
require_once('lib/translators/TmhEntityListsTranslator.php');
require_once('lib/translators/TmhMetadataTranslator.php');
require_once('lib/translators/TmhRouteTranslator.php');
require_once('lib/translators/TmhTitleTranslator.php');
require_once('lib/translators/TmhTopicTranslator.php');

//echo "<pre>";
$json = new TmhJson();
$database = new TmhDatabase($json);
$server = new TmhServer();
$domain = new TmhDomain($json, $server);
$locale = new TmhLocale($domain, $json);
$route = new TmhRoute($locale, $json, $server);
$transformerFactory = new TmhTransformerFactory($database, $domain, $locale, $route, $server);
$entity = new TmhEntity($json, $route, $transformerFactory);
//$entityTmp = $entity->get();
//print_r($entityTmp);

$translatorFactory = new TmhTranslatorFactory($locale, $route, $server);
$ancestorTransformer = new TmhAncestorsTransformer($locale, $route);
$metadataTransformer =  new TmhMetadataTransformer($domain);
$siblingTransformer = new TmhSiblingTransformer($domain, $locale, $route);
$htmlEntity = new TmhHtmlEntity($entity, $transformerFactory, $translatorFactory);
//$htmlEntityTmp = $htmlEntity->get();
//print_r($htmlEntityTmp);

$nodeFactory = new TmhHtmlNodeFactory();
$elementFactory = new TmhHtmlElementFactory($nodeFactory, $server);
$componentFactory = new TmhHtmlComponentFactory($elementFactory);
$nodeTransformer = new TmhHtmlNodeTransformer();
$documentFactory = new TmhHtmlDocumentFactory($elementFactory, $componentFactory, $nodeTransformer);
$alpha = new TmhAlpha($documentFactory, $htmlEntity);
echo $alpha->toHtml();
//echo "</pre>";
