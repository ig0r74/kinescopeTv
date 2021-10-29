<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

// $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

// if (!$isAjax) @session_write_close(); exit;

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('mgr');

$id = htmlspecialchars($_GET['id']);

if (!$id) return '';

$modelPath = MODX_CORE_PATH . 'components/kinescopetv/model/';

if(!$kinescopeTv = $modx->getService('kinescopetv','kinescopeTv',$modelPath)) {
    $modx->log(1, 'Service kinescopetv not found');
}

$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->getService('error','error.modError');


print json_encode($kinescopeTv->getVideoUrl($id));

@session_write_close(); exit();