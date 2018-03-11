<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/11/18
     * Time: 4:19 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/StrikingModel.php");

    function validInputSizeAlpha($uncleanString, $maxLength) {
        $sizedString = substr($uncleanString, 0, $maxLength);
        $cleanString = preg_replace("[^\.a-zA-Z' ]", '', $sizedString);
        $cleanString = str_replace("\\", "", $cleanString);
        $cleanString = str_replace("'", "\'", $cleanString);
        return $cleanString;
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
        if (isset($_GET["command"]) && isset($_GET['user']) && (isset($_GET['description'])) &&
            (isset($_GET["type"]))
        ) {
            $command = validInputSizeAlpha($_GET["command"], 255);
            $user = validInputSizeAlpha($_GET["user"], 255);
            $description = validInputSizeAlpha($_GET["description"], 255);
            if($description === "") {
                throw new InvalidArgumentException("Invalid description");
            }
            $type = validInputSizeAlpha($_GET["type"], 4);
            if ($type == "good") {
                $model->newGoodStrike(User::getUserById($user), $description);
                $results['results'] = "success";
            } else if ($type == "bad") {
                $model->newBadStrike(User::getUserById($user), $description);
                $results['results'] = "success";
            } else {
                throw new InvalidArgumentException("Invalid strike type");
            }
        } else {
            throw new InvalidArgumentException("Not all required parameters passed");
        }
    } catch (Exception $exception) {
        $results['error'] = $exception->getMessage();
    }
    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);