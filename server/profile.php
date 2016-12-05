<?php
/*
 * William Fleming
 * Imgup - Server Side
 * album.php
 * Allowed Methods: POST
 * Protected: Yes
 * Purpose: Process updates to the users profile
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
  $authHeader = $request->getHeader('authorization');
  /*
   *  Look for the 'authorization' header
   */
  if ($authHeader) {
    $authenticated = AuthCheck($authHeader); // Pass the auth header to auth checker function
    // If true, user is authenticated
    if ($authenticated){
        $token_array= (array) $authenticated; // Convert JWT object to Array
        $data = (array) $token_array["data"];  // Index in to the data and Convert to Array again
        $userid = $data["userId"];  // Index to the userId
        // Retrieve tagline and bio
        $tagline = filter_input(INPUT_POST, 'tagline', FILTER_SANITIZE_STRING);
        $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
        
        $config = Factory::fromFile('config/config.php', true);
        $dsn = 'mysql:host=' . $config->get('database')->get('host') . ';dbname=' . $config->get('database')->get('name');
        $db = new PDO($dsn, $config->get('database')->get('user'), $config->get('database')->get('password'));
        // Check to see if the user is in the db for this photo
        $sql = "UPDATE PROFILE SET tagline=:tagline,bio=:bio WHERE user=:user";
        $stmt= $db->prepare($sql);
        $stmt->bindValue(':tagline', $tagline);
        $stmt->bindValue(':bio', $bio);
        $stmt->bindValue(':user', $userid);
        $stmt->execute();
        $errorInfo = $stmt->errorInfo();
        header('Content-type: application/json');
        echo json_encode([
            'status'    => "success",
            'error'     => $errorInfo,
            'user'      => $userid,
            'tagline'   => $tagline,
            'bio'       => $bio
            ]);
         

    // Token Can't be Extracted   
    } else {
        header('HTTP/1.0 400 Bad Request');
        header('Content-type: application/json');
        echo json_encode([
              'status'    => "failure",
        ]);

    }
  // No auth token, send 400  
  } else {   
      header('HTTP/1.0 400 Bad Request');
      header('Content-type: application/json');
      echo json_encode([
              'status'    => "failure",
      ]);

  }

// If not post, send 405
} else {
    header('HTTP/1.0 405 Method Not Allowed');
    header('Content-type: application/json');
    echo json_encode([
              'status'    => "failure",
    ]);

}