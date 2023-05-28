#!/usr/bin/python3
import socketserver
import MySQLdb
import time
import os
import threading
import smtplib
import email
from datetime import datetime
from lib.dht import *
import RPi.GPIO as GPIO
GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False) 

host = "localhost"
user = "dbuser"
passwd = "dbpassword"
db = "security"

system_alarm = 0
silent = "yes"
connection = MySQLdb.connect(host, user, passwd, db)
cursor = connection.cursor()
time_now = datetime.now().strftime('%d-%m-%Y %H:%M')
trigger = 0
message = ""
tempdata = ""
sensor_id = 0
total_sensors = 0
email_address = []
sensor_name = []
sensor_type = []
sensor_pin = []
sensor_status = []
alarm_temp = []
email_data = []
GPIO.setup(16, GPIO.OUT)
GPIO.output(16, GPIO.LOW)
def get_db_data():
    cursor.execute("SELECT email FROM users")
    records = cursor.fetchall()
    for row in records:
        email_address.append(row)

def get_sensors():
    global sensor_name
    global sensor_type
    global sensor_pin
    sensor_name = []
    sensor_type = []
    sensor_pin = []
    cursor.execute("SELECT * FROM sensors")
    records = cursor.fetchall()
    for row in records:
        sname = str(row[1])
        sensor_name.append(sname)
        stype = str(row[2])
        sensor_type.append(stype)
        spin = str(row[3])
        sensor_pin.append(spin)
    print("Sensors names in the database :" +str(sensor_name)) 
def alarm_reset():
    global trigger
    global system_alarm
    global silent
    cursor.execute("SELECT status, silent FROM status ORDER BY id DESC LIMIT 1;")
    records = cursor.fetchall()
    for row in records:
        silent = row[1]
        print(row[0])
        if row[0] == "Armed":
           system_alarm = 1
           trigger = 0
        elif row[0] == "Unset":
           system_alarm = 0
           trigger = 0
           GPIO.output(16, GPIO.LOW) #turn speaker off
           print("system unset")
        else:
           pass

def get_email_data():
    global email_data
    cursor.execute("SELECT * FROM alert")
    records = cursor.fetchall()
    for row in records:
        email_data.append
        email_server = row[1]
        email_port = row[2]
        email_login = row[3]
        email_password = row[4]
    email_data = [email_server, email_port, email_login, email_password]
    print("alarm email settings :" +str(email_data)) 
    return email_data
get_email_data()
get_db_data()
get_sensors()

def send_email(receiver, message):
    email_body = message+ "\nPlease Check your alarm system\nThank you"
    msg = ("From: %s\r\nTo: %s\r\nSubject: %s\r\n"
           % (email_data[2], receiver, message))
    msg = msg + email_body
    s = smtplib.SMTP(email_data[0], email_data[1])
    s.starttls()
    s.login(email_data[2], email_data[3])
    s.sendmail(email_data[2], receiver, msg)
    s.close()
def update_data(sensor_status2):
    global sensor_status
    if len(sensor_status2) == len(sensor_pin):
       sensor_status = []
       sensor_status = sensor_status2
def setup_gpios():
    for i in range (0,len(sensor_name)):
        if sensor_type[i] != "temp":
           #print(sensor_pin[i])
           GPIO.setup(int(sensor_pin[i]), GPIO.IN, pull_up_down = GPIO.PUD_UP)
def speaker(silent1):
    if silent1 == "yes":
       GPIO.output(16, GPIO.HIGH)
    else:
       GPIO.output(16, GPIO.LOW)
def trigger_status():
    global trigger
    if system_alarm > 0:
       trigger = 1
    else:
       trigger = 0
def check_gpios():
    global trigger
    global message
    global tempdata
    global system_alarm
    if trigger < 1:
          sensor_status2 = []
          for i in range (0,len(sensor_name)):
              if sensor_type[i] != "temp" and sensor_type[i] != "Fire" and GPIO.input(int(sensor_pin[i])) == 1:
                 alarm = sensor_type[i]+" "+sensor_name[i]+" -> Alarm"
                 sensor_status2.append(alarm)
                 update_data(sensor_status2)
                 trigger_status()
                 if trigger > 0:
                    for x in range (0, len(email_address)):
                        smail = email_address[x]
                        send_email(smail, alarm)
                        speaker(silent)
                 #print(alarm)
              elif sensor_type[i] != "temp" and sensor_type[i] != "Fire" and GPIO.input(int(sensor_pin[i])) == 0:
                  alarm = sensor_type[i]+" "+sensor_name[i]+" -> OK"
                  sensor_status2.append(alarm)
                  update_data(sensor_status2)
                 #print(sensor_status2)
              elif sensor_type[i] == "Fire" and GPIO.input(int(sensor_pin[i])) == 1:
                  alarm = sensor_type[i]+" "+sensor_name[i]+" -> OK"
                  sensor_status2.append(alarm)
                  update_data(sensor_status2)
              elif sensor_type[i] == "Fire" and GPIO.input(int(sensor_pin[i])) == 0:
                  alarm = sensor_type[i]+" "+sensor_name[i]+" -> Alarm"
                  sensor_status2.append(alarm)
                  update_data(sensor_status2)
                  trigger_status()
                  if trigger > 0:
                     for x in range (0, len(email_address)):
                         smail = email_address[x]
                         send_email(smail, alarm)
                         speaker(silent)
              else:
                 tempdata = get_temperature(sensor_pin[i])
                 tempdata = sensor_name[i]+"-> Temperature:" +str(tempdata[0])+"&#8451; Humidity: "+str(tempdata[1])+"%"
                 sensor_status2.append(tempdata)
                 update_data(sensor_status2)
    else:
          print("Sensors status" +str(sensor_status))
          print("trigger: " +str(trigger), silent, "Speaker", GPIO.input(16))
          pass
def check_temperature():
    global alarm_temp
    if trigger > 0:
          alarm_temp = []
          for i in range (0,len(sensor_type)):
              if sensor_type[i] == "temp":
                 tempdata = get_temperature(sensor_pin[i])
                 tempdata = sensor_name[i]+"-> Temperature:" +str(tempdata[0])+ "&#8451; Humidity: "+str(tempdata[1])+"%"
                 alarm_temp.append(tempdata)
                 return alarm_temp
def return_data():
   if len(sensor_status) == len(sensor_pin):
      return sensor_status
def alarm_run():
    check_gpios()
    time_now = datetime.now().strftime('%d-%m-%Y %H:%M')
    threading.Timer(1, alarm_run).start()
setup_gpios()
alarm_run()
alarm_reset()
