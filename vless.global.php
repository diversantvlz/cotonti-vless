<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once 'lesssc/lessc.inc.php';
require_once cot_incfile('cache');

class vLess extends Resources {


    public static function fire(){

        if(!isset(static::$registry['less']['files'])){
            return;
        }

        global $cache, $cfg;
        $force = ($cfg['debug_mode'])? cot_import('vlessforce', 'G', 'BOL'): false;

        $arrLess = static::$registry['less']['files'];

        $lessc = new lessc();

        if(!$cfg['debug_mode']){
            $lessc->setFormatter('compressed');
        }

        if($cache){
            $cacheForce = $cache;
        }else{
            $cacheForce = new Cache();
            $cacheForce->disk = new File_cache($cfg['cache_dir']);
        }

        foreach($arrLess as $scope_name => $scope){
            foreach($scope as $order_num => $order){
                foreach($order as $file){
                    $cache_id = pathinfo($file)['filename'];
                    $out = preg_replace('/less$/', 'css', $file);

                    $in = $file;
                    if($cacheForce && $cacheForce->disk->exists($cache_id, 'vless') && file_exists($out)){
                        $in = $cacheForce->disk->get($cache_id, 'vless');
                    }

                    $data = $lessc->cexecute($in, $force, $lessc);

                    if(is_string($in) || ($in['updated'] !== $data['updated'])){
                        $cacheForce->disk->store($cache_id, $data, 'vless');
                        file_put_contents($out, $data['compiled']);
                    }

                    self::addFile($out, 'css', $order_num, $scope_name);
                }
            }
        }

        unset(static::$registry['less']);
    }

}

vLess::fire();