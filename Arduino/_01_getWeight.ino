float getWeight(int p_rucheId, long p_coefZero[], float p_coefGain[]) {
#ifdef DEBUG_DISPLAY
  Serial.print("Début lecture poid pour ruche ");
  Serial.println(p_rucheId);

  Serial.print("coef zero : ");
  Serial.println(p_coefZero[p_rucheId - 1]);

  Serial.print("coef gain : ");
  Serial.println(p_coefGain[p_rucheId - 1]);
#endif

  case_scale(p_rucheId);
  scale.power_up();

  float weight = 0.0;

  delay(2000);
  scale.set_scale();
  scale.set_offset(p_coefZero[p_rucheId - 1]);
  scale.set_scale(p_coefGain[p_rucheId - 1]);
  delay(2000);

  weight = scale.get_units(10);
  weight = weight * 2;
  if (weight < 0.0){
    weight = 0.0;
  }
 
#ifdef DEBUG_DISPLAY
  Serial.print("\t| weight average fois 2:\t");
  Serial.println(weight);
#endif
  scale.power_down();
  return weight;

}

void case_scale(int p_rucheId) {
  Serial.println(p_rucheId);
  switch (p_rucheId) {
    case 1:
      scale.begin(A1, A0);
      break;
    case 2:
      scale.begin(A3, A2);
      break;
    case 3:
      scale.begin(A5, A4);
      break;
    case 4:
      scale.begin(A7, A6);
      break;
  }
}


