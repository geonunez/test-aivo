# Test Aivo

### Description
Build a service which retrieves the profile of one facebook user, using the Facebook API Graph.

### Get and install the project
***This example assume that project is located in /var/www/ and you have composer installed globally***
You just have to download it from github, run composer and fix the log folder permission:
```bash
# git clone https://github.com/geonunez/test-aivo /var/www/test-aivo
# cd /var/www/test-aivo && composer install
# HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
# setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX logs
# setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX logs
```

### Installing it over Apache
***This example assume that project is located in /var/www/ and the vhost file is named as test-aivo.conf***
1. Create a new virtualhost with this minimum configuration (**)
```bash
<VirtualHost *:80>
    ServerName test-aivo.dev
    ServerAlias test-aivo.dev
    DocumentRoot /var/www/test-aivo/public
    <Directory /var/www/test-aivo/public>
        # enable the .htaccess rewrites
                AllowOverride All
                Order allow,deny
                Allow from All
        </Directory>
    ErrorLog ${APACHE_LOG_DIR}/test-aivo_error.log
    CustomLog ${APACHE_LOG_DIR}/test-aivo_access.log combined
</VirtualHost>
```
2. Enable this new site
```bash
# a2ensite test-aivo.conf
# service apache2 reload
```
