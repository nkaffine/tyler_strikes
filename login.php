<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/18/18
     * Time: 8:09 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/exceptions/InvalidLoginCredentialsException.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/page/StandardUserPage.php");
    $page = new StandardUserPage("login");
    $email_section =
        "<label for='email'>Email</label><input id='email' class='form-control' type='text' maxlength='255' required>";
    $username_section =
        "<label for='username'>Username</label><input id='username' class='form-control' type='text' max='255' required>";
    $password_section =
        "<label for='password'>Password</label><input id='password' class='form-control' type='password' max='255' required>";
    $submit_button =
        "<button id='login' class='col-xs-6 btn btn-primary'>Log in</button><button id='signup' class='col-xs-6 btn btn-default'>Sign Up</button>";
    $html = "<div class='col-xs-12'><div class='col-xs-12'>" . $email_section . $username_section . $password_section .
        $submit_button . "</div></div>";
    $page->addToBody($html, Page::BOTTOM);
    $page->addJSFile("/scripts/login.js");
    echo $page->generateHtml();