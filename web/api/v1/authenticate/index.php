<?php

    include '../../utils.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    error_reporting(E_ALL);

    //process client request (VIA URL)

    $clientID = 'i4zj2DAEN6yxRasdDlG-JWvYzM';
    $clientSecret = 'mVmAE1ewqdaaasBHVaNGXlzov4vCQ3Yyj-mabLY5ikaZGBn65Tt4V4OIBSszHPt8IOB3XXMe2nafXx9fCg';
    $apiKey = '3_35VAKEGuX4nLeXXaaG3mgqHXFB6BnBveu68VLHIav0x75CbPHr4m5L321advJt';

    header("Content-Type:application/json");
    if(!empty($_GET['token'])){

        //get access token from URL
        $accessToken = $_GET['token'];

        $tokenResponse = tryIntrospection($accessToken, $clientID, $clientSecret, $apiKey);

        if ($tokenResponse){

            $userInfo = retrieve_user_info($accessToken, $apiKey);
            deliver_response(1, "token valid", $userInfo);
        }
        else {
            deliver_response(0, "token not valid", NULL);
        }
    }
    else
    {
        //throw invalid request
        deliver_response(0, "invalid request or invalid parameters", NULL);

    }

?>
