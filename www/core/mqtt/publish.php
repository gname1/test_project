<?php

require("phpMQTT.php");

$server = "postman.cloudmqtt.com";     // change if necessary
$port = 15043;                     // change if necessary
$username = "kllzeooz";                   // set your username
$password = "Gg5nBhn0TWWd";                   // set your password
$client_id = "mqttdash-d74b9607"; // make sure this is unique for connecting to sever - you could use uniqid()

$message = $_POST['message'];
$bulb_id = $_POST['bulb_id'];
$pub_topic = $_POST['pub_topic'];

//$topic_name = "iot/bulb".$bulb_id."/set";

$mqtt = new phpMQTT($server, $port, $client_id);

if ($mqtt->connect(true, NULL, $username, $password)) {
	$mqtt->publish($pub_topic, $message, 0);
	$mqtt->close();
} else {
    echo "Time out!\n";
}

echo json_encode(1);
