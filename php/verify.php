<?php
/*
Verifies the logged in user.
*/

$response = [];

session_start();

if(empty($_SESSION["id"])
    || $_SESSION["id"] != session_id()
    || empty($_SESSION['name'])
    || empty($_SESSION['phone'])
    || empty($_SESSION['admin'])
    || empty($_SESSION['uid'])) {
    $response["success"] = false;
}
else {
	session_regenerate_id();
	$_SESSION['id'] = session_id();
    $response["success"] = true;
    $response["name"] = $_SESSION['name'];
    $response["phone"] = $_SESSION['phone'];
    $response["admin"] = $_SESSION['admin'] == "Y" ? true : false;
    $response["uid"] = $_SESSION['uid'];
}

//Responds if response was requested.
if (isset($_GET["respond"]) && $_GET["respond"] == "json") {
    echo json_encode($response);
}
?>