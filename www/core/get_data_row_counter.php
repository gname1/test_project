<?php

require_once 'includes.php';
require_once 'functions.php';
require_once 'config.php';

$deskriptor_database = connect_database(HOST,USER,PASS,DB);

// Определяем кол-во записей в бд
$query_data_row_counter   =  "SELECT id FROM topics_data ORDER BY id DESC LIMIT 1";
$rezult_data_row_counter = get_assoc_array_from_database($deskriptor_database, $query_data_row_counter);
$count = $rezult_data_row_counter[0]["id"];
echo json_encode($count);

