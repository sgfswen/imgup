<?php
/*
 * William Fleming
 * Imgup - Server Side
 * downvote.php
 * Allowed Methods: POST
 * Protected: Yes
 * Purpose: Process a downvote for a single image by an authenticated user
 * Depedencies: Zend\Config, Zend\HTTP, Firebase\JWT
 *
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

        $photoid = filter_input(INPUT_POST, 'photoid', FILTER_SANITIZE_STRING);
        
        $config = Factory::fromFile('config/config.php', true);
        $dsn = 'mysql:host=' . $config->get('database')->get('host') . ';dbname=' . $config->get('database')->get('name');
        $db = new PDO($dsn, $config->get('database')->get('user'), $config->get('database')->get('password'));
        // Check to see if the user is in the db for this photo
        $sql = "SELECT * FROM DOWNVOTES WHERE user=:user AND photo=:photo";
        $stmt= $db->prepare($sql);
        $stmt->bindValue(':user', $userid);
        $stmt->bindValue(':photo', $photoid);
        $stmt->execute();
        $rows = $stmt->rowCount();
        // User has already downvoted, send 400
        if ($rows>0) { 
          header('HTTP/1.0 400 Bad Request');
          header('Content-type: application/json');
          echo json_encode([
                'status'    => "failure",
                'message'   => "Already Upvoted"
          ]);

          exit;
        // User has not downvoted
        } else {
          // Insert Upvote into DOWNVOTES (for checking above)
          $sql = "INSERT INTO DOWNVOTES (user,photo) VALUES (:user, :photo)";
          $stmt= $db->prepare($sql);
          $stmt->bindValue(':user', $userid);
          $stmt->bindValue(':photo', $photoid);
          $stmt->execute();
        
          // Update Count For Photo
          $sql = "UPDATE UPLOADS SET down=down+1 WHERE id=:photoid";
          $stmt= $db->prepare($sql);
          $stmt->bindValue(':photoid', $photoid);
          $stmt->execute();
          $errorInfo = $stmt->errorInfo();

          header('Content-type: application/json');
          echo json_encode([
                'status'    => "success",
                'error'     => $errorInfo
          ]);
        }

    // Token Can't be Extracted   
    } else {
        header('HTTP/1.0 400 Bad Request');
    }
  // No auth token, send 400  
  } else {   
      header('HTTP/1.0 400 Bad Request');
  }

// If not post, send 405
} else {
    header('HTTP/1.0 405 Method Not Allowed');
}