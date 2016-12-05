<?php
/*
 * William Fleming
 * Imgup - Server Side
 * album.php
 * Allowed Methods: POST
 * Protected: Yes
 * Purpose: Process an uploaded file, and store it in AWS, then store the link in the database.
 * Depedencies: Zend\Config, Zend\HTTP, Firebase\JWT, Aws\S3, Monolog
*/ 
require_once('vendor/autoload.php');
include('validation.php'); // getExtension Method

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Zend\Config\Factory;
use Zend\Http\PhpEnvironment\Request;
use Firebase\JWT\JWT;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('logs.log', Logger::WARNING));

$config = Factory::fromFile('config/config.php', true);


$request = new Request();

// Instantiate the S3 client with your AWS credentials
$client = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => 'us-east-2',
    'credentials' => [
        'key'    => $config->get('aws')->get('key'),
        'secret' => $config->get('aws')->get('secret')
    ]
]);



// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  // return only the headers and not the content
  // only allow CORS if we're doing a GET - i.e. no saving for now.
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
     header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Headers: Authorizationn');
     exit;

  }
}



/*
 * Get all headers from the HTTP request
 */
if ($request->isPost()) {
    $authHeader = $request->getHeader('authorization');
    $responseMessage = "";
    /*
     * Look for the 'authorization' header
     */
    if ($authHeader) {
        /*
         * Extract the jwt from the Bearer
         */
        list($jwt) = sscanf( $authHeader->toString(), 'Authorization: Bearer %s');
        if ($jwt) {
            try {
                /*
                 * decode the jwt using the key from config
                 */
                $secretKey = base64_decode($config->get('jwt')->get('key'));
                // If this breaks, then catch is called and returns 401
                $token = JWT::decode($jwt, $secretKey, [$config->get('jwt')->get('algorithm')]);
                // Get the users info
   				$token_array= (array) $token; // Convert JWT object to Array
    			$data = (array) $token_array["data"];  // Index in to the data and Convert to Array again
    			$id = $data["userId"];  // Index to the userId
                /* At this point, the user is authenticated, continue with the upload process */
				$message='';
				// Get all the file info
				$name = $_FILES['file']['name'];
				$size = $_FILES['file']['size'];
				$tmp = $_FILES['file']['tmp_name'];
				$ext = getExtension($name);
			 
				if(strlen($name) > 0) {
					// File format validation
					if(in_array($ext,$valid_formats)) {
						// File size validation
						if($size<(1024*1024)){
							//Rename image name.
							$image_name_actual = time().".".$ext;
					 
					 		try {
					 			//Use the client to store the object
					        	$client->putObject(array(
					    			'Bucket' => 'wfpublic',
					    			'Key' =>  $image_name_actual,
			             			'SourceFile' => $tmp,
			             			'StorageClass' => 'REDUCED_REDUNDANCY'
					        	));
               				
							$s3file='http://'.'wfpublic'.'.s3.amazonaws.com/'.$image_name_actual;
                			$dsn = 'mysql:host=' . $config->get('database')->get('host') . ';dbname=' . $config->get('database')->get('name');
                            $db = new PDO($dsn, $config->get('database')->get('user'), $config->get('database')->get('password'));
            			    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
            				/*
             	 			* We will fetch user id and password fields for the given username
             				*/
            				$sql = "INSERT INTO UPLOADS (uploader, source, title, up,down,reports,views) VALUES (:uploader,:source,:title,:up,:down,:reports,:views)";
    						$stmt= $db->prepare($sql);
    						$stmt->bindValue(':uploader', $id);
    						$stmt->bindValue(':source', $s3file);
    						$stmt->bindValue(':title', $title);
                            $stmt->bindValue(':up', 0);
                            $stmt->bindValue(':down', 0);
                            $stmt->bindValue(':reports', 0);
                            $stmt->bindValue(':views', 0);

            				$stmt->execute();

							header('Content-type: application/json');
               				echo json_encode([
                                'status' => "success",
                    			'img'    => $s3file
                			]);
					 
						    } catch (S3Exception $e) {
						         // Catch an S3 specific exception.
						        $error = $e->getMessage();
						        $log->error($error);
						        header('Content-type: application/json');
						        echo json_decode([
						        	"error" => $error
						        ]);
						    }
						} else {
							$log->warning('ERROR - Image size Max 1 Mb');
					        header('Content-type: application/json');
					        echo json_decode([
						        	"error" => "Image size Max 1 MB"
						        ]);
					        
						}
					} else { 
						$log->warning('ERROR - Invalid file, please upload image file.');
						header('Content-type: application/json');
						echo json_decode([
						        	"error" => "Invalid file, please upload image file."
						        ]);
			 		}
				
				} else {
					$log->warning('ERROR - Please select image file.');
					header('Content-type: application/json');
					echo json_decode([
						        	"error" => "Please select image file."
						        ]);
				}
				

            } catch (Exception $e) {
                /*
                 * the token was not able to be decoded.
                 * this is likely because the signature was not able to be verified (tampered token)
                 */
                header('HTTP/1.0 401 Unauthorized');
 				echo json_decode([
				   "error" => $responseMessage
			    ]);            
 			}
        } else {
            /*
             * No token was able to be extracted from the authorization header
             */
            header('HTTP/1.0 400 Bad Request');
            echo json_decode([
				   "error" => $responseMessage
			    ]);
        }
    } else {
        /*
         * The request lacks the authorization token
         */
        header('HTTP/1.0 400 Bad Request');
		echo json_decode([
			"error" => "Token Not Found"
		]); 
	}
} else {
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_decode([
				   "error" => "Method not allowed"
	]);
}

