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

        // Create regular users with real Vietnamese names (99 users)
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
            ['name' => 'Nguyễn Thị Vân', 'email' => 'vannt@gmail.com'],
            ['name' => 'Trần Văn Xuân', 'email' => 'xuantv@gmail.com'],
            ['name' => 'Lê Thị Yến', 'email' => 'yenlt@gmail.com'],
            ['name' => 'Phạm Văn Zung', 'email' => 'zungpv@gmail.com'],
            ['name' => 'Hoàng Thị Anh', 'email' => 'anhht@gmail.com'],
            ['name' => 'Võ Văn Bảo', 'email' => 'baovv@gmail.com'],
            ['name' => 'Đỗ Thị Chi', 'email' => 'chidt@gmail.com'],
            ['name' => 'Bùi Văn Đạt', 'email' => 'datbv@gmail.com'],
            ['name' => 'Ngô Thị Oanh', 'email' => 'oanhnt@gmail.com'],
            ['name' => 'Đinh Văn Phát', 'email' => 'phatdv@gmail.com'],
            ['name' => 'Mai Thị Quỳnh', 'email' => 'quynhmt@gmail.com'],
            ['name' => 'Đặng Văn Rồng', 'email' => 'rongdv@gmail.com'],
            ['name' => 'Dương Thị Sương', 'email' => 'suongdt@gmail.com'],
            ['name' => 'Trịnh Văn Tài', 'email' => 'taittv@gmail.com'],
            ['name' => 'Phan Thị Uyên', 'email' => 'uyenpt@gmail.com'],
            ['name' => 'Lý Văn Việt', 'email' => 'vietlv@gmail.com'],
            ['name' => 'Vũ Thị Xoan', 'email' => 'xoanvt@gmail.com'],
            ['name' => 'Tô Văn Yên', 'email' => 'yentv@gmail.com'],
            ['name' => 'Hồ Thị Trúc', 'email' => 'trucht@gmail.com'],
            ['name' => 'Cao Văn Thắng', 'email' => 'thangcv@gmail.com'],
            ['name' => 'Từ Thị Hương', 'email' => 'huongtt@gmail.com'],
            ['name' => 'Nguyễn Văn Đức', 'email' => 'ducnv@gmail.com'],
            ['name' => 'Trần Thị Mai', 'email' => 'maitt@gmail.com'],
            ['name' => 'Lê Văn Tuấn', 'email' => 'tuanlv@gmail.com'],
            ['name' => 'Phạm Thị Hoa', 'email' => 'hoapt@gmail.com'],
            ['name' => 'Hoàng Văn Long', 'email' => 'longhv@gmail.com'],
            ['name' => 'Võ Thị Thu', 'email' => 'thuvt@gmail.com'],
            ['name' => 'Đỗ Văn Nam', 'email' => 'namdv@gmail.com'],
            ['name' => 'Bùi Thị Thanh', 'email' => 'thanhbt@gmail.com'],
            ['name' => 'Ngô Văn Kiên', 'email' => 'kiennv@gmail.com'],
            ['name' => 'Đinh Thị Tuyết', 'email' => 'tuyetdt@gmail.com'],
            ['name' => 'Mai Văn Hải', 'email' => 'haimv@gmail.com'],
            ['name' => 'Đặng Thị Ngọc', 'email' => 'ngocdt@gmail.com'],
            ['name' => 'Dương Văn Hiếu', 'email' => 'hieudv@gmail.com'],
            ['name' => 'Trịnh Thị Thảo', 'email' => 'thaott@gmail.com'],
            ['name' => 'Phan Văn Tâm', 'email' => 'tampv@gmail.com'],
            ['name' => 'Lý Thị Nhung', 'email' => 'nhunglt@gmail.com'],
            ['name' => 'Vũ Văn Hoàng', 'email' => 'hoangvv@gmail.com'],
            ['name' => 'Tô Thị Thùy', 'email' => 'thuytt@gmail.com'],
            ['name' => 'Hồ Văn Bình', 'email' => 'binhhv@gmail.com'],
            ['name' => 'Cao Thị Diệp', 'email' => 'diepct@gmail.com'],
            ['name' => 'Từ Văn Đạo', 'email' => 'daotv@gmail.com'],
            ['name' => 'Nguyễn Thị Kim', 'email' => 'kimnt@gmail.com'],
            ['name' => 'Trần Văn Phong', 'email' => 'phongtv@gmail.com'],
            ['name' => 'Lê Thị Loan', 'email' => 'loanlt@gmail.com'],
            ['name' => 'Phạm Văn Thành', 'email' => 'thanhpv@gmail.com'],
            ['name' => 'Hoàng Thị Mỹ', 'email' => 'myht@gmail.com'],
            ['name' => 'Võ Văn Toàn', 'email' => 'toanvv@gmail.com'],
            ['name' => 'Đỗ Thị Hằng', 'email' => 'hangdt@gmail.com'],
            ['name' => 'Bùi Văn Trung', 'email' => 'trungbv@gmail.com'],
            ['name' => 'Ngô Thị Giang', 'email' => 'giangnt@gmail.com'],
            ['name' => 'Đinh Văn Hiệp', 'email' => 'hiepdv@gmail.com'],
            ['name' => 'Mai Thị Hằng', 'email' => 'hangmt@gmail.com'],
            ['name' => 'Đặng Văn Dũng', 'email' => 'dungdv@gmail.com'],
            ['name' => 'Dương Thị Hạnh', 'email' => 'hanhdt@gmail.com'],
            ['name' => 'Trịnh Văn Tiến', 'email' => 'tienttv@gmail.com'],
            ['name' => 'Phan Thị Lệ', 'email' => 'lept@gmail.com'],
            ['name' => 'Lý Văn Hùng', 'email' => 'hunglv@gmail.com'],
            ['name' => 'Vũ Thị Hồng', 'email' => 'hongvt@gmail.com'],
            ['name' => 'Tô Văn Trí', 'email' => 'tritv@gmail.com'],
            ['name' => 'Hồ Thị Trang', 'email' => 'tranght@gmail.com'],
            ['name' => 'Cao Văn Hùng', 'email' => 'hungcv@gmail.com'],
            ['name' => 'Từ Thị Thơ', 'email' => 'thott@gmail.com'],
            ['name' => 'Nguyễn Văn Khánh', 'email' => 'khanhnv@gmail.com'],
            ['name' => 'Trần Thị Phượng', 'email' => 'phuongtt@gmail.com'],
            ['name' => 'Lê Văn Đông', 'email' => 'donglv@gmail.com'],
            ['name' => 'Phạm Thị Lan', 'email' => 'lanpt@gmail.com'],
            ['name' => 'Hoàng Văn Tú', 'email' => 'tuhv@gmail.com'],
            ['name' => 'Võ Thị Ngân', 'email' => 'nganvt@gmail.com'],
            ['name' => 'Đỗ Văn Thịnh', 'email' => 'thinhdv@gmail.com'],
            ['name' => 'Bùi Thị Nhàn', 'email' => 'nhanbt@gmail.com'],
            ['name' => 'Ngô Văn Thắng', 'email' => 'thangnv@gmail.com'],
            ['name' => 'Đinh Thị Thúy', 'email' => 'thuydt@gmail.com'],
            ['name' => 'Mai Văn Đông', 'email' => 'dongmv@gmail.com'],
            ['name' => 'Đặng Thị Tâm', 'email' => 'tamdt@gmail.com'],
            ['name' => 'Dương Văn Thái', 'email' => 'thaidv@gmail.com'],
            ['name' => 'Trịnh Thị Hạnh', 'email' => 'hanhtt@gmail.com'],
            ['name' => 'Phan Văn Tuấn', 'email' => 'tuanpv@gmail.com'],
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
