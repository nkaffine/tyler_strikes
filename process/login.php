<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/18/18
     * Time: 8:31 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/StrikingModel.php");

    function validInputSizeAlpha($uncleanString, $maxLength) {
        $sizedString = substr($uncleanString, 0, $maxLength);
        $cleanString = preg_replace("[^\.a-zA-Z' ]", '', $sizedString);
        $cleanString = str_replace("\\", "", $cleanString);
        $cleanString = str_replace("'", "\'", $cleanString);
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
    $model = new StrikingModel();
    try {
        if (isset($_GET["type"]) && isset($_GET['password']) && (isset($_GET['username']) || isset($_GET['email']))) {
            $type = validInputSizeAlpha($_GET["type"], 255);
            $username = validInputSizeAlpha($_GET["username"], 255);
            $password = validInputSizeAlpha($_GET["password"], 255);
            $email = validInputSizeAlpha($_GET["email"], 255);
            if ($type === "signup") {
                $model->signUp($username, $email, $password);
                $results["results"] = "success";
            } else if ($type === "login") {
                $model->login($username, $email, $password);
                $results["results"] = "success";
            } else {
                throw new InvalidArgumentException("Invalid type of command");
            }
        } else {
            throw new InvalidArgumentException("Not all required parameters passed");
        }
    } catch (Exception $exception) {
        $results['error'] = $exception->getMessage();
    }
    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);