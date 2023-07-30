<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AcademicPerformance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;


class AcademicPerformanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'academic:performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CRUD Operations for Academics';



    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Add your CRUD operations here using the StudentPerformance model

        // Insert test data
        $this->insertTestData();

        // Run the MySQL query
        $this->runQuery();
    }

    protected function insertTestData()
    {


        $testData = [
            [
                'name' => 'John Doe',
                'student_group' => 'Group A',
                'subject' => 'Math',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 3,
            ],
            [
                'name' => 'Jane Smith',
                'student_group' => 'Group B',
                'subject' => 'Physics',
                'date' => Carbon::now()->subDays(4),
                'assessment_score' => 7,
            ],
            [
                'name' => 'John Doe',
                'student_group' => 'Group A',
                'subject' => 'Math',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 9,
            ],
            [
                'name' => 'John Doe',
                'student_group' => 'Group A',
                'subject' => 'Physics',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 9,
            ],
            [
                'name' => 'John Doe',
                'student_group' => 'Group B',
                'subject' => 'Math',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 9,
            ],
            [
                'name' => 'John Doe',
                'student_group' => 'Group B',
                'subject' => 'Math',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 9,
            ],
            [
                'name' => 'John Doe',
                'student_group' => 'Group B',
                'subject' => 'Math',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 8,
            ],
            [
                'name' => 'John Doe',
                'student_group' => 'Group 8',
                'subject' => 'Physics',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 3,
            ],
            [
                'name' => 'John Doe',
                'student_group' => 'Group B',
                'subject' => 'Physics',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 9,
            ],
            [
                'name' => 'John Doe',
                'student_group' => 'Group B',
                'subject' => 'Math',
                'date' => Carbon::now()->subDays(5),
                'assessment_score' => 6,
            ],
        ];

        foreach ($testData as $data) {
            AcademicPerformance::create($data);
        }

        $this->info('Test data inserted successfully.');
    }

    protected function runQuery()
    {
        $results = DB::select('
        SELECT 
        student_group, 
        subject,
        AVG(assessment_score) as average,
        MAX(assessment_score) AS score_above_70
        FROM (
        SELECT student_group, subject, assessment_score,
            PERCENT_RANK() OVER (PARTITION BY student_group, subject ORDER BY assessment_score) AS percentile FROM academic_performances
) AS subquery
WHERE percentile >= 0.7
GROUP BY student_group, subject;

    ');

    var_dump($results);

        // Display the results
        $this->info('Results:');
        $headers = ['Group Name', 'Subject', 'Average Assessment', '70th Percentile'];
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                $result->student_group,
                $result->subject,
                $result->average,
                $result->score_above_70,
            ];
        }
        $this->table($headers, $data);
    }
}
