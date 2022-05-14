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

int randTemp, randHum;

// Deklarasi Fungsi
void connectWifi();
void getHttp();

void postHttp();

void setup() {
  Serial.begin(115200);
  connectWifi();
  //postHttp();

  // getHttp();

  
  
}

void loop() {
  //postHttp();
  //delay(1000);
}

void postHttp() {
  Serial.println("Posting...");
  String url = "http://192.168.100.189/esp32/api/api.php?data=insert";
  HTTPClient http;
  String response;

  StaticJsonDocument<200> buff;
  String jsonParams;

  randTemp = random(30, 50);
  randHum = random(40, 80);

  buff["temp"] = String(randTemp);
  buff["hum"] = String(randHum);

  serializeJson(buff, jsonParams);
  //Serial.println(jsonParams);

  http.begin(url);
  //http.addHeader("Content-Type", "application/json");
  int statusCode = http.POST(jsonParams);
  response = http.getString();

  if (statusCode == 200)
  {
    Serial.println("Post Method Success!");
    Serial.println("Temp : " + String(randTemp));
    Serial.println("Hum : " + String(randHum));
  }
  else
  {
    Serial.println("Post Method Failed!");
  }
  
  // Serial.println(response);
  // Serial.println(statusCode);
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
    Serial.println("Connected to Internet");
  }
}