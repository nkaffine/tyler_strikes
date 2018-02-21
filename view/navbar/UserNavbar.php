<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/navbar/ANavbar.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/navbar/PageListItem.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/navbar/LogoutButton.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/17/17
     * Time: 8:04 PM
     */
    class UserNavbar extends ANavbar {
        public function __construct($active) {
            $this->left = array();
            $active = strtolower($active);
            $this->left["home"] = new PageListItem("Home", "/");
            if ($active !== null) {
                if ($this->left[$active] !== null) {
                    $this->left[$active]->select();
                }
            }
            $this->right = array();
            $this->right["logout"] = new LogoutButton();
        }
    }