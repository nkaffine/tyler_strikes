<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/page/APage.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/navbar/UserNavbar.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/page/Page.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/24/17
     * Time: 6:55 PM
     */
    class StandardUserPage extends APage {
        public function __construct($title) {
            parent::__construct($title);
        }

        /**
         * Initializes page with default body information
         */
        protected function initializeHtmlBody() {
            $navbar = new UserNavbar($this->title);
            $this->addJSFile("/scripts/logout.js");
            $this->addJSFile("/scripts/error.js");
            $this->addJSFile("/scripts/newStrike.js");
            $this->addJSFile("/scripts/displayStrikes.js");
            $this->addJSFile("/scripts/timeFormatting.js");
            $this->addToHead("<link rel=\"apple-touch-icon\" href=\"/images/aniovalicon.jpg\">", Page::BOTTOM);
            $this->addToBody($navbar->generateNavbar(), Page::TOP);
        }
    }