#include <SPI.h>
#include <MFRC522.h>
//NodeMCU--------------------------
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WebServer.h>

#include <Servo.h>

//************************************************************************
#define SS_PIN  D4  
#define RST_PIN D3  
//servo
Servo servo1;
Servo servo2;

#define SERVO_PIN_1 D1
#define SERVO_PIN_2 D2
// LED pin
#define ld D0
//************************************************************************
MFRC522 mfrc522(SS_PIN, RST_PIN); // Create MFRC522 instance.
//************************************************************************
const char *ssid = "Deco";
const char *password = "Wifipassword1.";
const char* device_token  = "5";
//************************************************************************
String URL = "http://192.168.68.100/interface/ard/getdata.php";// edit ip
String getData, Link;
String OldCardID = "";
unsigned long previousMillis = 0;
ESP8266WebServer server(80);  // Create an instance of the server

//************************************************************************

//*********************************
void setup() {
  delay(1000);
  Serial.begin(115200);
  SPI.begin();
  mfrc522.PCD_Init();
  connectToWiFi();
  //servo
  servo1.attach(SERVO_PIN_1);
  servo2.attach(SERVO_PIN_2);

  servo1.write(0);
  servo2.write(0);
  pinMode(ld, OUTPUT);

  server.on("/interface/ard/getdata.php", HTTP_GET, handleRequest);

  // Start the server
  server.begin();


}
//************************************************************************
void loop() {
  if(!WiFi.isConnected()){
    connectToWiFi();    
  }
  //---------------------------------------------
  if (millis() - previousMillis >= 15000) {
    previousMillis = millis();
    OldCardID="";
  }
  delay(50);
  //---------------------------------------------
  //look for new card
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    return;
  }
  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;
  }
  String CardID ="";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    CardID += mfrc522.uid.uidByte[i];
  }
  //---------------------------------------------
  if( CardID == OldCardID ){
    return;
  }
  else{
    OldCardID = CardID;
  }
  //---------------------------------------------
//  Serial.println(CardID);
  SendCardID(CardID);
  delay(1000);
}
//************send the Card UID to the website*************
void SendCardID( String Card_uid ){
  Serial.println("Sending the Card ID");
  if(WiFi.isConnected()){
     WiFiClient wifiClient; 
    HTTPClient http;    
    //GET Data
    getData = "?card_uid=" + String(Card_uid) + "&device_token=" + String(device_token); // Add the Card ID to the GET array in order to send it
    //GET methode
    Link = URL + getData;
    http.begin(wifiClient,Link);
    int httpCode = http.GET();   
    String payload = http.getString();    

    Serial.println(Link);   
    Serial.println(httpCode);   
    Serial.println(device_token);   
    Serial.println(Card_uid);     
    Serial.println(payload);    

    if (httpCode == 200) {
    if (payload.substring(0, 3) == "Log") {
      Serial.println(payload);

      int servoNumber = payload.charAt(4) - '0';
      String action = payload.substring(6);

      if (servoNumber == 1) {
        if (action == "Open") {
          servo1.write(90);
          led();
        } else if (action == "Close") {
          servo1.write(0);
          led();
        }
      } else if (servoNumber == 2) {
        if (action == "Open") {
          servo2.write(90);
          led();
        } else if (action == "Close") {
          servo2.write(0);
          led();
        }
      } 
    } else if (payload == "successful") {
      led();
    } else if (payload == "available") {
      led();
    }
  }
  }
}

//
void handleRequest() {
  // Allow any origin to access this resource
  server.sendHeader("Access-Control-Allow-Origin", "*");
  server.send(200, "text/plain", "Hello from Arduino!");
}
//********************connect to the WiFi******************
void connectToWiFi(){
    WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
    delay(1000);
    WiFi.mode(WIFI_STA);
    Serial.print("Connecting to ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);
    
    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
    }
    Serial.println("");
    Serial.println("Connected to " + String(ssid));
  
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());  //IP address assigned to your ESP
    
    delay(1000);
}


void led(){

  digitalWrite(ld, HIGH);
  delay(1000);
  digitalWrite(ld, LOW);
  delay(1000);
    digitalWrite(ld, HIGH);
  delay(1000);
  digitalWrite(ld, LOW);
  delay(1000);


}