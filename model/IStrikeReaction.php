<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/11/18
     * Time: 7:37 PM
     */
    interface IStrikeReaction {
        /**
         * Creates a new reaction for the given user, strike and reaction.
         *
         * @param $user IUser the user who is reacting.
         * @param $strike IStrike the strike being reacted to.
         * @param $reaction string the emoji reaction to the strike.
         * @return mixed
         */
        public static function newStrikeReaction($user, $strike, $reaction);

        public function getUser();

        public function getStrike();

        public function getReaction();

        public function getReactionsForStrike($strike);
    }