# About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

# Importante
Para esta prueba tecnica no es necesario poner en ambiente local el Backend, ya que este esta publicado en mi Host de Hostinger, con la finalidad de simplificar la compilacion en local, sin embargo adjunto el codigo para que se refleje por si se ocupa validar las soluciones propuestas.

De esta manera los `endpoint con los que se comunica el front, estan con disponibilidad total desde internet`

# Si se considera necesaria la compilacion local
1. Clona el repositorio de git
2. Navega al directorio del proyecto y ejecuta `composer install`
3. Crea una BD
4. Copia el archivo `cp .env.example .env` y coloca las credenciales correspondientes a la conexion
5. Genera una clave de aplicacion con php `artisan key:generate`
6. Corre las migraciones `php artisan migrate`
7. Ejecuta los seeders `php artisan db:seed`
8. Crea el storage link con el comando `php artisan storage:link`
9. Ejecuta `php artisan serve`


