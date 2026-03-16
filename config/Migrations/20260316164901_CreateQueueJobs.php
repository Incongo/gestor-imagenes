<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateQueueJobs extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('queue_jobs');
        $table->addColumn('type', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('data', 'json', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('status', 'string', [
            'default' => 'pending',  // Valor por defecto
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('priority', 'integer', [
            'default' => 0,          // Valor por defecto
            'null' => false,
        ]);
        $table->addColumn('attempts', 'integer', [
            'default' => 0,          // Valor por defecto
            'null' => false,
        ]);
        $table->addColumn('max_attempts', 'integer', [
            'default' => 3,          // Valor por defecto
            'null' => false,
        ]);
        $table->addColumn('result', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('started', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('completed', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        // ÍNDICES OPTIMIZADOS
        $table->addIndex(['status'], [
            'name' => 'IDX_STATUS',
            'unique' => false,
        ]);

        $table->addIndex(['type'], [
            'name' => 'IDX_TYPE',
            'unique' => false,
        ]);

        // ÍNDICE COMPUESTO IMPORTANTE: para encontrar trabajos pendientes por prioridad
        $table->addIndex(['status', 'priority', 'created'], [
            'name' => 'IDX_STATUS_PRIORITY_CREATED',
            'unique' => false,
        ]);

        $table->create();
    }
}
