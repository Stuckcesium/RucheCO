#ifdef CALIBRATE

void initBalance(int p_rucheId, long p_coefZero[]) {

  case_scale(4);


  float   SCALE =     false;  //Set to 'false' on your first try, then enter your calibration factor
  long    OFFSET =    false; //Set to 'false' if you dont know your offset / zero factor.
  //float   SCALE =     64520.00;  //Set to 'false' on your first try, then enter your calibration factor
  //long    OFFSET =    20000; //Set to 'false' if you dont know your offset / zero factor.

  //ne rien mettre sur la balance lire la valeur affichée par le offset, mettre un poids connu sur la balance faire + et - pour arriver au poids de la bouteille de coca

  Serial.println("HX711 calibration sketch");
  Serial.println("Remove all weight from scale");
  Serial.println("After readings begin, place known weight on scale");
  Serial.println("Press +, l, m, n, (10, 100, 1000, 10000) to increase calibration factor");
  Serial.println("Press q, s, d (-10, -100, -1000) to decrease calibration factor");
  Serial.println("Press t to tare and set scale to zero");


  scale.set_scale();

  long zero_factor = scale.read_average(); //Get a baseline reading
  Serial.print("Zero factor / OFFSET: "); //This can be used to remove the need to tare the scale. Useful in permanent scale projects.
  Serial.println(zero_factor);
  zero_factor = scale.read_average(); //Get a baseline reading
  Serial.print("Zero factor / OFFSET: "); //This can be used to remove the need to tare the scale. Useful in permanent scale projects.
  Serial.println(zero_factor);

  if (OFFSET) {
    scale.set_offset(OFFSET); //set offset
  } else {
    scale.tare(); //Else reset scale to zero
  }

  do
  {


    if (SCALE) {
      scale.set_scale(SCALE);
    }
    Serial.print("Reading: ");
    Serial.print(scale.get_units(5), 5);
    Serial.print(" weight");
    Serial.print(" calibration_factor: ");
    Serial.print(SCALE, 5);
    Serial.println();

    if (Serial.available())
    {
      char tmp = Serial.read();
      if (tmp == '+' || tmp == 'k')
        SCALE += 10;
      else if (tmp == 'l')
        SCALE += 100;
      else if (tmp == 'm')
        SCALE += 1000;
      else if (tmp == 'n')
        SCALE += 10000;
      else if (tmp == '-' || tmp == 'q')
        SCALE -= 10;
      else if (tmp == 's')
        SCALE -= 100;
      else if (tmp == 'd')
        SCALE -= 1000;

      else if (tmp == 't') {
        scale.tare();
        SCALE = 0.00;
      }
    }
    // statement block
  } while (1 == 1);
}

#endif
