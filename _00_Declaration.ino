#include "DHT.h"
#include <Wire.h>
#include <DS3231.h> // Libreria ds3231, https://github.com/jarzebski/Arduino-DS3231
#include <avr/sleep.h> 
#include <SoftwareSerial.h>
#include <HX711.h> //bodge

// décommenter pour passer en mode développement
#define DEBUG_DISPLAY
#define SigFox Serial2

const int nbMaxRuche = 4;
char buffer [50];
int rucheID;

//--------------- Pour calibrage balance-------------------------
//#define CALIBRATE
//---------------------------------------------------------------

//--------------- DHT 22 Capteur de temperature -----------------
#define DHTPIN 9     // what digital pin we're connected to
#define DHTTYPE DHT22   // DHT 22
DHT dht(DHTPIN, DHTTYPE);
//---------------------------------------------------------------

//--------------- Balance ---------------------------------------
long coefZero[nbMaxRuche] = {27000, 27560, 40200, 10300};
float coefGain[nbMaxRuche] = {64520.00, 64100.00, 63650.00, 65500.00};
float tab_weight[nbMaxRuche] = {0.0, 0.0, 0.0, 0.0};
HX711 scale;
//---------------------------------------------------------------

//--------------------SIGFOX-----------------------------------

  typedef struct s_payload1 {
    int8_t trame;
    int16_t temperature;
    uint16_t humidity;
    uint16_t p1;
    uint16_t p2;
    uint16_t p3;
  };

  typedef struct s_payload2 {
    int8_t trame;
    int16_t temperature;
    uint16_t humidity;
    uint16_t p4;
    uint16_t p5;
    uint16_t p6;
  };

  union payload1_u
  {
    s_payload1 data;
    uint8_t rawData[sizeof(s_payload1)];
  } t_payload1;


  union payload2_u
  {
    s_payload2 data;
    uint8_t rawData[sizeof(s_payload2)];
  } t_payload2;


//-------------------------DS3231-------------------------------
DS3231 clock;
RTCDateTime dt;
const byte pin_wake = 18;//pin used for alarm clock
byte temp_buffer = 0b11110111; //Byte to disable SQW pin of DS3231, not logical yes, but without that the Arduino doesn't go to sleep mode even the first time
char print_date[16]; // Actual time repository
uint8_t theminute;
const int interval = 25; //interval de reveil en minute
//--------------------------------------------------------------


