<?php
if(!class_exists('KinescopeTvInputRender')) {
    class KinescopeTvInputRender extends modTemplateVarInputRender {
        public function getTemplate() {
            return $this->modx->getOption('core_path').'components/kinescopetv/tv/input/tpl/kinescopetv.tpl';
        }
        public function process($value,array $params = array()) {
        }
    }
}
return 'KinescopeTvInputRender';