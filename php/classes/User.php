<?php
/**
 * User Class for Old-Friends
 *
 * This class is User entity that stores website users
 *
 * @author Korigan Payne <koriganp@gmail.com>
 * @version 1.0.0
 **/

namespace OldFriends;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use InvalidArgumentException;

//use PhpParser\Node\Expr\Empty_;

use Ramsey\Uuid\Uuid;
class User implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this user, this is a primary key
	 * @var Uuid $userId
	 *
	 **/
	private $userId;
	/**
	 * this creates the activation token
	 * @var $userActivationToken
	 **/
	private $userActivationToken;
	/**
	 * this creates the user name
	 * @var $username
	 **/
	private $username;
	/**
	 * this is the email address for user
	 * @var $userEmail
	 **/
	private $userEmail;
	/**
	 * this is the hash for user password
	 * @var $userHash
	 **/
	private $userHash;
	/**
	 * this is the salt for user password
	 * @var $userSalt
	 **/
	private $userSalt;
	/**
	 * constructor for this user
	 * @param string|Uuid $newUserId id of this User or null if a new User
	 * @param string $newUserActivationToken activation token to safe guard against malicious accounts
	 * @param string $newUserEmail string containing email
	 * @param string $newUserHash string containing password hash
	 * @param string $newUserSalt string containing password salt
	 * @param  $newUsername
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws  \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throw \Exception if some other exception occurs
	 **/
	public function  __construct(string $newUserId, ?string $newUserActivationToken, string $newUsername, string $newUserEmail, string $newUserHash, string $newUserSalt) {
		try {
			$this->setUserId($newUserId);
			$this->setUserActivationToken($newUserActivationToken);
			$this->setUsername($newUsername);
			$this->setUserEmail($newUserEmail);
			$this->setUserHash($newUserHash);
			$this->setUserSalt($newUserSalt);

		} catch( \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for User id
	 *
	 * @return Uuid value of User id
	 **/
	public function getProfileId() : Uuid {
		return($this->userId);
	}

	/**
	 * mutator method for User id
	 *
	 * @param Uuid/string $newUserId new value of User id
	 * @throws \RangeException if $newUserId is not positive
	 * @throws \TypeError if $newUserId is not a uuid or string
	 **/
	public function setUserId($newUserId) : void {
		try {
			$uuid = self::validateUuid($newUserId);
		} catch(InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the User id
		$this->userId = $uuid;
	}
	/**
	 * accessor method for activation token
	 * @return string | null value of the activation token
	 **/
	public function getUserActivationToken(): ?string {
		return ($this->userActivationToken);
	}
	/**
	 *mutator method for account activation token
	 *
	 * @param string $newUserActivationToken
	 * @throws InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 **/
	public function setUserActivationToken(?string $newUserActivationToken): void {
		if($newUserActivationToken === null) {
			$this->userActivationToken = null;
			return;
		}
		$newUserActivationToken = strtolower(trim($newUserActivationToken));
		if(ctype_xdigit($newUserActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newUserActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->userActivationToken = $newUserActivationToken;
	}
	/**
	 * accessor method for username
	 *
	 * @return string value of username
	 */
	public function getUsername():string {
		return $this->username;
	}

	/**
	 * mutator method for username
	 *
	 * @param
	 **/
	public function setUsername($newUsername): void {
		$newUsername = trim($newUsername);
		$newUsername = filter_var($newUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUsername) === true) {
			throw(new InvalidArgumentException("Username is empty of insecure"));
		}
		//verify the profile content will fit in database
		if(strlen($newUsername) > 32) {
			throw(new \RangeException(("Username is too large")));
		}
		//store the username
		$this->username= $newUsername;
	}
	/**
	 * accessor method for userEmail
	 *
	 * @return string value of email
	 **/
	public function getUserEmail(): string {
		return $this->userEmail;
	}
	/**
	 * mutator for userEmail
	 *
	 * @param string $newUserEmail new value of email
	 * @throws InvalidArgumentException if $newUserEmail is not a valid email or insecure
	 * @throws \RangeException if $newUserEmail is > 128 characters
	 * @throws \TypeError if $newUserEmail is not a string
	 **/
	public function setUserEmail(string $newUserEmail): void {
		// verify the email is secure
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_VALIDATE_EMAIL);
		if( empty($newUserEmail) === true) {
			throw(new \PDOException("user email is empty or insecure"));
		}
		// verify the email will fit in the database
		if( strlen($newUserEmail) > 128) {
			throw(new \RangeException("user email is too large"));
		}
		// store the email
		$this->userEmail = $newUserEmail;
	}
	/**
	 * accessor method for userHash
	 *
	 * @return string value of hash
	 **/
	public function getUserHash(): string {
		return $this->userHash;
	}
	/**
	 * mutator method for userHash
	 *
	 * @param string $newUserHash
	 * @throws InvalidArgumentException if the $newUserHash is not secure
	 * @throws \RangeException if the $newUserHash is not 128 characters
	 * @throws \TypeError if $newUserHash is not a string
	 **/
	public function setUserHash($newUserHash): void {
		//enforce that the hash is properly formatted
		$newUserHash = trim($newUserHash);
		$newUserHash = strtolower($newUserHash);
		if( empty($newUserHash) === true) {
			throw(new InvalidArgumentException("User password hash empty or insecure"));
		}
		//enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newUserHash)) {
			throw(new InvalidArgumentException("User password hash is empty or insecure"));
		}
		//enforce that the hash is exactly 128 characters.
		if( strlen($newUserHash) !== 128) {
			throw(new \RangeException("User hash must be 128 characters"));
		}
		//store the hash
		$this->userHash = $newUserHash;
	}
	/**
	 * accessor method for userSalt
	 *
	 * @return string representation of the salt hexadecimal
	 **/
	public function getUserSalt(): string {
		return $this->userSalt;
	}
	/**
	 * mutator method for userSalt
	 *
	 * @param string $newUserSalt
	 * @throws InvalidArgumentException if the salt is not secure
	 * @throws \RangeException if the salt is not 64 characters
	 * @throws \TypeError if the salt is not a string
	 **/
	public function setUserSalt($newUserSalt): void {
		//enforce that the salt is properly formatted
		$newUserSalt = trim($newUserSalt);
		$newUserSalt = strtolower($newUserSalt);
		//enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newUserSalt)) {
			throw(new InvalidArgumentException("User password salt is empty or insecure"));
		}
		//enforce that the salt is exactly 64 characters.
		if( strlen($newUserSalt) !== 64) {
			throw(new \RangeException("User salt must be 64 characters"));
		}
		//store the salt
		$this->userSalt = $newUserSalt;
	}


	/**
	 * inserts this User into mySQl
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQl related errors occur
	 *
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO user(UserId, UserActivationToken, UserName, UserEmail, UserHash, UserSalt) VALUES(:userId, :userActivationToken, :username, :userEmail, :userHash, :userSalt)";
		$statement = $pdo->prepare($query);
		$parameters = [ "userId" => $this->userId-> getBytes(), "userActivationToken" => $this->userActivationToken, "username" => $this->username, "userEmail" => $this->userEmail, "userHash" => $this->userHash, "userSalt" => $this->userSalt];
		$statement->execute($parameters);
	}
	/**
	 * deletes this user from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place in the template
		$parameters = ["userId"=> $this->userId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this user in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// crate query template
		$query = "UPDATE user SET userActivationToken = :userActivationToken, username = :username, userEmail = :userEmail, userHash = :userHash, userSalt = :userSalt WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in template
		$parameters = [ "userId" => $this->userId->getBytes(), "userActivationToken" => $this->userActivationToken, "username" => $this->username, "userEmail" => $this->userEmail, "userHash" => $this->userHash, "userSalt" => $this->userSalt];
		$statement->execute($parameters);
	}

	/**
	 * gets the User by userId
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $userId user Id to search for
	 * @return User|null User or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getUserByUserId(\PDO $pdo, string $userId):?User {
		// sanitize the user id before searching
		try {
			$userId = self::validateUuid($userId);
		} catch(InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT userId, userActivationToken, username, userEmail, userHash, userSalt FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);
		// bind the user id to the place holder in the template
		$parameters = ["userId" => $userId->getBytes()];
		$statement->execute($parameters);
		// grab the user from mySQL
		try {
			$user = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new User($row["userId"],  $row["userActivationToken"], $row["username"],$row["userEmail"], $row["userHash"], $row["userSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($user);
	}
	/**
	 * gets the User by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $userEmail email to search for
	 * @return User|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getUserByUserEmail(\PDO $pdo, string $userEmail): ?User {
		// sanitize the email before searching
		$userEmail = trim($userEmail);
		$userEmail = filter_var($userEmail, FILTER_VALIDATE_EMAIL);
		if(empty($userEmail) === true) {
			throw(new \PDOException("not a valid email"));
		}
		// create query template
		$query = "SELECT userId, userActivationToken, username, userEmail, userHash, userSalt FROM user WHERE userEmail = :userEmail";
		$statement = $pdo->prepare($query);
		// bind the user id to the place holder in the template
		$parameters = ["userEmail" => $userEmail];
		$statement->execute($parameters);
		// grab the User from mySQL
		try {
			$user = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new User($row["userId"], $row["userActivationToken"], $row["username"],$row["userEmail"], $row["userHash"], $row["userSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($user);
	}

	/**
	 * gets the User by username
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $username to search for
	 * @return \SPLFixedArray of all users found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getUserByUsername(\PDO $pdo, string $username) : \SPLFixedArray {
		// sanitize the Username before searching
		$username = trim($username);
		$username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if( empty($username) === true) {
			throw(new \PDOException("not a valid Username"));
		}
		// create query template
		$query = "SELECT  userId, userActivationToken, username, userEmail, userHash, userSalt  FROM user WHERE username = :username";
		$statement = $pdo->prepare($query);
		// bind the profile Username to the place holder in the template
		$parameters = ["username" => $username];
		$statement->execute($parameters);
		$users = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while (($row = $statement->fetch()) !== false) {
			try {
				$user = new User($row["userId"], $row["userActivationToken"],  $row["username"], $row["userEmail"], $row["userHash"], $row["userSalt"]);
				$users[$users->key()] = $user;
				$users->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($users);
	}

	/**
	 * get the user by user activation token
	 *
	 * @param string $userActivationToken
	 * @param \PDO object $pdo
	 * @return User|null User or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public
	static function getUserByUserActivationToken(\PDO $pdo, string $userActivationToken) : ?User {
		//make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$userActivationToken = trim($userActivationToken);
		if( ctype_xdigit($userActivationToken) === false) {
			throw(new InvalidArgumentException("user activation token is empty or in the wrong format"));
		}
		//create the query template
		$query = "SELECT  userId, userActivationToken, username, userEmail, userHash, userSalt FROM user WHERE userActivationToken = :userActivationToken";
		$statement = $pdo->prepare($query);
		// bind the profile activation token to the placeholder in the template
		$parameters = ["userActivationToken" => $userActivationToken];
		$statement->execute($parameters);
		// grab the User from mySQL
		try {
			$user = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new User($row["userId"], $row["userActivationToken"],$row["username"], $row["userEmail"], $row["userHash"], $row["userSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($user);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["userId"] = $this->userId->toString();
		unset($fields["userHash"]);
		unset($fields["userSalt"]);
		return ($fields);
	}
}
