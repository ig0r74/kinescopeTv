<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var kinescopeTv $kinescopeTv */
$kinescopeTv = $modx->getService('kinescopeTv', 'kinescopeTv', MODX_CORE_PATH . 'components/kinescopetv/model/');
$modx->lexicon->load('kinescopetv:default');

// handle request
$corePath = $modx->getOption('kinescopetv_core_path', null, $modx->getOption('core_path') . 'components/kinescopetv/');
$path = $modx->getOption('processorsPath', $kinescopeTv->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);