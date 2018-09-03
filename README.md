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
        - [Explicación stackoverflow](https://stackoverflow.com/questions/2904854/what-is-middleware-exactly)
        - Los middlewares se registran en x:\xampp\htdocs\prj_laravelapi\app\Http\Kernel.php
        - Los **middlewares (software glue)** orignalmente son interfaces de tipo pasarela entre dos sistemas agnosticos. 
Permiten la integración entre dos plataformas: `[Plat A] in/out <- middleware -> in/out [Plat B]`. 
El middlware lleva acabo esta tarea usando servicios.
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
- Que es un **provider**? 
    - [Explicación stackoverflow](https://stackoverflow.com/questions/37104764/confused-about-laravel-providers-and-contracts)
    - [Reflection Class php.net](http://php.net/manual/en/class.reflectionclass.php)
    - Es una clase **abstracta** que tiene un metodo register que sirve para mapear **Interface -> Clase instanciable** de modo que cuando se desee hacer una
inyección de dependencia usando una interfaz, esta se lleve acabo (normalmente usando **ReflectionClass**) consultando al ServiceProvider.
- x:\xampp\htdocs\prj_laravelapi\app\Providers\ **RouteServiceProvider.php** se quita el prefijo
- **comando:** `php artisan route:list` 
- x:\xampp\htdocs\prj_laravelapi\config\ **app.php** Se cargan los valores de .env en un array
- x:\xampp\htdocs\prj_laravelapi\ **database\factories\UserFactory.php** generador de objetos
- x:\xampp\htdocs\prj_laravelapi\ **database\migrations\2014_10_12_000000_create_users_table.php**
- x:\xampp\htdocs\prj_laravelapi\ **database\seeds\DatabaseSeeder.php** Desde este se llamara a los factories para rellenar la bd con información
- x:\xampp\htdocs\prj_laravelapi\resources\
    - **assets** Recursos de frontend compilados
    - **lang**  Mensajes de validación
    - **views**  No se usaran mucho
- x:\xampp\htdocs\prj_laravelapi\ **routes**\channels.php Para transmitir eventos a lo largo de toda la app. No se utilizará.
- x:\xampp\htdocs\prj_laravelapi\ **routes**\console.php comandos personalizados que se puede tener en php artisan
- x:\xampp\htdocs\prj_laravelapi\ **storage** donde se almacenan los logs
- x:\xampp\htdocs\prj_laravelapi\ **vendor** codigo de terceros gestionado por composer. No se debe tocar
- Hay que evitar tener rutas iguales para Api y para Web, siempre prevalecerá las de web.
- En middlewaregroups se cargan unas librerias de web como sesiones y crf que no secargan para api lo que la hace más ligera
- el ORM que se usará **ELOQUENT**

5. [Creación de nuestro primer modelo y archivos asociados](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/creacion-de-nuestro-primer-modelo-y-archivos-asociados)
- Diagrama 
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5b014de4bc1b8dcc70d83031/6a3a5051307f57b023a2cd7de15dd2ca/image.png" height="200" width="400">
- **comando:** `php artisan make:model --help`
    - flag **-a, --all** Genera el modelo, factory que nos permitira insertar datos falsos o de prueba y resource controller es un **controlador de recursos**, cada modelo es un recurso.
- **comando:** `php artisan make:model Product --all`
- Ruta de los modelos: x:\xampp\htdocs\prj_laravelapi\ **app**
- Crear ruta de api:  x:\xampp\htdocs\prj_laravelapi\routes\ **api.php**
- En el metodo show si no se recibe una instancia laravel lanzará una excepcion de **ModelNotFoundException** que se controlara en **x:\..api\app\Exceptions\Handler.php**
- Ruta en **api.php** `Route::resource("products","ProductController");` esta es una ruta para **web** pero como estamos usando
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
    - Las migraciones son clases de tipo Migration y se guardan con un timestamp tipo: **<yyyy_mm_dd_hhmmss_cadena-de-accion>.php**
    - El orden es importante ya que laravel ejecutara todo lo que hay en esta carpeta segun el nombre.
    - Fijandonos en el diagrama, **Buyer** y **Product** deben existir antes de **Transaction**
    - Tener presente la **tabla pivote** es una representación fisica de una relación n:m. En el ejemplo **Product<->Category** con lo cual
obtendriamos una tabla **Category_Product** (Union de nombres en singular en orden alfabético **Norma 5**)
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
x:\xampp\htdocs\prj_laravelapi\vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php
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
- Para este fin se usan los **Factories** `x:\xampp\htdocs\prj_laravelapi\database\factories`
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
<?php
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
                ["id"] => string(3) "360"
                ["name"] => string(16) "Travis Fahey III"
                ["email"] => string(17) "browe@example.net"
                ["password"] => string(60) "$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm"
                ["remember_token"] => string(10) "BBDx9sGEME"
                ["created_at"] => string(19) "2018-08-23 22:49:44"
                ["updated_at"] => string(19) "2018-08-23 22:49:44"
            }
            ["original":protected] =>
            array(7) {
                ["id"] => string(3) "360"
                ["name"] => string(16) "Travis Fahey III"
                ["email"] => string(17) "browe@example.net"
                ["password"] => string(60) "$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm"
                ["remember_token"] => string(10) "BBDx9sGEME"
                ["created_at"] => string(19) "2018-08-23 22:49:44"
                ["updated_at"] => string(19) "2018-08-23 22:49:44"
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
- 

21. []()
-
22. []()
-


## DESPLEGADO EN PROD
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

