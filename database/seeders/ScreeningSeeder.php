<?php
namespace Database\Seeders;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Theater;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScreeningSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('seat_holds')->truncate();
        DB::table('reservation_seat')->truncate();
        DB::table('reservations')->truncate();
        DB::table('screenings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $movies = Movie::all();
        $theaters = Theater::all();
        $baseDate = \Carbon\Carbon::parse('2027-04-29 00:00:00');
        $times = ['14:00', '17:00', '20:00'];
        $basePrices = [1200, 1500, 1800];

        foreach ($movies as $movieIndex => $movie) {
            foreach ($theaters as $theaterIndex => $theater) {
                foreach ($times as $timeIndex => $time) {
                    $startTime = $baseDate
                        ->clone()
                        ->addDays($movieIndex + $theaterIndex)
                        ->setTimeFromTimeString($time);
                    $endTime = $startTime->clone()->addHours(2);
                    Screening::create([
                        'movie_id' => $movie->id,
                        'theater_id' => $theater->id,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'base_price' => $basePrices[$timeIndex] ?? 1200,
                    ]);
                }
            }
        }
    }
}
