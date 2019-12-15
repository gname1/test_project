<?php
    $conn = mysqli_connect('db', 'user', 'test', 'myDb', 3306);
    mysqli_set_charset($conn, "utf8");
    $query = 'SELECT * From Person';
    $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Demo</title>

    </head>

    <body>
        <p>Hello world</p>
         <p>
                <?php
                while ($value = $result->fetch_array(MYSQLI_ASSOC)) {
                    foreach ($value as $element) {
                        echo ' - ' . $element;
                    }
                }
                $result->close();
                mysqli_close($conn);
                ?>
          </p>
    </body>

</html>
