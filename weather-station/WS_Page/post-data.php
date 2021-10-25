<?php
class dht11{
 public $link='';
 function __construct($bateria, $tempo, $temperatura, $umidade){
  $this->connect();
  $this->storeInDB($bateria, $tempo, $temperatura, $umidade);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost',<bd>,<bd_password>) or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'nodeMCU') or die('Cannot select the DB');
 }
 
 function storeInDB($bateria, $tempo, $temperatura, $umidade){
  $query = "INSERT INTO <bb_table>(bateria, tempo, temperatura, umidade) VALUES ('$bateria', '$tempo', $temperatura, $umidade)";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['temperatura'] != '' and  $_GET['umidade'] != ''){
 $dht11=new dht11($_GET['bateria'], $_GET['tempo'], $_GET['temperatura'],$_GET['umidade']);
}
?>
