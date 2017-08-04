float getHumidity() {
  // Wait a few seconds between measurements.
  delay(2000);
  float humidity = dht.readHumidity();

  // Check if any reads failed and exit early (to try again).
  if (isnan(humidity)) {
#ifdef DEBUG_DISPLAY
    Serial.println("Failed to read humidity from DHT sensor!");
#endif
    humidity = 0;

  }
#ifdef DEBUG_DISPLAY
  Serial.print("Humidité ambiante : ");
  Serial.println(humidity);
#endif

  return humidity;

}
