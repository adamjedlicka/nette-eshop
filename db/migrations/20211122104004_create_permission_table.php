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
                    ['role_id' =>  'admin', 'resource_id' => 'Admin:Dashboard', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'admin', 'resource_id' => 'Category', 'action' => '',  'type' => 'allow'],
                    ['role_id' => 'authenticated', 'resource_id' => 'Front:Error', 'action' => '', 'type' => 'allow'],
                    ['role_id' => 'authenticated', 'resource_id' => 'Front:Error4xx', 'action' => '', 'type' => 'allow'],
                    ['role_id' => 'authenticated', 'resource_id' => 'Front:Homepage', 'action' => '', 'type' => 'allow'],
                    ['role_id' => 'authenticated', 'resource_id' => 'Front:User', 'action' => 'login', 'type' => 'allow'],
                    ['role_id' =>  'authenticated', 'resource_id' => 'Front:User', 'action' => 'logout', 'type' => 'allow'],
                    ['role_id' => 'guest', 'resource_id' => 'Front:Error', 'action' => '', 'type' => 'allow'],
                    ['role_id' => 'guest', 'resource_id' => 'Front:Error4xx', 'action' => '', 'type' => 'allow'],
                    ['role_id' => 'guest', 'resource_id' => 'Front:Homepage', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'guest', 'resource_id' => 'Front:User', 'action' => 'facebookLogin', 'type' => 'allow'],
                    ['role_id' =>  'guest', 'resource_id' => 'Front:User', 'action' => 'forgottenPassword', 'type' => 'allow'],
                    ['role_id' => 'guest', 'resource_id' => 'Front:User', 'action' => 'login', 'type' => 'allow'],
                    ['role_id' => 'guest', 'resource_id' => 'Front:User', 'action' => 'logout', 'type' => 'allow'],
                    ['role_id' =>  'guest', 'resource_id' => 'Front:User', 'action' => 'register', 'type' => 'allow'],
                    ['role_id' =>  'guest', 'resource_id' => 'Front:User', 'action' => 'renewPassword', 'type' => 'allow'],
                ])
                ->saveData();
        }
    }
}
