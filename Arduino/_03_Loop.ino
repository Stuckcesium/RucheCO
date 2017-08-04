void loop() {

  Serial.print("prochain reveil a la minute : ");
  Serial.println(theminute);

  Serial.println(print_date);
  clock.setAlarm1(0, 0, theminute, 0, DS3231_MATCH_M_S); // set alarm a chaque fois que theminute match avec l'heure du ds3231
  delay (100);
  sleep(); //call sleep routine
  // ********** Arduino return in loop section here, after woke
  
  mainprog();
}

