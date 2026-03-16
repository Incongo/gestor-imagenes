-- Tabla: users (usuarios)
-- Almacena la información de los usuarios del sistema
users
├── id INT PRIMARY KEY AUTO_INCREMENT
├── email VARCHAR(255) UNIQUE
├── password VARCHAR(255)
├── name VARCHAR(100)
├── role ENUM('admin', 'user') DEFAULT 'user'
├── active BOOLEAN DEFAULT FALSE  -- Admin debe activar
├── created DATETIME
├── modified DATETIME
└── last_login DATETIME

-- Tabla: folders (carpetas)
-- Estructura jerárquica infinita (autorreferenciada)
folders
├── id INT PRIMARY KEY AUTO_INCREMENT
├── parent_id INT NULL  -- NULL para carpetas raíz
├── name VARCHAR(255)
├── slug VARCHAR(255)   -- Para URLs amigables
├── description TEXT NULL
├── created_by INT       -- Usuario que creó la carpeta
├── created DATETIME
├── modified DATETIME
└── FOREIGN KEY (parent_id) REFERENCES folders(id) ON DELETE CASCADE
    FOREIGN KEY (created_by) REFERENCES users(id)

-- Tabla: permissions (permisos)
-- Relaciona usuarios con carpetas y sus permisos
permissions
├── id INT PRIMARY KEY AUTO_INCREMENT
├── user_id INT
├── folder_id INT
├── can_view BOOLEAN DEFAULT FALSE
├── can_download BOOLEAN DEFAULT FALSE
├── granted_by INT       -- Admin que otorgó el permiso
├── granted DATETIME
├── modified DATETIME
└── FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    FOREIGN KEY (folder_id) REFERENCES folders(id) ON DELETE CASCADE
    FOREIGN KEY (granted_by) REFERENCES users(id)
    UNIQUE KEY (user_id, folder_id)  -- Un permiso por usuario/carpeta

-- Tabla: images (imágenes)
-- Almacena la información de cada imagen
images
├── id INT PRIMARY KEY AUTO_INCREMENT
├── folder_id INT
├── filename VARCHAR(255)      -- Nombre original
├── slug VARCHAR(255)          -- Nombre para URL
├── path_original VARCHAR(512)  -- Ruta relativa
├── path_medium VARCHAR(512)
├── path_thumbnail VARCHAR(512)
├── filesize INT               -- En bytes
├── width INT
├── height INT
├── mime_type VARCHAR(100)
├── uploaded_by INT
├── uploaded DATETIME
├── modified DATETIME
└── FOREIGN KEY (folder_id) REFERENCES folders(id) ON DELETE CASCADE
    FOREIGN KEY (uploaded_by) REFERENCES users(id)

-- Tabla: metadata (metadatos EXIF)
-- Almacena los metadatos extraídos de las imágenes
metadata
├── id INT PRIMARY KEY AUTO_INCREMENT
├── image_id INT UNIQUE
├── camera_make VARCHAR(100)
├── camera_model VARCHAR(100)
├── exposure_time VARCHAR(50)
├── aperture VARCHAR(50)
├── iso INT
├── focal_length VARCHAR(50)
├── gps_latitude DECIMAL(10,8)
├── gps_longitude DECIMAL(11,8)
├── taken_date DATETIME
├── creator VARCHAR(255)
├── copyright VARCHAR(255)
├── all_data JSON              -- Todos los metadatos en bruto
└── FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE

-- Tabla: tags (etiquetas)
-- Palabras clave para búsqueda
tags
├── id INT PRIMARY KEY AUTO_INCREMENT
├── name VARCHAR(100) UNIQUE
├── slug VARCHAR(100) UNIQUE
├── created DATETIME
└── modified DATETIME

-- Tabla: images_tags (relación N:M)
-- Relaciona imágenes con etiquetas
images_tags
├── image_id INT
├── tag_id INT
├── PRIMARY KEY (image_id, tag_id)
└── FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE

-- Tabla: settings (configuración)
-- Almacena configuraciones del admin
settings
├── id INT PRIMARY KEY AUTO_INCREMENT
├── `key` VARCHAR(100) UNIQUE
├── `value` TEXT
├── type ENUM('text', 'number', 'boolean', 'json') DEFAULT 'text'
├── description TEXT
├── modified DATETIME
└── created DATETIME

-- Tabla: queue_jobs (sistema de colas propio)
-- Trabajos en cola (thumbnails, zips, etc)
queue_jobs
├── id INT PRIMARY KEY AUTO_INCREMENT
├── type ENUM('thumbnail', 'zip', 'metadata')  -- Tipo de trabajo
├── data JSON                                    -- Datos del trabajo
├── status ENUM('pending', 'processing', 'completed', 'failed') DEFAULT 'pending'
├── priority INT DEFAULT 0
├── attempts INT DEFAULT 0
├── max_attempts INT DEFAULT 3
├── result TEXT NULL                              -- Resultado o error
├── created DATETIME
├── started DATETIME NULL
├── completed DATETIME NULL
└── INDEX (status, priority, created)