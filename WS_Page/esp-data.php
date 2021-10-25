<!DOCTYPE html>
<html><body>
<?php
/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

$servername = "localhost";

// REPLACE with your Database name
$dbname = <db_name>;
// REPLACE with Database user
$username = <user_db_name>;
// REPLACE with Database user password
$password = <db_password>;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//SQL_get_information_from_DB
$sql = "SELECT id, sensor, local, temperatura, umidade, horario FROM <table_name> ORDER BY id DESC";

echo '<table cellspacing="4" cellpadding="4">
      <tr> 
        <td>ID</td> 
        <td>Sensor</td> 
        <td>Local</td>
        <td>Temperatura</td> 
        <td>Umidade</td>
        <td>Horario</td>
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_sensor = $row["sensor"];
        $row_local = $row["local"];
        $row_temperatura = $row["temperatura"];
        $row_umidade = $row["umidade"];  
        $row_horario = $row["horario"];
 
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_sensor . '</td> 
                <td>' . $row_local . '</td> 
                <td>' . $row_temperatura . '</td> 
                <td>' . $row_umidade . '</td>
                <td>' . $row_horario . '</td>
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>
