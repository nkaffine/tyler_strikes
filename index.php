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
    try {
        $user = User::loginWithCookie();
        $page = new StandardUserPage("home");
        $page->addToBody("<h1>" . $user->getUsername() . "</h1>", Page::BOTTOM);
        echo $page->generateHtml();
    } catch (UserNotLoggedInException $exception) {
        header("Location: /login.php");
        exit;
    }

