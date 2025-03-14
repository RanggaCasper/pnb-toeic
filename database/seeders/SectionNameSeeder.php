<?php

namespace Database\Seeders;

use App\Models\Section\SectionName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SectionName::firstOrCreate([
           'name' => 'Part 1: Photographs',
           'type' => 'listening',
           'description' => 'For each question in this part, you will hear four statements about a picture . When you hear the statements, you must select the one statement that best describes what you see in the picture and mark your answer. <br><strong> The statements will not be printed and will be spoken only one time. </strong>'
        ]);

        SectionName::firstOrCreate([
            'name' => 'Part 2: Question-Response',
            'type' => 'listening',
            'description' => 'You will hear a question or statement and three responses spoken in English. <strong> They will not be printed and will be spoken only one time </strong>. Select the best response to the question or statement and mark the letter (A), (B), or (C)'
        ]);

        SectionName::firstOrCreate([
            'name' => 'Part 3: Conversations',
            'type' => 'listening',
            'description' => 'You will hear some conversations between two or more people. You will be asked to answer three questions about what the speakers say in each conversation. Select the best response to each question and mark the letter (A), (B), (C), or (D). <strong> The co'
        ]);

        SectionName::firstOrCreate([
            'name' => 'Part 4: Talk',
            'type' => 'listening',
            'description' => 'You will hear some talks given by a single speaker. You will be asked to answer three questions about what the speaker says in each talk. Select the best response to each question and mark the letter (A), (B), (C), or (D). <strong> The talks will not be printed and will be spoken only one time. </strong>'
        ]);

        SectionName::firstOrCreate([
            'name' => 'Part 5: Incomplete Sentences',
            'type' => 'reading',
            'description' => 'A word or phrase is missing in each of the sentences below. Four answer choices are given below each sentence. Select the best answer to complete the sentence. Then mark the letter (A), (B), (C), or (D).'
        ]);
        
        SectionName::firstOrCreate([
            'name' => 'Part 6: Text Completion',
            'type' => 'reading',
            'description' => 'Read the texts that follow. A word, phrase, or sentence is missing in parts of each text. Four answer choices for each question are given below the text. Select the best answer to complete the text. Then mark the letter (A), (B), (C), or (D).'
        ]);
        
        SectionName::firstOrCreate([
            'name' => 'Part 7: Reading Comprehension',
            'type' => 'reading',
            'description' => 'In this part you will read a selection of texts, such as magazine and newspaper articles, e-mails, and instant messages. Each text or set of texts is followed by several questions. Select the best answer for each question and mark the letter (A), (B), (C), or (D).'
        ]);
    }
}
