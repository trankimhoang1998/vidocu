<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            'Toán học',
            'Ngữ văn',
            'Tiếng Anh',
            'Vật lý',
            'Hóa học',
            'Sinh học',
            'Lịch sử',
            'Địa lý',
            'Tin học',
            'Giáo dục công dân',
        ];

        $topics = [
            'Chương 1',
            'Chương 2',
            'Chương 3',
        ];

        // Cấp 1: Lớp (Lớp 1 - Lớp 12)
        for ($grade = 1; $grade <= 12; $grade++) {
            $gradeCategory = Category::create([
                'name' => "Lớp $grade",
                'slug' => Str::slug("lop $grade"),
                'parent_id' => null,
            ]);

            // Cấp 2: Môn học
            foreach ($subjects as $subject) {
                $subjectCategory = Category::create([
                    'name' => $subject,
                    'slug' => Str::slug("lop $grade $subject"),
                    'parent_id' => $gradeCategory->id,
                ]);

                // Cấp 3: Chương
                foreach ($topics as $topic) {
                    Category::create([
                        'name' => $topic,
                        'slug' => Str::slug("lop $grade $subject $topic"),
                        'parent_id' => $subjectCategory->id,
                    ]);
                }
            }
        }
    }
}
