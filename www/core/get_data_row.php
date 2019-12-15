<?php

require_once 'includes.php';
require_once 'functions.php';
require_once 'config.php';


$row_id = $_POST['row_id'];

$deskriptor_database = connect_database(HOST,USER,PASS,DB);

// Возвращаем строку из бд по id
$query_data_row   =  'SELECT topic, message FROM topics_data WHERE id="'.$row_id.'"';
$rezult_data_row = get_assoc_array_from_database($deskriptor_database, $query_data_row);

echo json_encode(array('topic' => $rezult_data_row[0]["topic"], 'message' => $rezult_data_row[0]["message"]));



