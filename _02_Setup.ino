void setup() {

  Serial.begin(9600);

#ifdef CALIBRATE

  int balance = 3;
  initBalance(balance, coefZero);

#endif

  
  clock.begin();
  //arduino, ds3231, Wake, interrupts, wakeup, sleep,
  modificabyte(temp_buffer, 0); //call DS3231 byte modify routine
  clock.armAlarm1(false);
  clock.armAlarm2(false);
  clock.clearAlarm1();
  clock.clearAlarm2();
  //pinMode (4, OUTPUT); // alla porta 4 e' collegato il led che segnala lo stato di "sveglio"
  pinMode(pin_wake, INPUT); //pin 2 for alarm from ds3231

  attachInterrupt(digitalPinToInterrupt(pin_wake), wakeup, FALLING); // attiva l’interrupts - enable intrrupts
  clock.setDateTime(2017, 02, 10, 11, 00, 00); // init horloge pour la 1ere sequence avec une dummy date,
  theminute = interval; // défini la 1ere alarme dans un 1 interval
  dht.begin(); // initialise DHT22

  SigFox.begin(9600);

  delay(2000);
  dt = clock.getDateTime(); // get time form DS3231
  sprintf(print_date, "%02d/%02d/%d %02d:%02d:%02d", dt.day, dt.month, dt.year, dt.hour, dt.minute, dt.second); //display sleeping time
   // execute main avant d'aller en veille pour la 1ere fois
  mainprog();

}
