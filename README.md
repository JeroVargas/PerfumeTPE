# Aura Premium - Gestor de Alta Perfumería

## Integrantes
- Jerónimo Vargas (jeronimovargas26@gmail.com)
- Nicolas Diaz Rodriguez (diaznicoo240@gmail.com)

## Temática
Web de catálogo y gestión de alta perfumería y sus familias olfativas.

## Descripción
El sistema permite explorar y administrar un catálogo de perfumes y las categorías (familias olfativas) a las que pertenecen. En la base de datos se almacena el nombre del perfume, sus notas aromáticas, precio, tipo de variante e imágenes opcionales. Una categoría puede tener muchos perfumes asociados (relación 1:N), pero cada perfume pertenece a una única categoría.

---

## Rol de cada integrante

- *Jerónimo Vargas (Rol A):* Desarrollo de la entidad N (Perfumes), CRUD completo de ítems con selección dinámica de categorías, sistema de enrutamiento base, control de accesos mediante sesiones y procesamiento del inicio de sesión (Login).
- *Nicolas Diaz Rodriguez (Rol B):* Desarrollo de la entidad 1 (Categorías), CRUD completo de categorías, listado público de categorías con ítems filtrados por categoría, soporte de imágenes opcionales en el catálogo y funcionalidad de cierre de sesión (Logout).

---

## Requerimientos No Funcionales Destacados

### 1. Instalación Automática (Auto-Deploy)
El proyecto está pensado para que funcione "llave en mano". Al levantar la aplicación por primera vez en un entorno limpio, el sistema se conecta a MySQL, crea la base de datos de forma automática si no existe (usando el nombre definido en config.php) y ejecuta un script que crea las tablas e inyecta los datos de muestra iniciales y usuarios de prueba.

### 2. Estructura y Herencia de Modelos
Para mantener el código ordenado y evitar repetir la lógica de conexión en cada archivo, se armó una clase base llamada Model. Esta clase centraliza la conexión a la base de datos mediante PDO y el deploy automático. Tanto PerfumeModel como CategoriaModel heredan de ella (extends Model), aprovechando la conexión compartida.

### 3. Seguridad y Control de Accesos
La seguridad de las rutas privadas se centralizó en el archivo de ruteo (router.php) mediante middlewares de sesión. Si un usuario no logueado intenta forzar una URL privada o enviar un formulario por POST a una ruta administrativa, el sistema lo frena antes de que alcance la lógica del controlador.

---

## Instrucciones de Despliegue (Apache y MySQL)

Para levantar y probar el sitio en un servidor local (como XAMPP o WampServer), siga estos pasos:

1. *Copiar el proyecto:* Descargue o clone esta carpeta y colóquela dentro del directorio raíz de su servidor Apache (habitualmente la carpeta htdocs en XAMPP).
2. *Configurar las credenciales:* Abra el archivo config.php ubicado en la raíz del proyecto y configure las constantes según los datos de su entorno local (host, usuario y contraseña de MySQL). 
3. *Nombre de la Base de Datos:* Por defecto, la constante MYSQL_DB está configurada como perfumetpe. No es necesario crearla manualmente en phpMyAdmin; el sistema se encargará de crearla y poblarla en la primera ejecución.
4. *Acceso al sitio:* Inicie los servicios de Apache y MySQL desde su panel de control local y acceda desde el navegador a la URL correspondiente (por ejemplo: http://localhost/PerfumeTPE/).

---

## Usuario y Clave para administrador

Para acceder a las secciones privadas de administración (Panel de control, altas, bajas y modificaciones), utilice los siguientes datos de acceso ya cargados en el sistema:

- *Usuario (Email):* adminperfume@gmail.com
- *Contraseña:* admin