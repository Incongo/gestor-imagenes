<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateImagesTags extends BaseMigration
{
    public function change(): void
    {
        // CONFIGURACIÓN ESPECIAL para tabla pivote
        $table = $this->table('images_tags', [
            'id' => false,                    // NO crear columna id
            'primary_key' => ['image_id', 'tag_id']  // Clave primaria compuesta
        ]);

        $table->addColumn('image_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('tag_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);

        // ÍNDICE ÚNICO para evitar duplicados
        $table->addIndex(['image_id', 'tag_id'], [
            'name' => 'UNIQUE_IMAGE_TAG',
            'unique' => true,
        ]);

        // CLAVES FORÁNEAS
        $table->addForeignKey('image_id', 'images', 'id', [
            'constraint' => 'fk_images_tags_image',
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION',
        ]);

        $table->addForeignKey('tag_id', 'tags', 'id', [
            'constraint' => 'fk_images_tags_tag',
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION',
        ]);

        $table->create();
    }
}
