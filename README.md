# Amatent - Blitzbowl

## Requisitos

- PHP >= 8.1
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- Filter PHP Extension
- Hash PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Session PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Instalación

- Clone el repositorio y entrar en la carpeta que tiene el mismo nombre del repositorio
- Ejecutar `composer install`
  - Ejecutar `composer update` si hay algún error
- Renombrar o copiar `.env.example` a `.env` y ajustar la configuración, principalmente la conexión a Base de datos. Otra opción es crear el archivo `.env` en local y subirlo por FTP.
  - IMPORTANTE: Nunca añadir `.env`al repositorio
- Ejecutar `php artisan key:generate`
- Si la base de datos a utilizar es sqlite, primero es necesario crear el archivo `database.sqlite` dentro de la carpeta `database`

## Base de datos
- Para eliminar todos los datos y volver a crear la base de datos utilizar el comando `php artisan migrate:fresh`
- Para añadir la información por defecto en la base de datos ejecutar `php artisan db:seed`
- Si se han añadido algunos cambios en la estructura de la base de datos usar el comando `php artisan migrate` para aplicar los últimos.


## Creditos

Amatent - Blitzbowl está basado en el proyecto Laravel SB Admin 2. Este usa librerias externas, gracias a la comunidad web por hacerlas disponibles.

- Laravel - Open source framework.
- LaravelEasyNav - Haciendo que la navegación en Laravel sea sencilla.
- SB Admin 2 - Gracias a Start Bootstrap.


## License

Licensed under the [MIT](LICENSE) license.
