<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAttributeCategoryTable extends AbstractMigration
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
        $this->table('attribute_category')
            ->addColumn('attribute_id', 'integer')
            ->addForeignKey('attribute_id', 'attribute', 'id')
            ->addColumn('category_id', 'integer')
            ->addForeignKey('category_id', 'category', 'id')
            ->create();
    }
}
