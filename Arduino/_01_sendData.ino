void sigfoxSendData(float p_tab_weight[], float p_humidity, float p_temp, int p_nbMaxRuche) {
  Serial.println("Debut envoi");
  
  // on initialise avec des valeurs reconnnaissables
  t_payload1.data.trame = 1;
  t_payload1.data.temperature = t_payload2.data.temperature = p_temp * 10;
  t_payload1.data.humidity = t_payload2.data.humidity = p_humidity * 10;
  t_payload1.data.p1 = p_tab_weight[0] * 100;
  t_payload1.data.p2 = p_tab_weight[1] * 100;
  t_payload1.data.p3 = p_tab_weight[2] * 100;
  t_payload2.data.trame = 2;
  t_payload2.data.p4 = p_tab_weight[3] * 100;
  t_payload2.data.p5 = 0; //p_tab_weight[4] * 100;
  t_payload2.data.p6 = 0; //p_tab_weight[5] * 100;


  /*
    t_payload1.data.trame = 1;
    t_payload1.data.temperature = t_payload2.data.temperature = 20.3 * 10;
    t_payload1.data.humidity = t_payload2.data.humidity = 523;
    t_payload1.data.p1 = 1111;
    t_payload1.data.p2 = 2222;
    t_payload1.data.p3 = 3333;
    t_payload2.data.trame = 2;
    t_payload2.data.p4 = 4444;
    t_payload2.data.p5 = 5555;

  */
  Serial.println(t_payload1.data.p1);

  SigFox.print("AT$SF=");

  for (byte i = 0; i < sizeof(t_payload1); i++) {
    if (t_payload1.rawData[i] <= 0xF) SigFox.print("0"); // pour bien avoir 2 caractères
    //Serial.println(t_payload1.rawData[i], DEC);
    //Serial.println(t_payload1.rawData[i], HEX);
    SigFox.print(t_payload1.rawData[i], HEX);

  }
  SigFox.print("\r");
  Serial.println(sizeof(t_payload1));
  delay (3000);
  SigFox.print("AT$SF=");

  for (byte i = 0; i < sizeof(t_payload2); i++) {
    if (t_payload2.rawData[i] <= 0xF) SigFox.print("0"); // pour bien avoir 2 caractères
    SigFox.print(t_payload2.rawData[i], HEX);
  }
  SigFox.print("\r");

}

