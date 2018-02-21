<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/navbar/INavbar.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/17/17
     * Time: 8:07 PM
     */
    abstract class ANavbar implements INavbar {
        /**
         * @var INavbarItem[]
         */
        protected $left;
        /**
         * @var INavbarItem[]
         */
        protected $right;

        /**
         * Generates the html for the navbar.
         *
         * @return string the html formatted navbar.
         */
        public function generateNavbar() {
            $html = "<nav class=\"navbar navbar-inverse\"><div class=\"container-fluid\"><div class=\"navbar-header\">";
            $html .= "<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>" .
                "<span class='icon-bar'></span>" .
                "<span class='icon-bar'></span>" .
                "<span class='icon-bar'></span>" .
                "</button>";
            $html .= $this->getHeader();
            $html .= "</div><div class='collapse navbar-collapse' id='myNavbar'><ul class=\"nav navbar-nav\">";
            $html .= $this->getLeftList();
            $html .= "</ul><ul class=\"nav navbar-nav navbar-right\">";
            $html .= $this->getRightList();
            $html .= "</ul></div></div></nav>";
            return $html;
        }

        /**
         * Gets the navbar header for the navbar.
         *
         * @return string the header for the navbar.
         */
        protected function getHeader() {
            return "<a class=\"navbar-brand\" href=\"/\">Tyler's Strike System</a>";
        }

        /**
         * Gets the list of pages for the header.
         *
         * @return string the list of pages for the navbar.
         */
        protected function getLeftList() {
            $html = "";
            foreach ($this->left as &$page) {
                $html .= $page->generateHtml();
            }
            return $html;
        }

        /**
         * Gets the list of right elements for the header.
         *
         * @return string the list of right elements for the navbar.
         */
        protected function getRightList() {
            if ($this->right === null) {
                return "";
            } else {
                $html = "";
                foreach ($this->right as $right) {
                    $html .= $right->generateHtml();
                }
                return $html;
            }
        }
    }