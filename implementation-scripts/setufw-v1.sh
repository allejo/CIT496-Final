#!/bin/bash

echo "This file is being executed from $PATH"

#DENY / INCOMING / * / Webserver
sudo ufw default deny

#Log all UFW events
sudo ufw logging on

#HTTP & Apache
sudo ufw allow 80

#HTTPS
sudo ufw allow 443

#SSH
sudo ufw allow 22

#Outgoing traffic to any address from specific subnet - We know it can be a little dangerous but we're all about the adventure
sudo ufw default allow outgoing from 10.42.0.*/255.255.255.0

#Confirm all ufw rules with user
sudo ufw status numbered
read -p "!!CONFIRM ABOVE!! Press any key to continue..."
