eramba_isms
===========

Installation Steps

1. Get ready a web-server that supports php > 5.2.0 (web-hosting, linux server, windows servers, Etc.)

2. Get ready a mysql database (web-hosting, linux server, windows servers, Etc.)
2.a. eramba will connect here to retrieve and store data, so you will need to provide  the ip address of the server, a username and password that can connect and write/read to the database.

3. Uncompress the code as it comes (usually a GZIP file) in the directory where your web-server is reading files. You should get an "eramba" directory full of things.
3.a. Either case, you will need to grant write permissions to the "downloads" directory inside "eramba". The way you do that depends on the operating system or hosting provider you are using, so is up to you how you get that done.

4. Upload the database schema provided under the to the database you created before.
5. Under the "db-schema" directory inside "eramba", you will find "base.sql". You need to "import" this to the database you created on the step #2.

6. Setup your eramba configuration file
6.a. Under the "lib" directory inside "eramba", you will find a file called "configuration.inc". You need to configure the database username, password and ip address.

7. Log on to your eramba  instance
7.a. The default credentials are "admin" / "password". Dont forget to change them under the "System Management" module right away!

############## READ!!!!!!!! #################

WARNING! eramba is "too young" to be published on internet without  minimising surface attack.  If you plan to publish your instance on internet make sure you have SSL and the system is behing Web Authentication (in Apache that would be .htaccess, Etc.)

