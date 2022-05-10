<?php
/*
Verifies the logged in user.
*/

$response = [];

session_start();

if(empty($_SESSION["id"]) || $_SESSION["id"] != session_id() || empty($_SESSION['name'])) {
    $response["success"] = false;
}
else {
	session_regenerate_id();
	$_SESSION['id'] = session_id();
    $response["success"] = true;
    $response["name"] = $_SESSION['name'];
}

//Responds if response was requested.
if (isset($_GET["respond"]) && $_GET["respond"] == "json") {
    echo json_encode($response);
}
?>