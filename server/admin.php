<?php
/*
 * William Fleming
 * Imgup - Server Side
 * admin.php
 * Allowed Methods: GET, POST
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

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) &&
      $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
     header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Headers: Authorizationn');
     exit;
  }
}

/*
 * Check if GET
 */
if ($request->isGet()) {
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
        
        $config = Factory::fromFile('config/config.php', true);
        $dsn = 'mysql:host=' . $config->get('database')->get('host') . ';dbname=' . $config->get('database')->get('name');
        $db = new PDO($dsn, $config->get('database')->get('user'), $config->get('database')->get('password'));

        $sql = "SELECT * FROM USERS";
        $stmt= $db->prepare($sql);
        $stmt->execute();
        $users= $stmt->fetchAll();
        $errorInfo = $stmt->errorInfo();

        $sql = "SELECT * FROM UPLOADS";
        $stmt= $db->prepare($sql);
        $stmt->execute();
        $uploads = $stmt->fetchAll();
        $errorInfo = $stmt->errorInfo();

        $sql = "SELECT * FROM UPLOADS where reports > 0";
        $stmt= $db->prepare($sql);
        $stmt->execute();
        $reports = $stmt->fetchAll();
        $errorInfo = $stmt->errorInfo();

        header('Content-type: application/json');
        echo json_encode([
            'status'    => "success",
            'error'     => $errorInfo,
            'users'     => $users,
            'uploads'   => $uploads,
            'reports'   => $reports
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
} else if ($request->isPost()) {
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
          
          $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
          $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
          $config = Factory::fromFile('config/config.php', true);
          $dsn = 'mysql:host=' . $config->get('database')->get('host') . ';dbname=' . $config->get('database')->get('name');
          $db = new PDO($dsn, $config->get('database')->get('user'), $config->get('database')->get('password'));

          $sql = "SELECT * FROM USERS WHERE id=:userid and username=:username";
          $stmt= $db->prepare($sql);
          $stmt->bindValue(':userid', $userid);
          $stmt->bindValue(':username', $username);
          $stmt->execute();
          $rows= $stmt->rowCount();
          // If there is a result, the requested user exists
          if ($rows > 0){
            $sql = "DELETE FROM USERS WHERE username=:username";
            $stmt= $db->prepare($sql);
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            $sql = "DELETE FROM PROFILE WHERE user=:userid";
            $stmt= $db->prepare($sql);
            $stmt->bindValue(':userid', (int) $userid);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            $sql = "DELETE FROM UPLOADS WHERE uploader=:userid";
            $stmt= $db->prepare($sql);
            $stmt->bindValue(':userid', (int) $userid);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            $sql = "DELETE FROM UPVOTES WHERE user=:userid";
            $stmt= $db->prepare($sql);
            $stmt->bindValue(':userid', (int) $userid);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            $sql = "DELETE FROM DOWNVOTES WHERE user=:userid";
            $stmt= $db->prepare($sql);
            $stmt->bindValue(':userid', (int) $userid);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            header('Content-type: application/json');
            echo json_encode([
              'status'    => "success",
              'error'     => $errorInfo
              ]);

          } else {
            header('HTTP/1.0 400 Bad Request');
            header('Content-type: application/json');
            echo json_encode([
                'status'    => "failure",
                'error'    => $errorInfo
          ]);

        }  

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


} else {
    header('HTTP/1.0 405 Method Not Allowed');
    header('Content-type: application/json');
    echo json_encode([
              'status'    => "failure",
    ]);
} 