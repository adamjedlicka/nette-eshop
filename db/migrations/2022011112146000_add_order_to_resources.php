<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddOrderToResources extends AbstractMigration
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
        if ($this->isMigratingUp()) {
            $this->table('resource')
                ->insert([
                    ['id' => 'Admin:Orders'],
                    ['id' => 'Orders'],
                ])
                ->saveData();

            $this->table('permission')
                ->insert([
                    ['role_id' =>  'admin', 'resource_id' => 'Admin:Orders', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'admin', 'resource_id' => 'Orders', 'action' => '', 'type' => 'allow'],
                ])
                ->saveData();
        } else {
            $this->execute("DELETE FROM permission WHERE resource_id = 'Admin:Orders'");
            $this->execute("DELETE FROM permission WHERE resource_id = 'Orders'");
            $this->execute("DELETE FROM resource WHERE id = 'Admin:Orders'");
            $this->execute("DELETE FROM resource WHERE id = 'Orders'");
        }
    }
}
