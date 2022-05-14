#include <Arduino.h>
#include <WiFi.h>
#include <ESP32Ping.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

// Deklarasi Variabel dan Konstanta
String wifiSSID = "KOSAN PAK MAMAN";
String wifiPassword = "gegerarum22";
const IPAddress routerIp(192,168,100,1);
String googleDotCom = "www.google.com";

// Deklarasi Fungsi
void connectWifi();
void getHttp();

void setup() {
  Serial.begin(115200);
  connectWifi();
  getHttp();
  
  
}

void loop() {
  
}

void getHttp() {
  String url = "https://reqres.in/api/users/2";
  HTTPClient http;
  String response;

  http.begin(url);
  http.GET();

  response = http.getString();
  Serial.println(response);

  StaticJsonDocument<1024> doc;
  deserializeJson(doc, response);
  JsonObject obj = doc.as<JsonObject>();

  String data = obj[String("data")];
  String support = obj[String("support")];

  Serial.println(data);
  Serial.println(support);

  StaticJsonDocument<1024> doc2;
  deserializeJson(doc2, data);
  JsonObject obj2 = doc2.as<JsonObject>();

  String id = obj2[String("id")];

  Serial.println("idnya adalah " + id);
}

void connectWifi() {
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
}