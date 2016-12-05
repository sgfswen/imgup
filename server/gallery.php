<?php
/*
 * William Fleming
 * Imgup - Server Side
 * gallery.php
 * Allowed Methods: GET
 * Protected: No
 * Purpose: Return the public gallery in JSON format.
 * Depedencies: Zend\Config, Zend\HTTP, Firebase\JWT
 *
*/ 

require_once('vendor/autoload.php');
use Zend\Config\Config;
use Zend\Config\Factory;
use Zend\Http\PhpEnvironment\Request;
use Firebase\JWT\JWT;

$request = new Request();
$config = Factory::fromFile('config/config.php', true);

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
      $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
     header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Headers: Authorizationn');
     exit;

  }
}



/*
 * Get all headers from the HTTP request
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $dsn = 'mysql:host=' . $config->get('database')->get('host') . ';dbname=' . $config->get('database')->get('name');
    $db = new PDO($dsn, $config->get('database')->get('user'), $config->get('database')->get('password'));
    $db = new PDO($dsn, 'wpf8741', 'Gcma5EB$');
    $filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
    $limit = 24 * (int) $page;

    /*
     * Check if the filter is for the new photos
    */ 
    if ($filter == "new"){
      /*
       * We will fetch user id and password fields for the given username
       */
      $sql = "SELECT * FROM UPLOADS ORDER BY id LIMIT $limit";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $rows = $stmt->rowCount();

      $images = array();
      if ($stmt->execute()) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $images[] = $row;
          }
      }
      $reversed = array_reverse($images);
      header('Content-type: application/json');
      echo json_encode([
          'img'    => $reversed,
          'filter' => $filter,
          'page'   => $page
      ]);
      exit;
    }

    if ($filter == "hot"){
      /*
       * We will fetch user id and password fields for the given username
       */
      $sql = "SELECT * FROM UPLOADS ORDER BY up LIMIT $limit";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $reversed = array_reverse($result);

      header('Content-type: application/json');
      echo json_encode([
          'img'    => $reversed,
          'filter' => $filter,
          'page'   => $page
      ]);
      exit;
    }

    if ($filter == "views"){
      /*
       * We will fetch user id and password fields for the given username
       */
      $sql = "SELECT * FROM UPLOADS ORDER BY views LIMIT $limit";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $reversed = array_reverse($result);

      header('Content-type: application/json');
      echo json_encode([
          'img'    => $reversed,
          'filter' => $filter,
          'page'   => $page
      ]);
      exit;
    }


            
} else {
    header('HTTP/1.0 405 Method Not Allowed');
}