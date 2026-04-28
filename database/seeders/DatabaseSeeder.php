<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        $this->call(AdminUserSeeder::class);

        // Genres, movies, theaters, and seats
        $this->call(GenreSeeder::class);
        $this->call(MovieSeeder::class);
        $this->call(TheaterSeeder::class);
        $this->call(SeatSeeder::class);

        // Screenings
        $this->call(ScreeningSeeder::class);

        // Create a test user
        User::firstOrCreate(
    ['email' => 'test@example.com'],
    [
        'name' => 'Test User',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]
);
    }
}
