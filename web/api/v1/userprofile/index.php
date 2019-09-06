<?php

    include '../../utils.php';
    require_once __DIR__ . '/../../../../vendor/autoload.php';
    error_reporting(E_ALL);

    //process client request (VIA URL)
    $clientID = 'i4zj2DAEN6yxR2DlG-JsdWvYzM';
    $clientSecret = 'mVmAESsEsl84M1rho9BHasdaVaNGXlzov4vCQ3Yyj-mabLY5ikaZGBn65Tt4V4OIBSszHPt8IOB3XXMe2nafXx9fCg';
    $apiKey = '3_35VAKEGuX4nLseXXG3mgqHXFB6BnasdaBveu68VLHIav0x75CbPHr4m5LRYSEo7WdavJt';

    header("Content-Type:application/json");
    if(!empty($_GET['uuid'])){

        //get access token from URL
        $accessToken = $_GET['uuid'];

        $userInfo = retrieve_user_info($accessToken, $apiKey);

        if(isset($userInfo)){
            deliver_response(1, "valid user", $userInfo);
        }
        else {
            deliver_response(0, "user not found", NULL);
        }
    }
    else
    {
        //throw invalid request

        deliver_response(0, "invalid request or invalid parameters", NULL);

    }



?>
