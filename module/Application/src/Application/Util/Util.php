<?php
namespace Application\Util;

use Test\Data;
use Test\Util\Timer;
use Application\Exception;
class Util {
    
    protected static $writableDir;
    
    static function getWritableDir($name) {
    
    	if (isset(self::$writableDir[$name])) {
    		return self::$writableDir[$name];
    	}
    
    	$config = Data::getInstance()->get('config');
    	
    	if (!isset($config['writableDir'][$name])) {
    		throw new Exception('Writable Dir ' . $name . ' not found');
    	}
    
    	self::$writableDir[$name] = $config['writableDir']['base'] . $config['writableDir'][$name];
    	return self::$writableDir[$name];
    }
    
    
    
    /**
     * 替换内容中的变量
     *
     * @param string $str
     * @param array $variables
     * @return string
     */
    public static function replaceVariables($str, $variables = array()) {
    
    	// get all variables
    	preg_match_all('/\${(?P<key>[_\w]+)}/i', $str, $matches);
    
    	if (isset($matches['key'])) {
    		$keys = $matches['key'];
    
    		$len = count($keys);
    		for ($i=0; $i<$len; $i++) {
    			// clear unhandled variables
    			if (!isset($variables[$keys[$i]])) {
    				$variables[$keys[$i]] = '';
    			}
    			// replace variables
    			$str = str_ireplace('${' . $keys[$i] . '}', $variables[$keys[$i]], $str);
    		}
    	}
    
    	return $str;
    }
    
    
    static function formatString($string) {
    	return str_replace('"', '', $string);
    }
    
    
}