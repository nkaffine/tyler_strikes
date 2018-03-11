<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/11/18
     * Time: 4:51 PM
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
        if (isset($_GET["command"])) {
            $command = validInputSizeAlpha($_GET["command"], 255);
            if ($command === "total") {
                $results['results'] = $model->getStrikeStatus();
            } else {
                throw new InvalidArgumentException("Invalid Command");
            }
        } else {
            $strikes = $model->getStrikes();
            $json_strikes = array();
            foreach ($strikes as $strike) {
                array_push($json_strikes, $strike->getJSON());
            }
            $results['results']['strikes'] = $json_strikes;
            $results['results']['strike_status'] = $model->getStrikeStatus();
        }
    } catch (Exception $exception) {
        $results['error'] = $exception->getMessage();
    }
    header('Content-Type: application/json');
    echo json_encode($results, JSON_PRETTY_PRINT);