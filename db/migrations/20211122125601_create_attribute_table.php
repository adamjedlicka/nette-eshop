<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAttributeTable extends AbstractMigration
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
        $this->table('attribute')
            ->addColumn('name', 'string')
            ->addColumn('description', 'text')
            ->create();

        if ($this->isMigratingUp()) {
            $this->table('resource')
                ->insert([
                    ['id' => 'Admin:Attribute'],
                    ['id' => 'Attribute'],
                ])
                ->saveData();

            $this->table('permission')
                ->insert([
                    ['role_id' =>  'admin', 'resource_id' => 'Admin:Attribute', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'admin', 'resource_id' => 'Attribute', 'action' => '', 'type' => 'allow'],
                ])
                ->saveData();
        }
    }
}
