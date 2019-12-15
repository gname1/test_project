<?php

//require("examples/subscribe.php");

/*
  for ($i = 0; $i < 10; $i++) {
    echo $i;
	@ob_flush();
	flush();
    sleep(1);
  }
*/
/*
function freelocation($location){
if($location){
        ob_end_clean();
        header("Connection: close\r\n");
        header("Content-Encoding: none\r\n");
        ignore_user_abort(true); ob_start();
		header('location:'.$location);
        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush(); flush(); ob_end_clean();
 }
}

freelocation('http://localhost/light.iot/examples/subscribe.php');
*/


?>

<html>

	<head>
		<title>Light IoT</title>
		<link rel="stylesheet" href="css/style.css">
		<script src="http://code.jquery.com/jquery-2.0.3.js"></script>
	</head>
	
	<body>
	
	
		<script>
			
			setInterval(function() { 
				//execFunc(); 
			}, 3000);
			
			//setInterval(function() { execFunc(); }, 3000);
			//execFunc();
			
			function execFunc(){
				$.ajax({
					type: "POST",
					url: "examples/subscribe.php",
					dataType: "json",
					success: function(data){
							//alert(1);
							var div_value = $('#testdiv').text() + data;
							$('#testdiv').text(div_value);	
							execFunc();
					}
				});
			}
			
			
					
			
			
			
			/*
			$.get("examples/test.php", execFunc);
			function execFunc(response){
				//$('div').text(value);
				//alert(1);
				var json = jQuery.parseJSON(response);
				
				$('div').text(json.a);
			}
			*/
			
			/*
			setInterval(function() {
			   document.getElementById("image").src="/file.php?v="+new Date().getTime();
			 }, 5000);
			*/

		
		</script>
	
	
		<h1>Light IoT</h1>
		
		<button> <img class="bulb_image" src="images/lightbulb_on.png"  /><figcaption> 123 12312312sdfsdfsdf sdf sdf sd f31 2312 3123123 123123123123</figcaption></button>
		<button> <img class="bulb_image" src="images/lightbulb_on.png"  /><figcaption>1</figcaption></button>
		<button> <img class="bulb_image" src="images/lightbulb_on.png"  /><figcaption></figcaption></button>
		<p> Состояние: </p>
		<input type="button" onclick="change_switch()" value="Переключить"/>

		<script>
			
			function change_switch(){
				
				$.ajax({
					type: "POST",
					url: "examples/publish.php",
					dataType: "json",
					data: {'switch_value': 0},
				
				});
			}
		
		</script>
		
		<div id="time"></div>
		<div id="testdiv"></div>
		
		
		
	</body>

</html>