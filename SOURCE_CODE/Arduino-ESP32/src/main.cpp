// Viral Science www.youtube.com/c/viralscience  www.viralsciencecreativity.com
// Secret Knock Pattern Door Lock
#include <Arduino.h>
#include "FS.h"
#include <EEPROM.h>
#include <WiFi.h>
#include <ESP32Ping.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <time.h>
#include <math.h> // Math!

// Storage configuration
const int EEPROM_SIZE = 20;

// Arduino I/O configuration
const int knockSensor = 36;
const int programSwitch = 39;
const int lockMotor = 32;
const int redLED = 12;
const int greenLED = 13;
const int voltageInput = 35;

float vin = 0.0;
float baterai = 0.0;
int valueVoltage = 0;
int batteryInterval = 3000;

int startTime_battery = millis();
int now_battery = millis();

// Arduino software configuration
// const int threshold = 1900;
const int threshold = 300;
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
int signalPressed = 0;

void listenToSecretKnock();
void triggerDoorUnlock();
boolean validateKnock();

// WiFi configuration
String wifiSSID = "-";
String wifiPassword = "08080808";
String googleDotCom = "www.google.com";
const IPAddress routerIp(192, 168, 100, 1);

int timeOut = 8000;      // milliseconds
int tryConnect = 100000; // milliseconds
int startTime_loop = millis();
int now_loop = millis();
int get_interval = 500;

void connectWifi();
void reConnectWifi();

// Time configuration
const char *ntpServer = "pool.ntp.org";
const long gmtOffset_sec = 25200;
const int daylightOffset_sec = 0;
char localTime[30];

void printLocalTime();

// Randomizer
int randBatt;

// API configuration
int getHttp();
void postHttpInsertRiwayat(int stat);
void postHttpUpdateBaterai();
void postHttpUpdatePolaKunci();

// Main Program
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
  pinMode(voltageInput, INPUT);

  Serial.begin(115200);
  Serial.println("Program start.");

  digitalWrite(greenLED, HIGH);
  connectWifi();
  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
  printLocalTime();
  getHttp();
}

void loop()
{
  now_battery = millis();
  if (now_battery - startTime_battery >= batteryInterval)
  {
    valueVoltage = analogRead(voltageInput);
    vin = float(valueVoltage) / 4096 * 5;
    baterai = -96.63 * pow(vin, 3) + 999.34 * pow(vin, 2) - 3278.71 * vin + 3400.59;

    if (vin < 3.4)
    {
      baterai = 0;
    }
    Serial.print("INPUT V = ");
    Serial.print(vin, 2);
    Serial.print(" volt");
    Serial.print("\tBaterai = ");
    Serial.print(baterai, 2);
    Serial.println(" %");
    startTime_battery = millis();
    postHttpUpdateBaterai();
  }

  knockSensorValue = analogRead(knockSensor);
  // getHttp();
  // Serial.println(knockSensorValue);

  now_loop = millis();
  if (now_loop - startTime_loop >= get_interval){
    signalPressed = getHttp();
    Serial.println(signalPressed);
    startTime_loop = millis();
  }

  if (digitalRead(programSwitch) == HIGH || signalPressed == 1)
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

  if (WiFi.status() != WL_CONNECTED)
  {
    reConnectWifi();
  }
  
}

// Function and Procedure Definitions
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
  postHttpInsertRiwayat(1);
}

