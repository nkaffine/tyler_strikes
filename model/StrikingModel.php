<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/11/18
     * Time: 1:56 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/IStrikingModel.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/User.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/BadStrike.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/GoodStrike.php");

    class StrikingModel implements IStrikingModel {

        /**
         * Logs in a user to the system.
         *
         * @param $username string the username of the user.
         * @param $email string the email of the user.
         * @param $password string the password of the user.
         * @return void
         */
        public function login($username, $email, $password) {
            if ($password === null) {
                throw new InvalidArgumentException("Password cannot be null");
            }
            if ($username === null) {
                //Make sure that email is not null and then login with email
                if ($email === null) {
                    throw new InvalidArgumentException("Email and Username cannot both be null");
                } else {
                    //We know that email and password are not null
                    User::loginEmail($email, $password);
                }
            } else {
                //We know the username and password are not null.
                User::login($username, $password);
            }
        }

        /**
         * Creates a user in the system.
         *
         * @param $username string the username of the user.
         * @param $email string the email of the user.
         * @param $password string the password of the user.
         * @return void
         */
        public function signUp($username, $email, $password) {
            if ($username === null || $email === null || $password === null) {
                throw new InvalidArgumentException("Email, Username, and Password must not be null");
            }
            User::newUser($username, $password, $email);
        }

        /**
         * Gets a list of all the strikes in the system sorted by date.
         *
         * @return IStrike[] a list of strikes sorted by date.
         */
        public function getStrikes() {
            return GoodStrike::getAllStrikes();
        }

        /**
         * Gets all the strikes from a specific user in the system.
         *
         * @param $user IUser the user who gives the strikes.
         * @return array associative array with "good" and "bad" as the keys for the list of good and bad strikes.
         */
        public function getStrikesFromUser($user) {
            $strikes = array();
            $goodstrikes = GoodStrike::getStrikesByUser($user);
            $badstrikes = BadStrike::getStrikesByUser($user);
            $strikes["good"] = $goodstrikes;
            $strikes["bad"] = $badstrikes;
            return $strikes;
        }

        /**
         * Creates a new good strike in the system from the given user with the given description.
         *
         * @param $user IUser the user who gives the strike.
         * @param $description string the description of the strike.
         * @return IStrike the strike.
         */
        public function newGoodStrike($user, $description) {
            return GoodStrike::newStrike($user, $description);
        }

        /**
         * Creates a new bad strike in the system from the given user with the given description.
         *
         * @param $user IUser the user who gives the strike.
         * @param $description string the description of the strike.
         * @return IStrike the strike.
         */
        public function newBadStrike($user, $description) {
            return BadStrike::newStrike($user, $description);
        }

        /**
         * Logs the user out of the system.
         *
         * @return void
         */
        public function logout() {
            User::logout();
        }

        /**
         * Gets the total bad strikes minus the good strikes
         *
         * @return int the total strike status.
         */
        public function getStrikeStatus() {
            return GoodStrike::getStrikeStatus();
        }
    }