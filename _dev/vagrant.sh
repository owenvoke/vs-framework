#!/usr/bin/env bash

# ----- Update system
echo '################ UPDATING SYSTEM ################'
sudo apt-get update -q
sudo apt-get upgrade -qqy

# ----- Install FFMPEG (for creating thumbnails)
echo '################ UPDATING SYSTEM ################'
sudo apt-get install ffmpeg -y

# ----- Install MySQL
echo '################ INSTALLING MYSQL ################'
debconf-set-selections <<< "mysql-server mysql-server/root_password password root"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password root"
sudo apt-get install -qqy mysql-server

sed -i "s/skip-external-locking/#skip-external-locking/g" /etc/mysql/mysql.conf.d/mysqld.cnf
sed -i "s/bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
sudo service mysql restart

# ----- MySQL Import
if [ -f /vagrant/resources/dump.sql ]; then
 cat /vagrant/resources/dump.sql | mysql -uroot -proot
else
 echo '[PROVISION NOTICE] No SQL dump was found'
fi

# ----- Install apache2
echo '################ INSTALLING APACHE2 ################'
sudo apt-get install -qqy apache2
rm /etc/apache2/sites-available/000-default.conf
cp /vagrant/_dev/apache2/000-default.conf /etc/apache2/sites-available/
sudo a2enmod rewrite

# ----- Install PHP
echo '################ INSTALLING PHP ################'
sudo apt-get install -yqq php php-fpm php-mysql php-curl php-json php-gd php-mcrypt php-intl php-sqlite3 php-gmp php-mbstring php-xml php-zip php-geoip php-apcu php-apcu php-xdebug php-codesniffer libapache2-mod-php7.0

sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.0/fpm/php.ini
sed -i "s/listen.owner = www-data/listen.owner = ubuntu/g" /etc/php/7.0/fpm/pool.d/www.conf
sed -i "s/listen.group = www-data/listen.group = ubuntu/g" /etc/php/7.0/fpm/pool.d/www.conf
sudo service php7.0-fpm restart

echo '################ SETUP LOGS ################'
mkdir -p /vagrant/logs
chown -R ubuntu: /vagrant/logs

sudo /etc/init.d/apache2 restart