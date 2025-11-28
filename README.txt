# Proyecto Cantina

Proyecto desarrollado por John, Jan y Nico.

## Configuración del Servidor

Este proyecto puede ejecutarse tanto con **Nginx** como con **Apache2**. A continuación se detallan las configuraciones necesarias para cada servidor.

---

## Configuración Nginx

### 1. Archivo principal de configuración (`/etc/nginx/nginx.conf`)
```nginx
user www-data;
worker_processes auto;
pid /run/nginx.pid;
error_log /var/log/nginx/error.log;
include /etc/nginx/modules-enabled/*.conf;

events {
    worker_connections 768;
}

http {
    sendfile on;
    tcp_nopush on;
    types_hash_max_size 2048;
    include /etc/nginx/mime.types;
    default_type application/octet-stream;
    
    # Protocolos SSL/TLS
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
    
    access_log /var/log/nginx/access.log;
    gzip on;
    
    include /etc/nginx/conf.d/*.conf;
    include /etc/nginx/sites-enabled/*;
}
```

### 2. Configuración del sitio (`/etc/nginx/sites-available/proyecto-cantina`)
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name _;
    
    root /opt/lampp/ProyectoCantina/public;
    index index.php index.html;
    
    client_max_body_size 50M;
    
    access_log /var/log/nginx/proyecto_cantina_access.log;
    error_log /var/log/nginx/proyecto_cantina_error.log;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

### 3. Activar el sitio
```bash
sudo ln -s /etc/nginx/sites-available/proyecto-cantina /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

## Configuración Apache2

### 1. Configuración del VirtualHost (`/opt/lampp/apache2/conf/httpd.conf`)
```apache
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
```

### 2. Reiniciar Apache
```bash
sudo /opt/lampp/lampp restart
```

---

## Configuración PHP

### Archivo `php.ini`

Asegúrate de configurar los siguientes valores en tu archivo `php.ini`:
```ini
upload_max_filesize = 50M
post_max_size = 55M
```

**Ubicación del archivo:**
- Para Nginx + PHP-FPM: `/etc/php/8.3/fpm/php.ini`
- Para Apache (XAMPP): `/opt/lampp/etc/php.ini`

### Reiniciar PHP-FPM (si usas Nginx)
```bash
sudo systemctl restart php8.3-fpm
```

---

## Requisitos

- PHP 8.3
- Nginx o Apache2
- MySQL/MariaDB
- Composer

## Instalación

1. Clona el repositorio
2. Configura el servidor web según las instrucciones anteriores
3. Configura las credenciales de base de datos en `.env`
4. Ejecuta las migraciones de la base de datos

---

**Desarrollado por:** John, Jan y Nico