<?php

function connect_database($host,$user,$pass,$database) {
    $deskriptor_database = mysqli_connect($host,$user,$pass,$database);
    if (!$deskriptor_database) {
        exit('Ошибка при подключении к базе данных');
    }

    mysqli_query($deskriptor_database,'SET NAMES utf8');
    return $deskriptor_database;
}

function close_database($deskriptor_database) {
    mysqli_close($deskriptor_database);
}

function show404page() {
    header("HTTP/1.1 404 Not Found");
    echo '404 page';
}

function get_assoc_array_from_database($deskriptor_database, $query) {
    $result  =  mysqli_query( $deskriptor_database,  $query );
    $arr=array();
    while ($row = mysqli_fetch_assoc($result))
    {
        $arr[] = $row;
    }
    return $arr;
}

function translit_rus($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}

function slug($str) {
    $notsymb = array(',', '.', ' ', '_');
    $replsymb= '-';
    $newstr = str_replace($notsymb, $replsymb, $str);
    while($newstr{strlen($newstr)-1} == $replsymb) {
        $newstr = substr($newstr,0,-1);
    }
    $newstr = preg_replace("/(\-){2,}/", '$1', $newstr);
    $newstr = mb_strtolower($newstr);
    return $newstr;
}

function get_current_place($field_name) {
    $current_url = get_current_url($_SERVER['REQUEST_URI']);
    if (isset($_GET[$field_name])) {
        $pattern = "/visockiy\.vladimir\/(.*)\?/";
        preg_match($pattern, $current_url, $current_place_array);
        $current_place = $current_place_array[1];
    }
    else {
        if ($current_url == "/visockiy.vladimir/")
        {
            return "";
        }
        $pattern = "/\/(\w*)$/";
        preg_match($pattern, $current_url, $current_place_array);
        $current_place = $current_place_array[1];
    }
    return $current_place;
}

function get_current_page_name($current_url) {

    $pattern = "/([\w|\.]+)\//";  // /visockiy\.vladimir\/(.*)\/(\w+)\?/
    $current_url = preg_replace("/([\w|\.]+)\//", '', $current_url);    // удаляем левую часть
    $current_url = preg_replace("/\//", '', $current_url);    // удаляем /
    $current_url = preg_replace("/\.[\w]+/", '', $current_url);    // удаляем .*
    return $current_url;
}

function get_current_url($str) {

    $pattern = "/\.(\w+)$/";
    $s = preg_replace ($pattern, '', $str);
    if (preg_match("/\.(\w+)\?/", $s))  // qweqweqwe.php?qwe=opop -> qweqweqwe?qwe=opop
    {
        $s = preg_replace ("/\.(\w+)\?/", '?', $s);
    }
    if (preg_match("/([\w|.]+)\/([\w]+)\/([\w|-]+)$/", $s))  // asdasdasd/text/qweqweqw -> asdasdasd/text?id=qweqweqw                 if (preg_match("/\/([\w|-]+)$/", $s))
    {
        $s = preg_replace ("/([\w|.]+)\/([\w]+)\/([\w|-]+)$/", '$1/$2?name=$3', $s);
    }
    if (preg_match("/index/", $s))
    {
        $s = preg_replace ("/index/", '', $s);
    }


    return $s;

}


?>
