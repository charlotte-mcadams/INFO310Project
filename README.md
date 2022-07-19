CSIS-Seminars
=============

## Deployement Information:
<br>

### MySQL Database/Server:
- For our database we decided to use MySQL. The following steps should be taken to deploy a MySQL Database and server exactly how it is setup on our own machines running windows.<br>
</br>

> Step 1<br>
> Download MySQL Community server from the following link:
<https://dev.mysql.com/downloads/windows/installer/8.0.html><br>
>After the download is complete run the downloaded .msi file.


> Step 2<br>
> The MySQL installer will ask you for a setup type, choose custom. Select 
> 1. MySQL Server
> 2. MySQL Workbench
> 3. MySQL Router
> 4. Connnector/ODBC
>
> I am unsure as to whether these last two bits of a software are needed but just to be safe I have put them in.
> Select **Next >**

> Step 3<br>
> You may get a warning here with MySQL Installer attempting to resolve certain requirements simply ignore them and select **Next>**
> <br>
> You will then be brought to the installation page, check that you are installing the correct products and select **Execute**

> Step 4<br>
> You will then be brought to a product configuration page where the installer will allow you to configure the relevant products you downloaded select **Next >**.<br>
 On the high availability screen you will be able to choose to install the InnoDB cluster or Standalone MySQL server, choose the latter and select **Next >**

> Step 5<br>
> On the *Type and Networking* page I selected development computer, and just left the *Connectivity* section as default. After clicking **Next >**, on the *Authentication* page, make sure to **Use Strong Password Encryption**, and select **Next >**.

> Step 5<br>
> You should now be on the *Accounts and Roles* section, where a root password needs to be set. If you dont want to change any of our php code then just set your password as Info310!, otherwise you will have to go into our **dbconnection.php** file and change the password to what was chosen. Select **Next >**.

> Step 6<br>
> Next you should be taken to the Windows Service section where you can configure MySQL as a windows service. This isnt necessary but I ticked **configure MySQL Server as a Windows Service**, aswell as start the MySQL Server on system startup, and I just ran it on the standard system account. Select **Next >**

> Step 7<br>
> You can now apply the configuration by selecting **Execute**. Once the configuring has finished, select finish, you should then be brought back to the Product config screen where you should just be able to select **Next >** (you may however be asked to connect to a sample server just follow the steps on the screen).

> Step 8<br>
> This will complete the installation, If it asks you to then start MySQL workbench after setup, tick the box as we will use this next. If not then start MySQL workbench after finishing the installation.

> Step 9<br>
 After starting MySQL workbench select the + next to MySQL Connections, give you database a relevant name, make sure the hostname is 127.0.0.1 on port 3306 (unless you changed it in the config settings), adn the username is root. Click **OK** and you should be prompted to enter a password for root. Enter Info310!, or your root password if it is different.

> Step 10 <br>
> You should be brought to a page where you can perform various functions. Firstly add a new schema by clicking the little barrel with a + next to it. Call the schema seminars and click **Apply**. While you are there add another schema called users.<br>
> Double click on the **seminars** schema in schemas, and add the query in the seminar_event.sql file that was provided in our repository on GitBucket, and select the lightning bolt to run. If you refresh you schema a new table sohuld have appeared called seminar_event.<br>
> Double click on the users schema and add the logininfo.sql query into the query box and run. Again a logininfo table should have appeared.<br></br>
>  We also now need to do a quick insert to allow for the login on our website to work, simply run the query: 

> INSERT INTO logininfo(username, password, role) VALUES ('admin', 'Info310!', 'admin');

> your database should now be all set up!


<br>


<div align="center">
    <h2>PHP Download and Config:</h2>
    <a href="https://php.net">
        <img
            alt="PHP"
            src="https://www.php.net/images/logos/new-php-logo.svg"
            width="80">
    </a>
</div>


* We decided to use PHP as our web framework, the following steps should be taken to download and configure PHP for the Apache web server in the next section.
<br>
</br>

> Step 1<br>
> Download the following linked file (assuming you are running windows 64): https://windows.php.net/downloads/releases/php-8.1.6-nts-Win32-vs16-x64.zip.


> Step 2<br>
> Create a new directory in the root of your C:\ drive called php and extract the contents of the downloaded ZIP into it. Make a new copy of the php.ini-development in the same place and name it php.ini.

> Step 3<br>
> In this php.ini folder you will need to uncomment two extensions the mysqli extension, and openssl extension (you can just ctrl-f and search in the file for ;extension). To uncomment simply remove the ; before the extension.<br><br>
> You may also need to add the php file to the path environment variable : 
> 
> Click the Windows Start button and type ?environment?, then click Edit the system environment variables. Select the Advanced tab, and click the Environment Variables button.
Scroll down the System variables list and click Path followed by the Edit button. Click New and add C:\php:

> PHP should now be set up.



<div align="center">
    <h2>Apache Download and Config:</h2>
    <a href="https://php.net">
        <img
            alt="PHP"
            src="https://httpd.apache.org/images/httpd_logo_wide_new.png"
            width="300">
    </a>
</div>

> Step 1<br>
> Dowload the following linked file: https://www.apachelounge.com/download/VS16/binaries/httpd-2.4.53-win64-VS16.zip. This is just a binary version of Apache from Apache Lounge, meaning it is already compiled and ready to go.

> Step 2<br>
> Extract the contents of the ZIP file into the root of your C:\ drive, a folder called Apache24 should appear. On the Command line (make sure you open powershell or whatever terminal you are using with admin capabilities) navigate into the bin directory of this folder and run the command .\httpd -k install.   

> Step 3<br>
> We now need to configure Apache to run PHP. In the Apache24 folder under the conf folder open the http.conf file with a text editor. Add the following 2 lines to the bottom of the load modules section:<br>
> PHPIniDir "c:/php"<br>
LoadModule php_module "C:\php\php8apache2_4.dll"<br>
>Then search for AddType and add the following after the last AddType line:<br>
AddType application/x-httpd-php .php<br>
> We also need to make sure Apache recognises index.php as the landing page so change the line where it says:<br>
```html
<IfModule dir_module>
	DirectoryIndex index.html
</IfModule>
```
>to:<br>
```html
><IfModule dir_module>
	DirectoryIndex index.php index.html
\</IfModule>
```
>We also need to make one more change which is to set the the AllowOveride line to All, rather than none (this is for the .htaccess file)


> Step 4<br>
> In the command line in the bin directory again run the command .\httpd -k start.<br>
> Check that the web server is running by typing localhost into your web browser, a page should appear.

> Step 5<br>
> The last step is to simply copy all the files inside of our gitbucket CSIS-Seminars repository into the htdocs folder inside the Apache24 folder.<br>
> After doing this, and going to localhost on your web browser our web application should appear and should be fully functional.<br>
> Log in with the admin username: admin, and password: Info310!
