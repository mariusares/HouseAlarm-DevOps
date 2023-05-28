#!/usr/bin/python3
import smtplib
import email
import signal
import os
import MySQLdb
receiver = "mariusares@gmail.com"
message = "test email"
email_data = ["mail.robofarm.ro", "587", "alarm@robofarm.ro", "AlarmSystem2023"]
email_subject = "test email TO"
def send_email(receiver, message):
    msg = ("From: %s\r\nTo: %s\r\nSubject: %s\r\n"
           % (email_data[2], receiver, email_subject))
    msg = msg + message

    s = smtplib.SMTP(email_data[0], email_data[1])
    s.starttls()
    s.login(email_data[2], email_data[3])
    s.sendmail(email_data[2], receiver, msg)
    s.close()
    os.kill(os.getpid(), signal.SIGTERM)

send_email(receiver, message)
