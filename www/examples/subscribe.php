<html>

	<head>
		<title>title</title>
		<script src="http://code.jquery.com/jquery-2.0.3.js"></script>
	</head>
	
	<body>
		test
		<input type="button" onclick="alert(1)" value="Переключить"/>
		<div id="testdiv">1</div>
		
		

<?php




@ob_flush();
	flush();

require("phpMQTT.php");

$server = "postman.cloudmqtt.com";     // change if necessary
$port = 15043;                     // change if necessary
$username = "kllzeooz";                   // set your username
$password = "Gg5nBhn0TWWd";                   // set your password
$client_id = "mqttdash-d74b9607"; // make sure this is unique for connecting to sever - you could use uniqid()


$mqtt = new phpMQTT($server, $port, $client_id);

if(!$mqtt->connect(true, NULL, $username, $password)) {
	exit(1);
}

$topics['#'] = array("qos" => 0, "function" => "procmsg");
$mqtt->subscribe($topics, 0);


while(1){
	$mqtt->proc();
	
	usleep(100);
	//echo "+";
	//procmsg('bluerhinos/phpMQTT/examples/publishtest', 'wtf');
	//$mqtt->message('wtf');
	//echo $topics['bluerhinos/phpMQTT/examples/publishtest'];
	//var_dump($topics['bluerhinos/phpMQTT/examples/publishtest']);
	//$mqtt->printstr('wtf');
	//$mqtt->read();
}


/*
for ($i = 1; $i <= 1000000; $i++) {
    $mqtt->proc();
	
}
*/

//$mqtt->proc();


$mqtt->close();


function procmsg($topic, $msg){
	@ob_flush();
	flush();
	
	
	//echo '<script> document.getElementById("testdiv").innerHTML="2"; </script>';
						
	?>
	
	<p> Light state: <?php echo json_encode($msg); ?> </p>
	
	<?php
	
}


echo json_encode("0");

?>

		

	</body>
	
</html>
