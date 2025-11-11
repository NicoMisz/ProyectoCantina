README

Configuració nginx
server {
    listen 80;
    listen [::]:80;
    server_name _;
#    server_name localhost;
    root /opt/lampp/ProyectoCantina/public;

    index index.php index.html;

    access_log /var/log/nginx/proyecto_cantina_access.log;
    error_log /var/log/nginx/proyecto_cantina_error.log;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        #include fastcgi_params;
        include fastcgi.conf;

        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}


Configuracio apache2

  GNU nano 7.2                                                               /opt/lampp/apache2/conf/httpd.conf                                                                   M     
Alias /bitnami/ "/opt/lampp/apache2/htdocs/"
Alias /bitnami "/opt/lampp/apache2/htdocs"


<VirtualHost *:80>
    DocumentRoot "/opt/lampp/ProyectoCantina/public"
    ServerName localhost
    
    <Directory "/opt/lampp/ProyectoCantina/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php [QSA,L]
        </IfModule>
    </Directory>
</VirtualHost>


