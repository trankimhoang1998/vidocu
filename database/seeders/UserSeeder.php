<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin account
        User::create([
            'name' => 'Nguyễn Văn An',
            'email' => 'admin@vidocu.com',
            'password' => Hash::make('password'),
            'role' => 0,
            'email_verified_at' => now(),
        ]);

        // Create regular users with real Vietnamese names
        $users = [
            ['name' => 'Trần Thị Bình', 'email' => 'binhtt@gmail.com'],
            ['name' => 'Lê Văn Cường', 'email' => 'cuonglv@gmail.com'],
            ['name' => 'Phạm Thị Dung', 'email' => 'dungpt@gmail.com'],
            ['name' => 'Hoàng Văn Em', 'email' => 'emhv@gmail.com'],
            ['name' => 'Võ Thị Phương', 'email' => 'phuongvt@gmail.com'],
            ['name' => 'Đỗ Văn Giang', 'email' => 'giangdv@gmail.com'],
            ['name' => 'Bùi Thị Hà', 'email' => 'habt@gmail.com'],
            ['name' => 'Ngô Văn Hùng', 'email' => 'hungnv@gmail.com'],
            ['name' => 'Đinh Thị Lan', 'email' => 'landt@gmail.com'],
            ['name' => 'Mai Văn Khoa', 'email' => 'khoamv@gmail.com'],
            ['name' => 'Đặng Thị Linh', 'email' => 'linhdt@gmail.com'],
            ['name' => 'Dương Văn Minh', 'email' => 'minhdv@gmail.com'],
            ['name' => 'Trịnh Thị Nga', 'email' => 'ngatt@gmail.com'],
            ['name' => 'Phan Văn Ơn', 'email' => 'onpv@gmail.com'],
            ['name' => 'Lý Thị Phúc', 'email' => 'phuclt@gmail.com'],
            ['name' => 'Vũ Văn Quang', 'email' => 'quangvv@gmail.com'],
            ['name' => 'Tô Thị Rạng', 'email' => 'rangtt@gmail.com'],
            ['name' => 'Hồ Văn Sơn', 'email' => 'sonhv@gmail.com'],
            ['name' => 'Cao Thị Tâm', 'email' => 'tamct@gmail.com'],
            ['name' => 'Từ Văn Út', 'email' => 'uttv@gmail.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'role' => 1,
                'email_verified_at' => now(),
            ]);
        }
    }
}
