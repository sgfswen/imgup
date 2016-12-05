<?php
/*
 * William Fleming
 * Imgup - Server Side
 * auth_check.php
 * Purpose: Process a login header, and return the token if successful.
 * Depedencies: Zend\Config, Firebase\JWT
*/ 


require_once('vendor/autoload.php');
use Zend\Config\Config;
use Zend\Config\Factory;
use Firebase\JWT\JWT;


/*
 * Check if a requrest is authenticated. 
 * If so, return the token in array format.
 * If not, return false.
 * @param header - Authorization Header
*/ 
function AuthCheck($header){
	/*
     * Extract the jwt from the Bearer
     */
    list($jwt) = sscanf( $header->toString(), 'Authorization: Bearer %s');
    if ($jwt) {
      
   		$config = Factory::fromFile('config/config.php', true);
        /*
         * decode the jwt using the key from config
         */
        $secretKey = base64_decode($config->get('jwt')->get('key'));
        // If this breaks, then catch is called and returns 401
        $token = JWT::decode($jwt, $secretKey, [$config->get('jwt')->get('algorithm')]);
        // Get the users info
	    $token_array= (array) $token; // Convert JWT object to Array
	    return $token_array;

    // JWT not extracted from header
	} else {
		return false;
	}	    
	
}