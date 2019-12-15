<?php

require("phpMQTT.php");

$server = "postman.cloudmqtt.com";     // change if necessary
$port = 15043;                     // change if necessary
$username = "kllzeooz";                   // set your username
$password = "Gg5nBhn0TWWd";                   // set your password
$client_id = "mqttdash-d74b9607"; // make sure this is unique for connecting to sever - you could use uniqid()

$switch_value = $_POST['switch_value'];
$topic_name = "iot/bulb1/get";//"light/switch";

$mqtt = new phpMQTT($server, $port, $client_id);

if ($mqtt->connect(true, NULL, $username, $password)) {
	$mqtt->publish($topic_name, $switch_value, 0);
	$mqtt->close();
} else {
    echo "Time out!\n";
}

