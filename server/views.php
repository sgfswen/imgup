<?php
/*
 * William Fleming
 * Imgup - Server Side
 * views.php
 * Allowed Methods: POST
 * Protected: No
 * Purpose: Process a view count for when pictures in the gallery are clicked on.
 * Depedencies: Zend\Config, Zend\HTTP, Firebase\JWT
*/ 
require_once('vendor/autoload.php');
require_once('auth_check.php');
use Zend\Config\Config;
use Zend\Config\Factory;
use Zend\Http\PhpEnvironment\Request;
use Firebase\JWT\JWT;


$request = new Request();

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  // return only the headers and not the content
  // only allow CORS if we're doing a GET - i.e. no saving for now.
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) &&
      $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST') {
     header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Headers: Authorizationn');
     exit;

  }
}

/*
 * Check if POST
 */
if ($request->isPost()) {
      $config = Factory::fromFile('config/config.php', true);
      $dsn = 'mysql:host=' . $config->get('database')->get('host') . ';dbname=' . $config->get('database')->get('name');
      $db = new PDO($dsn, $config->get('database')->get('user'), $config->get('database')->get('password'));
      $photoid = filter_input(INPUT_POST, 'photoid', FILTER_SANITIZE_STRING);
      // Update Count For Photo
      $sql = "UPDATE UPLOADS SET views=views+1 WHERE id=:photoid";
      $stmt= $db->prepare($sql);
      $stmt->bindValue(':photoid', $photoid);
      $stmt->execute();
      $errorInfo = $stmt->errorInfo();

      header('Content-type: application/json');
      echo json_encode([
            'status'    => "success",
            'error'     => $errorInfo
      ]);
    

// If not POST, send 405
} else {
    header('HTTP/1.0 405 Method Not Allowed');
}