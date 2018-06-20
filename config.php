<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

//error_reporting(-1);
/* 
 * Database configuration and connection
*/

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ob_start();
session_start();

// Create a connection.
  $DB = null;
  if (isset($_SERVER['SERVER_SOFTWARE']) &&
  strpos($_SERVER['SERVER_SOFTWARE'],'Google App Engine') !== false) {
    // Connect from App Engine.
    try{
       $DB = new pdo('mysql:unix_socket=/cloudsql/motivatestudy-967:db; dbname=motivate', 'root', '');
    }catch(PDOException $ex){
        die(json_encode(
            array('outcome' => false, 'message' => 'Unable to connect.')
            )
        );
    }
  } else {
    // Connect from a development environment.
    try{
       $DB = new pdo('mysql:host=localhost; dbname=motivate', 'root', 'root');
    }catch(PDOException $ex){
        die(json_encode(
            array('outcome' => false, 'message' => 'Unable to connect')
            )
        );
    }
  }
 
//get error/success messages
if ($_SESSION["errorType"] != "" && $_SESSION["errorMsg"] != "" ) {
    $ERROR_TYPE = $_SESSION["errorType"];
    $ERROR_MSG = $_SESSION["errorMsg"];
    $_SESSION["errorType"] = "";
    $_SESSION["errorMsg"] = "";
}

/* 
 * Session verification. If no session value page redirect to login.php
 */

$mode = $_REQUEST["mode"];
if ($mode == "login") {

    $username = trim($_POST['username']);
    $pass = trim($_POST['user_password']);

    if ($username == "" || $pass == "") {

        $_SESSION["errorType"] = "danger";
        $_SESSION["errorMsg"] = "Enter manadatory fields";
    } else {
        $sql = "SELECT * FROM system_users WHERE u_username = :uname AND u_password = :upass ";

        try {
            $stmt = $DB->prepare($sql);

            // bind the values
            $stmt->bindValue(":uname", $username);
            $stmt->bindValue(":upass", md5($pass));

            // execute Query
            $stmt->execute();
            $results = $stmt->fetchAll();

            if (count($results) > 0) {
                $_SESSION["errorType"] = "success";
                $_SESSION["errorMsg"] = "You have successfully logged in.";

                $_SESSION["user_id"] = $results[0]["u_userid"];
                $_SESSION["rolecode"] = $results[0]["u_rolecode"];
                $_SESSION["username"] = $results[0]["u_username"];
                $_SESSION["name"] = $results[0]["u_name"];
                $_SESSION['timeout'] = time();
                header("Location:dashboard.php");
                exit;
            } else {
                $_SESSION["errorType"] = "info";
                $_SESSION["errorMsg"] = "username or password does not exist.";
            }
        } catch (Exception $ex) {

            $_SESSION["errorType"] = "danger";
            $_SESSION["errorMsg"] = $ex->getMessage();
        }
        echo $_SESSION["errorType"];
        echo "<br />";
        echo $_SESSION["errorMsg"];
    }
                header("Location:/");
    ob_end_flush();
    
}
