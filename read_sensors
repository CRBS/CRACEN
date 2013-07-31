#include <OneWire.h>
#include <DallasTemperature.h>
#include <Ethernet.h>
#include <SPI.h>
#include <Client.h>

// constants
#define AIRFLOW_PIN A1
#define TEMP_PIN 2

// variables
int airFlow_Value = 0;
int tempC = 0;
int tempF = 0;

OneWire oneWire(TEMP_PIN); // Setup to communicate with any OneWire devices
DallasTemperature sensors(&oneWire); // Pass oneWire reference to Dallas Temperature
DeviceAddress tempSensor = { 0x28, 0xB0, 0xD5, 0xA7, 0x04, 0x00, 0x00, 0x24 }; // Temp sensor address

byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0x98, 0x5C}; //Ethernet shield mac address
char server[] = "http://localhost.ucsd.edu";
long time;

EthernetClient client;

void setup() 
{
  Serial.begin(9600);
  if (Ethernet.begin(mac)==1);{
    Serial.println("Ethernet configured."); //check ethernet connection
  }
  pinMode(AIRFLOW_PIN, INPUT);  
  sensors.begin();
  sensors.setResolution(tempSensor, 10);
}

void loop()
{//read sensors
  airFlow_Value = analogRead(AIRFLOW_PIN);
  sensors.requestTemperatures();
  tempC = sensors.getTempC(tempSensor);
  tempF = (DallasTemperature::toFahrenheit(tempC));
  report(time, airFlow_Value, tempC, tempF);
}

void report(long time, int airFlow_Value, int tempC, int tempF)
{
  Serial.println("connecting...");
  
  if (client.connect(server, 80)){
    Serial.println("connected");
    
    //construct URL of script that will insert data into database
 
    client.print("GET http://localhost/sensors.php");
    client.print("?time=");
    client.print(time);
    
    client.print("&airFlow_Value=");
    client.print(airFlow_Value);
    client.print("&tempC=");
    client.print(tempC);
    client.print("&tempF=");
    client.print(tempF);
    client.println();
    client.println();
    
   /*print to serial monitor as a quick check 
   to make sure sensors are working*/
   Serial.print("airFlow_Value = ");
   Serial.println(airFlow_Value);
   Serial.print("tempC = ");
   Serial.println(tempC);
   Serial.print("tempF = ");
   Serial.println(tempF);
   
   Serial.println("End transmission");
   
   while(client.available()) {
     client.read();
   }
   
   if(!client.connected()) {
     client.stop(); //kills connection
     Serial.println("Disconnected");
     delay(2000);
   }
   
  }
  else {
    Serial.println("connection failed");
  }
}
