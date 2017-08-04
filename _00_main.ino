void mainprog() {

  float temp = getTemp();
  //récupération humidité
  float hum = getHumidity();
  //récupération poids

  for (int i = 1 ; i <= nbMaxRuche ; i++) {

    rucheID = i;
#ifdef DEBUG_DISPLAY
    Serial.println("**************************************************");
    sprintf (buffer, "Début de traitement pour la ruche : %d ", rucheID);
    Serial.println(buffer);
#endif

    tab_weight[rucheID - 1] = getWeight(rucheID, coefZero, coefGain);
#ifdef DEBUG_DISPLAY
    sprintf (buffer, "Fin de traitement pour la ruche : %d ", rucheID);
    Serial.println(buffer);
    Serial.println("**************************************************");
#endif
  }

  sigfoxSendData(tab_weight, hum, temp, nbMaxRuche);

}


