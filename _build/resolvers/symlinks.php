<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/kinescopeTv/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/kinescopetv')) {
            $cache->deleteTree(
                $dev . 'assets/components/kinescopetv/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/kinescopetv/', $dev . 'assets/components/kinescopetv');
        }
        if (!is_link($dev . 'core/components/kinescopetv')) {
            $cache->deleteTree(
                $dev . 'core/components/kinescopetv/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/kinescopetv/', $dev . 'core/components/kinescopetv');
        }
    }
}

return true;