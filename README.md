# TrueTrack
Aplicación web para el seguimiento de envíos de una empresa de transporte. Este proyecto es el que presenté en mi TFG del Grado Superior de Desarrollo de Aplicaciones Web que cursé durante 2023 y 2025 (TFG presentado en Junio de 2025). En el proyecto pude plasmar los conocimientos adquiridos durante mis estudios al utilizar varias herramientas y lenguajes de programación. Laravel es el framework elegido para la mayoría del proyecto (incluye backend y frontend), y para completar la UI he utilizado Vue, que he ido aprendiendo durante el desarrollo del proyecto.

![Alt text](public/img/screenshot.jpg?raw=true "Optional Title")

## Herramientas usadas
- Laravel 12
- Vue 3
- Bootstrap 5
- Javascript
- MySQL

<p align="center">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=laravel,vue,bootstrap,js,mysql,vscode" />
  </a>
</p>

## Guía de instalación / Despliegue y configuración 

1. Instalación de MAMP 
<p>Para ejecutar la aplicación web en local se debe instalar un servidor MySQL y MAMP es una buena opción. Este servidor proporciona todo lo necesario para ejecutar un servidor web y poder probar las funcionalidades de la app. El link de descarga es el siguiente:</p>
<blockquote>https://downloads.mamp.info/MAMP-PRO/Windows/MAMP-PRO/MAMP-MAMP-PRO-5.0.6.exe</blockquote><br/>
<p>Una vez instalado, se debe ejecutar MAMP y por defecto ya funciona el servidor MySQL.</p>

2. Crear nueva base de datos 
<p>Con MAMP se incluye también PHPMYADMIN, que es un administrador de bases de datos con interfaz gráfica. Para acceder, hay que ir a http://localhost/phpMyAdmin5/ directamente o ir a http://localhost/MAMP/ y desde allí a Tools > PHPMYADMIN. Al acceder al menú principal aparece una lista a la izquierda con las bases de datos y un botón para crear nueva: En la sección principal aparece la opción de crear la BBDD donde se debe indicar su nombre: “truetrack” y darle al botón “Crear”. En este momento ya se ha creado la base de datos y en los siguientes pasos se creará la estructura de la misma.</p>

3. Clonar el repositorio 
<p>El siguiente paso es obtener el código que forma la aplicación, y éste está alojado en GitHub. Para ello hay que instalar y ejecutar el instalador de Git. Se puede obtener de la dirección https://git-scm.com/downloads y elegir la versión del sistema operativo que se desee. Una vez instalado en el sistema, hay que ejecutar Git Bash y dirigirse a la ruta que por defecto usa MAMP:</p>
<blockquote>C:\MAMP\htdocs</blockquote><br/>
<p>Allí ejecutar el siguiente comando para clonar el repositorio:</p>
<blockquote>git clone https://github.com/DanielGodoyGalindo/truetrack.git</blockquote><br/>
<p>Una vez se haya clonado hay que ingresar dentro del directorio “truetrack” que se ha creado.</p>

4. Instalar Composer y dependencias PHP 
<p>Al usar Laravel, una forma sencilla de actualizar e instalar dependencias PHP es por medio de Composer, que se trata de un gestor que lee el fichero “composer.json” dentro del proyecto e instala las dependencias necesarias. Para ello se debe descargar de aquí: </p>
<blockquote>https://getcomposer.org/download/.</blockquote><br/>
<p>Una vez hecho, en Git Bash se ejecuta este comando:</p>
<blockquote>composer install</blockquote><br/>

5. Instalar Node.js e instalar dependencias para el frontend 
<p>Ir a https://nodejs.org/es/download y descargar Node.js, que ya incluye npm, gestor de paquetes de Javascript. Ejecutar en Git Bash el siguiente comando para instalar las dependencias incluidas en el fichero package.json, Esto instala las dependencias que usa la aplicación web, incluido Vue: </p>
<blockquote>npm install</blockquote><br/>

6. Crear fichero .env 
<p>Tras clonar aparece un fichero llamado “.env.example” que hay que copiar y llamarlo “.env”. Dentro de este nuevo fichero se modifican las siguientes líneas: </p>
<blockquote>APP_URL=http://localhost:8000<br/>
DB_CONNECTION=mysql<br/>
DB_HOST=127.0.0.1<br/>
DB_PORT=3306<br/>
DB_DATABASE=truetrack<br/>
DB_USERNAME=root<br/>
DB_PASSWORD=root<br/>
MAIL_MAILER=smtp<br/>
MAIL_HOST=smtp.gmail.com<br/>
MAIL_PORT=587<br/>
MAIL_USERNAME=truetrackwebapp@gmail.com<br/>
MAIL_PASSWORD=****************<br/>
MAIL_ENCRYPTION=tls<br/>
MAIL_FROM_ADDRESS="truetrackwebapp@gmail.com"<br/>
MAIL_FROM_NAME="TrueTrack"</blockquote><br/>

7. Generar clave (key) para la aplicación 
<p>Ejecutar en Git Bash el siguiente comando:</p>
<blockquote>php artisan key:generate</blockquote><br/>
<p>Esto genera una clave que se guarda en el fichero .env y se usa para cifrar datos como sesiones de usuario y cookies, y es necesaria para el correcto funcionamiento de Laravel.</p>

8. Ejecutar migraciones (y opcionalmente seeders) 
<p>Las migraciones crean la estructura de la base de datos, permitiendo crear tablas y configurarlas mediante código que Laravel reconoce. El comando para crear las tablas necesarias para la base de datos es:</p>
<blockquote>php artisan migrate</blockquote><br/>
 
<p>Los seeders alimentan las tablas y añaden datos para que la aplicación sea funcional sin que el usuario tenga que crear los datos. Si se desean ejecutar las migraciones y los seeders conjuntamente se debe ejecutar el siguiente comando: </p>
<blockquote>php artisan migrate:fresh --seed</blockquote><br/>

9. Instalar Laravel Localization (aplicación en Inglés y Español) 
<p>Con este paso se instala una herramienta que permite cambiar el idioma de la aplicación con sólo hacer clic en un botón. Se deben definir unos ficheros que guardan los textos en los idiomas que queramos (por defecto son Inglés y Español). Hay que seguir los pasos que se indican en el readme del repositorio. Ha sido desarrollada por la comunidad (Cámara, M. (n.d.)):</p> 
<blockquote>https://github.com/mcamara/laravel-localization</blockquote><br/>

10. Ejecutar procesos de frontend y servir aplicación Laravel por http 
<p>El último paso para poder acceder a la aplicación es ejecutar dos comandos. El primero es para ejecutar un script que se encuentra en el fichero “package.json”, esto lanza un servidor de desarrollo para aplicaciones frontend (en este caso Vue) y el segundo comando ejecuta un servidor de 
desarrollo para aplicaciones backend (como Laravel):</p>
<blockquote>npm run dev & php artisan serve</blockquote><br/>
<p>Si se desea ejecutar la aplicación en modo producción, primero se compilan los assets de Vue y luego se sirve la aplicación:</p>
<blockquote>npm run build<br/>
php artisan serve</blockquote><br/>
<p>Una vez arrancados los dos servidores, se puede acceder a la aplicación en la siguiente dirección web:</p>
<blockquote>http://localhost:8000/</blockquote><br/>

## Nota sobre el proyecto
Esta aplicación es un proyecto personal desarrollado con fines de aprendizaje, y no está pensado para uso comercial o de distribución.
Se aceptan sugerencias y comentarios!