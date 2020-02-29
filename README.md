# Proyectolaravel

![alt text](https://raw.githubusercontent.com/jfrugone1970/proyectolaravel/branch/Sistema de compras ventas(laravel).jpg) 

Sistema de Compras y Ventas en Laravel 5.7, Vue.js y Bootstrap
El presente proyecto de Sistema de Compra y Venta de productos esta desarrollado en el framework de Laravel 5.7, Vue.js, y Boottraps es un sistema de Venta de productos, comprende los siguientes módulos:
1) Categoría
2) Productos
3) Clientes
4) Proveedores
5) Compras
6) Ventas
Para lo que se refiere a categoría se refiere a la categoria de productos
Para lo que es los productos para el manejo de los productos
Para lo que se refiere a Cliente para el manejo de Catálogo de clientes
Para lo que se refiere a Proveedores para el manejo de Catalogo de Proveedores
Para las Compras para las Compras que se realiza a los Proveedores
Para las Ventas las transacciones mercantiles de ventas que se realizan
Ahora bien para eso se va a explicar la instalación de Laravel para dar mas explicación mas adelante del proyecto:

Instalación de Laravel
Requísitos del servisor

El marco Laravel tiene algunos requisitos del sistema. La máquina virtual Laravel Homestead cumple todos estos requisitos , por lo que es muy recomendable que utilice Homestead como su entorno de desarrollo local de Laravel.

Sin embargo, si no está utilizando Homestead, deberá asegurarse de que su servidor cumpla con los siguientes requisitos:

PHP> = 7.1.3
Extensión PHP OpenSSL
PDO PHP Extension
Extensión PHP Mbstring
Tokenizer PHP Extension
Extensión XML PHP
Extensión PHP Ctype
Extensión PHP JSON
Extensión PHP BCMath

Instalando Laravel .- Laravel utiliza Composer para gestionar sus dependencias. (https://getcomposer.org/) Vía instalador de Laravel
Primero, descargue el instalador de Laravel usando Composer:

composer global require laravel/installer

Una vez instalado, el comando creará una nueva instalación de Laravel en el directorio que especifique. Por ejemplo, creará un directorio llamado que contiene una nueva instalación de Laravel con todas las dependencias de Laravel ya instaladas:laravel newlaravel new blogblog

laravel new blog

Servidor de desarrollo local
Si tiene PHP instalado localmente y desea utilizar el servidor de desarrollo integrado de PHP para servir su aplicación, puede usar el servecomando Artisan. Este comando iniciará un servidor de desarrollo en :http://localhost:8000

php artisan serve

Configuración

Directorio publico
Después de instalar Laravel, debe configurar el documento / raíz web de su servidor web para que sea el publicdirectorio. El en este directorio sirve como controlador frontal para todas las solicitudes HTTP que ingresan a su aplicación.index.php

Archivos de configuración
Todos los archivos de configuración para el marco de Laravel se almacenan en el configdirectorio. Cada opción está documentada, así que siéntase libre de revisar los archivos y familiarizarse con las opciones disponibles para usted.

Clave de aplicación
Lo siguiente que debe hacer después de instalar Laravel es configurar su clave de aplicación en una cadena aleatoria. Si instaló Laravel a través de Composer o el instalador de Laravel, el comando ya ha configurado esta clave para usted .php artisan key:generate

Por lo general, esta cadena debe tener 32 caracteres de longitud. La clave se puede establecer en el .envarchivo de entorno. Si no ha cambiado el nombre del archivo , debe hacerlo ahora. Si la clave de la aplicación no está configurada, sus sesiones de usuario y otros datos cifrados no serán seguros..env.example.env

Configuración del servidor WEB

apache
Laravel incluye un archivo que se utiliza para proporcionar URL sin el controlador frontal en la ruta. Antes de servir Laravel con Apache, asegúrese de habilitar el módulo para que el servidor cumpla con el archivo.public/.htaccessindex.phpmod_rewrite.htaccess

Si el .htaccessarchivo que se incluye con Laravel no funciona con su instalación de Apache, pruebe esta alternativa:

Options +FollowSymLinks -Indexes
RewriteEngine On

RewriteCond %{HTTP:Authorization} .
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
