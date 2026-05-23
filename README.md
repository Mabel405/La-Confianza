# La Confianza

Aplicación administrativa desarrollada con Laravel 12 para la gestión de inventario, compras, ventas, clientes, proveedores y usuarios con control de permisos.

## Tecnologías

- PHP 8.2
- Laravel 12
- Vite + Tailwind CSS
- Spatie Laravel Permission
- MySQL / SQLite / PostgreSQL (configurable desde `.env`)
- Composer
- Node.js / npm

## Descripción general

La aplicación ofrece un panel administrativo con módulos para:

- Gestión de productos, marcas, presentaciones y categorías
- Gestión de clientes y proveedores
- Registro de compras y ventas
- Control de usuarios, roles y permisos
- Autenticación de acceso con login/logout
- Vistas de error personalizadas (`401`, `404`, `500`)

## Módulos principales

- `categorias`
- `presentaciones`
- `marcas`
- `productos`
- `clientes`
- `proveedores`
- `compras`
- `ventas`
- `users`
- `roles`
- `profile`

## Modelos y relaciones clave

- `Producto` relaciona `Marca`, `Presentacione` y `Categoria`
- `Compra` y `Venta` usan relación many-to-many con `Producto`
- `User` tiene roles y permisos mediante `Spatie\Permission\Traits\HasRoles`
- `Role` y `Permission` controlan acceso a las acciones CRUD

## Requisitos

- PHP 8.2
- Composer
- Node.js >= 18
- npm
- Extensiones PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo

## Instalación local

1. Clona el repositorio:

```bash
git clone <url-del-proyecto>
cd La-Confianza-main
```

2. Instala dependencias PHP:

```bash
composer install
```

3. Instala dependencias de frontend:

```bash
npm install
```

4. Copia el archivo de entorno y genera clave de aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

5. Configura tu base de datos en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_bd
DB_USERNAME=usuario
DB_PASSWORD=clave
```

6. Ejecuta migraciones:

```bash
php artisan migrate
```

7. Crea datos iniciales (opcional):

```bash
php artisan db:seed --class=PermissionSeeder
php artisan db:seed
```

> El `UserSeeder` crea un usuario administrador por defecto:
> - Email: `admin@gmail.com`
> - Password: `12345678`

## Ejecución

- Modo desarrollo:

```bash
npm run dev
```

- Compilar para producción:

```bash
npm run build
```

- Iniciar servidor Laravel:

```bash
php artisan serve
```

## Rutas importantes

- `/` - Panel de control
- `/login` - Inicio de sesión
- `/logout` - Cerrar sesión
- Recursos CRUD:
  - `/categorias`
  - `/presentaciones`
  - `/marcas`
  - `/productos`
  - `/clientes`
  - `/proveedores`
  - `/compras`
  - `/ventas`
  - `/users`
  - `/roles`
  - `/profile`

## Notas

- La aplicación usa middleware de permisos en los controladores para proteger acciones de creación, edición y eliminación.
- El módulo de productos permite cargar imágenes y asociar categorías.
- Las compras y ventas usan tablas intermedias para almacenar cantidad, precios y descuentos.
- Si usas SQLite, crea `database/database.sqlite` y ajusta `DB_CONNECTION=sqlite`.
