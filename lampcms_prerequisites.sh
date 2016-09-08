
apache_root_dir="/var/www"






#mongo installation
echo "sudo apt-get update"
sudo apt-get update
echo "\n------------------------------------------------------------------------------\n"

echo "sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10"
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
echo "\n------------------------------------------------------------------------------\n"

echo "sudo echo 'deb http://repo.mongodb.org/apt/ubuntu '$(lsb_release -sc)'/mongodb-org/3.0 multiverse' | sudo tee /etc/apt/sources.list.d/mongodb-org-3.0.list"
sudo echo "deb http://repo.mongodb.org/apt/ubuntu "$(lsb_release -sc)"/mongodb-org/3.0 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.0.list
echo "\n------------------------------------------------------------------------------\n"

echo "sudo apt-get update"
sudo apt-get update
echo "\n------------------------------------------------------------------------------\n"

echo "sudo apt-get install -y mongodb-org"
sudo apt-get install -y mongodb-org
echo "\n------------------------------------------------------------------------------\n"

echo "service mongod status"
service mongod status
echo "\n------------------------------------------------------------------------------\n"



#MYSQL Installation
echo "sudo apt-get install mysql-server libapache2-mod-auth-mysql php5-mysql"
sudo apt-get install mysql-server libapache2-mod-auth-mysql php5-mysql
echo "\n------------------------------------------------------------------------------\n"

echo "sudo mysql_install_db"
sudo mysql_install_db
echo "\n------------------------------------------------------------------------------\n"

echo "sudo /usr/bin/mysql_secure_installation"
sudo /usr/bin/mysql_secure_installation
echo "\n------------------------------------------------------------------------------\n"

#PHP installation
echo "sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt libpcre3 libpcre3-dev"
sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt libpcre3 libpcre3-dev
echo "\n------------------------------------------------------------------------------\n"

echo "sudo apt-get install php5-cgi php5-curl php5-gd php5-apcu php5-oauth php5-dev php5-tidy php5-mongo"
sudo apt-get install php5-cgi php5-curl php5-gd php5-apcu php5-oauth php5-dev php5-tidy php5-mongo
echo "\n------------------------------------------------------------------------------\n"



# apache2 installation
echo "sudo apt-get update"
sudo apt-get update
echo "\n------------------------------------------------------------------------------\n"

echo "sudo apt-get install apache2"
sudo apt-get install apache2
echo "\n------------------------------------------------------------------------------\n"

#echo "sed -i '/DocumentRoot/c\DocumentRoot \/var\/www\/Raudra_Forum/' /etc/apache2/sites-available/000-default.conf"
#sed -i '/DocumentRoot/c\DocumentRoot \/var\/www\/Raudra_Forum/' /etc/apache2/sites-available/000-default.conf
#echo "\n------------------------------------------------------------------------------\n"


#echo "sed -i '/DocumentRoot/c\\DocumentRoot $apache_root_dir/Raudra_Forum/' /etc/apache2/sites-available/default-ssl.conf"
#sed -i '/DocumentRoot/c\DocumentRoot $apache_root_dir\/Raudra_Forum/' /etc/apache2/sites-available/default-ssl.conf
#echo "\n------------------------------------------------------------------------------\n"

echo "ifconfig eth0 | grep -w inet | awk '{ print $2 }' | cut -d ":" -f2"
ip=`sudo ifconfig eth0 | grep -w inet | awk '{ print $2 }' | cut -d ":" -f2`
echo "\n------------------------------------------------------------------------------\n"

echo "Go for '$ip' in your browser"

