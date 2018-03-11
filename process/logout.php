<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 2/20/18
     * Time: 6:19 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/model/StrikingModel.php");
    $result = array();
    $result['error'] = null;
    $result['results'] = null;
    $model = new StrikingModel();
    try {
        User::logout();
        $result['results'] = "success";
    } catch (Exception $exception) {
        $result['error'] = $exception->getMessage();
    }
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
