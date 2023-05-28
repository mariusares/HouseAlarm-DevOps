#!/usr/bin/python3
import Adafruit_DHT
sensor = Adafruit_DHT.AM2302
#pin = 4

def get_temperature(pin):
    """_summary_

    Args:
        pin (_type_): integer Digital Raspberry Pi Pin

    Returns:
        float temp and humi, representing the temperature and humidity read by the sensor
    """
    humidity, temperature = Adafruit_DHT.read_retry(sensor, pin)
    temp =  round(float(temperature), 2)
    humi =  round(float(humidity), 3)
    return (temp, humi)
