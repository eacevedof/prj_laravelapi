# prj_laravelapi - Laravel 5.6.33 con homestead

## [Curso de desarrollo de API RESTful con Laravel - Youtube](https://www.youtube.com/watch?v=8Ren77hsZUo&index=1&list=PLIcuwIrm4rKcyfsOnnjqfXoa9rulZ9LgY)

### [Contenido curso - Escueal.it](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel#content)

### Lecciones:

1. [Crear un proyecto en laravel](https://escuela.it/cursos/curso-de-desarrollo-de-api-restful-con-laravel/clase/crear-un-proyecto-en-laravel)
- composer create-project laravel/laravel prj_laravelapi 5.6.* (tarda como 15 min en instalar)
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
3. []()
-
-
-
4. []()
-
-
-
5. []()
-
-
-