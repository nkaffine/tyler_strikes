<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/18/18
     * Time: 3:43 PM
     */

    /**
     * Interface IStrikingModel representing the model for the Tyler strike system.
     */
    interface IStrikingModel {
        /**
         * Logs in a user to the system.
         *
         * @param $username string the username of the user.
         * @param $email string the email of the user.
         * @param $password string the password of the user.
         * @return void
         */
        public function login($username, $email, $password);

        /**
         * Creates a user in the system.
         *
         * @param $username string the username of the user.
         * @param $email string the email of the user.
         * @param $password string the password of the user.
         * @return void
         */
        public function signUp($username, $email, $password);


        /**
         * Logs the user out of the system.
         *
         * @return void
         */
        public function logout();

        /**
         * Gets a list of all the strikes in the system, split up by good and bad.
         *
         * @return IStrike[] list of all strikes sorted by date.
         */
        public function getStrikes();

        /**
         * Gets all the strikes from a specific user in the system.
         *
         * @param $user IUser the user who gives the strikes.
         * @return array associative array with "good" and "bad" as the keys for the list of good and bad strikes.
         */
        public function getStrikesFromUser($user);

        /**
         * Creates a new good strike in the system from the given user with the given description.
         *
         * @param $user IUser the user who gives the strike.
         * @param $description string the description of the strike.
         * @return IStrike the strike.
         */
        public function newGoodStrike($user, $description);

        /**
         * Creates a new bad strike in the system from the given user with the given description.
         *
         * @param $user IUser the user who gives the strike.
         * @param $description string the description of the strike.
         * @return IStrike the strike.
         */
        public function newBadStrike($user, $description);

        /**
         * Gets the total bad strikes minus the good strikes
         *
         * @return int the total strike status.
         */
        public function getStrikeStatus();
    }