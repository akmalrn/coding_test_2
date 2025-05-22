<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $author1 = Author::where('first_name', 'Akmal Rahmattullah')->first(); // ganti sesuai data kamu
        $author2 = Author::where('first_name', 'Fajar Nur Soleh')->first();

        $authorId1 = 'uuid-here-1'; 
        $authorId2 = 'uuid-here-2';

        Book::Create([
            'isbn' => '1220765',
            'title' => 'Buku Perang',
            'author_id' => $author1->id ?? $authorId1,
        ]);

        Book::Create([
            'isbn' => '1220766',
            'title' => 'Buku Sejarah',
            'author_id' => $author1->id ?? $authorId1,
        ]);

        Book::Create([
            'isbn' => '1220767',
            'title' => 'Buku Pengetahuan Alam',
            'author_id' => $author2->id ?? $authorId1,
        ]);

        Book::Create([
            'isbn' => '1220768',
            'title' => 'Buku Pengetahuan Sosial',
            'author_id' => $author2->id ?? $authorId1,
        ]);
    }
}
