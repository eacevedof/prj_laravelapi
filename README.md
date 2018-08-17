# prj_laravelapi - Laravel 5.6.33 con homestead

## [Curso de desarrollo de API RESTful con Laravel - Youtube](https://www.youtube.com/watch?v=8Ren77hsZUo&index=1&list=PLIcuwIrm4rKcyfsOnnjqfXoa9rulZ9LgY)

### [Contenido curso - Escueal.it](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel#content)

### Lecciones:

1. [Crear un proyecto en laravel](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/crear-un-proyecto-en-laravel)
- **composer**: `composer create-project laravel/laravel prj_laravelapi 5.6.*` (tarda como 15 min en instalar)
- version instalada: `php artisan --version` `Laravel Framework 5.6.33`
- con `php artisan serve` despliega laravel en su servidor integrado: 127.0.0.1:8000
2. [Configurar la base de datos](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/configurar-la-base-de-datos)
- `php artisan migrate` intenta migrar una bd
- archivo `.env` archivo de configuracion
- **error** al ejecutar `php artisan migrate`: 
    `Illuminate\Database\QueryException:SQLSTATE[HY000]:General error:26 file is encrypted or is not a database (SQL:..`
    **solución:**
    - He tenido que instalar [sqlite-tools-win32-x86-*](https://www.sqlite.org/2018/sqlite-tools-win32-x86-3240000.zip)
    - Con esta herramienta en E:/programas/sqlite3-console la he configurado como variable de entorno
    - He creado la bd con el comando `sqlite3 database.sqlite` y despues `.databases` este último es el que escribe la bd en blanco
    - Seguidamente he ejecutado: `php artisan migrate` y ha ido bien. Parece que no le gusta cuando se crea un archivo sqlite cone el notepad++
    - `Migration table created successfully.`
    - **NO** hacia falta habilitar `extension=php_sqlite3.dll - ;sqlite3.extension_dir ` en **php.ini**
3. [Otras alternativas instalación](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/otras-alternativas-para-disponer-de-laravel-en-local-para-desarrollo)
- explicación comando `composer create-project` 
4. [Estructura de laravel](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/repaso-a-la-estructura-de-aplicacion-laravel-55)
- x:\xampp\htdocs\prj_laravelapi\app **\Exceptions**\Handler.php archivo de excepciones, en esta carpeta se puede crear distintos archivos de excepciones
- x:\xampp\htdocs\prj_laravelapi\app\Http
    - **Controllers** Todas las acciones de la API. Un controlador por determinadas acciones (no más de 5 metodos)
    - **Middleware**  Elementos que se ejecutan en cualquier punto de la petición. Interceptores
        - Los middlewares se registran en x:\xampp\htdocs\prj_laravelapi\app\Http\Kernel.php
```php
//estos se van a ejecutar siempre
protected $middleware = [\App\Http\Middleware\CheckForMaintenanceMode::class, 
//estos se ejecutaran para WEB y para APIS
protected $middlewareGroups = [

protected $routeMiddleware = [
```

- para distinguir si se está ejecutando la app desde la Web o una Api se usan las rutas: `x:\xampp\htdocs\prj_laravelapi\routes`
- el apartado de API esta en texto porque es un alias de `$routeMiddleware`
- x:\xampp\htdocs\prj_laravelapi\app**\Providers**
- Que es un provider? Es una lógica que se ejecuta antes de hacer cualquier tipo de acción de la petición recibida.
    - Registrar rutas, acciones que se van a ejecutar, registrar algo que se desea compartir en todo el proyecto.
    - Es como una caja de sastre
- x:\xampp\htdocs\prj_laravelapi\app\Providers\ **RouteServiceProvider.php** se quita el prefijo
- comando: `php artisan route:list` 
- x:\xampp\htdocs\prj_laravelapi\config\app.php Se cargan los valores de .env en un array
- x:\xampp\htdocs\prj_laravelapi\database\factories\UserFactory.php generador de objetos
- x:\xampp\htdocs\prj_laravelapi\database\migrations\2014_10_12_000000_create_users_table.php
- x:\xampp\htdocs\prj_laravelapi\database\seeds\DatabaseSeeder.php Desde este se llamara a los factories para rellenar la bd con información
- x:\xampp\htdocs\prj_laravelapi\resources\
    - **assets** Recursos de frontend compilados
    - **lang**  Mensajes de validación
    - **views**  No se usaran mucho
- x:\xampp\htdocs\prj_laravelapi\routes\channels.php Para transmitir eventos a lo largo de toda la app. No se utilizará.
- x:\xampp\htdocs\prj_laravelapi\routes\console.php comandos personalizados que se puede tener en php artisan
- x:\xampp\htdocs\prj_laravelapi\storage donde se almacenan los logs
- x:\xampp\htdocs\prj_laravelapi\vendor codigo de terceros gestionado por composer. No se debe tocar
- Hay que evitar tener rutas iguales para Api y para Web, siempre prevalecerá las de web.
- En middlewaregroups se cargan unas librerias de web como sesiones y crf que no secargan para api lo que la hace más ligera
- el ORM que se usará **ELOQUENT**

5. [Creación de nuestro primer modelo y archivos asociados](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/creacion-de-nuestro-primer-modelo-y-archivos-asociados)
- Diagrama ![diagrama de clases](https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b014de4bc1b8dcc70d83031/6a3a5051307f57b023a2cd7de15dd2ca/image.png)
- **comando:** `php artisan make:model --help`
    - flag **-a, --all** Genera el modelo, factory que nos permitira insertar datos falsos o de prueba y resource controller es un controlador de recursos, cada modelo es un recurso.
- **comando:** `php artisan make:model Product --all`
- Ruta de los modelos: x:\xampp\htdocs\prj_laravelapi\ **app**