<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/21/18
     * Time: 1:10 AM
     */
    class LogoutButton implements INavbarItem {

        public function generateHtml() {
            return "<li id='logout'><a>Logout</a></li>";
        }
    }