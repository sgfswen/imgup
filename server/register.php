<?php
/*
 * William Fleming
 * Imgup - Server Side
 * register.php
 * Allowed Methods: POST
 * Protected: No
 * Purpose: Process the signup form
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
      $config = Factory::fromFile('config/config.php', true);
      $dsn = 'mysql:host=' . $config->get('database')->get('host') . ';dbname=' . $config->get('database')->get('name');
      $db = new PDO($dsn, $config->get('database')->get('user'), $config->get('database')->get('password'));
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
      
      // Double check the username
      $sql = "SELECT * FROM USERS WHERE username=:username";
      $stmt= $db->prepare($sql);
      $stmt->bindValue(':username', $username);
      $stmt->execute();
      $rows = $stmt->rowCount();
      if ($rows > 0){
        header('HTTP/1.0 400 Bad Request');
        header('Content-type: application/json');
        echo json_encode([
            'status'    => "Failure",
            'error'     => $errorInfo[2]
        ]);
        exit;
      } else {
        // Insert New User
        $sql = "INSERT INTO USERS (username, password, isAdmin) VALUES (:username, :password, :admin)";
        $stmt= $db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $stmt->bindValue(':admin', 0);
        $stmt->execute();
        $errorInfo = $stmt->errorInfo();

        // Get the new user
        $sql = "SELECT id FROM USERS WHERE username=:username";
        $stmt= $db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $errorInfo = $stmt->errorInfo();
        $result = $stmt->fetch();

        // Create the new user's default profile
        $sql = "INSERT INTO PROFILE (user,tagline,bio,location,age) VALUES (:user, :tagline, :bio, :location, :age)";
        $stmt= $db->prepare($sql);
        $stmt->bindValue(':user', $result['id']);
        $stmt->bindValue(':tagline', "Tagline");
        $stmt->bindValue(':bio', "Bio");
        $stmt->bindValue(':location', "Location");
        $stmt->bindValue(':age', 0);
        $stmt->execute();
        $errorInfo = $stmt->errorInfo();
        header('Content-type: application/json');
        echo json_encode([
              'status'    => "success",
              'error'     => $errorInfo
        ]);




      }

// If not POST, send 405
} else {
    header('HTTP/1.0 405 Method Not Allowed');
}