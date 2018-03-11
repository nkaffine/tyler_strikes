<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/11/18
     * Time: 4:06 PM
     */
    class NewStrike {
        /**
         * Displays the box for adding the new strike.
         *
         * @return string the html for displaying the box for a new string.
         */
        public static function displayBox() {
            $html = "<div class='col-xs-12'>";
            $html .= "<div class=\"form-group col-xs-12 no-pad\"><label for=\"newStrike\">New Strike:</label><textarea class=\"form-control\" " .
                "rows=\"5\" id=\"newStrike\"></textarea></div>";
            $html .= "<button class='btn btn-success col-xs-6' id='goodStrike'>Good Strike</button>";
            $html .= "<button class='btn btn-danger col-xs-6' id='badStrike'>Bad Strike</button>";
            $html .= "</div>";
            return $html;
        }
    }