#include <Arduino.h>
#include <WiFi.h>
#include <ESP32Ping.h>

String wifiSSID = "KOSAN PAK MAMAN";
String wifiPassword = "gegerarum22";
const IPAddress routerIp(192,168,100,1);
String googleDotCom = "www.google.com";

void setup() {
  Serial.begin(115200);
  Serial.println("Connecting to Wifi..");
  
  WiFi.begin(wifiSSID.c_str(), wifiPassword.c_str());
  while(WiFi.status()!=WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }

  Serial.println("\nWifi Connected");
  Serial.println(WiFi.SSID());
  Serial.println(WiFi.RSSI());
  Serial.println(WiFi.macAddress());
  Serial.println(WiFi.localIP());
  Serial.println(WiFi.gatewayIP());

  if (Ping.ping(googleDotCom.c_str()))
  {
    Serial.println("Connected to Google");
  }
    //Serial.println("Connected to Router");
  
}

void loop() {
  Ping.ping(googleDotCom.c_str());
  Serial.println(Ping.averageTime());
  //delay(100);
}