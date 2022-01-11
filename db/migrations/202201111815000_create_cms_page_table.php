<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCmsPageTable extends AbstractMigration
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
        $this->table('cms_page')
            ->addColumn('name', 'string')
            ->addColumn('content', 'string')
            ->addColumn('slug', 'string')
            ->addIndex('slug', ['unique' => true])
            ->create();

        if ($this->isMigratingUp()) {
            $this->table('resource')
                ->insert([
                    ['id' => 'Admin:CmsPage'],
                    ['id' => 'CmsPage'],
                ])
                ->saveData();

            $this->table('permission')
                ->insert([
                    ['role_id' =>  'admin', 'resource_id' => 'Admin:CmsPage', 'action' => '', 'type' => 'allow'],
                    ['role_id' =>  'admin', 'resource_id' => 'CmsPage', 'action' => '', 'type' => 'allow'],
                ])
                ->saveData();
        } else {
            $this->execute("DELETE FROM permission WHERE resource_id = 'Admin:CmsPage'");
            $this->execute("DELETE FROM permission WHERE resource_id = 'CmsPage'");
            $this->execute("DELETE FROM resource WHERE id = 'Admin:CmsPage'");
            $this->execute("DELETE FROM resource WHERE id = 'CmsPage'");
        }
    }
}
