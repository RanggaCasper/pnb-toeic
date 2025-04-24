<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ToeicScore;


class ToeicScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        $scores = [
            ['correct' => 1, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 2, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 3, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 4, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 5, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 6, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 7, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 8, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 9, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 10, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 11, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 12, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 13, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 14, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 15, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 16, 'listening_score' => 5, 'reading_score' => 5],
            ['correct' => 17, 'listening_score' => 5, 'reading_score' => 65],
            ['correct' => 18, 'listening_score' => 5, 'reading_score' => 70],
            ['correct' => 19, 'listening_score' => 5, 'reading_score' => 75],
            ['correct' => 20, 'listening_score' => 5, 'reading_score' => 80],
            ['correct' => 21, 'listening_score' => 5, 'reading_score' => 85],
            ['correct' => 22, 'listening_score' => 5, 'reading_score' => 90],
            ['correct' => 23, 'listening_score' => 5, 'reading_score' => 95],
            ['correct' => 24, 'listening_score' => 5, 'reading_score' => 100],
            ['correct' => 25, 'listening_score' => 5, 'reading_score' => 105],
            ['correct' => 26, 'listening_score' => 5, 'reading_score' => 110],
            ['correct' => 27, 'listening_score' => 5, 'reading_score' => 115],
            ['correct' => 28, 'listening_score' => 5, 'reading_score' => 120],
            ['correct' => 29, 'listening_score' => 5, 'reading_score' => 125],
            ['correct' => 30, 'listening_score' => 5, 'reading_score' => 130],
            ['correct' => 31, 'listening_score' => 5, 'reading_score' => 135],
            ['correct' => 32, 'listening_score' => 5, 'reading_score' => 140],
            ['correct' => 33, 'listening_score' => 5, 'reading_score' => 145],
            ['correct' => 34, 'listening_score' => 5, 'reading_score' => 150],
            ['correct' => 35, 'listening_score' => 5, 'reading_score' => 155],
            ['correct' => 36, 'listening_score' => 5, 'reading_score' => 160],
            ['correct' => 37, 'listening_score' => 5, 'reading_score' => 165],
            ['correct' => 38, 'listening_score' => 5, 'reading_score' => 170],
            ['correct' => 39, 'listening_score' => 5, 'reading_score' => 175],
            ['correct' => 40, 'listening_score' => 5, 'reading_score' => 180],
            ['correct' => 41, 'listening_score' => 5, 'reading_score' => 185],
            ['correct' => 42, 'listening_score' => 5, 'reading_score' => 190],
            ['correct' => 43, 'listening_score' => 5, 'reading_score' => 195],
            ['correct' => 44, 'listening_score' => 5, 'reading_score' => 200],
            ['correct' => 45, 'listening_score' => 5, 'reading_score' => 205],
            ['correct' => 46, 'listening_score' => 5, 'reading_score' => 210],
            ['correct' => 47, 'listening_score' => 5, 'reading_score' => 215],
            ['correct' => 48, 'listening_score' => 5, 'reading_score' => 220],
            ['correct' => 49, 'listening_score' => 5, 'reading_score' => 225],
            ['correct' => 50, 'listening_score' => 5, 'reading_score' => 230],
            ['correct' => 51, 'listening_score' => 235, 'reading_score' => 195],
            ['correct' => 52, 'listening_score' => 235, 'reading_score' => 200],
            ['correct' => 53, 'listening_score' => 240, 'reading_score' => 205],
            ['correct' => 54, 'listening_score' => 245, 'reading_score' => 210],
            ['correct' => 55, 'listening_score' => 250, 'reading_score' => 215],
            ['correct' => 56, 'listening_score' => 255, 'reading_score' => 220],
            ['correct' => 57, 'listening_score' => 260, 'reading_score' => 225],
            ['correct' => 58, 'listening_score' => 265, 'reading_score' => 230],
            ['correct' => 59, 'listening_score' => 270, 'reading_score' => 235],
            ['correct' => 60, 'listening_score' => 275, 'reading_score' => 240],
            ['correct' => 61, 'listening_score' => 280, 'reading_score' => 245],
            ['correct' => 62, 'listening_score' => 285, 'reading_score' => 250],
            ['correct' => 63, 'listening_score' => 290, 'reading_score' => 255],
            ['correct' => 64, 'listening_score' => 295, 'reading_score' => 260],
            ['correct' => 65, 'listening_score' => 300, 'reading_score' => 265],
            ['correct' => 66, 'listening_score' => 305, 'reading_score' => 270],
            ['correct' => 67, 'listening_score' => 310, 'reading_score' => 275],
            ['correct' => 68, 'listening_score' => 315, 'reading_score' => 280],
            ['correct' => 69, 'listening_score' => 320, 'reading_score' => 285],
            ['correct' => 70, 'listening_score' => 325, 'reading_score' => 290],
            ['correct' => 71, 'listening_score' => 330, 'reading_score' => 295],
            ['correct' => 72, 'listening_score' => 335, 'reading_score' => 300],
            ['correct' => 73, 'listening_score' => 340, 'reading_score' => 305],
            ['correct' => 74, 'listening_score' => 345, 'reading_score' => 310],
            ['correct' => 75, 'listening_score' => 350, 'reading_score' => 315],
            ['correct' => 76, 'listening_score' => 400, 'reading_score' => 340],
            ['correct' => 77, 'listening_score' => 405, 'reading_score' => 345],
            ['correct' => 78, 'listening_score' => 410, 'reading_score' => 350],
            ['correct' => 79, 'listening_score' => 415, 'reading_score' => 355],
            ['correct' => 80, 'listening_score' => 420, 'reading_score' => 360],
            ['correct' => 81, 'listening_score' => 425, 'reading_score' => 365],
            ['correct' => 82, 'listening_score' => 430, 'reading_score' => 370],
            ['correct' => 83, 'listening_score' => 435, 'reading_score' => 375],
            ['correct' => 84, 'listening_score' => 440, 'reading_score' => 380],
            ['correct' => 85, 'listening_score' => 445, 'reading_score' => 385],
            ['correct' => 86, 'listening_score' => 450, 'reading_score' => 390],
            ['correct' => 87, 'listening_score' => 455, 'reading_score' => 395],
            ['correct' => 88, 'listening_score' => 460, 'reading_score' => 400],
            ['correct' => 89, 'listening_score' => 465, 'reading_score' => 405],
            ['correct' => 90, 'listening_score' => 470, 'reading_score' => 410],
            ['correct' => 91, 'listening_score' => 475, 'reading_score' => 415],
            ['correct' => 92, 'listening_score' => 480, 'reading_score' => 420],
            ['correct' => 93, 'listening_score' => 485, 'reading_score' => 425],
            ['correct' => 94, 'listening_score' => 490, 'reading_score' => 430],
            ['correct' => 95, 'listening_score' => 495, 'reading_score' => 435],
            ['correct' => 96, 'listening_score' => 495, 'reading_score' => 440],
            ['correct' => 97, 'listening_score' => 495, 'reading_score' => 445],
            ['correct' => 98, 'listening_score' => 495, 'reading_score' => 450],
            ['correct' => 99, 'listening_score' => 495, 'reading_score' => 455],
            ['correct' => 100, 'listening_score' => 495, 'reading_score' => 460],
        ];

        foreach ($scores as $score) {
            ToeicScore::create($score);
        }
    }
}
