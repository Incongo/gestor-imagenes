<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateSettings extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('settings');
        $table->addColumn('key', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('value', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('type', 'string', [
            'default' => 'text',
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => true,
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
        $table->addIndex(['key'], [
            'name' => 'UNIQUE_KEY',
            'unique' => true,       // La clave debe ser única
        ]);

        $table->create();
    }
}
