# prj_laravelapi - Laravel 5.6.33 con homestead

## [Curso de desarrollo de API RESTful con Laravel - Youtube](https://www.youtube.com/watch?v=8Ren77hsZUo&index=1&list=PLIcuwIrm4rKcyfsOnnjqfXoa9rulZ9LgY)

### [Contenido curso - Escueal.it](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel#content)

### Lecciones:

1. [Crear un proyecto en laravel](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/crear-un-proyecto-en-laravel)
- **composer**: `composer create-project laravel/laravel prj_laravelapi 5.6.*` (tarda como 15 min en instalar)
- version instalada: `php artisan --version` `Laravel Framework 5.6.33`
- con `php artisan serve` despliega laravel en su servidor integrado: 127.0.0.1:8000
2. [Configurar la base de datos](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/configurar-la-base-de-datos)
- **comando:** `php artisan migrate` intenta migrar una bd
    - Si la bd está vacía crea las tablas: **users, migrations y password_resets**
- Archivo `.env` archivo de configuracion
- Creo un archivo en `<project>/database/database.sqlite`
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
- <project>\app **\Exceptions**\Handler.php archivo de excepciones, en esta carpeta se puede crear distintos archivos de excepciones
- <project>\app\Http
    - **Controllers** Todas las acciones de la API. Un controlador por determinadas acciones (no más de 5 metodos)
    - **Middleware**  Elementos que se ejecutan en cualquier punto de la petición. Interceptores
        - [Explicación stackoverflow](https://stackoverflow.com/questions/2904854/what-is-middleware-exactly)
        - Los middlewares se registran en <project>\app\Http\Kernel.php
        - Los **middlewares (software glue)** orignalmente son interfaces de tipo pasarela entre dos sistemas agnosticos. 
Permiten la integración entre dos plataformas: `[Plat A] in/out <- middleware -> in/out [Plat B]`. 
El middlware lleva acabo esta tarea usando servicios.
```php
//<project>/app/Http/Kernel.php
//estos se van a ejecutar siempre
protected $middleware = [
    \App\Http\Middleware\CheckForMaintenanceMode::class,
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    \App\Http\Middleware\TrustProxies::class,
];

//estos se ejecutaran para WEB y para APIS
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        // \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

    'api' => [
        'throttle:60,1',
        'bindings',
    ],
];

protected $routeMiddleware = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
];
```

- para distinguir si se está ejecutando la app desde la Web o una Api se usan las rutas: `<project>\routes`
- el apartado de API esta en texto porque es un alias de `$routeMiddleware`
- <project>\app**\Providers**
- Que es un **provider**? 
    - [Explicación stackoverflow](https://stackoverflow.com/questions/37104764/confused-about-laravel-providers-and-contracts)
    - [Reflection Class php.net](http://php.net/manual/en/class.reflectionclass.php)
    - Es una clase **abstracta** que tiene un metodo register que sirve para mapear **Interface -> Clase instanciable** de modo que cuando se desee hacer una
inyección de dependencia usando una interfaz, esta se lleve acabo (normalmente usando **ReflectionClass**) consultando al ServiceProvider.
- <project>\app\Providers\ **RouteServiceProvider.php** se quita el prefijo
- **comando:** `php artisan route:list` 
- <project>\config\ **app.php** Se cargan los valores de .env en un array
- <project>\ **database\factories\UserFactory.php** generador de objetos
- <project>\ **database\migrations\2014_10_12_000000_create_users_table.php**
- <project>\ **database\seeds\DatabaseSeeder.php** Desde este se llamara a los factories para rellenar la bd con información
- <project>\resources\
    - **assets** Recursos de frontend compilados
    - **lang**  Mensajes de validación
    - **views**  No se usaran mucho
- <project>\ **routes**\channels.php Para transmitir eventos a lo largo de toda la app. No se utilizará.
- <project>\ **routes**\console.php comandos personalizados que se puede tener en php artisan
- <project>\ **storage** donde se almacenan los logs
- <project>\ **vendor** codigo de terceros gestionado por composer. No se debe tocar
- Hay que evitar tener rutas iguales para Api y para Web, siempre prevalecerá las de web.
- En middlewaregroups se cargan unas librerias de web como sesiones y crf que no secargan para api lo que la hace más ligera
- el ORM que se usará **ELOQUENT**

5. [Creación de nuestro primer modelo y archivos asociados](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/creacion-de-nuestro-primer-modelo-y-archivos-asociados)
- Diagrama 
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b014de4bc1b8dcc70d83031/6a3a5051307f57b023a2cd7de15dd2ca/image.png" height="200" width="400">
- **comando:** `php artisan make:model --help`
    - flag **-a, --all** Genera el modelo, factory que nos permitira insertar datos falsos o de prueba y resource controller es un **controlador de recursos**, cada modelo es un recurso.
- **comando:** `php artisan make:model Product --all`
- Ruta de los modelos: <project>\ **app**
- Crear ruta de api:  <project>\routes\ **api.php**
- 
```php
//<project>/routes/api.php
use Illuminate\Http\Request;
Route::apiResource("users","UserController");
Route::apiResource("buyers","BuyerController",["only"=>["index","show"]]);
Route::apiResource("sellers","SellerController",["only"=>["index","show"]]);
Route::apiResource("products","ProductController",["only"=>["index","show"]]);
Route::apiResource("transactions","TransactionController",["only"=>["index","show"]]);
Route::apiResource("transactions.categories","TransactionCategoryController",["only"=>["index"]]);
Route::apiResource("categories","CategoryController");
//Route::get("slug-de-ruta","ProductController@methodX");
```
- En el metodo show si no se recibe una instancia laravel lanzará una excepcion de **ModelNotFoundException** que se controlara en **x:\..api\app\Exceptions\Handler.php**
- Ruta en **<project>/routes/api.php** `Route::resource("products","ProductController");` esta es una ruta para **web** pero como estamos usando
una ruta de **api** se tiene que usar **Route::apiResource()**
    - Otra forma de forzar un metodo en las ruta es: `Route::get("slug-de-ruta","ProductController@create")`
- **comando:** `php artisan route:list` Muestra las rutas generadas por la linea escrita en **api.php**
```shell
$ php artisan route:list
+--------+-----------+-------------------------+------------------+------------------------------------------------+------------+
| Domain | Method    | URI                     | Name             | Action                                         | Middleware |
+--------+-----------+-------------------------+------------------+------------------------------------------------+------------+
|        | GET|HEAD  | /                       |                  | Closure                                        | web        |
|        | GET|HEAD  | products                | products.index   | App\Http\Controllers\ProductController@index   | api        |
|        | POST      | products                | products.store   | App\Http\Controllers\ProductController@store   | api        |
|        | GET|HEAD  | products/create         | products.create  | App\Http\Controllers\ProductController@create  | api        |
|        | GET|HEAD  | products/{product}      | products.show    | App\Http\Controllers\ProductController@show    | api        |
|        | PUT|PATCH | products/{product}      | products.update  | App\Http\Controllers\ProductController@update  | api        |
|        | DELETE    | products/{product}      | products.destroy | App\Http\Controllers\ProductController@destroy | api        |
|        | GET|HEAD  | products/{product}/edit | products.edit    | App\Http\Controllers\ProductController@edit    | api        |
+--------+-----------+-------------------------+------------------+------------------------------------------------+------------+
```

- No nos interesa usar los metodos: create y edit
```shell
# despues de cambiar `Route::resource("products","ProductController");` a `Route::apiResource("products","ProductController");`
$ php artisan route:list
+--------+-----------+--------------------+------------------+------------------------------------------------+------------+
| Domain | Method    | URI                | Name             | Action                                         | Middleware |
+--------+-----------+--------------------+------------------+------------------------------------------------+------------+
|        | GET|HEAD  | /                  |                  | Closure                                        | web        |
|        | GET|HEAD  | products           | products.index   | App\Http\Controllers\ProductController@index   | api        |
|        | POST      | products           | products.store   | App\Http\Controllers\ProductController@store   | api        |
|        | GET|HEAD  | products/{product} | products.show    | App\Http\Controllers\ProductController@show    | api        |
|        | PUT|PATCH | products/{product} | products.update  | App\Http\Controllers\ProductController@update  | api        |
|        | DELETE    | products/{product} | products.destroy | App\Http\Controllers\ProductController@destroy | api        |
+--------+-----------+--------------------+------------------+------------------------------------------------+------------+

# despues de agregar a routes\api.php Route::get("slug-de-ruta","ProductController@methodX");
$ php artisan route:list
+--------+-----------+--------------------+------------------+------------------------------------------------+------------+
| Domain | Method    | URI                | Name             | Action                                         | Middleware |
+--------+-----------+--------------------+------------------+------------------------------------------------+------------+
|        | GET|HEAD  | /                  |                  | Closure                                        | web        |
|        | GET|HEAD  | products           | products.index   | App\Http\Controllers\ProductController@index   | api        |
|        | POST      | products           | products.store   | App\Http\Controllers\ProductController@store   | api        |
|        | GET|HEAD  | products/{product} | products.show    | App\Http\Controllers\ProductController@show    | api        |
|        | PUT|PATCH | products/{product} | products.update  | App\Http\Controllers\ProductController@update  | api        |
|        | DELETE    | products/{product} | products.destroy | App\Http\Controllers\ProductController@destroy | api        |
|        | GET|HEAD  | slug-de-ruta       |                  | App\Http\Controllers\ProductController@methodX | api        |
+--------+-----------+--------------------+------------------+------------------------------------------------+------------+
```

6. [Implementar el esqueleto de los demás recursos del API](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/implementar-el-esqueleto-de-los-demas-recursos-del-api)
- Archivos que más se utilizan: **config/app.php** y **config/database.php**
- **database/migrations**
    - **Tips restricciones ELOQUENT:**
        - Los **nombres de las tablas** deben de ir en **plural** y **minúsculas**
        - Los **nombres de los campos** siempre en **minúsculas** - `products.name, categories.description`
        - Las **claves foraneas** se deben formar de la siguiente manera: `<nombre-tabla-singular>_id` ejemplo: `products.seller_id`
    - Las migraciones son clases de tipo Migration y se guardan con un timestamp tipo: **<yyyy_mm_dd_hhmmss_cadena-de-accion>.php**
    - El orden es importante ya que laravel ejecutara todo lo que hay en esta carpeta segun el nombre.
    - Fijandonos en el diagrama, **Buyer** y **Product** deben existir antes de **Transaction**
    - Tener presente la **tabla pivote** es una representación fisica de una relación n:m. En el ejemplo **Product<->Category** con lo cual obtendriamos una tabla **category_product** (Union de nombres en singular en orden alfabético **Norma 5**)

- **comando:** `php artisan make:model Transaction --all`

```bash
$ php artisan make:model Transaction --all
Model created successfully.
Factory created successfully.
Created Migration: 2018_08_18_130213_create_transactions_table
```
- Despues de agregar ruta en **routes/api.php**: **Route::apiResource("transactions","TransactionController");**
    - Cuidado!! el **slug** de la ruta debe estar siempre en **ingles plural**
```bash
$ php artisan route:list
+--------+-----------+---------------------------+---------------------+----------------------------------------------------+------------+
| Domain | Method    | URI                       | Name                | Action                                             | Middleware |
+--------+-----------+---------------------------+---------------------+----------------------------------------------------+------------+
|        | GET|HEAD  | /                         |                     | Closure                                            | web        |
|        | GET|HEAD  | products                  | products.index      | App\Http\Controllers\ProductController@index       | api        |
|        | POST      | products                  | products.store      | App\Http\Controllers\ProductController@store       | api        |
|        | GET|HEAD  | products/{product}        | products.show       | App\Http\Controllers\ProductController@show        | api        |
|        | PUT|PATCH | products/{product}        | products.update     | App\Http\Controllers\ProductController@update      | api        |
|        | DELETE    | products/{product}        | products.destroy    | App\Http\Controllers\ProductController@destroy     | api        |
|        | GET|HEAD  | transaction               | transaction.index   | App\Http\Controllers\TransactionController@index   | api        |
|        | POST      | transaction               | transaction.store   | App\Http\Controllers\TransactionController@store   | api        |
|        | GET|HEAD  | transaction/{transaction} | transaction.show    | App\Http\Controllers\TransactionController@show    | api        |
|        | PUT|PATCH | transaction/{transaction} | transaction.update  | App\Http\Controllers\TransactionController@update  | api        |
|        | DELETE    | transaction/{transaction} | transaction.destroy | App\Http\Controllers\TransactionController@destroy | api        |
+--------+-----------+---------------------------+---------------------+----------------------------------------------------+------------+
```
- Creado modelo **Category** con make:model --all
- Creando el recurso **users**
```bash
$ php artisan make:model User --all
Model already exists!
```
- Laravel ya viene con el **modelo User** ya creado. No es bueno borrarlo y volverlo a crear
- Como para este modelo ya tenemos: 
    - **database/migrations/+++_create_users_table.php**
    - **database/factories/UserFactory.php**
    - **app/User.php** (modelo)
    - Falta el Controlador!
        - **comando:** - `php artisan make:controller UserController -m User`
        - con flag **-m** crea recurso para el modelo dado
        - flag **-r** crea un recurso básico de tal forma que los métodos no llevan la inyección de dependencias
- Cuidado con los nombres y las rutas de ser posible siempre usar palabras en ingles
- Es preferible evitar crear rutas personalizadas. Si se hace esto probablemente se haya incurrido en un error.
- Los modelos de las tablas pivote se pueden crear en cualquier orden
- Haciendo que laravel interprete rutas en español **min: 15:12**. Buscar: [`Localizing Resource URIs laravel.com`](https://laravel.com/docs/5.6/controllers#restful-localizing-resource-uris)
- Habria que tocar el **app/providers/RouteServiceProvider.php - booot() despues de parent::boot()**
    - `Route::binding("profesor",function(){ Profesor});` **min: 17:34** 
- Las palabras se separan por mayusculas. CamelCase
- **Duda: ¿Qué pasa si ya tengo una Bd y los nombres de las tablas no cumplen con el estandard de laravel para los modelos?**

7. [Creación de la tabla pivote](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/creacion-de-la-tabla-pivote)
- **comando:** `php artisan make:migration`
    - **--create[=CREATE]**
    - **table[=TABLE]**
```bash
$ php artisan make:migration create_category_product_table
Created Migration: 2018_08_18_140049_create_category_product_table
```
8. [Ejecutar migraciones](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/ejecutar-migraciones)
- **comando:** `php artisan migrate`
- Es común que ocurran errores en la migracion
- **comando:** `php artisan migrate:fresh`
- Recrea las tablas desde cero.
```bash
$ php artisan migrate:fresh
Dropped all tables successfully.
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table
Migrating: 2018_08_17_212821_create_products_table
Migrated:  2018_08_17_212821_create_products_table
Migrating: 2018_08_18_130213_create_transactions_table
Migrated:  2018_08_18_130213_create_transactions_table
Migrating: 2018_08_18_131136_create_categories_table
Migrated:  2018_08_18_131136_create_categories_table
Migrating: 2018_08_18_140049_create_category_product_table
Migrated:  2018_08_18_140049_create_category_product_table
```
- **Resultado**
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b782b6ee487ec2c9552dbbd/70b774790c4630fd0e1257e38a6c6ff3/image.png" height="200" width="100">
- Con esto ya tendriamos todas las tablas creadas
- Ahora queda configurar los campos de las mismas en las clases de las migraciones
    - **Ejemplo class CreateUsersTable extends Migration**
```php
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(){Schema::dropIfExists('users');}
}//CreateUsersTable extends Migration
```

9. [Preguntas finales y resumen del contenido del curso](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/preguntas-finales-y-resumen-del-contenido-del-curso)
- Seguridad con **Laravel Passport** que implementa **OAuth2**
- **OAuth2** Es un protocolo de autorización
    - Entidades involucradas:
    - **Propietario de recursos:** Parte que puede autorizar el acceso a los recursos. Generalmente una persona.
    - **Cliente:** Sitio web o app que accedera a los recursos
    - **Proveedor:**
        - Servidor de autorización: Valida usuario y credenciaes y genera tokes de acceso.
        - Servidor de recursos: Recibe peticiones de acceso a los recursos protegidos autorizando el acceso dependiendo del token.
- **Ejemplo linkedin**
    - Solicitar código de autorización:
    - `GET https://www.linkedin.com/oauth/v2/authorization`
    - Intercambiar código de autenticación por Access Token
    - `POST https://www.linkedin.com/oauth/v2/accessToken`
    - Realizar una petición de autenticación
    - `GET https://api.linkedin.com/v1/people/~:(id,first-name,last-name,email-address)?format=json`

- **JWT (json web token):**  Es una validación por token que no permite identificar al cliente

10. [Creación de modelos heredando de otro modelo](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/creacion-de-modelos-heredando-de-otro-modelo)
- Aplicar atributos a los modelos
- Cada atributo muy probablemente estara en la bd
- Atributos computados
- **comandos:** 
    - **-c:** controller, **-r:** resource controller
    `php artisan make:mode Buyer -cr`
    `php artisan make:mode Seller -cr`
- Se aplica herencia en Buyer y Seller ya que extienden de User (ver diagrama)
- Aplicando atributo **protected $table = "users"** en User para evitar duplicación de código

11. [Propiedades para la configuración de modelos](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/propiedades-para-la-configuracion-de-modelos)
- Todos los atributos que se pueden configurar en un modelo
```
<project>\vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php
+-------------------------------+-------------------------------------+---------------------------------------+
| protected $connection;        | protected $with = [];               | protected static $resolver;           |
| protected $table;             | protected $withCount = [];          | protected static $dispatcher;         |
| protected $primaryKey = 'id'; | protected $perPage = 15;            | protected static $booted = [];        |
| protected $keyType = 'int';   | public $exists = false;             | protected static $globalScopes = [];  |
| public $incrementing = true;  | public $wasRecentlyCreated = false; | protected static $ignoreOnTouch = []; |
+-------------------------------+-------------------------------------+---------------------------------------+
```
- **User**
    - **array $fillable:**
        - Todos los atributos que no esten aqui no se tomaran en cuenta en el metodo **create()** y habria 
que añadirlos manualmente
        - Es una buena practica poner todos los atributos en **$fillable**
        - Si no se desea que el atributo se establezca manualmente entonces no hay que incluirlo en **$fillable** 
por ejemplo `person_id`
    - **array $hidden:**
        - Son aquellos atributos que cuando el modelo se transforme en JSON no se mostrarán
        - Por ejemplo: la contraseña y el token
    - "password" es fillable y hidden es decir que se debe llenar por un proceso especifico y no de manera manual
    - Users se podria crear con roles pero aumentaria la complejidad del sistema de validación
    - Tal como esta un Usuario es Vendedor si tiene productos y un Usuario es Comprador si tiene transacciones

12. [Creación de columnas para las tablas mediante migraciones Laravel](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/creacion-de-columnas-para-las-tablas-mediante-migraciones-laravel)
- En **migrations**, **2014_10_12_000000_create_users_table** está el atributo autonumerico `$table->increments('id');`
    - El método **$table->increments(xxxx)** indica que `xxxx` es una clave primaria y sera automático
    - Importante el metodo `unsigned()` en las claves enteras
    - [Tipos de columnas que se pueden crear](https://laravel.com/docs/5.6/migrations#columns)
- La clase de migración **CreateUsersTable** trabaja con **callbacks**
    - **Blueprint:** El plano o plantilla
    - metodo **up**
```php
<?php
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
```
- Migration Products
```php
<?php
    $table->integer("seller_id")->unsigned();//entero sin signo
    //seller_id deberia apuntar a sellers pero como ya hemos dicho un seller es un user por lo
    //tanto en on: se pasa "users"
    $table->foreign("seller_id")->references("id")->on("users");
```
- Migration Transactions
```php
<?php
    $table->foreign("product_id")->references("id")->on("products");
    $table->foreign("buyer_id")->references("id")->on("users");
```
- Migration Categories No lleva claves foraneas ya que se relaciona con la **tabla pivote category_product**
- Migration Category_Product
```php
<?php
    $table->integer("category_id")->unsigned();
    $table->integer("product_id")->unsigned();

    $table->foreign("category_id")->references("id")->on("categories");
    $table->foreign("product_id")->references("id")->on("products");
```
- **comando:** `php artisan migrate` como ya estan creados los modelos entiende que no hay nada que migrar
- **comando:** `php artisan migrate:fresh` borra la bd entera y crea la bd nuevamente
- Si da algún error `artisan migrate` es mejor ejecutar un `:fresh` para crear nuevamente toda la bd (tablas y campos)
- El comando `:fresh` solo está disponible a partir de **laravel 5.5**

13. [Implementación de factories para los recursos](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/implementacion-de-factories-para-los-recursos)
- Metiendo datos en las tablas. 
- Tenemos un **factory** para cada uno de los modelos 
- Se reutiliza una variable global (objeto) **$factory** que usa el metodo **define** con **callback**
- Para este fin se usan los **Factories** `<project>\database\factories`
- Ejemplo archivo: **UserFactory.php** 
```php
<?php
use Faker\Generator as Faker;
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//antes para password se usaba la funcion bcrypt("secret")
        'remember_token' => str_random(10),
    ];
});
```
- Se usa libreria [**Faker**](https://github.com/fzaninotto/Faker)
    - Faker es una libreria que sirve para generar datos aleatorios de distintos formatos
    - Números, horas, parrafos, palabras, etc.
- Los factories solo son para el entorno de desarrollo (pruebas)
- `App\Category::class` Devuelve el nombre del modelo
- `\App\Product::AVAILABLE` En php a las constantes se instancian como si fueran variables estáticas
- Es importante el orden. Para el caso de Product["seller_id"] se necesita antes un usuario con lo cual
se debe ejecutar primero el **UserFactory.php**
- Explicación `"seller_id" => User::all()->random()->id,` **video: 15:28**
- Ejemplo de **ProductFactory.php**
```php
<?php
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        "name" => $faker->word,
        "description" => $faker->paragraph(1),
        "quantity" => $faker->numberBetween(1,10),
        //mala práctica, mejor definirlos como constantes en el modelo
        //"status" => $faker->randomElement(["disponible","no_disponible"]),
        //"status" => $faker->randomElement(["si","no"]),
        
        "status" => $faker->randomElement([Product::AVAILABLE,Product::NOT_AVAILABLE]),
        //de todos los usuarios obten uno y de ese id
        "seller_id" => User::all()->random()->id,
        //es lo mismo que el anterior
        //"seller_id" => User::inRandomOrder()->first()->id,
    ];
});
```
- Ejemplo **TransactionFactory.php**
    - Explicación `"product_id" => ,` dependiendo del vendedor **video: 19:44**

```php
<?php
use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    //No uso User pq no tiene relación directa con Transactions
    //Como laravel sabe que Seller tiene Products?. 
    //Esto se hace despues, al configurar las fks en los modelos
    $seller = Seller::has("products")->get()->random();
    $buyer = User::all()->except($seller->id)->random();
    
    return [
        "quantity" => $faker->numberBetween(1,3),
        "buyer_id" => $buyer->id,
        "product_id"=> $seller->products->random()->id,
    ];
});
```

14. [Crear las relaciones entre recursos, mediante los modelos Laravel](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/crear-las-relaciones-entre-recursos-mediante-los-modelos-laravel)
- Configurando interacciones entre modelos (Relaciones)
- **Quen pertenece a es quien tiene la clave foranea**
- **Transaction::class** devuelve el espacio de nombre de la clase en la que se está
- Buyer. Un buyer solo tiene transacciones
    - Un Buyer tiene muchas Transactions (1:n): **hasMany**
    - **$this->hasMany(Transaction::class);** 

```js
[tabla][<entidad>_id]   ->  belongsTo       ->  metodo en singular
[tabla][!<entidad>_id]  ->  hasMany         ->  metodo en plural
[tabla][tabla-pivote]   ->  belongsToMany   ->  metodo plural
```
- Ejemplo **Product**
```php
    //Relaciones:
    //1 product -> 1 seller
    //1 product -> n categories
    //1 product -> n transactions
    
    //product.seller_id -> belongsTo()
    public function seller(){return $this->belongsTo(Seller::class);}
       
    //product.no(transaction_id) -> hasMany()
    public function transactions(){return $this->hasMany(Transaction::class);}   
    
    //product - categories (n:m) -> belongsToMany()
    public function categories(){
        //tabla n:m category_product
        return $this->belongsToMany(Category::class);
    }  
```

- Ejemplo **Transaction**
```php
    //Relaciones:
    //1 transaction -> 1 product

    //transaction.buyer_id -> belongsTo()
    public function buyer(){ return $this->belongsTo(Buyer::class); }
    
    //transaction.product_id -> belongsTo()
    public function product(){ return $this->belongsTo(Product::class);}  
```

15. [Invocar las factory desde DatabaseSeeder](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/invocar-las-factory-desde-databaseseeder)
- DatabaseSeeder esta clase sirve como empaquetador para la generacion de datos
- Uso de **Illuminate\Support\Facades**
- Las clases [**Facade**](https://www.sitepoint.com/how-laravel-facades-work-and-how-to-use-them-elsewhere/) son clases estaticas que mapean un servicio y simplifican su uso
```php
<?php
//acceso común
App::make("some_service")->methodName();
//En facade
someService::methodName();

//app.php:
'aliases' => [
    'App' => Illuminate\Support\Facades\App::class,
    'Artisan' => Illuminate\Support\Facades\Artisan::class,
    'Auth' => Illuminate\Support\Facades\Auth::class,
    'Blade' => Illuminate\Support\Facades\Blade::class,
    'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
...
```

- **comando:** `php artisan db:seed` 
- **comando:** `php artisan migrate:fresh --seed` limpia la bd e inserta los datos 
- Ejemplo **DatabaseSeeder**
    - Explicación callback para datos dependientes. Asignación de categorias a productos **video: 08:24**
    - `...->each(function($product) use ($categories) ...`
    - `->pluck("id")...` Devuelve solo un array con los valores del campo indicado. (array_colum())
    - `...$product->categories()->attach(...`
```php
<?php
use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Category::truncate();
        Transaction::truncate();
        Product::truncate();
        
        //uso de facade
        DB::table("category_product")->truncate();
        
        $cantUser = 1000;
        $cantCategories = 30;
        $cantProducts = 2000;
        $cantTransactions = 1000;
        
        factory(User::class,$cantUser)->create();
        $categories = factory(Category::class,$cantCategories)->create();
        
        //relacion n:m category_product
        //por cada producto que se crea se le agrega categorias
        factory(Product::class,$cantProducts)->create()
                ->each(function($product) use ($categories)
        {
            $rndCategories = $categories->random(mt_rand(1,5))->pluck("id");
            $product->categories()->attach($rndCategories);
        });
        
        factory(User::class,$cantUser)->create();
        factory(Transaction::class,$cantTransactions)->create();
        
        Schema::enableForeignKeyConstraints();
    }//run
}//DatabaseSeeder
```

16. [Consejos para el versionado de las API](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/consejos-para-el-versionado-de-las-api)
- Ejemplo: [stripe.com - plataforma de pagos](https://stripe.com/docs/api)
- Maneras:
    - En url ...api/v1/ en laravel se puede configurar con el prefijo 
    - El problema es que si hago peticiones a la api que no es versionada habria problemas
    - La API resuelve que api necesita el cliente. Se suele usar en empresas grandes
    - Como el API resuelve que version tiene el cliente.
    - Si yo se quien es mi cliente puedo saber que version está usando. Guardando en un campo extra.

17. [Laravel Tinker](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/laravel-tinker)
- **Tinker** interprete de consola para php
- Sirve para hacer pruebas rápidas sin necesidad de crear una ruta y controlador
- **comando:** `php artisan tinker` Habilita la consola para interpretar en tiempo real código php
```ssh
$ php artisan tinker
Psy Shell v0.9.7 (PHP 7.1.15 — cli) by Justin Hileman
>>> $x = 33;
=> 33
>>> echo $x;
33⏎
>>>
```
- **comando en Tinker:** `>>> App\User::all();`

```ssh
=> Illuminate\Database\Eloquent\Collection {#4890
     all: [
       App\User {#4891
         id: "1",
         name: "Paris Tillman",
         email: "shania11@example.org",
         created_at: "2018-08-23 22:49:40",
         updated_at: "2018-08-23 22:49:40",
       },
       App\User {#4892
         id: "2",
         name: "Nikko Bins",
         email: "gideon85@example.com",
         created_at: "2018-08-23 22:49:40",
         updated_at: "2018-08-23 22:49:40",
       },
       App\User {#4893
        ...
```

18. [Conclusión de la clase y preguntas finales](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/conclusion-de-la-clase-y-preguntas-finales)
- [Blog - Laravel Service Container IoC](https://medium.com/@bvipul/facades-in-laravel-why-and-how-b5f6e036e66b)
- [Youtube - Escuela.it: laravel 5 primeros pasos](https://www.youtube.com/watch?v=5YRyOdpM5gM)
- [Blog - What are facades](https://medium.com/a-young-devoloper/understanding-laravel-facades-4802025899e6)
- [Youtube - Escuela.it: Análisis de los Patrones de diseño con Laravel #laravelIO](https://www.youtube.com/watch?v=SCpigk7UToM)
- [Amazon - Libro recomendado de patrones de diseño](https://www.amazon.es/Laravel-Design-Patterns-Best-Practices-ebook/dp/B00M6N1A08)

## LECCIÓN 3
19. [Generalizando el Código y Mejorando el Funcionamiento de la API](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/generalizando-el-codigo-y-mejorando-el-funcionamiento-de-la-api)
- Se agregan rutas faltantes en **routes/api.php**
- **comando:** `php artisan route:list`
- **UserController->index()** - **User::all()**
    - [Illuminate\Database\Eloquent\Collection](https://laravel.com/api/5.7/Illuminate/Database/Eloquent/Collection.html)
    - Ejemplo **User::all()** - Devuelve un objeto de `Illuminate\Database\Eloquent\Collection` con un array de objetos del modelo **App\User**
```php
object( Illuminate\Database\Eloquent\Collection )#207 (1)
{
    ["items":protected] => array(3)
    {
        [0] => object(App\User)#2347 (27) {
            ["table":protected] => string(5) "users"
            ["fillable":protected] =>
            array(3) {
                [0] => string(4) "name"
                [1] => string(5) "email"
                [2] => string(8) "password"
            }
            ["hidden":protected] =>
            array(2) {
                [0] => string(8) "password"
                [1] => string(14) "remember_token"
            }
            ["connection":protected] => string(6) "sqlite"
            ["primaryKey":protected] => string(2) "id"
            ["keyType":protected] => string(3) "int"
            ["incrementing"] => bool(true)
            ["with":protected] => array(0){ }
            ["withCount":protected] => array(0){ }
            ["perPage":protected] => int(15)
            ["exists"] => bool(true)
            ["wasRecentlyCreated"] => bool(false)
            ["attributes":protected] =>
            array(7) {
                ["id"] => string(3) "136"
                ["name"] => string(17) "Brayan Hodkiewicz"
                ["email"] => string(17) "llind@example.org"
                ["password"] => string(60) "$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm"
                ["remember_token"] => string(10) "6vvtrU8jiL"
                ["created_at"] => string(19) "2018-08-23 22:49:42"
                ["updated_at"] => string(19) "2018-08-23 22:49:42"
            }
            ["original":protected] =>
            array(7) {
                ["id"] => string(3) "136"
                ["name"] => string(17) "Brayan Hodkiewicz"
                ["email"] => string(17) "llind@example.org"
                ["password"] => string(60) "$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm"
                ["remember_token"] => string(10) "6vvtrU8jiL"
                ["created_at"] => string(19) "2018-08-23 22:49:42"
                ["updated_at"] => string(19) "2018-08-23 22:49:42"
            }
            ["changes":protected] => array(0){ }
            ["casts":protected] => array(0){ }
            ["dates":protected] => array(0){ }
            ["dateFormat":protected] => NULL
            ["appends":protected] => array(0){ }
            ["dispatchesEvents":protected] => array(0){ }
            ["observables":protected] => array(0){ }
            ["relations":protected] => array(0){ }
            ["touches":protected] => array(0){ }
            ["timestamps"] => bool(true)
            ["visible":protected] => array(0){ }
            ["guarded":protected] =>
            array(1) {
                [0] => string(1) "*"
            }
            ["rememberTokenName":protected] => string(14) "remember_token"
        }//end obj[0]

        [1] => object(App\User)#2571 (27) {
            ["table":protected] => string(5) "users"
            ["fillable":protected] =>
            array(3) {
                [0] => string(4) "name"
                [1] => string(5) "email"
                [2] => string(8) "password"
            }
            ["hidden":protected] =>
            array(2) {
                [0] => string(8) "password"
                [1] => string(14) "remember_token"
            }
            ...
        }//end obj[1]

        [2] => object(App\User)#2571 (27) {
        ...
        }//end obj[2]
    }//end array items
}//end obj Illuminate\Database\Eloquent\Collection 
```
- <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b014de4bc1b8dcc70d83031/3ceea2ccf13b3745b0547ddc94e90bff/image.png" height="100" width="500">
- Es interesante que el **json** devuelto este envuelto en un objeto superior. Este objeto raiz se suele llamar **data**
- `response()->json(["data"=>$oCollection],200);`
```json
{
    "data": [
        {
            "id": 55,
            "name": "Reba Quitzon",
            "email": "coby16@example.com",
            "created_at": "2018-08-23 22:49:41",
            "updated_at": "2018-08-23 22:49:41"
        },
        ...
    ]
}
```
- En el metodo **show(User $user)** hay que tratar la respuesta cuando el id no existe en la bd
- Insert - **store(Request $request)** 
    - Hay que hacer una validación de datos antes de guardar
    - [Reglas de validación admitidas](https://laravel.com/docs/5.6/validation#available-validation-rules)
    - `required | max | unique | confirmed`
    - Al usar **confirmed** creara un campo extra <campo>_confirmation que llegará por POST esto lo gestiona laravel
    ```php
    public function store(Request $request)
    {
        $arData = $request->validate([
            "name" => "required|max:100",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
        ]);
        $arData["password"] = bcrypt($arData["password"]);
        /*
        $arData: array(3) {
          ["name"] => string(4) "juan"
          ["email"] => string(17) "prueba@prueba.com"
          ["password"] => string(60) "$2y$10$koMLOC7rr3jb7nb4qwd.M.EnuIFU8kYSLARwBBzH/nCjGGdzos08W"
        }
        */
        $oUser = User::create($arData);
        //201 es parte del cod http que indica que se ha creado satisfactoriamente una instancia
        return response()->json(["data"=>$oUser],201);   
    }
    ```
    - Si alguna de las reglas de validación falla se lanza una **excepción** - **ValidationException**
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014de4bc1b8dcc70d83031/600x261/45eba66cd208d94cd874843759270707/image.png" height="200" width="600">
    - Si excluimos de hidden los campos: pass y token entonces podemos ver que en la respuesta JSON se incluye esta información
- Segun como está montado el sistema un Buyer y un Seller no se crean ni se destruyen por lo tanto hay que bloquear esos metodos de escritura.
```php
//los otros metodos se quitan. Solo se deja index y show
Route::apiResource("buyers","BuyerController",["only"=>["index","show"]]);
Route::apiResource("sellers","SellerController",["only"=>["index","show"]]);
```

- Actualmente Buyer y Seller devuelven lo mismo en index() (los usuarios)
- Dos endpoints no deberian devolver los mismos recursos
- Hay que corregir los metodos index() para que no devuelvan lo mismo
- Ejemplo para sellers: `Seller::has('products').get();response()->json(["data"=>$sellers],200);`
    - Tener que hacer esto cada vez que se instancia **Seller** es repetir código lo cual es sintoma de una mala práctica
    - Para centralizar la caracteristica `has('products')` se usa el `GlobalScope`
    ```php
    //<project>/app/Scopes/SellerScope.php
    namespace App\Scopes;

    use Illuminate\Database\Eloquent\Scope;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;

    class SellerScope implements Scope
    {
        public function apply(Builder $builder, Model $model) {$builder->has("products");}//apply
    }//SellerScope
    ```

- Para evita estar modificando cada uno de los metodos con la condicionante que restringe los datos se usaria un **GlobalScope**
- **Global Scopes** Es una rutina que se ejecutara siempre en una instancia **video: 00:52:10**
- **protected static function boot** metodo de tipo global scope
- Uso de [**static::**](http://php.net/manual/es/language.oop5.late-static-bindings.php)
- Uso de **static::addGlobalScope(new BuyerScope);**
- Hay que definir la Carpeta **app/Scopes** - **video: 00:53:43**
- Se implementa en las clases Scope el metodo: **public function apply(Builder $builder, Model $model)** con la condición de restricción
- La teoria es que REST solo devuelva un tipo de recurso (no consultas mixtas) a menos que con el tiempo se vea que esto es necesario
- Retocando el **return response()->json(["data" => $entity],200)** **video: 01:05:00**
- Tratando con archivo: **app/Exepctions/Handler.php** metodo: **report(Exception $exception)**
    - Nos permite constuir respuestas de error
- **Traits** Una serie de funciones que podemos implementar de modo que cualquier estructura u otra clase desde cualquier lado lo puede implementar
    - Los **Traits** se usan para emular **herencia multiple** en lenguajes que no tienen esta caracteristica como PHP
    - Crear carpeta **app/Traits**
    - Crear archivo **ApiResponser.php - trait ApiResponser**
    - metodo **function showAll(Collection $collection,$code=200)**
    - importamos **use Illuminate\Support\Collection;** pq es más genérica que **Illuminate\Database\Eloquent\Collection**
    - **showMessage(..)** no se utiilizará pero se deja para que se vea la posibilidad de enviar mensajes
- Ejemplo de `LIKE '%algo%'` **video: 01:15:00**
    - `User::where("name",'%like%',$request->name)->get();`
- Cambios en metodos primitivos aplicando `$this` con metodos del Trait
- El archivo `app/Exepctions/Handler.php`
    - [PHP Customizando Excepciones](http://php.net/manual/es/language.exceptions.extending.php)
    - 
    ```php
    use Illuminate\Validation\ValidationException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use Symfony\Component\HttpKernel\Exception\HttpException;
    use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
    ```
    - **Metodos importantes:** 
    - **function repport(Exception $exeption):** Escribe en el log en: **<project>/storage/logs/laravel.log**
    - Se puede configurar el atributo array **$dontReport** para indicarle que eventos no se deben guardar
    - El atributo **$dontFlash** en errores de validación. Sirve para no reenviar algunos datos recibidos en el servidor como por ejemplo: `password y password_confirmation`
    - **function render($request, Exception $exception)** Una vez que se lanza la Excepcion es el que se ejecuta para resolver que es lo que se tiene que hacer.
    - `render` trata el tipo de `Exception` con `instanceof`. Las que nos interesan son:
        - **AuthenticationException:** `return $this->unauthenticated($request, $e)`
        - Si válido devuelve un json sino redirige a página de login
        - **ValidationException:** `return $this->convertValidationExceptionToResponse($e, $request)`
        - Lo mismo
    - Al ser una **API JSON** deberiamos devolver siempre JSON y no redireccionar
    - Para esto hay que sobrescribir esos metodos aplicando el Trait en Handler
    - 
    ```php
    //app/Exepctions/Handler.php
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException)
            return $this->convertValidationExceptionToResponse($exception,$request);

        return parent::render($request, $exception);
    }//render

    protected function convertValidationExceptionToResponse(ValidationException $exception, $request)
    {
        //errors es un array
        $errors = $exception->validator->errors()->getMessages();
        return $this->errorResponse($errors,422);
        /*
        return $request->expectsJson()
            ? $this->invalidJson($request, $exception)
            : $this->invalid($request, $exception);
         * 
         */
    }//convertValidationExceptionToResponse        
    ```
    - Personalizar los mensajes de error: **video: 01:35:17**
        - Los mensajes de error salen de **<project>/resources/lang/<lang>**
        - Son archivos php de arrays con mapeos `error => mensaje de error`
        - Para cambio de idioma hay que hacerlo en **<project>/config/app.php** item **locale => es**
        - Repo de traducciones de mensajes: [https://github.com/caouecs/Laravel-lang](https://github.com/caouecs/Laravel-lang)

    - Al modificar el tratamiento de excepciones se esta haciendo tanto para las rutas de la API como para las rutas de la web
    - Lo ideal sería tener dos proyectos. Uno web y otro API
    - Si tienes dos proyectos necesitas dos instancias
    - Para Auth si se usaran rutas web
    - Tratando **ModelNotFoundException** `Error 404` - Ocurre cuando se envia un **id** que no existe
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b014de4bc1b8dcc70d83031/b13b888b08113acd05dc65e415be8b99/image.png" height="50" width="300">
    - 
    ```php
    //app/Exepctions/Handler.php
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException)
            return $this->convertValidationExceptionToResponse($exception,$request);
        
        if($exception instanceof ModelNotFoundException)
            return $this->errorResponse("Does not exists any instance with the specified id",404);
            
        return parent::render($request, $exception);
    }//render     
    ```
    - Tratando excepcion **NotFoundHttpException**  `Error 404` **video: 01:44:26** - Ocurre cuando el endpoint no existe
    - Parametrizando el mensaje y código con el objeto `$exception`
    - `$this->errorResponse($exception->getMessage(),$exception->getCode()); `
    - Excepcion: **MethodNotAllowedHttpException** `Error 405` **video: 01:49:00** - Ocurre cuando se usa un metodo `POST,GET,...` no permitido
    - Hay otras tantas excepciones que pueden ocurrir y que no estemos tratando (errores inesperados) para estos casos hay que crear un `return $this->errorResponse("Unexpected error",500);`
    - Como estamos en desarrollo se puede enviar datos de error de excepciones con información que no deberia ser pública. 
    - 
    ```php 
    //Handler.php
    //lee .env APP_DEBUG = true - se está en desarrollo
    if(config("app.debug"))
        return parent::render($request, $exception);
    
    return $this->errorResponse("Unexpected error",500);    
    ```
    - Recuperando el modelo no encontrado
    ```php    
    if($exception instanceof ModelNotFoundException)
    {
        $sModelName = $exception->getModel();
        return $this->errorResponse("No model found with name {$sModelName}",404); 
    }

    {"error":{"message":"No model found with name App\\Seller","code":404}}
      
    if($exception instanceof ModelNotFoundException)
    {
        $sModelName = class_basename($exception->getModel());
        return $this->errorResponse("No model found with name {$sModelName}",404); 
    }
    {"error":{"message":"No model found with name Seller","code":404}}
    ```

- **nota:**
    - no daba con la solución del envio post para store. No es lo mismo **laravelapi/users** que **laravelapi/users/**

## LECCIÓN 4
20. [Comenzando Operaciones Complejas de la API RESTful](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/comenzando-operaciones-complejas-de-la-api-restful)
- Faltan configurar los controladores Product y Categories
- **<project>/routes/api.php - ProductController**
    - Solo va a tener publicados metodos de lectura
    - La creación/modificación dependerá del vendedor 
    - No se puede tratar directamente el `seller_id` en la url pq así se podría permitir que un vendedor cree productos a otro vendedor.  Es algo más complejo
    - Lo mismo pasaria con **Transactions y Buyers**
    - 
    ```php
    //<project>/routes/api.php 
    Route::apiResource("products","ProductController",["only"=>["index","show"]]);
    Route::apiResource("transactions","TransactionController",["only"=>["index","show"]]);
    ```
- Se eliminan los metodos que no se van a utilizar en Product y TransactionController
- **Error** no me devuelve resultados la llamada a categories ni transaction
    - **solucion** netbeans no copiaba los cambios en www
- **video: 00:10:08** url: `http://127.0.0.1:8000/sellers/1/products/5` con PATCH
    - Si intento actualizar el producto mediante esa url y como products tiene una clave foranea **seller_id** necesito enviarle que vendedor está haciendo el cambio, podría enviarle en la url el `/seller/{id}/products/5` pero se tratara por separado en un controlador más complejo, donde se requerira datos del vendedor y del producto.

- **video: 00:13:21** antes de guardar hay que validar las restricciones por campo que están en migration. 
- Se valida por separado para evitar una Excepcion
- en `update` el metodo `$request->only(["name","description"])` indica que solo guardara lo que venga con datos
```php
//<project>/app/Http/Controllers/CategoryController.php
public function store(Request $request)
{
    //en la migración estan las restricciones de los campos y estas hay que validarlas
    //<project>/database/migrations/2018_08_18_131136_create_categories_table.php
    $data = $request->validate([
        "name" => "required|max:255",
        "description" => "required|max:1000"
    ]);
    $category = Category::create($data);
    return $this->showOne($category,201);
}//store

public function update(Request $request, Category $category)
{
    $request->validate([
        "name" => "max:255",
        "description" => "max:1000"
    ]);
    
    //fill nos asegura que solo se trate los valores que llegan por post
    $category->fill($request->only(["name","description"]));
    //si no hay cambios
    if($category->isClean())
        return $this->errorResponse("You need to specify any new value to update the category",422);

    $category->save();
    return $this->showOne($category);
}//update

public function destroy(Category $category)
{
    $category->delete();
    return $this->showOne($category);
}//destroy
```
- **video: 00:23:00** Cruzando todos con todos
- Según la imágen UML vamos cruzando de forma transitiva 
- Operaciones complejas:
    - Ejemplo **TransactionCategoryController:** `<p:padre><m:modelo-a-devolver>Controller`
    - Devolverá **las categorías de una transacción**
    - **comando:** `php artisan make:controller TransactionCategoryController -m Category -p Transaction` crea controlador de recurso anidado
    - metodo `public function index(Transaction $transaction)` recibe la transaccion que tiene las categorias a devolver.
    - metodo `public function show(Transaction $transaction, Category $category)` no solo necesito la transacción sino tambien la categoria de esa transacción que se mostrara
    - Para unas operaciones basta implementar el padre y otras ambos objetos, padre y modelo
- Gran parte de estas operaciones no son obligatorias
- **video: 00:34:34** Rutas y endpoints similares
    - Que pasa si se quiere eliminar una categoria asociada a una transacción
    - Para eliminar la categoria no es necesaria la transacción
    - Como ya se tiene un metodo **destroy** en **Categories** no hace falta configurarlo en **TransactionCategoryController**
    - Es más sencillo poner: `categories/{id}` que `transactions/{id}/categories/{id}`
    - solo necesitariamos el método **index()** que nos devolveria la lista de categorias asociadas a una transacción
    - **video: 00:37:37** configurando rutas con recursos complejos o anidados
    - `Route::apiResource(<padre-plural>.<modelo-plural>,<controlador>)`
    - `Route::apiResource("transactions.categories","TransactionCategoryController",["only"=>["index"]]);`
    -
    ```ssh
     | GET|HEAD  | transactions/{transaction}/categories | transactions.categories.index App\Http\Controllers\TransactionCategoryController@index | api        |
    ```
    - **video: 00:40:18** configurando metodo 'complejo' *index*
- **video: 00:44:33** haciendo una pausa para organizar nuestro código **Refactoring**
    - Se va a categorizar todo por recursos.
    - Crear carpetas dentro de controllers con los nombre de los grupos
- **video: 00:44:50** Creando carpetas. En singular y CamelCase.
    - Se cambian los controladores a las carpetas
    - Se retoca el espacio de nombre de cada controlador movido
    - En cada controlador que extiende de Controller se importa con: `use App\Http\Controllers\Controller;` el controlador. Antes no era necesario pq estaban en el mismo espacio: `use App\Http\Controllers`
    - Se actualizan los controladores con sus espacios de nombre (las carpetas) en `<project>/routes/api.php`
    - 
    ```php
    Route::apiResource("products","Product\ProductController",["only"=>["index","show"]]);
    Route::apiResource("transactions","Transaction\TransactionController",["only"=>["index","show"]]);
    Route::apiResource("transactions.categories","Transaction\TransactionCategoryController",["only"=>["index"]]);
    Route::apiResource("categories","Category\CategoryController");    
    ```
- Creo **<project>/app/Http/Controllers/Transaction/TransactionSellerController.php**
    - **comando:** `php artisan make:controller Transaction/TransactionSellerController -m Category -p Transaction`
    - Va a obtener los vendedores asociados a una transacción. Quién fue el que vendió.
    - Solo vamos a implementar el metodo **index()** y no **show()**. Index devolverá solo uno ya que el sistema está configurado así. Pero en otros casos podria devolver más de 1
    -
```php
//<project>/app/Http/Controllers/Transaction/TransactionSellerController.php
    public function index(Transaction $transaction)
    {
        $oCollection = $transaction->product->seller;
        //showOne pq de antemano sabemos que es solo un elemento de seller por transacción
        //return $this->showOne($oCollection);
        return $this->showAll($oCollection->get()); 
        //da error: Argument 1 passed to App\Http\Controllers\Controller::showAll() must be an instance of Illuminate\Support\Collection, instance of App\Seller given
        //return $this->showAll($oCollection->get());  va bien
    }//index
```
    - ruta: `laravelapi:8000/transactions/1/sellers`
- **video: 00:58:46** Explicación **Restfull Purista**
    - Si se pide usuarios se retorna usuarios. Un tipo de recurso por petición salvo justificadas excepciones. 
    - Para la primera versión de la API esto es ley.
    - Consultas mixtas recurrentes.
    - Ejemplo:
        - cien productos y peticiones sucesivas para obtener las categorias de cada producto es mejor crear un **endpoint**
        que **devuelva los productos con sus categorias**
        - **laravelapi:8000/products/categories**
        - Esta url romperia el **standard**. Las rutas de recurso no serian de mucha utilidad y habria que tratar de forma manual la ruta.
        - En routes/api.php:
        ```php
        Route::get("/products/categories","ProductCategoryController@showAll");
        ```
- **video: 01:01:40** Recurso padre: Buyer
    - BuyerTransactionController, BuyerProductController, BuyerSellerController y BuyerCategoryController
    - BuyerProductController
        - El salto hay que hacerlo utilizando transactions. No valdria con: `$buyer->transactions->products`
        - `$buyer->transactions` devuelve una colección por lo tanto no existe una propiedad `products`
        - habría que recorrer toda la coleccíon y obtener una a una los productos
        - **eagerloading - with()** permite obtener recursos junto con sus propiedades
        - **video: 01:11:00** resuelve el n+1 en las consultas. En lugar de tener que lanzar una consulta por separado por cada transacción
        ```sql
        -- todas las transacciones de un comprador y todos los productos de esas transacciones
        SELECT DISTINCT t.*,p.*
        FROM products p
        INNER JOIN transactions t
        ON p.id = t.product_id
        INNER JOIN users b
        ON b.id = t.buyer_id
        WHERE 1=1
        AND b.id = {buyers/id}
        ```
        ```php
        public function index(Buyer $buyer)
        {
            //transactions():ret $this->hasMany(Transaction::class); 
            //  with("product"): Transaction.product() 
            //      ret $this->belongsTo(Product::class)
            $oCollection = $buyer->transactions()
                                ->with("product")
                                ->get();
            return $this->showAll($oCollection);
        }
        ```
        - Aqui devuelve las transacciones con todos sus productos, pero el objetivo es que devuelva solo los productos
        - Para esto usamos [pluck()](https://laravel.com/docs/5.6/collections#method-pluck)
        ```php
        $oCollection = $buyer->transactions()
                                ->with("product")
                                ->get()
                                //recuperar solo productos
                                ->pluck("product");
        ```
    - BuyerSellerController
        - Devolver solo vendedores de un comprador 
        ```php
        //se repite 751
        $oCollection = $buyer->transactions()
                    ->with("product.seller")
                    ->get()
                    ->pluck("product.seller")

        {"data":[{"id":114,"name":"Amalia Wunsch","email":"anika.fahey@example.org","created_at":"2018-08-23 22:49:42",
        "updated_at":"2018-08-23 22:49:42"},{"id":751,"name":"Esteban Kessler","email":"skunde@example.org",
        "created_at":"2018-08-23 22:49:49","updated_at":"2018-08-23 22:49:49"},{"id":751,"name":"Esteban Kessler",
        "email":"skunde@example.org","created_at":"2018-08-23 22:49:49","updated_at":"2018-08-23 22:49:49"}]}

        $oCollection = $buyer->transactions()
                    ->with("product.seller")
                    ->get()
                    ->pluck("product.seller")
                    ->unique("id") //elimina repetidos
                    ->values() //reorganiza nueva collección y evita un array asociativo "id":objeto

        {"data":[{"id":114,"name":"Amalia Wunsch","email":"anika.fahey@example.org","created_at":"2018-08-23 22:49:42",
        "updated_at":"2018-08-23 22:49:42"},{"id":751,"name":"Esteban Kessler","email":"skunde@example.org",
        "created_at":"2018-08-23 22:49:49","updated_at":"2018-08-23 22:49:49"}]}
        ```
        ```sql
        -- distintas transacciones que repiten comprador y vendedor
        select t.id transaction_id,t.buyer_id,ps.seller_id
        from transactions t
        inner join 
        (
            SELECT DISTINCT p.id product_id,p.seller_id
            FROM products p
            INNER JOIN users s
            ON p.seller_id = s.id
        ) ps
        ON t.product_id = ps.product_id
        GROUP BY t.buyer_id,ps.seller_id
        HAVING COUNT(transaction_id)>1
        ORDER BY ps.seller_id,t.buyer_id
        +----------------+----------+-----------+
        | transaction_id | buyer_id | seller_id |
        +----------------+----------+-----------+
        |           1000 |     1106 |       751 |
        +----------------+----------+-----------+
        ```
        - Devolver las categorias de un comprador
        - `laravelapi:8000/buyers/1106/categories`
        ```sql
        -- todas las categorias de un comprador
        SELECT DISTINCT c.*
        FROM categories c
        INNER JOIN category_product cp
        ON c.id = cp.category_id 
        INNER JOIN transactions t 
        ON t.product_id = cp.product_id
        INNER JOIN users b
        ON b.id = t.buyer_id
        WHERE 1=1
        AND b.id = 1106
        ```
        ```php
        //<project>/app/Http/Controllers/Buyer/BuyerCategoryController.php
        public function index(Buyer $buyer)
        {
            $oCollection = $buyer->transactions()
                        //recuperación usando tabla pivote (category_product). Se utiliza .
                        ->with("product.categories")
                        ->get()
                        ->pluck("product.categories") 
            //hasta aqui, pluck, muestra un array de arrays. Array de productos con su array de categorias
                        ->collapse() 
            //quita el array superior y solo deja el de categorias. video: 01:27:42 metodo collapse()
                        ->unique("id") //elimina repetidos
                        ->values() //reorganiza nueva collección y evita un array asociativo "id":objeto
            ;
            return $this->showAll($oCollection);
        }//Index        
        ```
- Traducción de los mensajes en las excepciones
    - Las validaciones se traducen en **<project>/resources/lang/en/validation.php**
    - Las excepciones (mensajes en **<project>/app/Exceptions/Handler.php**) se harian con helpers y las funcionalidades de [**localize**](https://laravel.com/docs/5.6/localization)
    - Podriamos crear nuesto archivo en: **<project>/resources/lang/<idioma>/errors.php**
    - función `__(archivo.indice)`

### LECCION 5
21. [Objetivos en la clase 5](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/objetivos-en-la-clase-5)
- Objetivos de la lección 5

22. [Controlador complejo Category-Transaction](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/controlador-complejo-category-transaction)
- uso de **->whereHas()**
- **comando:** `$ php artisan make:controller Category/CategoryTransactionController -p Category -m Transaction`
```php
//<project>/app/Http/Controllers/Category/CategoryTransactionController.php
public function index(Category $category)
{
    $oCollection = $category->products()
                    //whereHas: solo producto que tengan transacciones
                    ->whereHas("transactions")
                    //solo las transacciones
                    ->with("transactions")
                    ->get() //ejecuta la consulta
                    ->pluck("transactions")
                    ->collapse()
            ;
    return $this->showAll($oCollection);
}//index
```
```sql
-- las transacciones de una categoria
SELECT DISTINCT t.*
FROM categories c
INNER JOIN category_product cp
ON c.id = cp.category_id 
INNER JOIN transactions t -- whereHas
ON t.product_id = cp.product_id
WHERE 1=1
AND c.id = 10
```

23. [Controlador complejo Category-Buyer](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/controlador-complejo-category-buyer)
- **comando:** `$ php artisan make:controller Category/CategoryBuyerController -p Category -m Buyer`
```php
//<project>/app/Http/Controllers/Category/CategoryBuyerController.php
public function index(Category $category)
{
    $oCollection = $category->products()
                //whereHas: solo producto que tengan transacciones
                ->whereHas("transactions") //inner join prod on trans
                //solo las transacciones
                ->with("transactions.buyer") //inner join trans on user
                ->get() //ejecuta la consulta
                ->pluck("transactions") //distinct transactions
                ->collapse()
                ->pluck("buyer") //buyer.*
                ->unique("id") //distinct
                ->values()//solo devuelve valores de un array [clave=>valor]
            ;
    return $this->showAll($oCollection);
}//index
```
```sql
-- los comparadores de una categoria
SELECT DISTINCT b.*
FROM users b
INNER JOIN transactions t
ON t.buyer_id = b.id
INNER JOIN category_product cp
ON cp.product_id = t.product_id
WHERE 1=1
AND cp.category_id = 8
```

24. [Otros de controladores complejos asociados a categorías](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/otros-de-controladores-complejos-asociados-a-categorias)
- **comando:** `$ php artisan make:controller Category/CategoryProductController -p Category -m Product`
- **comando:** `$ php artisan make:controller Category/CategorySellerController -p Category -m Seller`
- En este caso accedemos a products de forma directa: 
```php
//<project>/app/Http/Controllers/Category/CategoryProductController.php
public function index(Category $category)
{
    //no se usa parentesis, pq el paretensis ayuda a acceder al querybuilder 
    //que a su vez sirve para añadir más restricciones
    $oCollection = $category->products;
    return $this->showAll($oCollection);
}//index

//esto hay que quitarlo
"pivot": {"category_id": "10","product_id": "28"}

//<project>/app/Http/Controllers/Category/CategorySellerController.php
public function index(Category $category)
{
    $oCollection = $category->products()
            ->with("seller")->get()
            ->pluck("seller")
            ->unique("id")
            ->values()
        ;
    return $this->showAll($oCollection);
}//index
```

25. [Cómo eliminar los datos pertenecientes a una tabla pivote](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/como-eliminar-los-datos-pertenecientes-a-una-tabla-pivote)
- Laravel por defecto muestra los datos de la tabla pivote en `"pivot" : ...`
- No queremos que sea **visible**
```php
//hay que aplicarlo en los modelos Category y Product
protected $hidden = ["pivot"];
```
- De momento la **API** es solo **API** y no es **RESTful**
- Pasar parametros a index(param)
- Se pasa como simple querystring `...&orderby=name`
- `$collection->sortBy("price")`
- Como verifico que ese parámetro existe en la petición?: **video: 00:04:45**
    ```php
    request()->has("sortby");
    request->sortby;//name
    $collection->ordeBy(request->sortby);
    ```
- Traer los datos ordenados desde la bd (con el querybuilder). Esto es usar el método `->orderBy()` antes del método `->get()`

26. [Controladores complejos que dependen de Seller](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/controladores-complejos-que-dependen-de-seller)
- **comando:** `$ php artisan make:controller Seller/SellerTransactionController -p Seller -m Transaction`
- **postman:** `http://laravelapi:8000/sellers/15/transactions`
```php
//<project>/app/Http/Controllers/Seller/SellerTransactionController.php
    $oCollection = $seller->products()  //products.seller_id = s.id
            ->whereHas("transactions")  //products.id = transactions.product_id
            ->with("transactions")      //transactions.*
            ->get()
            ->pluck("transactions")     //quita el indice asociativo
            ->collapse()                //distinct transactions.*
    ;
    //dd($oCollection);
    return $this->showAll($oCollection);
```
```sql
-- las transacciones de un vendedor
SELECT DISTINCT t.*
,p.seller_id
FROM transactions t
INNER JOIN products p
ON t.product_id = p.id
WHERE 1=1
AND p.seller_id = 15
-- ORDER BY 7

+-----+---------------------+---------------------+----------+------------+----------+-----------+
| id  |     created_at      |     updated_at      | quantity | product_id | buyer_id | seller_id |
+-----+---------------------+---------------------+----------+------------+----------+-----------+
| 370 | 2018-08-23 22:52:01 | 2018-08-23 22:52:01 |        2 |        190 |      241 |        15 |
| 806 | 2018-08-23 22:52:06 | 2018-08-23 22:52:06 |        1 |        190 |     1222 |        15 |
| 853 | 2018-08-23 22:52:06 | 2018-08-23 22:52:06 |        1 |        190 |      894 |        15 |
+-----+---------------------+---------------------+----------+------------+----------+-----------+

{"data":[
    {"id":370,"created_at":"2018-08-23 22:52:01","updated_at":"2018-08-23 22:52:01","quantity":"2"
    ,"product_id":"190","buyer_id":"241"},{"id":806,"created_at":"2018-08-23 22:52:06"
    ,"updated_at":"2018-08-23 22:52:06","quantity":"1","product_id":"190","buyer_id":"1222"}
    ,{"id":853,"created_at":"2018-08-23 22:52:06","updated_at":"2018-08-23 22:52:06","quantity":"1"
    ,"product_id":"190","buyer_id":"894"}]}
```
- `Route::apiResource("sellers.categories","Seller\SellerCategoryController",["only"=>["index"]]);`
- **postman** `http://laravelapi:8000/sellers/15/categories`
```php
//<project>/app/Http/Controllers/Seller/SellerCategoryController.php
$oCollection = $seller->products()  //products.seller_id = s.id
        ->whereHas("categories")  //products.id = cateogory_product.product_id
        ->with("categories")      //categories.*
        ->get()
        ->pluck("categories")     //extrae los arrays de categories del array de arrays
        ->collapse()              //quita los indices
        ->unique("id")            //distinct
        ->values()                //solo valores. Siempre que se llama a unique hay que llamar a values
;
```
```sql
-- las categorias de un vendedor
SELECT DISTINCT c.*
FROM categories c
INNER JOIN category_product cp
ON cp.category_id = c.id
INNER JOIN products p
ON cp.product_id = p.id
WHERE 1=1
AND p.seller_id = 15
```

27. [Controlador complejo Seller-Buyer](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/controlador-complejo-seller-buyer)
- **comando:** `$ php artisan make:controller Seller/SellerBuyerController -p Seller -m Buyer`
```php
//<project>/app/Http/Controllers/Seller/SellerCategoryController.php
$oCollection = $seller->products()  //products.seller_id = s.id
        ->whereHas("transactions")  //products.id = transactions.product_id
        //->with("transactions.buyer") //transactions.buyer_id = users.id esta se podría omitir
        ->get()                      //devuelve el array de transacciones
        ->pluck("transactions")     //extrae los arrays de transactions del array de arrays
        ->collapse()              //quita los indices
        ->pluck("buyer")            //buyers.*
        ->unique("id")            //distinct
        ->values()                //solo valores
;
```
28. [Operaciones con productos asociados a vendedor](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/operaciones-con-productos-asociados-a-vendedor)
- **comando:** `php artisan make:controller Seller/SellerProductController -p Seller -m Product`
- En `routes/api.php` **except => ["show"]** y posiblemente **create y edit** si hay rutas de recursos (web) **video: 00:02:34**
- Es el controlador central junto al de las transacciones
- Tendra métodos: **index, store, update y destroy**
- Estaremos mostrando un producto perteneciente a un vendedor
- El método **show** ya está definido en **ProductController**
- **postman:** `http://laravelapi:8000/sellers/23/products`

29. [Almacenar nuevos productos asociados a un vendedor](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/almacenar-nuevos-productos-asociados-a-un-vendedor)
- Implementación de método **SellerProductController.store**
- **postman:** `POST => http://laravelapi:8000/sellers/23/products`
```php
//<project>/app/Http/Controllers/Seller/SellerProductController.php
public function store(Request $request, Seller $seller)
{
    $data = $request->validate([
        "name" => "required|max:255",
        "description" => "required|max:1000",
        "quantity" => "required|integer|min:1",
    ]);
    //El producto tiene un estado: Disponible o No disponible. 
    //Para que esté disponible debe tener al menos una categoria
    //por defecto se crea NOT_AVAILABLE
    $data["status"] = Product::NOT_AVAILABLE;
    $data["seller_id"] = $seller->id; //el seller_id no se recupera de la url
    $product = Product::create($data);
    return $this->showOne($product,201);
}//store
```
30. [Actualizaciones y borrados sobre productos de un vendedor](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/actualizaciones-y-borrados-sobre-productos-de-un-vendedor)
- Implementación métodos **update y destroy**
- Petición de tipo **PUT o PATCH**
- El formulario hay que enviarlo en **form-urlencoded**
- **postman:** `PUT http://laravelapi:8000/sellers/15/products/190`
- **postman:** `DELETE => http://laravelapi:8000/sellers/15/products/190`
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014de4bc1b8dcc70d83031/600x438/9e13a1558e41b18ce652cc1aa2eff32f/image.png" height="200" width="400">
```php
//<project>/app/Http/Controllers/Seller/SellerProductController.php
public function update(Request $request, Seller $seller, Product $product)
{
	$data = $request->validate([
		"name" => "max:255",
		"description" => "max:1000",
		"quantity" => "integer|min:1",
		//esto obliga a que status tenga solo estos valores
		"status" => "in:" . Product::AVAILABLE . "," . Product::NOT_AVAILABLE
	]);    
	
	//tenemos que verificar si la persona que hace la actualizacion es la propietaria del producto
	//se puede hacer por "policies"
	//Este método disparará una excepción y como aqui no estoy tratandola se ejecutará el Handler (//<project>/app/Exceptions/Handler.php)
	$this->checkSeller($seller,$product);
	
	//no tratamos el estado aqui pq más adelaten se tratará 
	//$product->fill($request->only(["name","description","quantity"]));
	$product->fill($data); //versión mejorada
	
	//si el estado va a cambiar a disponible tenemos que verificar que el producto tenga una categoria
	//se ha pasado a disponible pero no tiene categorias
	if($product->status = Product::AVAILABLE && $product->categories()->count()===0)
		return $this->errorResponse ("An active product must have at least one category",409);
	
	//el producto no ha cambiado
	if($product->isClean())
		return $this->errorResponse ("Please specify at least one new value to update",422);
	
	$product->save();
	
	return $this->showOne($product);
}//update

private function checkSeller(Seller $seller, Product $product)
{
	if($seller->id != $product->seller_id) 
		//throw new HttpException(422, "The specified seller is not the actual seller of this product");
		//mejor 403 operación no permitida
		throw new HttpException(403,"The specified seller is not the actual seller of this product");
}//checkSeller

public function destroy(Seller $seller, Product $product)
{
	//tenemos que elimnar el producto asociado a un vendedor
	$this->checkSeller($seller, $product);
	$product->delete();
	return $this->showOne($product);
}//destroy
```

31. [Resto de operaciones del API](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/resto-de-operaciones-del-api)
- **comandos:** 
    `php artisan make:controller Product/ProductTransactionController -p Product -m Transaction`
    `php artisan make:controller Product/ProductBuyerController -p Product -m Buyer`
    `php artisan make:controller Product/ProductCategoryController -p Product -m Category`
        - Aqui hay dos operaciones interesantes **video: 00:04:40**
        - **update** y **destroy**
- **update**
    - En laravel para realizar esta acción tenemos 3 posibles metodos:
    - **attach, sync, syncWithoutDetaching**
    - **attach** permite crear de forma repetida la misma categoria. Un producto podría tener la misma categoría dos veces. *no nos vale!*
    - **sync** recibe un **id** borra todas las categorias asociadas y agrega la nueva *tampoco nos vale!*
    - **syncWithoutDetaching** Si tenemos dos repetidas nos deja solo una. *Se aplica esta*
    - **video: 00:08:41**
    - `PUT laravelapi:8000/products/8/categories/4`
    ```php
    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }    
    ```
    - Hay una restricción, y es que si el "seller" (usuario) no es dueño de ese producto no debería poder agregar la categoría. **video 00:11:39**
    - Se puede hacer la validación llamando al método: **`SellerPorductController::checkSeller(seller,product)`**
    - Para evitar copiar este método en el controlador: `ProductCategoryController`se pasa a `SellerProductController`
    - Despues de hacer el cambio, se comprueba que no se recibe desde ningún lado el **Seller** con lo cual no es posible ejecutar el método **checkSeller**. El **endpoint** no suministra esta información
    - Usando **policies y gates** se podría tratar esta casuistica

- **destroy**
    - Se elimina el registro en la tabla pivote
    - `DELETE laravelapi:8000/products/8/categories/8`
    ```php
    public function destroy(Product $product, Category $category)
    {
        //se elimina la relación en la tabla pivote
        if(!$product->categories()->find($category->id))
        {
            return $this->errorResponse("The specified category is not a category of this product",404);
        }

        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }//destroy    
    ```

32. [Operación de creación de transacciones](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/operacion-de-creacion-de-transacciones)
- Creación de transacciones. La posibilidad de comprar.
- Se necesitarán tres recursos: **producto, comprador y la transacción**
- El controlador lo crearemos de una forma manual ya que laravel no da la posibilidad de crear controladores con más de dos recursos en su interior.
- El controlador irá dentro de la carpeta de **product**
- **comando:** `php artisan make:controller Product/ProductBuyerTransactionController -r` r: controlador de recurso
- `POST laravelapi:8000/products/3/buyers/1/transactions` 
    - quantity:1
- En este punto la API tiene todas las operaciónes posibles
- Todavía **NO** es **RESTFUL**
```php
class ProductBuyerTransactionController extends Controller
{
    public function store(Request $request, Product $product, User $buyer)
    {
        $request->validate([
            "quantity" => "required|integer|min:1"
        ]);

        //para comprar no se puede ser el mismo vendedor
        if($buyer->id == $product->seller_id)
        {
            return $this->errorResponse("the buyer must be different from the seller",409);
        }

        if($product->status === Product::NOT_AVAILABLE)
        {
            return $this->errorResponse("The product is not available yet. Try later",409);
        }

        if($product->quantity < $request->quantity)
        {
            return $this->errorResponse("The product does not have enough unit for this transaction",409);
        }

        $product->quantity -= $request->quantity;
        $product->save();

        $transaction = Transaction::create([
            "quantity" => $request->quantity,
            "buyer_id" => $buyer->id,
            "product_id" => $product->id,
        ]);
        return $this->showOne($transaction,201);
    }//store
}//ProductBuyerTransactionController
```

33. [Agregando Nuevas Características a la API y Transformando las Respuestas para Aumentar la Compatibilidad](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/agregando-nuevas-caracteristicas-a-la-api-y-transformando-las-respuestas-para-aumentar-la-compatibilidad)
- Capa extra de mapeo entre los modelos y el json
- [Laravel Eloquent Resources](https://laravel.com/docs/5.7/eloquent-resources) (sustituye a Fractal)
- API Resources
- **comando:** `php artisan make:resource User`
- Laravel antes de montar una respuesta en JSON llama al método **`toArray($oRequest)`**
- En este método se configura `["alias" => this->atributo,...]`
```php
//App\Http\Resources
class UserResource extends Resource
{
    ...
    public function toArray($oRequest)
    {
        return [
            "id" => $this->id,
            "name" => $this->name
            ...
        ];
    }//toArray
```
- **comando:** `php artisan make:resource UserResource`
```php
//<project>/app/Http/Resources/UserResource.php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }//toArray

    //como quedaría
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            "identifier" => $this->id,
            "full_name" => $this->name,
            "email_address" => $this->email,
            "last_modified" => (string)$this->updated_at,
            "creation_date" => (string)$this->created_at
                
        ];
    }//toArray

}//UserResource
```
- **comando:** `php artisan make:resource BuyerResource`
- **comando:** `php artisan make:resource TransactionResource`
- **comando:** `php artisan make:resource ProductResource`
- **comando:** `php artisan make:resource CategoryResource`
- **comando:** `php artisan make:resource SellerResource`
- Relación **UserController::index() / UserResource::** - **video: 00:08:18**
- `return UserResource::collection($oCollection);`
- En `toArray()` se puede usar `this->atributo` ya que laravel por defecto agrega esos atributos al recurso usando el objeto `resource`
```php
//
namespace App\Http\Controllers\User;
...
class UserController extends Controller
{
    ...
    public function index()
    {
        $oCollection = User::all();
        $oCollection = UserResource::collection($oCollection);
        return $oCollection;
...
```
- Para las peticiones **GET** va bien la transformación en resources pero que pasa para las peticiones **POST** **video: 00:19:40**
- Le decimos al controlador que el recurso se encargará de las validaciones y la escritura en la BD
- Se retoca el Trait: `ApiResponser.php`
```php
function showAll(Collection $collection,$code=200)
{
    if($collection->isEmpty())
    {
        $arData = ["data"=>$collection];
        return $this->successReponse($arData,$code);
    }
    
    //resource apunta a //<project>/app/Http/Resources/<Model>Resource.php
    $resource = $collection->first()->resource;
    $transformedCollection = $resource::collection($collection);
    $arData = ["data"=>$transformedCollection];
    
    return $this->successReponse($arData,$code);
}//showAll

function showOne(Model $oModel, $code=200)
{
    //Http/Resources/<Model>Resource.php
    $oModelResource = $oModel->resource;
    $oResource = new $oModelResource($oModel);
    /*
si no paso el modelo como argumento:
    - public function __construct($resource) constructor de JsonResource
Symfony\Component\Debug\Exception\FatalThrowableError: Too few arguments to function Illuminate\Http\Resources\Json\JsonResource::__construct(), 0 passed in <project>\app\Traits\ApiResponser.php on line 44 and exactly 1 expected in file <project>\vendor\laravel\framework\src\Illuminate\Http\Resources\Json\JsonResource.php on line 55        */
    $arData = ["data"=>$oResource];
    return $this->successReponse($arData,$code);
}//showOne

```

```php
//BaseResource.php
public static function mapAttribute($attribute,$invert=FALSE)
{
    if($invert)
        return array_flip(static::map)[$attribute];
    return static::$map[$attribute];
}

public function toArray($request)
{
    //return parent::toArray($request);
    //attributesToArray es un metodo de laravel del modelo los que estan visibles
    $visibleAttributes = $this->resource->attributesToArray();
    $arAttrMapped = [];
    
    foreach($visibleAttributes as $attribute => $value)
        $arAttrMapped[static::mapAttribute($attribute)] = $value;
    
    return $arAttrMapped;
}//toArray
```
- **video 01:06:40** En este punto se acaba de configurar con herencia de **BaseResource** los recursos y están funcionando.
- Configurando los controladores para que acepten llamadas con los **aliases** del array de mapeo en los recursos.
- En el controlador se crean dos metodos de transformación del objeto **$request** de modo que se pueda validar según los atributos originales y las reglas ya definidas en los metodos.
- **error: No me funciona el metodo POST de sellers/3/products (store)**
    - Era: `$rules = $this->validate([]) y debía ser $rules = []`
- Prueba de compra: `laravelapi:8000/products/500/buyers/1/transactions`
- Configurando HATEOAS **video: 01:45:10**
    - [Youtube - RESTful con Laravel: ¿Qué es HATEOAS y Por Qué Usarlo?](https://www.youtube.com/watch?v=hvbDNsmL0lE)
    - HATEOAS agrega enlaces entre recursos
    - Hace referencia a un elemento particular que se denomina **negociación de contenido**.
    - La negociación de contenido se aplica para casos en los que la API devuelve distintos formatos de respuesta de modo que el cliente pueda escoger alguno de preferencia.
    - Se agrega un nuevo recurso llamado **links**
```php
//<project>/app/Http/Resources/SellerResource.php
public function toArray($request)
{
    $transform = parent::toArray($request);
    
    $hateoas = [
        "links" => [
            "rel" => "self",
            "href" => route("sellers.show",$this->id),
        ]
    ];
    
    $transform = array_merge($transform,$hateoas);
    return $transform;
} 
```
- Resultado:
```json
{
    "data": [
        {
            "identifier": 3,
            "full_name": "Cassandra McClure DVM",
            "email_address": "madisyn.gleason@example.net",
            "creation_date": "2018-08-23 22:49:40",
            "last_modified": "2018-08-23 22:49:40",
            "links": {
                "rel": "self",
                "href": "http://laravelapi:8000/sellers/3"
            }
        },
```
34. [Implementando HATEOAS en la API](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/implementando-hateoas-en-la-api)

- 

<hr/>

## DESPLIEGUE EN PRODUCCIÓN
- Incluir archivo `usererrorhandler.php` si fuera necesario
- [Instalar laravel en 1n1 uf4no ingles](http://www.uf4no.com/articles/guide-to-deploy-laravel-5-app-to-shared-hosting-1and1-9)
- [Instalar laravel en 1n1 laracasts ingles](https://laracasts.com/discuss/channels/servers/install-laravel-in-1and1-servers)
    - **comando: `$mkdir -p hello/goodbye`** **-p** indica que si no existe la carpeta padre la crea
    - **comando: `ls -s`** **-s** crea un link **s**imbolico al archivo [`ls`](http://manpages.ubuntu.com/manpages/xenial/man1/ln.1.html)
    - **comando: `source ~/.profile`** Ejecuta el archivo `.profile` que es parte de un bash
    - **comando: `curl -sS https://getcomposer.org/installer | php`** El comando curl hace una transferencia de archivos `-s`: silent, `S`: show error `| php`: ???ni idea
    - **comando: `php composer.phar install`**
- Crear archivo: **.env**
    - Retocar el dominio
- Al ejecutar da **error**: `No application encryption key has been specified`
- Ejecutar **comando:** `php artisan key:generate`
    - Escribe en `.env`, `APP_KEY=base64:aNZ+S0Rq3xNuqHOemgYdh3jfEnXEQkox6IIID5VFbqs=`
```ssh
$ php artisan key:generate
Application key [base64:aNZ+S0Rq3xNuqHOemgYdh3jfEnXEQkox6IIID5VFbqs=] set successfully.
```
```ssh
# ejecutar 
source ~/.profile
php artisan tinker
```

- El home ya no da error, pero si la ruta: **error:** `http://<dominio>/users`
```
Internal Server Error
The server encountered an internal error or misconfiguration and was unable to complete your request.
Please contact the server administrator at to inform them of the time this error occurred, and the actions you performed just before this error.
More information about this error may be available in the server error log.
Additionally, a 500 Internal Server Error error was encountered while trying to use an ErrorDocument to handle the request.
```
- ### Solucion
- Había que aplicar el cambio en .htaccess 
```ssh
#http://www.uf4no.com/articles/guide-to-deploy-laravel-5-app-to-shared-hosting-1and1-9
RewriteRule ^ /index.php
```

## PHP ARTISAN CLI
```ssh
Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  clear-compiled       Remove the compiled class file
  down                 Put the application into maintenance mode
  env                  Display the current framework environment
  help                 Displays help for a command
  inspire              Display an inspiring quote
  list                 Lists commands
  migrate              Run the database migrations
  preset               Swap the front-end scaffolding for the application
  serve                Serve the application on the PHP development server
  tinker               Interact with your application
  up                   Bring the application out of maintenance mode
 app
  app:name             Set the application namespace
 auth
  auth:clear-resets    Flush expired password reset tokens
 cache
  cache:clear          Flush the application cache
  cache:forget         Remove an item from the cache
  cache:table          Create a migration for the cache database table
 config
  config:cache         Create a cache file for faster configuration loading
  config:clear         Remove the configuration cache file
 db
  db:seed              Seed the database with records
 event
  event:generate       Generate the missing events and listeners based on registration
 key
  key:generate         Set the application key
 make
  make:auth            Scaffold basic login and registration views and routes
  make:channel         Create a new channel class
  make:command         Create a new Artisan command
  make:controller      Create a new controller class
  make:event           Create a new event class
  make:exception       Create a new custom exception class
  make:factory         Create a new model factory
  make:job             Create a new job class
  make:listener        Create a new event listener class
  make:mail            Create a new email class
  make:middleware      Create a new middleware class
  make:migration       Create a new migration file
  make:model           Create a new Eloquent model class
  make:notification    Create a new notification class
  make:observer        Create a new observer class
  make:policy          Create a new policy class
  make:provider        Create a new service provider class
  make:request         Create a new form request class
  make:resource        Create a new resource
  make:rule            Create a new validation rule
  make:seeder          Create a new seeder class
  make:test            Create a new test class
 migrate
  migrate:fresh        Drop all tables and re-run all migrations
  migrate:install      Create the migration repository
  migrate:refresh      Reset and re-run all migrations
  migrate:reset        Rollback all database migrations
  migrate:rollback     Rollback the last database migration
  migrate:status       Show the status of each migration
 notifications
  notifications:table  Create a migration for the notifications table
 package
  package:discover     Rebuild the cached package manifest
 queue
  queue:failed         List all of the failed queue jobs
  queue:failed-table   Create a migration for the failed queue jobs database table
  queue:flush          Flush all of the failed queue jobs
  queue:forget         Delete a failed queue job
  queue:listen         Listen to a given queue
  queue:restart        Restart queue worker daemons after their current job
  queue:retry          Retry a failed queue job
  queue:table          Create a migration for the queue jobs database table
  queue:work           Start processing jobs on the queue as a daemon
 route
  route:cache          Create a route cache file for faster route registration
  route:clear          Remove the route cache file
  route:list           List all registered routes
 schedule
  schedule:run         Run the scheduled commands
 session
  session:table        Create a migration for the session database table
 storage
  storage:link         Create a symbolic link from "public/storage" to "storage/app/public"
 vendor
  vendor:publish       Publish any publishable assets from vendor packages
 view
  view:cache           Compile all of the application's Blade templates
  view:clear           Clear all compiled view files
```