<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Inserirs as roles padrões
        $this->fillRolesTable('Desenvolvedor', 'Oficial', 'Membro');
    }

    private function fillRolesTable(string ...$roles) {
        foreach ($roles as $role) {
            $model = new Role();
            $model->setAttribute('name', $role);
            $model->setAttribute('guard_name', 'web');
            $model->save();
        }
    }
};