void listenToSecretKnock()
{
  Serial.println("knock starting");
  // postHttp();

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
      // postHttp();
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
      digitalWrite(greenLED, LOW);
      for (i = 0; i < 4; i++)
      {
        digitalWrite(redLED, HIGH);
        delay(100);
        digitalWrite(redLED, LOW);
        delay(100);
      }
      digitalWrite(greenLED, HIGH);
      postHttpInsertRiwayat(0);
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

void postHttpInsertRiwayat(int stat)
{
  Serial.println("Posting...");
  printLocalTime();
  String url = "http://192.168.137.236/esp32-test/api/api.php?data=insert_riwayat";
  HTTPClient http;
  String response;

  StaticJsonDocument<200> buff;
  String jsonParams;

  randBatt = random(0, 100);

  buff["id_perangkat"] = String(1);
  buff["datetime"] = String(localTime);
  if (stat == 0)
  {
    buff["status"] = String(0);
  }
  else
  {
    buff["status"] = String(1);
  }

  serializeJson(buff, jsonParams);
  // Serial.println(jsonParams);

  http.begin(url);
  // http.addHeader("Content-Type", "application/json");
  // delay(4000);
  int statusCode = http.POST(jsonParams);
  response = http.getString();

  if (statusCode == 200)
  {
    Serial.println("Post Method Success!");
    Serial.println("id_perangkat : " + String(1));
    Serial.println("datetime : " + String(localTime));
    Serial.println("status : " + String(stat));
  }
  else
  {
    Serial.println("Post Method Failed!");
  }

  // Serial.println(response);
  // Serial.println(statusCode);
}

void postHttpUpdateBaterai()
{
  Serial.println("Posting...");
  String url = "http://192.168.137.236/esp32-test/api/api.php?data=update_baterai";
  HTTPClient http;
  String response;

  StaticJsonDocument<200> buff;
  String jsonParams;

  randBatt = random(0, 100);

  buff["id_master"] = String(1);
  buff["kapasitas_baterai"] = String(baterai);

  serializeJson(buff, jsonParams);
  // Serial.println(jsonParams);

  http.begin(url);
  // http.addHeader("Content-Type", "application/json");
  int statusCode = http.POST(jsonParams);
  response = http.getString();

  if (statusCode == 200)
  {
    Serial.println("Post Method Success!");
    Serial.println("Batt : " + String(randBatt));
  }
  else
  {
    Serial.println("Post Method Failed!");
  }

  // Serial.println(response);
  // Serial.println(statusCode);
}

void postHttpUpdatePolaKunci()
{
  Serial.println("Posting...");
  String url = "http://192.168.137.236/esp32-test/api/api.php?data=update_pola_kunci";
  HTTPClient http;
  String response;

  StaticJsonDocument<200> buff;
  String jsonParams;

  randBatt = random(0, 100);

  buff["id"] = String(1);
  buff["kapasistas_baterai"] = String(randBatt);

  serializeJson(buff, jsonParams);
  // Serial.println(jsonParams);

  http.begin(url);
  // http.addHeader("Content-Type", "application/json");
  int statusCode = http.POST(jsonParams);
  response = http.getString();

  if (statusCode == 200)
  {
    Serial.println("Post Method Success!");
    Serial.println("Batt : " + String(randBatt));
  }
  else
  {
    Serial.println("Post Method Failed!");
  }

  // Serial.println(response);
  // Serial.println(statusCode);
}

int getHttp()
{
  String url = "http://192.168.137.236/esp32-test/api/api.php?data=get_pressed";
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

  // Serial.println(data);
  // Serial.println(support);

  StaticJsonDocument<1024> doc2;
  deserializeJson(doc2, data);
  JsonObject obj2 = doc2.as<JsonObject>();

  String id = obj2[String("IS_PRESSED")];

  // Serial.println("is_pressed adalah " + id);
  return id.toInt();
}

void connectWifi()
{
  // Serial.println("Connecting to Wifi..");
  // WiFi.begin(wifiSSID.c_str(), wifiPassword.c_str());
  // int startTime = millis();
  // int now = millis();
  // while (WiFi.status() != WL_CONNECTED)
  // {
  //   Serial.print(".");
  //   if (now - startTime >= timeOut)
  //   {
  //     Serial.print("Failed to connect");
  //     break;
  //   }
  //   now = millis();
  //   delay(500);
  // }

  Serial.println("Smart Config Mode");
  WiFi.mode(WIFI_AP_STA);
  WiFi.beginSmartConfig();

  while (!WiFi.smartConfigDone())
  {
    Serial.print("-");
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

void reConnectWifi()
{
  if (now_loop - startTime_loop > tryConnect)
  {
    startTime_loop = millis();
    connectWifi();
  }
  now_loop = millis();
}

void printLocalTime()
{
  struct tm timeinfo;
  if (!getLocalTime(&timeinfo))
  {
    Serial.println("Failed to obtain time");
    return;
  }
  strftime(localTime, 30, "%F %T.000000", &timeinfo);
  Serial.println(localTime);
}
