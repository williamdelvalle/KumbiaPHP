<?php
/**
 * KumbiaPHP web & app Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://wiki.kumbiaphp.com/Licencia
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@kumbiaphp.com so we can send you a copy immediately.
 *
 * Clase que contiene metodos utiles para manejar seguridad
 * 
 * @category   Kumbia
 * @package    security 
 * @copyright  Copyright (c) 2005-2012 Kumbia Team (http://www.kumbiaphp.com)
 * @license    http://wiki.kumbiaphp.com/Licencia     New BSD License
 */
session_register("rsa_key");
abstract class Security {

	public static function generateRSAKey($kumbia){
		$h = date("G")>12 ? 1 : 0;
		$time = uniqid().mktime($h, 0, 0, date("m"), date("d"), date("Y"));
		$key = sha1($time);
		$_SESSION['rsa_key'] = $key;
		$xCode = "<input type='hidden' id='rsa32_key' value='$key' />\r\n";
		if($kumbia) {
            echo $xCode;    
		} else { 
            return $xCode;
        }
		
		return null;
	}

	public static function createSecureRSAKey($kumbia=true){
		$config = Config::read('config');
		if($config->kumbia->secure_ajax){
			if($_SESSION['rsa_key']){
				if((time()%8)==0){
					return self::generateRSAKey($kumbia);
				} else {
					if($kumbia){
					    echo "<input type='hidden' id='rsa32_key' value=\"{$_SESSION['rsa_key']}\"/>";
					} else{
					    echo "<input type='hidden' id='rsa32_key' value=\"{$_SESSION['rsa_key']}\"/>";
					}
					    
				}
			} else {
				return self::generateRSAKey($kumbia);
			}
		}
		return null;
	}

}
