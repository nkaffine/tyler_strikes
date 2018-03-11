<?php

    /**
     * Created by PhpStorm.
     * IUser: Nick
     * Date: 2/18/18
     * Time: 3:40 PM
     */

    /**
     * Interface representing a strike against tyler.
     */
    interface IStrike {
        /**
         * Gets the strike with the given id.
         *
         * @param $id int the id of the strike.
         * @return IStrike
         */
        public static function getStrikeById($id);

        /**
         * Creates a new strike authored by the given user with the given description.
         *
         * @param $user IUser the user authoring the strike.
         * @param $description string the description of the strike.
         * @return IStrike
         */
        public static function newStrike($user, $description);

        /**
         * Gets the date of this strike.
         *
         * @return string the date of this strike.
         */
        public function getStrikeDate();

        /**
         * Gets the user who authored this strike.
         *
         * @return IUser the user who authored this strike.
         */
        public function getStriker();

        /**
         * Gets the description of this strike.
         *
         * @return string the description of this strike.
         */
        public function getDescription();

        /**
         * Returns whether this strike is a bad strike.
         *
         * @return boolean whether this strike is a bad strike.
         */
        public static function isBad();

        /**
         * Gets the id of this strike.
         *
         * @return int id of this strike.
         */
        public function getStrikeId();

        /**
         * Gets all of the strikes of the strike type in the system.
         *
         * @return IStrike[]
         */
        public static function getStrikes();

        /**
         * Gets all of the strikes of the strike type in the system from the given user.
         *
         * @param $user IUser the user who gives the strikes.
         * @return IStrike[]
         */
        public static function getStrikesByUser($user);

        /**
         * Gets a list of all the strikes sorted by date
         *
         * @return IStrike[];
         */
        public static function getAllStrikes();

        /**
         * Gets the JSON representation of this strike.
         *
         * @return array the JSON formatted string of this strike.
         */
        public function getJSON();

        /**
         * Gets the total bad strikes less the good strikes.
         *
         * @return int the current strike status.
         */
        public static function getStrikeStatus();

    }