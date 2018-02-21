<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/navbar/INavbarItem.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/17/17
     * Time: 8:21 PM
     */
    class PageListItem implements INavbarItem {
        private $title;
        private $link;
        private $isSelected;

        /**
         * PageListItem constructor.
         *
         * @param $title string the title of the page.
         * @param $link string the link to the page.
         */
        public function __construct($title, $link) {
            if ($title == null || $link == null) {
                throw new InvalidArgumentException("Title and Link cannot be null");
            }
            $this->title = $title;
            $this->link = $link;
            $this->isSelected = false;
        }

        public function select() {
            $this->isSelected = true;
        }

        public function generateHtml() {
            $html = "<li";
            if ($this->isSelected) {
                $html .= " class='active'";
            }
            return $html . "><a href=\"{$this->link}\">{$this->title}</a></li>";
        }
    }