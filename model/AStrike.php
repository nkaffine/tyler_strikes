<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/22/18
     * Time: 8:21 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/select/SelectQuery.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/where/Where.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/db/DBQuerrier.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/IStrike.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/groupBy/GroupBy.php");

    abstract class AStrike implements IStrike {
        protected $id;
        protected $striker;
        protected $description;
        protected $date;

        /**
         * AStrike constructor.
         *
         * @param $id int the id of the strike.
         * @param $striker IUser the user issuing the strike.
         * @param $description string the description of the strike.
         * @param $date string the date that the strike was placed.
         */
        protected function __construct($id, $striker, $description, $date) {
            if ($id === null) {
                throw new InvalidArgumentException("strike id cannot be null");
            }
            $this->id = $id;
            $this->striker = $striker;
            $this->description = $description;
            $this->date = $date;
        }

        /**
         * Gets the strike with the given id.
         *
         * @param $id int the id of the strike.
         * @return IStrike
         */
        public static function getStrikeById($id) {
            $query = new SelectQuery("strike", "type", "user_id", "description", "date");
            $query->where(Where::whereEqualValue("strike_id", DBValue::nonStringValue($id)));
            $result = DBQuerrier::queryUniqueValue($query);
            $row = @ mysqli_fetch_array($result);
            if ($row['type'] == "good") {
                return new GoodStrike($id, User::getUserById($row['user_id']), $row['description'], $row["date"]);
            } else {
                return new BadStrike($id, User::getUserById($row['user_id']), $result['description'], $row['date']);
            }
        }

        /**
         * Gets the date of this strike.
         *
         * @return string the date of this strike.
         */
        public function getStrikeDate() {
            if ($this->date === null) {
                $this->initialize();
            }
            return $this->date;
        }

        /**
         * Gets the user who authored this strike.
         *
         * @return IUser the user who authored this strike.
         */
        public function getStriker() {
            if ($this->striker === null) {
                $this->initialize();
            }
            return $this->striker;
        }

        /**
         * Gets the description of this strike.
         *
         * @return string the description of this strike.
         */
        public function getDescription() {
            if ($this->description === null) {
                $this->initialize();
            }
            return $this->description;
        }

        /**
         * Gets the id of this strike.
         *
         * @return int id of this strike.
         */
        public function getStrikeId() {
            return $this->id;
        }

        /**
         * Gets all of the strikes of the strike type in the system.
         *
         * @return IStrike[]
         */
        public static function getStrikes() {
            $query = new SelectQuery("strike", "strike_id", "user_id", "description", "date");
            $query->where(Where::whereEqualValue("type", DBValue::stringValue(self::getStrikeType())));
            $result = DBQuerrier::defaultQuery($query);
            $strikes = array();
            while ($row = @ mysqli_fetch_array($result)) {
                if (self::isBad()) {
                    array_push($strikes,
                        new BadStrike($row['strike_id'], User::getUserById($row['user_id']), $row['description'],
                            $row['date']));
                } else {
                    array_push($strikes,
                        new GoodStrike($row['strike_id'], User::getUserById($row['user_id']), $row['description'],
                            $row['date']));
                }
            }
            return $strikes;
        }

        /**
         * Gets all of the strikes of the strike type in the system from the given user.
         *
         * @param $user IUser the user who gives the strikes.
         * @return IStrike[]
         */
        public static function getStrikesByUser($user) {
            $query = new SelectQuery("strike", "strike_id", "description", "date");
            $query->where(Where::whereEqualValue("type", DBValue::stringValue(self::getStrikeType())));
            $query->where(Where::whereEqualValue("user_id", DBValue::nonStringValue($user->getUserId())));
            $results = DBQuerrier::defaultQuery($query);
            $strikes = array();
            while ($row = @ mysqli_fetch_array($results)) {
                if (self::isBad()) {
                    array_push($strikes, new BadStrike($row['strike_id'], $user, $row['description'], $row['date']));
                } else {
                    array_push($strikes, new GoodStrike($row['strike_id'], $user, $row['description'], $row['date']));
                }
            }
            return $strikes;
        }

        /**
         * Gets a list of all the strikes sorted by date
         *
         * @return IStrike[];
         */
        public static function getAllStrikes() {
            $query = new SelectQuery("strike", "strike_id", "user_id", "description", "date", "type");
            $query->order(OrderStatement::orderDesc("date"));
            $result = DBQuerrier::defaultQuery($query);
            $strikes = array();
            while ($row = @ mysqli_fetch_array($result)) {
                if ($row['type'] === "bad") {
                    array_push($strikes,
                        new BadStrike($row['strike_id'], User::getUserById($row['user_id']), $row['description'],
                            $row['date']));
                } else {
                    array_push($strikes,
                        new GoodStrike($row['strike_id'], User::getUserById($row['user_id']), $row['description'],
                            $row['date']));
                }
            }
            return $strikes;
        }

        /**
         * Gets the JSON representation of this strike.
         *
         * @return array the JSON formatted string of this strike.
         */
        public function getJSON() {
            $json_strike = array();
            $json_strike['strike_id'] = $this->id;
            $json_strike['striker'] = $this->striker->getJSON();
            $json_strike['description'] = $this->description;
            $json_strike['date'] = $this->date;
            $json_strike['type'] = $this->getType();
            return $json_strike;
        }

        /**
         * Gets the total bad strikes less the good strikes.
         *
         * @return int the current strike status.
         */
        public static function getStrikeStatus() {
            $query = new SelectQuery("strike", "COUNT(*) total");
            $query->groupBy(GroupBy::groupBy()->addParameter("type"));
            $result = DBQuerrier::defaultQuery($query);
            $good = @mysqli_fetch_array($result);
            $bad = @mysqli_fetch_array($result);
            return $bad['total'] - $good['total'];
        }

        /**
         * Gets the type of strike that this strike is.
         */
        private static function getStrikeType() {
            if (self::isBad()) {
                return "bad";
            } else {
                return "good";
            }
        }

        /**
         * Gets the type of the strike.
         *
         * @return string the type of the strike.
         */
        protected abstract function getType();

        /**
         * Initializes all of the fields in this strike.
         *
         * @return void.
         */
        private function initialize() {
            $query = new SelectQuery("strike", "user_id", "description", "date");
            $query->where(Where::whereEqualValue("strike_id", DBValue::nonStringValue($this->id)));
            $result = DBQuerrier::queryUniqueValue($query);
            $row = @ mysqli_fetch_array($result);
            $this->striker = User::getUserById($row['user_id']);
            $this->description = $row['description'];
            $this->date = $row['date'];
        }
    }