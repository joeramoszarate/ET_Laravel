# Explore Tumbes — Documentación y README del proyecto

## Resumen del proyecto
Explore Tumbes es una plataforma web backend desarrollada en Laravel destinada a una agencia regional de turismo en Tumbes. Permite administrar tours, paquetes, reservas, clientes y pagos, y ofrece un panel y vistas públicas para que los turistas conozcan y reserven servicios.

Principales módulos:
- Gestión de usuarios y roles (administradores, clientes).
- Catálogo de destinos, tours y paquetes.
- Proceso de reservas y detalles por pasajero.
- Gestión de comprobantes y métodos de pago.
- Control de caja y movimientos.

Estructura típica de Laravel: `app/`, `resources/views/`, `routes/`, `database/migrations/`.

---

## Tabla de contenidos
- [Acerca del Proyecto](#acerca-del-proyecto)
- [Características Principales](#características-principales)
- [Stack Tecnológico](#stack-tecnológico)
- [Arquitectura del Sistema](#arquitectura-del-sistema)
- [Modelo de Base de Datos](#modelo-de-base-de-datos)
- [Requisitos Previos](#requisitos-previos)
- [Instalación y Configuración](#instalación-y-configuración)
- [Variables de Entorno](#variables-de-entorno)
- [Uso y Flujo Principal](#uso-y-flujo-principal)
- [Endpoints / Rutas Principales](#endpoints--rutas-principales)
- [SQL de la Base de Datos](#sql-de-la-base-de-datos)
- [Autor](#autor)

---

## Acerca del Proyecto
Este proyecto nace para digitalizar la gestión y comercialización de servicios turísticos en la región de Tumbes. Facilita a los clientes ver tours, reservar plazas, enviar información adicional (alergias, traslados) y gestionar pagos. Para la administración, permite CRUD de tours, paquetes, destinos y gestión de reservas y caja.

---

## Características Principales
- Autenticación y roles (admin / cliente).
- Panel administrativo con CRUD para tours, paquetes y destinos.
- Proceso de reserva orientado a agencia: selección de fechas, alojamiento, traslados, número de huéspedes y notas.
- Subida y gestión de imágenes (perfil de cliente, galería de tours).
- Registro y seguimiento de comprobantes de pago.
- Integridad con esquema legacy (soporte para tablas sin timestamps, claves personalizadas).

---

## Stack Tecnológico

Backend
- Laravel 10.x
- PHP 8.2+

Frontend
- Blade (plantillas server-side)
- Tailwind CSS + Vite para estilos y compilación de assets

Base de datos
- MySQL (script SQL incluido) — Eloquent ORM

Herramientas
- Composer, NPM, Git

---

## Arquitectura del Sistema
- Patrón MVC nativo de Laravel.
- Controladores en `app/Http/Controllers`.
- Modelos Eloquent en `app/Models`.
- Vistas en `resources/views` (Blade).
- Migraciones en `database/migrations`.

---

## Modelo de Base de Datos (resumen)
Tablas principales:
- `usuario`, `cliente`, `tiporol`, `tipo_documento`
- `destino`, `tour`, `paquete`, `detpaquetedestino`
- `reserva`, `detallereservatour`, `detallereservapaquete`, `pasajeroporreserva`
- `comprobantepago`, `detallepago`, `metodopago`
- `caja`, `caja_movimiento`

Nota: el proyecto soporta un esquema legacy en varias tablas (claves no incrementales, ausencia de timestamps). Revisa los modelos para `public $timestamps = false` donde aplique.

---

## Requisitos Previos
- PHP >= 8.1 (recomendado 8.2)
- Composer >= 2.x
- Node.js >= 18.x y NPM
- MySQL o MariaDB
- Extensiones PHP: `pdo_mysql`, `mbstring`, `openssl`, `xml`, `ctype`, `curl`

---

## Instalación y Configuración

1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd ET_Backend_Laravel
```

2. Instalar dependencias PHP

```bash
composer install
```

3. Instalar dependencias JS (opcional)

```bash
npm install
npm run build     # o `npm run dev` para desarrollo
```

4. Copiar `.env` y generar key

```bash
cp .env.example .env
php artisan key:generate
```

5. Configurar la base de datos en `.env` (ejemplo)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=explore_tumbes
DB_USERNAME=root
DB_PASSWORD=
```

6. Crear la base de datos

```sql
CREATE DATABASE explore_tumbes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

7. Importar el esquema (elige una de las dos opciones)

- Usando migraciones:

```bash
php artisan migrate
```

- Usando el script SQL incluido:

```bash
mysql -u root -p explore_tumbes < explore_tumbes_dump.sql
```

8. Crear enlace de almacenamiento (si subes imágenes)

```bash
php artisan storage:link
```

9. Ejecutar tests (opcional)

```bash
php artisan test
```

10. Levantar servidor de desarrollo

```bash
php artisan serve
```

Abrir `http://127.0.0.1:8000`.

---

## Variables de Entorno importantes
- `APP_URL` — URL base de la aplicación.
- `DB_*` — credenciales de la base de datos.
- `FILESYSTEM_DRIVER=public` — para servir archivos subidos.

---

## Uso y Flujo Principal
1. Un visitante navega la lista de tours en la parte pública.
2. Para reservar, el usuario debe iniciar sesión como cliente; si no tiene cuenta, se le solicita registrarse.
3. El cliente completa el formulario de reserva con fechas, número de pasajeros, tipo de alojamiento y opcionalmente solicita traslados.
4. Se crea una `reserva` y uno o más `detallereservatour` / `detallereservapaquete` según corresponda.
5. El administrador revisa la reserva, genera un `comprobantepago` y registra el pago en `detallepago` y en la `caja`.

---

## Endpoints / Rutas Principales (ejemplos)
- Rutas públicas: `/tours`, `/tours/{id}`, `/paquetes`
- Rutas cliente (prefijo `cliente`): `cliente/tours`, `cliente/tours/{id}/reservar`, `cliente/perfil`
- Rutas admin: `/admin/tours`, `/admin/reservas`, `/admin/usuarios`

Usa `php artisan route:list` para ver el listado completo y los nombres de rutas registrados.

---

## SQL de la Base de Datos
Incluye el archivo `explore_tumbes_dump.sql` con las instrucciones `CREATE TABLE` para las tablas principales. El archivo está preparado en sintaxis MySQL (InnoDB). Si vas a importar en un entorno donde el orden de creación cause errores por FK, desactiva temporalmente las restricciones de FK:

```sql
SET FOREIGN_KEY_CHECKS=0;
-- importar tablas
SET FOREIGN_KEY_CHECKS=1;
```

Si quieres, puedo añadir datos de ejemplo (seeders o inserts SQL) para:
- Usuarios/admin
- Tours demo
- Clientes de prueba

---

## Consideraciones y notas finales
- Revisa modelos que usan `public $timestamps = false` y claves primarias no incrementales — esto responde a la estructura legacy de la BD.
- Para producción: `APP_ENV=production` y `APP_DEBUG=false` en `.env`.
- ¿Quieres que agregue un `docker-compose.yml` para desarrollo con MySQL y PHP-FPM? Puedo generarlo.

---

## Autor
- Proyecto: Explore Tumbes
- Mantenimiento y código: equipo de desarrollo / contribuyentes

---

Si quieres modificaciones adicionales (agregar seeds, README más corto para GitHub, o incluir screenshots y diagramas ER), dime qué prefieres y lo implemento.
