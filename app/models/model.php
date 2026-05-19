<?php
require_once "config.php";

class Model {
    protected $db;

    public function __construct() {
        // Conexión limpia al servidor para evitar errores si la DB no existe
        $this->db = new PDO("mysql:host=".MYSQL_HOST.";charset=utf8", MYSQL_USER, MYSQL_PASS);
        $this->deploy();
    }

    private function deploy() {
        // Creamos la base de datos usando tu constante del config y nos paramos en ella
        $this->db->query("CREATE DATABASE IF NOT EXISTS " . MYSQL_DB);
        $this->db->query("USE " . MYSQL_DB);

        // Verificamos si ya existen tablas
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        
        if (count($tables) == 0) {
            // Tu SQL estructurado de forma prolija para la instalación automática
            $sql = <<<END
            -- 1. Estructura de tabla para la tabla `categorias`
            CREATE TABLE `categorias` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `nombre` text NOT NULL,
              `imagen` text NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            -- 2. Estructura de tabla para la tabla `usuarios`
            CREATE TABLE `usuarios` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(150) NOT NULL,
              `password` varchar(255) NOT NULL,
              `level` varchar(11) NOT NULL DEFAULT 'usuario',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            -- 3. Estructura de tabla para la tabla `perfume`
            CREATE TABLE `perfume` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `id_categoria` int(11) NOT NULL,
              `nombre` varchar(30) NOT NULL,
              `nota` varchar(30) NOT NULL,
              `precio` int(11) NOT NULL,
              `tipo_variante` varchar(50) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `fk_categoria` (`id_categoria`),
              CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            -- Volcado de datos iniciales para `categorias`
            INSERT INTO `categorias` (`id`, `nombre`, `imagen`) VALUES
            (5, 'Floral', NULL),
            (6, 'Amaderado', NULL),
            (7, 'Cítrico', NULL);

            -- Volcado de datos iniciales para `usuarios` (Incluye admin)
            INSERT INTO `usuarios` (`id`, `email`, `password`, `level`) VALUES
            (2, 'aaa@gmail.com', '\$argon2id\$v=19\$m=65536,t=4,p=1\$UVZ5STluc2hVblpuaUY1cQ\$RfB4QVWc1YzSm6tpjJ+t8JZbC3b3sMFCRAxiM8dvyLU', 'usuario'),
            (4, 'hola@gmail.com', '\$argon2id\$v=19\$m=65536,t=4,p=1\$TVRMRXdEcWxMeWtOaldVZg\$J/Ao+lNzmdKNRMD849d2p8sLjjwp5Efl8JFMrOKwB1U', 'usuario'),
            (6, 'adminperfume@gmail.com', '\$argon2id\$v=19\$m=65536,t=4,p=1\$bC4xNlI0M2ZkWHFpektxTw\$4+rdx98nXhuJ7hdE8fhJQcoL8RFyKFUUMGmlwQjTy4g', 'admin'),
            (7, 'as@gmail.com', '\$argon2id\$v=19\$m=65536,t=4,p=1\$ZjFPMDF0UGUyT3NqZXd5eA\$D2r+3GLaBbWSVRh/pMWuddS/eayiKyzLKKCxFjNUJrc', 'usuario');

            -- Volcado de datos iniciales para `perfume`
            INSERT INTO `perfume` (`id`, `id_categoria`, `nombre`, `nota`, `precio`, `tipo_variante`) VALUES
            (3, 5, 'Dior J’adore', 'jazmín', 45000, 'Floral'),
            (4, 6, 'Bleu de Chanel', 'cedro', 30000, 'Amaderado'),
            (5, 7, 'Acqua di Gio', 'bergamota', 28000, 'Cítrico'),
            (7, 7, 'Enses angria', 'pimienta roja', 71500, '');
            END;

            // Ejecutamos todo el bloque junto
            $this->db->exec($sql);
        }
    }
}