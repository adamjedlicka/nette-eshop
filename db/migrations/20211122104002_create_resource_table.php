<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateResourceTable extends AbstractMigration
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
        $this->table('resource', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'string')
            ->create();

        if ($this->isMigratingUp()) {
            $this->table('resource')
                ->insert([
                    ['id' => 'Admin:Category'],
                    ['id' => 'Admin:Dashboard'],
                    ['id' => 'Admin:Error4xx'],
                    ['id' => 'Category'],
                    ['id' => 'Front:Error'],
                    ['id' => 'Front:Error4xx'],
                    ['id' => 'Front:Homepage'],
                    ['id' => 'Front:User'],
                ])
                ->saveData();
        }
    }
}
