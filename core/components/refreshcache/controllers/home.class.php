<?php

/**
 * Created by PhpStorm.
 * User: BobRay
 * Date: 12/23/2018
 * Time: 12:12 AM
 */

if (! defined('MODX_CORE_PATH')) {

}

class refreshcacheHomeManagerController extends modExtraManagerController {
    public function getPageTitle() {
        return 'RefreshCache';
    }

    public function getLanguageTopics() {
        return array('refreshcache:default');
    }

    public function initialize() {
        $this->modx->lexicon->load('refreshcache:default');
    }

    public function normalize($paths) {
        if (is_array($paths)) {
            foreach ($paths as $k => $v) {
                $v = str_replace('\\', '/', $v);
                $paths[$k] = $v;
            }
        } else {
            $paths = str_replace('\\', '/', $paths);
        }
        return $paths;
    }

    /**
     * Gets Component Assets URL based on assets_path
     * field of namespace
     * @param $namespace
     * @return string
     */
    public function getComponentAssetsUrl($namespace) {
        $obj = $this->modx->getObject('modNamespace', array('name' => $namespace));
        $nsAssetsPath = $obj->get('assets_path');
        // $nsAssetsPath = '{assets_path}' . 'components/refreshcache/';
        $nsAssetsPath = $this->normalize(str_replace('{assets_path}', MODX_ASSETS_PATH, $nsAssetsPath));
        $nsAssetsPath = str_replace($this->normalize(dirname(MODX_BASE_PATH)), '', $nsAssetsPath);
        $base = $this->normalize(dirname(MODX_ASSETS_URL)) . '/';
        $short = str_replace($base, '', $this->normalize(MODX_SITE_URL));
        return $short . $nsAssetsPath;
    }
    public function loadCustomCssJs() {
        $namespace = 'refreshcache';
        $assetsUrl = $this->getComponentAssetsUrl('refreshcache');
        $this->addJavascript('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
        $this->addJavascript($assetsUrl . 'js/refreshcache.js');
    }


    public function process(array $scriptProperties = array()) {
        $buttonText = $this->modx->lexicon('rc_button_message');
        $output = '<div class="container">
    <h2  class="modx-page-header">RefreshCache</h2>
 
    <div class="x-panel-body shadowbox">
        <div class="panel-desc">Refreshed Resources</div>
        <div class="x-panel main-wrapper">
 
 
        <!-- <form action="#" id="refreshcache_form" method="post">-->
            <fieldset id="refreshcache_fieldset" style="padding: 0 30px 70px 30px;">
                <br class="clear"/>
 
                <br class="clear">
 
 
                <div class="refreshcache_submit">
                    <input style="padding:5px;margin-bottom:20px;" type="submit" id="refreshcache_submit" name="refreshcache_submit" value="' . $buttonText . '"/>
                </div>
                <div id="refreshcache_results">
                    <div class="refresh_cache_inner"></div>
                </div>
            </fieldset>
        <!--  </form>-->
        </div>
        </div>
</div>';

        return $output;

    }
}