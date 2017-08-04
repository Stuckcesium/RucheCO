float getTemp() {
  // Wait a few seconds between measurements.
  delay(2000);
  float temp = dht.readTemperature();

  // Check if any reads failed and exit early (to try again).
  if (isnan(temp)) {
#ifdef DEBUG_DISPLAY
    Serial.println("Failed to read temp from DHT sensor!");
#endif
    temp = 0;
  }
#ifdef DEBUG_DISPLAY
  Serial.print("Temperature ambiante : ");
  Serial.println(temp);
#endif
  return temp;
}
