<?php
	require_once 'core/includes.php';
	require_once 'core/functions.php';
	require_once 'core/config.php';
	
	
	/*
	
	1. Кнопка режима
	2. Virtual bulb
	3. Алгоритм сенсора
	------
	Авторизация
	
	*/
	
	
?>

<html>

	<head>
		<title>Light IoT</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="assets/css/style.css">
		<script src="assets/js/jquery-3.3.1.min.js"></script>
		<script src="assets/js/script.js"></script>
		
	</head>
	
	<body>

		
		
		<script type="text/javascript">
			// Массив с id всех bulbs
			arr_bulb = [];
			arr_bulb_count = 0;
			
		</script>
		
		
		<?php
		
		$deskriptor_database = connect_database(HOST,USER,PASS,DB);
	
	
		// Определяем кол-во записей в бд
		$query_data_row_counter   =  "SELECT id FROM topics_data ORDER BY id DESC LIMIT 1";
		$rezult_data_row_counter = get_assoc_array_from_database($deskriptor_database, $query_data_row_counter);
		//echo $rezult_data_row_counter[0]["id"];
	
	
		// Запрос получения bulbs
		$query_lightbulbes   =  "SELECT id, description FROM lightbulbs";
		$rezult_lightbulbes = get_assoc_array_from_database($deskriptor_database, $query_lightbulbes);
		
		
		?>
		
		<div id="page_content">
		
		<table id="devices_table">
			<tr>
				<th colspan="2">
					<h1>Light IoT</h1>
				</th>
			</tr>
			
			<tr>
				<th>
					<p>Устройство</p>
				</th>
				<th>
					<p>Режим управления</p>
				</th>
			</tr>
		<?php
		// Вывод bulbs
		foreach ($rezult_lightbulbes as $bulb) 
		{
			// Запрос получения текущего значения bulb
			$query_lightbulbes_value   =  "SELECT message FROM topics_data WHERE topic='iot/bulb".$bulb["id"]."/get' ORDER BY id DESC LIMIT 1";
			$rezult_lightbulbes_value = get_assoc_array_from_database($deskriptor_database, $query_lightbulbes_value);
			$bulb_current_switch_value = $rezult_lightbulbes_value[0]['message'];
			
			// Запрос  текущего режима bulb
			$query_lightbulbes_mode   =  "SELECT message FROM topics_data WHERE topic='iot/bulb".$bulb["id"]."/mode/get' ORDER BY id DESC LIMIT 1";
			$rezult_lightbulbes_mode = get_assoc_array_from_database($deskriptor_database, $query_lightbulbes_mode);
			$bulb_current_mode = $rezult_lightbulbes_mode[0]['message'];
			$bulb_current_mode_str = ($bulb_current_mode == 0) ? "Датчик" : "Ручной";
			
			
			if($bulb_current_mode == 0){
				$disable_for_btn_mode = "disabled";
			}
			else{
				$disable_for_btn_mode = "";
			}
			
		?>
		
		<script type="text/javascript">
			// Массив с id всех bulbs:  php -> javascript
			arr_bulb[arr_bulb_count++] = 	<?php echo $bulb["id"]; ?>;
			
		</script>

		
		<tr>
			<th>
				<button  class="btn" id="btn<?php echo $bulb["id"]; ?>" value="<?php echo $bulb["id"]; ?>"   <?php echo $disable_for_btn_mode; ?> > 
					<img value="<?php echo $bulb_current_switch_value; ?>" id="bulb<?php echo $bulb["id"]; ?>" class="bulb_image" src="assets/images/lightbulb_<?php echo $bulb_current_switch_value; ?>.png"/>
					<figcaption><?php echo $bulb["description"]; ?></figcaption>
				</button>
			</th>
			<th>
				<button class="btn_mode" value="<?php echo $bulb_current_mode; ?>" id="bulb_mode<?php echo $bulb["id"]; ?>"><?php echo $bulb_current_mode_str; ?></button>
			</th>
			
		</tr>
		
		
		<?php
		}
		?>
		</table>
		
		</div>
		
		<script type="text/javascript">

			// Кол-во записей в бд: php -> javascript
			data_row_counter = '<?php echo $rezult_data_row_counter[0]["id"];?>';
		</script>
		
		

	</body>

</html>