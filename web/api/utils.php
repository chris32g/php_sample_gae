<?php

//authenticate access token
function tryIntrospection($token, $id, $sec, $api){

    $authHeader="Basic ";
    $client_ID = $id;
    $secret= $sec;
    $hashedAuthString=base64_encode($client_ID . ":" . $secret);
    $authHeader .= $hashedAuthString;

    $ch = curl_init();
    $introData = "token=" . $token;
    $urlintrospection = "https://fidm.eu1.gigya.com/oidc/op/v1.0/".$api."/introspect";
    curl_setopt($ch,CURLOPT_URL,$urlintrospection);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $authHeader));
    curl_setopt($ch,CURLOPT_POSTFIELDS,$introData);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $curlResult = curl_exec($ch);
    curl_close($ch);

    $jsonArray = json_decode($curlResult, true);

    $tokenStatus = $jsonArray["active"];

    return $tokenStatus;

}

//get user info
function retrieve_user_info($accessToken, $api){

    $url = "https://fidm.eu1.gigya.com/oidc/op/v1.0/".$api."/userinfo";
    $bearAccessToken="Bearer " . $accessToken;

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $bearAccessToken));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

    $resultUI = curl_exec($ch);

    // CHECK STATUS TEST
    $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    global $reqResStatus;
    $reqResStatus = $resultStatus;

    // END CHECK STATUS
    curl_close($ch);

    $jsonInfoResult = json_decode($resultUI, true);

    if ($resultStatus == 200){
        return create_usr_obj($jsonInfoResult);
    }
    else{
        return NULL;
    }
}

//create a user json object
function create_usr_obj($obj){

    $user = array(
        'uuid'=> uniqid('',TRUE),
        'email'=>$obj["email"],
        'firstname' => $obj["given_name"],
        'lastname' => $obj["family_name"]
    );

    return $user;

}

//parse and deliver response
function deliver_response ($status, $statusMessage, $data)
{
    header("HTTP/1.1 $status $statusMessage");
    $response['status']=$status;
    $response['message']=$statusMessage;
    $response['user']=$data;

    $json_response = json_encode($response);
    echo $json_response;
}

?>