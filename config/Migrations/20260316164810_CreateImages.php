<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateImages extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('images');
        $table->addColumn('folder_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('filename', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('slug', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('path_original', 'string', [
            'default' => null,
            'limit' => 512,
            'null' => false,
        ]);
        $table->addColumn('path_medium', 'string', [
            'default' => null,
            'limit' => 512,
            'null' => false,
        ]);
        $table->addColumn('path_thumbnail', 'string', [
            'default' => null,
            'limit' => 512,
            'null' => false,
        ]);
        $table->addColumn('filesize', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('width', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('height', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('mime_type', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('uploaded_by', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('uploaded', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        // ÍNDICES OPTIMIZADOS (solo los necesarios)
        $table->addIndex(['folder_id'], [                    // Para buscar imágenes de una carpeta
            'name' => 'IDX_FOLDER_ID',
            'unique' => false,
        ]);

        $table->addIndex(['slug'], [                         // Para búsqueda por URL
            'name' => 'UNIQUE_SLUG',
            'unique' => true,                                 // El slug debe ser único
        ]);

        $table->addIndex(['uploaded_by'], [                  // Para buscar imágenes de un usuario
            'name' => 'IDX_UPLOADED_BY',
            'unique' => false,
        ]);

        $table->addIndex(['mime_type'], [                    // Para filtrar por tipo
            'name' => 'IDX_MIME_TYPE',
            'unique' => false,
        ]);

        // CLAVES FORÁNEAS
        $table->addForeignKey('folder_id', 'folders', 'id', [
            'constraint' => 'fk_images_folder',
            'delete' => 'CASCADE',      // Si borras carpeta, borras imágenes
            'update' => 'NO_ACTION',
        ]);

        $table->addForeignKey('uploaded_by', 'users', 'id', [
            'constraint' => 'fk_images_uploaded_by',
            'delete' => 'NO_ACTION',    // No borrar usuario si tiene imágenes
            'update' => 'NO_ACTION',
        ]);

        $table->create();
    }
}
