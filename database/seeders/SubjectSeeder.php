<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Subject::factory(10)->create();

        $planesData = [
            [
            'title'=> 'Cessna 172 Skyhawk',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/1963-Cessna-172D.jpg/800px-1963-Cessna-172D.jpg',
            'description' => 'Single-engine, high wing, fixed-wing aircraft made by the Cessna Aircraft Company. First flown in 1955',
            'comfort'=> fake()->randomDigitNotZero(),
            'seats' => '4',
            ],
        
            [
            'title'=> 'Boeing 737',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/f/f6/Lufthansa_Boeing_737-100_in_Zurich_1981.jpg',
            'description' => 'The Boeing 737 is an American narrow-body aircraft produced by Boeing.  First flight in April 1967',
            'comfort'=> fake()->randomDigitNotZero(),
            'seats' => '160',
            ],  

            [
            'title'=> 'Airbus A220-300',
            'image' => 'https://cdn.prod.website-files.com/65a0f5e2f3a73fc7e30e9205/65b12964ccc7ceaab8685d7c_53484680898_a91ca65dd6_k-p-1600.webp',
            'description' => 'Two engine narrow-body aircraft originally produced by Bombardier CSeries, later aqired by Airbus. First flight in 2015.',
            'comfort'=> '9',
            'seats' => '160',
            ],  

            [
            'title'=> 'Robinson R44',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Robinson_R44_II_%28cropped%29.jpg/800px-Robinson_R44_II_%28cropped%29.jpg',
            'description' => 'Four-seat light helicopter produced by Robinson Helicopter Company since 1992. ',
            'comfort'=> fake()->randomDigitNotZero(),
            'seats' => '4',
            ],  
        ];
        
        foreach ($planesData as $data) {
            // Create plane
            $plane = Subject::create([
                'title' => $data['title'],
                'image' => $data['image'],
                'description' => $data['description'],
                'comfort' => $data['comfort'],
                'seats' => $data['seats'],
                
            ]);
        }

    }
}
