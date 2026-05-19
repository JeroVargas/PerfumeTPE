# Aura Premium

## Integrantes
- Jerónimo Vargas (jeronimovargas26@gmail.com)
- Nicolas Diaz Rodriguez (diaznicoo240@gmail.com)

## Temática
Gestión de catálogo de alta perfumería y sus familias olfativas (categorías).

## Descripción
Sitio web dinámico que permite visualizar y administrar un catálogo de fragancias exclusivas. 
Los usuarios públicos pueden navegar por las familias olfativas, ver el catálogo general y filtrar perfumes. 
El administrador puede gestionar el contenido completo del sitio mediante un sistema de ABM.

## Funcionalidades y Roles (Requerimientos A y B)

### Acceso Público
- **Listado y Filtro por Categoría [Responsabilidad de Nicolas Diaz Rodriguez - Rol B]:** Interfaz pública que lista las familias olfativas y permite filtrar y listar de forma dinámica únicamente los perfumes pertenecientes a la categoría seleccionada (Cumplimiento del **Requerimiento B** de la cátedra).
- **Detalle de Ítems [Responsabilidad de Jerónimo Vargas - Rol A]:** Vista de detalles individuales para cada perfume con todas sus especificaciones técnicas y notas aromáticas.
- **Soporte Visual:** Manejo de imágenes opcionales con fallbacks elegantes tanto para categorías (Rol B) como para perfumes (Rol A).

### Acceso Administrador (Panel de Control)
- **Autenticación y Sesiones [Responsabilidad de Jerónimo Vargas - Rol A]:** Formulario de Login seguro, procesamiento y control de accesos en el ruteo mediante middlewares según el nivel de usuario (`level`).
- **ABM de Perfumes [Responsabilidad de Jerónimo Vargas - Rol A]:** CRUD completo de la entidad N (Perfumes), permitiendo el alta con selección dinámica de categorías, edición y baja.
- **ABM de Categorías [Responsabilidad de Nicolas Diaz Rodriguez - Rol B]:** CRUD completo de la entidad 1 (Categorías) para dar de alta, editar y borrar familias olfativas, protegiendo los datos mediante integridad referencial.
- **Cierre de Sesión [Responsabilidad de Nicolas Diaz Rodriguez - Rol B]:** Funcionalidad de Logout para destruir la sesión de forma segura.

## Diagrama de Entidad Relación (DER)
El modelo de datos cuenta con una relación 1:N entre las entidades **categorias** y **perfume**. 
Un perfume pertenece a una única categoría (vinculado mediante `id_categoria`), mientras que una categoría puede englobar múltiples perfumes. 
La entidad **usuarios** almacena las credenciales de acceso (`email`, `password`) y los permisos (`level`) para la administración privada del sitio.

![Diagrama de Entidad Relación Aura Premium](DER-PerfumeTPE.png)

## Cómo desplegar el sitio

### Requisitos
- Servidor Apache y motor de bases de datos MySQL (se recomienda usar XAMPP).
- PHP 8.0 o superior.

### Pasos
1. Clonar o copiar el repositorio dentro de la carpeta `htdocs` de XAMPP.
2. Iniciar los servicios de Apache y MySQL desde el Panel de Control de XAMPP.
3. Acceder desde el navegador a la URL del proyecto: `http://localhost/PerfumeTPE/` (o reemplazar por el nombre asignado a la carpeta del repositorio).

> **Importante (Auto-Deploy):** No es necesario importar ningún archivo `.sql` manualmente. La base de datos se creará automáticamente, generará la estructura de tablas (`categorias`, `perfume`, `usuarios`) e inyectará los datos iniciales y el administrador de prueba en el primer acceso a la página. Si se requiere modificar el host o las credenciales, editar las constantes en `config.php`.

## Usuario administrador
Para ingresar al panel de control y probar el ABM, utilice las siguientes credenciales:
- **Usuario:** adminperfume@gmail.com
- **Contraseña:** admin