<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSlugTable extends AbstractMigration
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
        $this->table('slug')
            ->addColumn('value', 'string')
            ->addIndex('value', ['unique' => true])
            ->addColumn('product_id', 'integer', ['null' => true])
            ->addForeignKey('product_id', 'product', 'id')
            ->addColumn('category_id', 'integer', ['null' => true])
            ->addForeignKey('category_id', 'category', 'id')
            ->create();
    }
}
