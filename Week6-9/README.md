## For start work:
## 1)download axios in \front (npm update)
## 2)configure Apache
### a)add in \apache\conf\httpd.conf in section "DocumentRoot:" next:
```	
	#EXAMPLE "C:/Users/User/Week6-9/back"
	<Directory "YOUR FULL PATH../Week6-9/back">
		Options Indexes FollowSymLinks Includes ExecCGI
		AllowOverride All
		Require all granted
	</Directory>
	#EXAMPLE "C:/Users/User/Week6-9/front"
	<Directory "YOUR FULL PATH../Week6-9/front">
		Options Indexes FollowSymLinks Includes ExecCGI
		AllowOverride All
		Require all granted
	</Directory>
```
###	b)change in \apache\conf\httpd.conf in section "Deny access to the entirety of your server's filesystem." next:
```
	<Directory />
		AllowOverride All
		Require all denied
	</Directory>
```
###	c)uncomment in \apache\conf\httpd.conf next:
```
	LoadModule rewrite_module modules/mod_rewrite.so
```
	
###	d)add in C:\Windows\System32\drivers\etc\hosts to access the local site next:
```
	127.0.0.1 example.com
	127.0.0.1 api.com
```
	
## 3)in \back run schema.sql to create a table to work with
