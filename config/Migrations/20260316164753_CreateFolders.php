<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateFolders extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('folders');
        $table->addColumn('parent_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('slug', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('created_by', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        // ÍNDICES 
        $table->addIndex(['slug'], [
            'name' => 'UNIQUE_SLUG',
            'unique' => true,
        ]);

        // CLAVES FORÁNEAS
        $table->addForeignKey('parent_id', 'folders', 'id', [
            'constraint' => 'fk_folders_parent',
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION',
        ]);

        $table->addForeignKey('created_by', 'users', 'id', [
            'constraint' => 'fk_folders_created_by',
            'delete' => 'NO_ACTION',
            'update' => 'NO_ACTION',
        ]);

        $table->create();
    }
}
