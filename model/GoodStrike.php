<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/22/18
     * Time: 8:21 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/AStrike.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/insert/InsertIncrementQuery.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/select/SelectQuery.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/DBValue.php");

    class GoodStrike extends AStrike {

        public function __construct($id, $striker, $description, $date) {
            parent::__construct($id, $striker, $description, $date);
        }

        /**
         * Creates a new strike authored by the given user with the given description.
         *
         * @param $user IUser the user authoring the strike.
         * @param $description string the description of the strike.
         * @return IStrike
         */
        public static function newStrike($user, $description) {
            $query = new InsertIncrementQuery("strike", "strike_id");
            $query->addParamAndValues("user_id", DBValue::nonStringValue($user->getUserId()));
            $query->addParamAndValues("description", DBValue::stringValue($description));
            $query->addParamAndValues("type", DBValue::stringValue("good"));
            DBQuerrier::defaultInsert($query);
            return new BadStrike($query->getPrimaryKeyValues()[0], $user, $description, null);
        }

        /**
         * Returns whether this strike is a bad strike.
         *
         * @return boolean whether this strike is a bad strike.
         */
        public static function isBad() {
            return false;
        }

        /**
         * Gets the type of the strike.
         *
         * @return string the type of the strike.
         */
        protected function getType() {
            return "good";
        }
    }