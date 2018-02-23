<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/select/SelectQuery.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/where/Where.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/DBValue.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/db/DBQuerrier.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/insert/InsertIncrementQuery.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/IUser.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/exceptions/UserNotLoggedInException.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/exceptions/InvalidLoginCredentialsException.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/18/18
     * Time: 7:40 PM
     */
    class User implements IUser {
        private $id;
        private $username;
        private $email;

        /**
         * User constructor.
         *
         * @param $id int the user_id of the user
         * @param $username string the username of the user.
         * @param $email string the email of the user.
         */
        private function __construct($id, $username, $email) {
            if ($id === null) {
                throw new InvalidArgumentException("Id cannot be null");
            }
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
        }

        /**
         * Uses the cookie in the browser to determine who the user is and returns the user.
         *
         * @return IUser
         * @throws UserNotLoggedInException
         */
        public static function loginWithCookie() {
            if (isset($_COOKIE['user_id'])) {
                $user_id = $_COOKIE["user_id"];
            } else {
                throw new UserNotLoggedInException("user not logged in");
            }
            return new User($user_id, null, null);
        }

        /**
         * Returns the user with the given username and password.
         *
         * @param $username string the username of the user.
         * @param $password string the password of the user.
         * @return IUser
         * @throws InvalidLoginCredentialsException
         */
        public static function login($username, $password) {
            $query = new SelectQuery("user", "email", "user_id");
            $password = md5($password);
            $query->where(Where::whereEqualValue("username", DBValue::stringValue($username)));
            $query->where(Where::whereEqualValue("password", DBValue::stringValue($password)));
            try {
                $results = DBQuerrier::queryUniqueValue($query);
            } catch (SQLNoSuchValueException $exception) {
                throw new InvalidLoginCredentialsException("Credentials supplied were invalid");
            }
            $row = @ mysqli_fetch_array($results);
            $user = new User($row['user_id'], $username, $row['email']);
            $user->setCookie();
            return $user;
        }

        /**
         * Returns the user with the given email and password.
         *
         * @param $email string the email of the user.
         * @param $password string the password of the user.
         * @return IUser
         * @throws InvalidLoginCredentialsException
         */
        public static function loginEmail($email, $password) {
            $query = new SelectQuery("user", "username", "user_id");
            $password = md5($password);
            $query->where(Where::whereEqualValue("email", DBValue::stringValue($email)));
            $query->where(Where::whereEqualValue("password", DBValue::stringValue($password)));
            try {
                $results = DBQuerrier::queryUniqueValue($query);
            } catch (SQLNonUniqueValueException $exception) {
                throw new InvalidLoginCredentialsException("Credentials supplied were invalid");
            }
            $row = @ mysqli_fetch_array($results);
            $user = new User($row['user_id'], $row['username'], $email);
            $user->setCookie();
            return $user;
        }

        /**
         * Returns the user with the given id.
         *
         * @param $id int the user_id of the desired user.
         * @return IUser
         */
        public static function getUserById($id) {
            $query = new SelectQuery("user", "username", "email");
            $query->where(Where::whereEqualValue("user_id", DBValue::nonStringValue($id)));
            $result = DBQuerrier::queryUniqueValue($query);
            $row = @ mysqli_fetch_array($result);
            $user = new User($id, $row['username'], $row['email']);
            $user->setCookie();
            return $user;
        }

        /**
         * Creates a new user with the given credentials.
         *
         * @param $username string the username for the new user.
         * @param $password string the password for the new user.
         * @param $email string the email of the user.
         * @return IUser
         */
        public static function newUser($username, $password, $email) {
            $password = md5($password);
            $query = new InsertIncrementQuery("user", "user_id");
            $query->addParamAndValues("username", DBValue::stringValue($username));
            $query->addParamAndValues("email", DBValue::stringValue($email));
            $query->addParamAndValues("password", DBValue::stringValue($password));
            DBQuerrier::defaultInsert($query);
            $user_id = $query->getPrimaryKeyValues()[0];
            $user = new User($user_id, $username, $email);
            $user->setCookie();
            return $user;
        }

        /**
         * Creates a new strike authored by this user.
         *
         * @param $description string the description of the strike
         * @return IStrike
         */
        public function addStrike($description) {
            // TODO: Implement addStrike() method.
        }

        /**
         * Gets the email of this user.
         *
         * @return string the email of this user.
         */
        public function getEmail() {
            if ($this->email === null) {
                $this->initialize();
            }
            return $this->email;
        }

        /**
         * Gets the username of this user.
         *
         * @return string the username of this user.
         */
        public function getUsername() {
            if ($this->username === null) {
                $this->initialize();
            }
            return $this->username;
        }

        /**
         * Initializes all of teh fields in this user.
         *
         * @return void.
         */
        private function initialize() {
            $query = new SelectQuery("user", "username", "email");
            $query->where(Where::whereEqualValue("user_id", DBValue::nonStringValue($this->id)));
            $result = DBQuerrier::queryUniqueValue($query);
            $row = mysqli_fetch_array($result);
            $this->email = $row['email'];
            $this->username = $row['username'];
        }

        /**
         * Sets the cookie for this user's session
         *
         * @return void
         */
        private function setCookie() {
            setcookie("user_id", $this->id, time() + (7 * 24 * 60 * 60), "/");
        }

        /**
         * Logs the user out of the system.
         *
         * @return void
         */
        public static function logout() {
            try {
                self::loginWithCookie();
                setcookie("user_id", 0, time() - (24 * 60 * 60), "/");
            } catch (UserNotLoggedInException $exception) {
             //Do nothing
            }
        }
    }