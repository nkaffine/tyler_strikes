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
         * @return IStrike
         */
        public static function getStrikeById();

        /**
         * Creates a new strike authored by the given user with the given description.
         *
         * @param $user IUser the user authoring the strike.
         * @param $description string the description of the strike.
         * @param $type int whether the strike was good or bad.
         * @return IStrike
         */
        public static function newStrike($user, $description, $type);

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

    }