// Viral Science www.youtube.com/c/viralscience  www.viralsciencecreativity.com
// Secret Knock Pattern Door Lock
#include <Arduino.h>
#include "FS.h"
#include <EEPROM.h>
#include <WiFi.h>
#include <ESP32Ping.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

const int EEPROM_SIZE = 20;

const int knockSensor = 36;
const int programSwitch = 39;
const int lockMotor = 32;
const int redLED = 12;
const int greenLED = 13;

const int threshold = 1900;
const int rejectValue = 25;
const int averageRejectValue = 15;
const int knockFadeTime = 150;
const int lockTurnTime = 2000;

const int maximumKnocks = 20;
const int knockComplete = 1200;

int secretCode[maximumKnocks] = {100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
int knockReadings[maximumKnocks];
int knockSensorValue = 0;
int programButtonPressed = false;

String wifiSSID = "KOSAN PAK MAMAN";
String wifiPassword = "gegerarum22";
const IPAddress routerIp(192, 168, 100, 1);
String googleDotCom = "www.google.com";

int randTemp, randHum;

void listenToSecretKnock();
void triggerDoorUnlock();
boolean validateKnock();

void connectWifi();
void getHttp();
void postHttp();

void setup()
{
  EEPROM.begin(EEPROM_SIZE);

  int i = 0;
  for (i = 0; i < maximumKnocks; i++)
  {
    secretCode[i] = EEPROM.read(i);
  }

  pinMode(lockMotor, OUTPUT);
  pinMode(redLED, OUTPUT);
  pinMode(greenLED, OUTPUT);
  pinMode(programSwitch, INPUT);

  Serial.begin(115200);
  Serial.println("Program start.");

  digitalWrite(greenLED, HIGH);
  connectWifi();
  getHttp();
}

void loop()
{
  knockSensorValue = analogRead(knockSensor);
  // Serial.println(knockSensorValue);

  if (digitalRead(programSwitch) == HIGH)
  {
    programButtonPressed = true;
    digitalWrite(redLED, HIGH);
  }
  else
  {
    programButtonPressed = false;
    digitalWrite(redLED, LOW);
  }

  if (knockSensorValue >= threshold)
  {
    listenToSecretKnock();
  }
}

boolean validateKnock()
{
  int i = 0;

  int currentKnockCount = 0;
  int secretKnockCount = 0;
  int maxKnockInterval = 0;

  for (i = 0; i < maximumKnocks; i++)
  {
    if (knockReadings[i] > 0)
    {
      currentKnockCount++;
    }
    if (secretCode[i] > 0)
    {
      secretKnockCount++;
    }

    if (knockReadings[i] > maxKnockInterval)
    {
      maxKnockInterval = knockReadings[i];
    }
  }

  if (programButtonPressed == true)
  {
    for (i = 0; i < maximumKnocks; i++)
    {
      secretCode[i] = map(knockReadings[i], 0, maxKnockInterval, 0, 100);
      EEPROM.write(i, secretCode[i]);
      Serial.print(knockReadings[i]);
      Serial.print(" ");
    }
    digitalWrite(greenLED, LOW);
    digitalWrite(redLED, LOW);
    delay(1000);
    digitalWrite(greenLED, HIGH);
    digitalWrite(redLED, HIGH);
    delay(50);
    for (i = 0; i < maximumKnocks; i++)
    {
      digitalWrite(greenLED, LOW);
      digitalWrite(redLED, LOW);

      if (secretCode[i] > 0)
      {
        delay(map(secretCode[i], 0, 100, 0, maxKnockInterval));
        digitalWrite(greenLED, HIGH);
        digitalWrite(redLED, HIGH);
      }
      delay(50);
    }

    EEPROM.commit();
    return false;
  }

  if (currentKnockCount != secretKnockCount)
  {
    return false;
  }
  int totaltimeDifferences = 0;
  int timeDiff = 0;
  for (i = 0; i < maximumKnocks; i++)
  {
    knockReadings[i] = map(knockReadings[i], 0, maxKnockInterval, 0, 100);
    timeDiff = abs(knockReadings[i] - secretCode[i]);
    if (timeDiff > rejectValue)
    {
      return false;
    }
    totaltimeDifferences += timeDiff;
  }
  if (totaltimeDifferences / secretKnockCount > averageRejectValue)
  {
    return false;
  }

  return true;
}

void triggerDoorUnlock()
{
  Serial.println("Door unlocked!");
  postHttp();
  int i = 0;

  digitalWrite(lockMotor, HIGH);
  digitalWrite(greenLED, HIGH);

  delay(lockTurnTime);

  digitalWrite(lockMotor, LOW);

  for (i = 0; i < 5; i++)
  {
    digitalWrite(greenLED, LOW);
    delay(100);
    digitalWrite(greenLED, HIGH);
    delay(100);
  }
}

void listenToSecretKnock()
{
  Serial.println("knock starting");
  //postHttp();

  int i = 0;
  for (i = 0; i < maximumKnocks; i++)
  {
    knockReadings[i] = 0;
  }

  int currentKnockNumber = 0;
  int startTime = millis();
  int now = millis();

  digitalWrite(greenLED, LOW);
  if (programButtonPressed == true)
  {
    digitalWrite(redLED, LOW);
  }
  delay(knockFadeTime);
  digitalWrite(greenLED, HIGH);
  if (programButtonPressed == true)
  {
    digitalWrite(redLED, HIGH);
  }
  do
  {
    knockSensorValue = analogRead(knockSensor);
    if (knockSensorValue >= threshold)
    {
      Serial.println("knock.");
      //postHttp();
      now = millis();
      knockReadings[currentKnockNumber] = now - startTime;
      currentKnockNumber++;
      startTime = now;
      digitalWrite(greenLED, LOW);
      if (programButtonPressed == true)
      {
        digitalWrite(redLED, LOW);
      }
      delay(knockFadeTime);
      digitalWrite(greenLED, HIGH);
      if (programButtonPressed == true)
      {
        digitalWrite(redLED, HIGH);
      }
    }

    now = millis();

  } while ((now - startTime < knockComplete) && (currentKnockNumber < maximumKnocks));

  if (programButtonPressed == false)
  {
    if (validateKnock() == true)
    {
      triggerDoorUnlock();
    }
    else
    {
      Serial.println("Secret knock failed.");
      postHttp();
      digitalWrite(greenLED, LOW);
      for (i = 0; i < 4; i++)
      {
        digitalWrite(redLED, HIGH);
        delay(100);
        digitalWrite(redLED, LOW);
        delay(100);
      }
      digitalWrite(greenLED, HIGH);
    }
  }
  else
  {
    validateKnock();
    Serial.println("New lock stored.");
    digitalWrite(redLED, LOW);
    digitalWrite(greenLED, HIGH);
    for (i = 0; i < 3; i++)
    {
      delay(100);
      digitalWrite(redLED, HIGH);
      digitalWrite(greenLED, LOW);
      delay(100);
      digitalWrite(redLED, LOW);
      digitalWrite(greenLED, HIGH);
    }
  }
}

void postHttp()
{
  Serial.println("Posting...");
  String url = "http://192.168.100.59/esp32/api/api.php?data=insert";
  HTTPClient http;
  String response;

  StaticJsonDocument<200> buff;
  String jsonParams;

  randTemp = random(30, 50);
  randHum = random(40, 80);

  buff["temp"] = String(randTemp);
  buff["hum"] = String(randHum);

  serializeJson(buff, jsonParams);
  // Serial.println(jsonParams);

  http.begin(url);
  // http.addHeader("Content-Type", "application/json");
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

void getHttp()
{
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

void connectWifi()
{
  Serial.println("Connecting to Wifi..");
  WiFi.begin(wifiSSID.c_str(), wifiPassword.c_str());
  while (WiFi.status() != WL_CONNECTED)
  {
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