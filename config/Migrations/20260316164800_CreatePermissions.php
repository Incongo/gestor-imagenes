<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePermissions extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('permissions');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('folder_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('can_view', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('can_download', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('granted_by', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('granted', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        // ÍNDICES 
        $table->addIndex(['user_id', 'folder_id'], [
            'name' => 'UNIQUE_USER_FOLDER',
            'unique' => true,           // Un permiso único por usuario/carpeta
        ]);

        // CLAVES FORÁNEAS 
        $table->addForeignKey('user_id', 'users', 'id', [
            'constraint' => 'fk_permissions_user',
            'delete' => 'CASCADE',      // Si borras usuario, borras permisos
            'update' => 'NO_ACTION',
        ]);

        $table->addForeignKey('folder_id', 'folders', 'id', [
            'constraint' => 'fk_permissions_folder',
            'delete' => 'CASCADE',      // Si borras carpeta, borras permisos
            'update' => 'NO_ACTION',
        ]);

        $table->addForeignKey('granted_by', 'users', 'id', [
            'constraint' => 'fk_permissions_granted_by',
            'delete' => 'NO_ACTION',    // No borrar admin que dio permiso
            'update' => 'NO_ACTION',
        ]);

        $table->create();
    }
}
