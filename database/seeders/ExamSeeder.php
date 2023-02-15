<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exam = new Exam;
        $exam->name = 'Semana 1';
        $exam->save();
        $exam = new Exam;
        $exam->name = 'Semana 2';
        $exam->save();
        $exam = new Exam;
        $exam->name = 'Semana 3';
        $exam->save();
    }
}
