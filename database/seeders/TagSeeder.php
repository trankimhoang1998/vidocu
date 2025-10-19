<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Môn học
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
            'Âm nhạc',
            'Thể dục',

            // Chủ đề
            'Học tập',
            'Ôn thi',
            'THPT Quốc gia',
            'Kỹ năng',
            'Phương pháp học',
            'Bài tập',
            'Lý thuyết',
            'Ứng dụng thực tế',

            // Cấp độ
            'Cơ bản',
            'Nâng cao',
            'Khó',

            // Dạng bài
            'Công thức',
            'Định lý',
            'Phương trình',
            'Văn học',
            'Ngữ pháp',
            'Từ vựng',
            'Lập trình',
            'Thí nghiệm',
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }

        $this->command->info('Tags created successfully!');
    }
}
