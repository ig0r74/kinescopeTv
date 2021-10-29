<?php
/** @var modX $modx */
$corePath = $modx->getOption('core_path',null,MODX_CORE_PATH).'components/kinescopetv/';
$assetsUrl = $modx->getOption('assets_url',null,MODX_CORE_PATH);
switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath.'tv/input/');
        break;
    case 'OnDocFormRender':
        $modx->regClientStartupScript($assetsUrl . 'components/kinescopetv/js/mgr/api.js?v=0.1.1');
        $modx->regClientStartupScript($assetsUrl . 'components/kinescopetv/js/mgr/default.js?v=0.1.1');
        $modx->regClientCSS($assetsUrl . 'components/kinescopetv/css/mgr/main.css?v=0.1.1');
        break;
}