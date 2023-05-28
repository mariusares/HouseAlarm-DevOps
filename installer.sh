#!/bin/bash

cmd="apt install -y "
cmd+="apache2 libapache2-mod-php7.4 phpmyadmin mariadb-client mariadb-server hostapd dnsmasq "
cmd+="python3-pip python3-socketio python3-mysqldb screen"
$cmd
cmd2="git clone https://github.com/adafruit/Adafruit_Python_DHT.git"
$cmd2
py="pip install RPi.GPIO"
$py
if grep -R "interface wlan0" /etc/dhcpcd.conf
then
   echo "Dhcpd Configured"
else
   echo "interface wlan0" >> /etc/dhcpcd.conf
   echo  "static ip_address=192.168.4.1/24" >> /etc/dhcpcd.conf
   echo "nohook wpa_supplicant" >> /etc/dhcpcd.conf
fi
if grep -R "www-data" /etc/sudoers
then
   echo "Sudoers cofigured"
else
echo "%www-data ALL=(ALL) NOPASSWD: /usr/bin/timedatectl, /sbin/iwlist, /sbin/reboot, \
/bin/systemctl enable hostapd, /bin/systemctl disable hostapd, /bin/systemctl enable dnsmasq, \
/bin/systemctl disable dnsmasq, /etc/init.d/hostapd, /etc/init.d/dnsmasq" >> /etc/sudoers
fi
echo -e "\ny\ny\mypassword\mypassword\ny\ny\ny\ny" | /usr/bin/mysql_secure_installation
echo "setting up database"
mysql < security.sql
echo "setting up permisions"
touch /etc/hostapd/hostapd.conf && chown www-data:www-data /etc/hostapd/hostapd.conf
chown www-data:www-data /etc/network/interfaces
chown www-data:www-data /etc/wpa_supplicant/wpa_supplicant.conf
echo "Installing web files"
cp -r web/* /var/www/html
echo "Installing Alarm System"
cp -r python_server /root
screen -Sdm server /root/main.py
echo "Done. The House Alarm System is ready!"
