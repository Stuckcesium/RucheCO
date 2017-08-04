// ********************** Set DS3121 SQW control bytes **********************************

void modificabyte (byte control, bool which) // update DS3121 RTC control bytes
{
  Wire.beginTransmission(0x68);
  if (which) // which=false -> 0x0e, true->0x0f.
    Wire.write(0x0f);
  else
    Wire.write(0x0e);
  Wire.write(control);
  Wire.endTransmission();
}

// *************wake routine, activated on interrupt from ds3231 ****************************
//
void wakeup()
{
  sleep_disable(); // désactive le sleep
}

// ****************************** asleep routine ******************************************

void sleep()
{
  Serial.print("Begin sleep.... ");

  dt = clock.getDateTime(); //get time form DS3231
  sprintf(print_date, "%02d/%02d/%d %02d:%02d:%02d", dt.day, dt.month, dt.year, dt.hour, dt.minute, dt.second); //display sleeping time on serial monitor

  sleep_enable(); // activer l'endormissement
  delay(100);

  set_sleep_mode(SLEEP_MODE_PWR_DOWN); //Select "power down mode" to maximize energy saving
  cli(); // disable interrupts
  //sleep_bod_disable(); // (brown out detection)
  sei(); // enable interrupts
  sleep_cpu(); //sleep mode on cpu

  // ****************************arduino wake up here *****************************************

  clock.clearAlarm1(); // clear alarme pour éviter les interrupt indesirables
  Serial.print("working.. ");
  dt = clock.getDateTime(); // get time form DS3231
  sprintf(print_date, "%02d/%02d/%d %02d:%02d:%02d", dt.day, dt.month, dt.year, dt.hour, dt.minute, dt.second);
  Serial.println(print_date);

  theminute = dt.minute + interval;

  if ( theminute > 59 ) {
    theminute = theminute - 60;
  }
}


