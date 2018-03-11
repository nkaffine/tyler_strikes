<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/18/18
     * Time: 8:04 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/page/StandardUserPage.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/exceptions/UserNotLoggedInException.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/User.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/strikes/NewStrike.php");
    try {
        $user = User::loginWithCookie();
        $page = new StandardUserPage("home");
        $page->addToBody("<div id='error' class='col-xs-12'></div>", Page::BOTTOM);
        $page->addToBody("<div id='strikeStatus' class='col-xs-12'></div>", Page::BOTTOM);
        $page->addToBody(NewStrike::displayBox(), Page::BOTTOM);
        $page->addToBody("<div id='strikes' class='col-xs-12'></div>", Page::BOTTOM);
        echo $page->generateHtml();
    } catch (UserNotLoggedInException $exception) {
        header("Location: /login.php");
        exit;
    }

