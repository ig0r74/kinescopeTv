<?php

class kinescopeTv
{
    /** @var modX $modx */
    public $modx;
    public $namespace = 'kinescopetv';


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/kinescopetv/';
        $assetsUrl = MODX_ASSETS_URL . 'components/kinescopetv/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('kinescopetv', $this->config['modelPath']);
        $this->modx->lexicon->load('kinescopetv:default');
        
        $token = $modx->getOption('kinescopetv_api_token');
        
        /* @var modRest $this->modRestClient */
        $this->modRestClient = $this->modx->getService('rest', 'rest.modRest');
        $this->modRestClient->setOption('baseUrl', 'https://api.kinescope.io/v1');
        $this->modRestClient->setOption('format', 'json');
        $this->modRestClient->setOption('suppressSuffix', true);
        $this->modRestClient->setOption('headers', [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ]);
    }
    
    public function getVideoUrl($video_id) {
        $response = $this->modRestClient->get('videos/' . $video_id);
        $data = $response->process();
        // $this->modx->log(1, print_r($data,1));
        
        if (isset($data['errorCode'])) {
            $this->modx->log(1, 'kinescopeTv getVideoUrl error: ' . print_r($data, 1));
            return '';
        } elseif (isset($data['data']['assets'][1]['url'])) {
            return [
                'status' => $data['data']['status'],
                'url' => $data['data']['assets'][1]['url']
            ];
        } elseif (isset($data['data']['status']) && $data['data']['status'] == 'processing') {
            return ['status' => 'processing'];
        } else {
            $this->modx->log(1, 'kinescopeTv error: url not found in response. Video id: ' . $video_id);
            return '';
        }
    }

}