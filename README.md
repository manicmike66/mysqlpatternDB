#mysqlpatternDB
There are two parts to having a web database: The web part and the database part. 

I assume you only want to run this on your own computer (the localhost) and that you're installing on Linux. If you aren't, you'll have to modify some of the instructions to suit. E.g. if you're on Windows, install WAMP server, Mac is MAMP server. The scripts will probably work without a problem on these but file paths on Windows will be different.

When you're finished installing it, you'll open http://localhost/index.php to begin using it. If you aren't, read this whole file before installing it. You will need to change or set certain passwords.

The components:

You need to have installed (and working):

- apache2
- libapache2-mod-php7.2
- mysql-server
- php-mysqli

sudo su - # become root until it's all installed
apt install apache2 libapache2-mod-php7.2 mysql-server php-mysqli
will get them on a debian based system

If you've just installed mysql it will have a randomly generated root password set, so you can install our blank database by copy-pasting this code (from the directory containing patterns-blank.sql) as the computer's root user.

cat patterns-blank.sql|mysql -u root --password='`cat /etc/mysql/debian.cnf |grep password|head -1|awk '{print $3}'`'

If you already have mysql installed, use:
cat patterns-blank.sql|mysql -u root --password='<your root password>'

This will create the database then grant access to user pattern@localhost with the password 'p@tt3rn'.

If you're going to use this on a networked computer, change the password from this default, since it's public and extremely easily guessed. If you change the database credentials, you also need to change the file includes/creds.ini

The php scripts all need to be copied to a web directory and it's easiest if this is the root directory.
Change ownership of the files to the owner of the apache service (on Ubuntu and mint this is www-data, so if you'd issue this command (as root):

cp -r html/* /var/www/html && chown -R www-data /var/www/html
The first command copies the files, the second changes ownership to the web server.

The images will be encoded and stored on the database. If you don't like this, feel free to customise the code to store them on your own filesystem. 
An advantage of storing on a database is that file backups are done with the database backup. 
An advantage of storing them on the filesystem is that you can rewrite the index to look for <IDPATTERN>.jpg and upload all of your images at once simply by putting a copy into the appropriate directory. 
I have written another version of this project which uses Postgres and the filesystem approach (mainly because PSQL has a really hard time displaying images stored in the database) and will make this available as a separate project on github when it's finished. 
