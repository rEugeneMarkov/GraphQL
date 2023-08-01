<?php


use Phinx\Seed\AbstractSeed;

class SeedReviewsTable extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            ['book_id' => 1, 'review' => 'Отзыв на книгу 1'],
            ['book_id' => 2, 'review' => 'Отзыв на книгу 2'],
            ['book_id' => 3, 'review' => 'Отзыв на книгу 3'],
        ];
        $reviews = $this->table('reviews');
        $reviews->insert($data)->saveData();
    }
}
