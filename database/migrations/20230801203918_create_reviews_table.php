<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateReviewsTable extends AbstractMigration
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
        $table = $this->table('reviews', ['engine' => 'InnoDB', 'collation' => 'utf8_general_ci']);
        $table->addColumn('review', 'string', ['limit' => 255, 'collation' => 'utf8_general_ci', 'null' => false])
              ->addColumn('book_id', 'integer', ['signed' => false, 'null' => true])
              ->addForeignKey('book_id', 'books', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
              ->create();
    }
}
