#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include "DHT.h"

//----------------------------------------SSID and Password of your WiFi router
const char* ssid = <wifi_ssid>;
const char* password = <wifi_password>;

//----------------------------------------Declaração de variaveis
#define DHTTYPE DHT22 
#define DHTPin D1
#define analogicoChuva A0
#define digitaLuminosidade D2

DHT dht(DHTPin, DHTTYPE);
String status_tempo;
String status_bateria;
float temperatura;
float umidade;

//----------------------------------------Procedure for send request HTTP to insert new Database
void Sending_To_phpmyadmindatabase(){
  HTTPClient http;
  WiFiClient client;

  float temperatura = dht.readTemperature();
  float umidade = dht.readHumidity();

  if( analogRead(analogicoChuva) <= 800 ){
    status_tempo = "chovendo";
  }else{
    status_tempo = "sem_chuva";
  }

  if( digitalRead(digitaLuminosidade) == 1 ){
    status_bateria = "descarregando";
  }else{
    status_bateria = "carregando";
  }

	String postData = "bateria=" + status_bateria + 
					  "&tempo=" + status_tempo + 
					  "&temperatura=" + temperatura + 
					  "&umidade=" + umidade;

	http.begin("http://192.168.2.105/nodemcu/post-data.php?" + postData);

  int httpResponseCode = http.POST(postData);
  
  http.end();
}


//----------------------------------------Setup
void setup(void){
  delay(500);
  dht.begin();
  delay(500);
  
  WiFi.begin(ssid, password);
  
  //----------------------------------------Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(250);    
  }

}

void loop(){
  Sending_To_phpmyadmindatabase();
  
  delay(1000);

  // Descontando os delays e tempo de conexção com wi-fi, é o quivalente 
  // a 15min de sleep.
  ESP.deepSleep(954 * 1000000);
}
