#!/usr/bin/python3
import socketserver
import MySQLdb
import time
import os
import threading
import RPi.GPIO as GPIO
GPIO.setmode(GPIO.BCM)

GPIO.setup(12, GPIO.IN, pull_up_down = GPIO.PUD_UP)
GPIO.setup(7, GPIO.IN, pull_up_down = GPIO.PUD_UP)
GPIO.setup(17, GPIO.IN, pull_up_down = GPIO.PUD_UP)

while True:
      print("PIR- ", GPIO.input(12))
      print("Intruder- ", GPIO.input(7))
      print("Fire- ", GPIO.input(17))
      time.sleep(1)
