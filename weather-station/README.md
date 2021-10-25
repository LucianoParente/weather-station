# Overwier 

### Esse projeto consiste em um sistema capaz de medir, em intervalos de 15 minutos, as condições ambientes tais como: Tempratura, umidade relativa do ar e verificar se está chovendo. O sistema é gerenciado e processado por uma placa controladora Esp8266 e todas a informações são coletadas e armazenadas em um banco de dados MySQL. 

# Architecture

### O principal componente é o Node MCU Esp8266, nele estão ligados alguns sensores como DHT22 (sensor de tempreatura e umidade), TL-83 (sensor de chuva), painel solar fotovoltaico (5v 1w), uma bateria 18650 (4.2v 9800mha) TP4056 (placa que alterna a fonte de energia entre o painel solar e bateria) e LDR (sensor de luz foto-resistivo). 

![](https://github.com/LucianoParente/weather-station/pics/Escheme.jpg)

#Station

![](https://github.com/LucianoParente/weather-station/pics/WS_img.jpeg)

# Web Page Monitoring

### Para acompanhar em tempo real as informações coletadas pela estação, desenvolvi uma págia web com informações em gráficos de forma amigável para que o usuário possa verificar a situação atual e o histórico anterior. 

![](https://github.com/LucianoParente/weather-station/pics/page_sample.png)

# Contato

### Para saber mais sobre esse e outros projetos, acesse minha pagina:
https://lucianoparente.github.io/
