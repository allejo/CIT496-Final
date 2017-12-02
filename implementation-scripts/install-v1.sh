#!/bin/bash

echo "To uninstall, please press 'a' now! To quit, press 'q'."

read -rsn1 input
if [ "$input" = "a" ]; then

	echo "LAMP will commence uninstall. Please use the auto-remove feature if there are errors."


sudo apt-get update

sudo apt-get -y  purge apache2 php7.0 libapache2-mod-php7.0 php7.0-mcrypt php7.0-curl php7.0-mysql php7.0-gd php7.0-cli php7.0-dev mysql-client
php7.0enmod mcrypt

sudo apt-get -y install purge mysql-server

echo -e "\n"


if [ $? -ne 0 ]; then
   echo "Please check the removal of services, There was a $(tput bold)$(tput setaf 1)Problem$(tput sgr0)"
else
   echo "Removal of services run $(tput bold)$(tput setaf 2)Sucessfully$(tput sgr0)"
fi

echo -e "\n"

fi

elif [ "$input" = "q" ]; then

	exit
	
fi
done

echo "LAMP will commence installation. Please use the auto-remove feature if there are errors."

sudo apt-get -y install python-software-properties

# Repositories
sudo add-apt-repository -y ppa:ondrej/php
sudo add-apt-repository -y ppa:ondrej/apache2
sudo add-apt-repository -y ppa:ondrej/mysql-5.7

#update
sudo apt-get update && sudo apt-get upgrade

#Apache, Php, MySQL and required packages installation

sudo apt-get -y install apache2 php7.0 libapache2-mod-php7.0 php7.0-mcrypt php7.0-curl php7.0-mysql php7.0-gd php7.0-cli php7.0-dev mysql-client
php7.0enmod mcrypt

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password donut123'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password donut123'
sudo apt-get -y install mysql-server

echo -e "\n"

service apache2 restart && service mysql restart > /dev/null

echo -e "\n"

php -v

if [ $? -ne 0 ]; then
   echo "Please Check the Install Services, There is some $(tput bold)$(tput setaf 1)Problem$(tput sgr0)"
else
   echo "Installed Services run $(tput bold)$(tput setaf 2)Sucessfully$(tput sgr0)"
fi

echo -e "\n

read -p "All services have been completed. Press any key to continue..."

exit 0
