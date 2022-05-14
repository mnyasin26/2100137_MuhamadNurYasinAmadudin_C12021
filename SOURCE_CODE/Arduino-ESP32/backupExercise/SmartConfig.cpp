#include <Arduino.h>
#include <WiFi.h>

// String wifiSSID = "KOSAN PAK MAMAN";
// String wifiPassword = "gegerarum22";

void setup() {
  Serial.begin(115200);
  Serial.println("Smart Config Mode");
  WiFi.mode(WIFI_AP_STA);
  WiFi.beginSmartConfig();

  while (!WiFi.smartConfigDone())
  {
    Serial.print("-");
    delay(500);
  }

  while(WiFi.status()!=WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }
  
  // WiFi.begin(wifiSSID.c_str(), wifiPassword.c_str());
  // while(WiFi.status()!=WL_CONNECTED) {
  //   Serial.print(".");
  //   delay(500);
  // }

  Serial.println("\nWifi Connected");
  Serial.println(WiFi.SSID());
  Serial.println(WiFi.RSSI());
  Serial.println(WiFi.macAddress());
  Serial.println(WiFi.localIP());
  Serial.println(WiFi.dnsIP());
}

void loop() {
  // put your main code here, to run repeatedly:
}