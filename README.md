# Sistema de Gestión de Capital Humano

Sistema desarrollado en Laravel 12 con PHP 8.2+, que incluye autenticación, gestión de usuarios, roles y permisos.

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm (para assets)
- Base de datos MySQL, PostgreSQL o SQLite

## Instalación

1. **Instalar dependencias de PHP**
   ```bash
   composer install
   ```

2. **Configurar entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configurar base de datos** en `.env`:
   - Para SQLite (por defecto): `DB_DATABASE=absolute_path_to/database/database.sqlite`
   - Para MySQL: configurar `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

4. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate --seed
   ```

5. **Instalar y compilar assets**
   ```bash
   npm install
   npm run build
   ```

6. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

## Usuario por defecto

- **Email:** admin@example.com  
- **Contraseña:** password  
- **Rol:** Administrador (todos los permisos)

## Módulos del sistema

### Autenticación (Laravel Breeze)
- Login
- Registro
- Recuperación de contraseña
- Verificación de email
- Perfil de usuario

### Módulo de Usuarios
- Listar usuarios
- Crear usuario
- Editar usuario
- Eliminar usuario
- Asignar roles

### Módulo de Roles
- Listar roles
- Crear rol
- Editar rol
- Eliminar rol
- Asignar permisos a roles

### Módulo de Permisos
- Listar permisos
- Crear permiso
- Editar permiso
- Eliminar permiso

## Permisos del sistema

| Permiso | Descripción |
|---------|-------------|
| ver-dashboard | Acceso al panel principal |
| listar-usuarios | Ver lista de usuarios |
| crear-usuarios | Crear nuevos usuarios |
| editar-usuarios | Modificar usuarios |
| eliminar-usuarios | Eliminar usuarios |
| listar-roles | Ver lista de roles |
| crear-roles | Crear nuevos roles |
| editar-roles | Modificar roles |
| eliminar-roles | Eliminar roles |
| listar-permisos | Ver lista de permisos |
| crear-permisos | Crear nuevos permisos |
| editar-permisos | Modificar permisos |
| eliminar-permisos | Eliminar permisos |

## Roles por defecto

- **Administrador:** Todos los permisos
- **Usuario:** Solo acceso al dashboard

## Tecnologías

- Laravel 12
- Laravel Breeze (autenticación)
- Spatie Laravel Permission (roles y permisos)
- Tailwind CSS
- Vite
