<?php

require_once(dirname(__DIR__,3) ."/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__,3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use OldFriends\ {
	User
};

/**
 * API for User
 *
 * @author Korigan Payne <koriganp@gmail.com>
 * version 1.0
 *
 **/

//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/old-friends.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
	$username = filter_input(INPUT_GET, "username", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for the methods that require it by content
	if($method === "GET") {
		//set XRSF cookie
		setXsrfCookie();

		if(empty($id) === false) {
			$user = User::getUserByUserId($pdo, $id);
			if($user !== null) {
				$reply->data = $user;
			}
		} else if(empty($username) === false) {
			$user = User::getUserByUsername($pdo, $username);
			if($user !== null) {
				$reply->data = $user;
			}
		} else if(empty($userEmail) === false) {
			$user = User::getUserByUserEmail($pdo, $userEmail);
			if($user !== null) {
				$reply->data = $user;
			}
		}
	} else if ($method === "PUT") {
		//enforce that the XSRF token is in the header
		verifyXsrf();

		//enforce the end user has JWT token
		ValidateJWTHeader();

		//enforce the user is signed in and only trying and only trying to edit their profile
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this user", 403));
		}

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the user to be updated
		$user = User::getUserByUserId($pdo, $id);
		if($user === null) {
			throw(new \RuntimeException("User does not exist", 404));
		}

		//username
		if(empty($requestObject->username) === true) {
			throw(new \InvalidArgumentException("No username present", 405));
		}

		$user->setUsername($requestObject->profileUsername);
		$user->setUserEmail($requestObject->profileEmail);
		$user->update($pdo);

		// update reply
		$reply->message = "User information updated";

	} else if ($method === "DELETE") {

		//Verify XRSF token
		verifyXsrf();

		//enforce the end user has a JWT token
		validateJwtHeader();

		$user = User::getUserByUserId($pdo, $id);
		if($user === null) {
			throw (new \RuntimeException("User does not exist"));
		}
		//enforce the user is signed in and only trying to edit their own information
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $user->getUserId()) {
			throw(new \InvalidArgumentException("You are not allowed to access this user information", 403));
		}

		//delete the post from the database
		$user->delete($pdo);
		$reply->message = "User Deleted";

	} else {
		throw (new \InvalidArgumentException(("Invalid HTTP request"), 400));
	}
} catch (\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);