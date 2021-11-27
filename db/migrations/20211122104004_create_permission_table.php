<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePermissionTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('permission')
            ->addColumn('action', 'string')
            ->addColumn('type', 'string')
            ->addColumn('role_id', 'string')
            ->addForeignKey('role_id', 'role', 'id')
            ->addColumn('resource_id', 'string')
            ->addForeignKey('resource_id', 'resource', 'id')
            ->create();

        if ($this->isMigratingUp()) {
            $this->table('permission')
                ->insert([
                    ['role_id' =>  'admin', 'resource_id' => 'Admin:Category', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'admin', 'resource_id' => 'Admin:Product', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'admin', 'resource_id' => 'Admin:Dashboard', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'admin', 'resource_id' => 'Category', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'admin', 'resource_id' => 'Product', 'action' => '', 'type' => 'allow'],
                ])
                ->saveData();
        }
    }
}
