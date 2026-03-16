<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateTags extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('tags');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('slug', 'string', [
            'default' => null,
            'limit' => 100,
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
        $table->addIndex(['name'], [
            'name' => 'UNIQUE_NAME',
            'unique' => true,      // El nombre debe ser único
        ]);

        $table->addIndex(['slug'], [
            'name' => 'UNIQUE_SLUG',
            'unique' => true,      // El slug debe ser único
        ]);

        $table->create();
    }
}
