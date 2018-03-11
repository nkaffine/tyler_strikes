<?php

    /**
     * Created by PhpStorm.
     * IUser: Nick
     * Date: 2/18/18
     * Time: 3:40 PM
     */

    /**
     * Interface representing a user
     */
    interface IUser {
        /**
         * Uses the cookie in the browser to determine who the user is and returns the user.
         *
         * @return IUser
         * @throws UserNotLoggedInException
         */
        public static function loginWithCookie();

        /**
         * Returns the user with the given username and password.
         *
         * @param $username string the username of the user.
         * @param $password string the password of the user.
         * @return IUser
         * @throws InvalidLoginCredentialsException
         */
        public static function login($username, $password);

        /**
         * Returns the user with the given email and password.
         *
         * @param $email string the email of the user.
         * @param $password string the password of the user.
         * @return IUser
         * @throws InvalidLoginCredentialsException
         */
        public static function loginEmail($email, $password);

        /**
         * Returns the user with the given id.
         *
         * @param $id int the user_id of the desired user.
         * @return IUser
         */
        public static function getUserById($id);

        /**
         * Creates a new user with the given credentials.
         *
         * @param $username string the username for the new user.
         * @param $password string the password for the new user.
         * @param $email string the email of the user.
         * @return IUser
         */
        public static function newUser($username, $password, $email);

        /**
         * Creates a new strike authored by this user.
         *
         * @param $description string the description of the strike
         * @return IStrike
         */
        public function addStrike($description);

        /**
         * Gets the email of this user.
         *
         * @return string the email of this user.
         */
        public function getEmail();

        /**
         * Gets the username of this user.
         *
         * @return string the username of this user.
         */
        public function getUsername();

        /**
         * Logs the user out of the system if they are logged in.
         *
         * @return void
         */
        public static function logout();

        /**
         * Gets the user id of this user.
         *
         * @return int the user id of this user.
         */
        public function getUserId();

        /**
         * Gets the formatted JSON for this user.
         *
         * @return array the formatted JSON for this user.
         */
        public function getJSON();
    }