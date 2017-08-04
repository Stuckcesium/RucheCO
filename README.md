# RucheCO
Ruches connectées avec balance et transmission via réseau SIGFOX

Projet de balances connectées pour le pesage de ruches, transmission des données toutes les 25 min via le réseau Sigfox, 

# Le fonctionnement

Un arduino Mega va lire toutes les 25 min le poids de 6 balances ainsi que la temperature et l'humidité ambiante. 
une fois l'acquisition des données OK, les données sont envoyées à un serveur via le réseau Sigfox.



# Le matériel 

Arduino Mega : microcontrolleur 
DS3231 : Horloge RTC avec fonction d'alarme pour reveil et mise en veille de l'arduino.
HX711 : amplificateur pour les balances
HBM PW2C : capteur de poids
DHT22 : Capteur de temperature

# Schéma :


