<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/18/18
     * Time: 8:31 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/User.php");

    function validInputSizeAlpha($uncleanString, $maxLength) {
        $sizedString = substr($uncleanString, 0, $maxLength);
        $cleanString = preg_replace("[^\.a-zA-Z' ]", '', $sizedString);
        return ($cleanString);
    }

    function validNumbers($uncleanString, $maxLength) {
        $cleanString = substr($uncleanString, 0, $maxLength);
        $cleanString = preg_replace("[^\.0-9]", '', $cleanString);
        return ($cleanString);
    }

    $results = array();
    $results['results'] = null;
    $results['error'] = null;
    try {
        if (isset($_GET["type"]) && isset($_GET['password']) && (isset($_GET['username']) || isset($_GET['email']))) {
            $type = validInputSizeAlpha($_GET["type"], 255);
            $username = validInputSizeAlpha($_GET["username"], 255);
            $password = validInputSizeAlpha($_GET["password"], 255);
            $email = validInputSizeAlpha($_GET["email"], 255);
            if ($type === "signup") {
                if ($_GET["username"] === null || $_GET["email"] === null) {
                    throw new InvalidArgumentException("Not all required parameters passed");
                }
                $user = User::newUser($username, $password, $email);
                $results['results'] = "success";
            } else if ($type === "login") {
                if ($_GET["email"] === null) {
                    $user = User::login($username, $password);
                } else {
                    $user = User::loginEmail($email, $password);
                }
                $results['results'] = "success";
            } else {
                throw new InvalidArgumentException("Invalid type of command");
            }
        } else {
            throw new InvalidArgumentException("Not all required parameters passed");
        }
    } catch (Exception $exception) {
        $result['error'] = $exception->getMessage();
    }
    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);