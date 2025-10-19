<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::where('slug', 'bai-viet')->first();
        $users = User::all()->pluck('id')->toArray();
        $allTags = Tag::all();

        if (!$category || empty($users) || $allTags->isEmpty()) {
            $this->command->warn('Please run CategorySeeder, UserSeeder and TagSeeder first.');
            return;
        }

        // Tag mapping by slug for easier access
        $tagMap = $allTags->keyBy('slug');

        $posts = [
            // Toán học
            [
                'title' => 'Phương pháp giải phương trình bậc hai',
                'description' => 'Hướng dẫn chi tiết cách giải phương trình bậc hai và các dạng bài tập nâng cao.',
                'content' => '<h2>Công thức nghiệm tổng quát</h2><p>Phương trình bậc hai có dạng ax² + bx + c = 0 (a ≠ 0). Để giải phương trình này, ta sử dụng công thức nghiệm: x = (-b ± √Δ) / 2a, với Δ = b² - 4ac.</p><h3>Các trường hợp</h3><ul><li>Δ > 0: Phương trình có 2 nghiệm phân biệt</li><li>Δ = 0: Phương trình có nghiệm kép</li><li>Δ < 0: Phương trình vô nghiệm</li></ul><p>Ngoài ra, ta còn có thể sử dụng định lý Vi-ét để tìm nghiệm nhanh hơn trong một số trường hợp đặc biệt.</p>',
                'status' => 1,
                'tags' => ['toan-hoc', 'phuong-trinh', 'cong-thuc', 'ly-thuyet', 'bai-tap'],
            ],
            [
                'title' => 'Hàm số bậc nhất và đồ thị',
                'description' => 'Tìm hiểu về hàm số bậc nhất, cách vẽ đồ thị và ứng dụng thực tế.',
                'content' => '<h2>Khái niệm hàm số bậc nhất</h2><p>Hàm số bậc nhất có dạng y = ax + b (a ≠ 0). Đồ thị của hàm số bậc nhất là một đường thẳng.</p><h3>Tính chất</h3><ul><li>Hệ số góc a quyết định độ dốc của đường thẳng</li><li>Tung độ gốc b là giao điểm với trục Oy</li><li>Hàm đồng biến khi a > 0, nghịch biến khi a < 0</li></ul><h3>Cách vẽ đồ thị</h3><p>Để vẽ đồ thị hàm số bậc nhất, ta chỉ cần xác định 2 điểm thuộc đồ thị và nối chúng lại.</p>',
                'status' => 1,
                'tags' => ['toan-hoc', 'ly-thuyet', 'ung-dung-thuc-te', 'co-ban'],
            ],
            [
                'title' => 'Định lý Pythagore và ứng dụng',
                'description' => 'Tìm hiểu định lý Pythagore và các bài toán thực tế liên quan.',
                'content' => '<h2>Định lý Pythagore</h2><p>Trong tam giác vuông, bình phương cạnh huyền bằng tổng bình phương hai cạnh góc vuông: a² + b² = c²</p><h3>Ứng dụng thực tế</h3><ul><li>Tính khoảng cách trong không gian</li><li>Xây dựng và kiến trúc</li><li>Định vị và bản đồ</li><li>Thiết kế đồ họa</li></ul><p>Định lý Pythagore là một trong những định lý quan trọng nhất trong toán học, được ứng dụng rộng rãi trong nhiều lĩnh vực khác nhau.</p>',
                'status' => 1,
                'tags' => ['toan-hoc', 'dinh-ly', 'ung-dung-thuc-te', 'co-ban'],
            ],

            // Vật lý
            [
                'title' => 'Định luật Newton và chuyển động',
                'description' => 'Giải thích 3 định luật Newton và cách áp dụng vào bài tập.',
                'content' => '<h2>Ba định luật Newton</h2><h3>Định luật I (Quán tính)</h3><p>Một vật đứng yên hoặc chuyển động thẳng đều sẽ giữ nguyên trạng thái đó nếu không chịu tác dụng của lực.</p><h3>Định luật II (Gia tốc)</h3><p>Gia tốc của một vật tỉ lệ thuận với lực tác dụng và tỉ lệ nghịch với khối lượng: F = ma</p><h3>Định luật III (Tác dụng và phản tác dụng)</h3><p>Lực và phản lực luôn xuất hiện đồng thời, cùng giá, cùng độ lớn nhưng ngược chiều.</p>',
                'status' => 1,
                'tags' => ['vat-ly', 'dinh-ly', 'ly-thuyet', 'bai-tap'],
            ],
            [
                'title' => 'Năng lượng và công suất điện',
                'description' => 'Cách tính năng lượng tiêu thụ và công suất của các thiết bị điện.',
                'content' => '<h2>Công suất điện</h2><p>Công suất điện P được tính theo công thức: P = U × I (với U là hiệu điện thế, I là cường độ dòng điện)</p><h3>Năng lượng điện</h3><p>Năng lượng tiêu thụ A = P × t (với t là thời gian sử dụng)</p><h3>Đơn vị đo</h3><ul><li>Công suất: Watt (W)</li><li>Năng lượng: kWh (kilowatt giờ)</li><li>1 kWh = 3.600.000 J</li></ul><p>Hiểu rõ về công suất và năng lượng điện giúp chúng ta sử dụng điện tiết kiệm và an toàn hơn.</p>',
                'status' => 1,
                'tags' => ['vat-ly', 'cong-thuc', 'ung-dung-thuc-te'],
            ],

            // Hóa học
            [
                'title' => 'Bảng tuần hoàn các nguyên tố hóa học',
                'description' => 'Hướng dẫn đọc và sử dụng bảng tuần hoàn hiệu quả.',
                'content' => '<h2>Cấu trúc bảng tuần hoàn</h2><p>Bảng tuần hoàn được sắp xếp theo số hiệu nguyên tử tăng dần, chia thành các chu kỳ (hàng ngang) và nhóm (cột dọc).</p><h3>Quy luật biến đổi tính chất</h3><ul><li>Trong một chu kỳ: Tính kim loại giảm, tính phi kim tăng</li><li>Trong một nhóm: Tính kim loại tăng, tính phi kim giảm</li><li>Bán kính nguyên tử và độ âm điện biến đổi có quy luật</li></ul><h3>Ứng dụng</h3><p>Bảng tuần hoàn giúp dự đoán tính chất hóa học, viết công thức hợp chất và cân bằng phương trình.</p>',
                'status' => 1,
                'tags' => ['hoa-hoc', 'ly-thuyet', 'co-ban'],
            ],
            [
                'title' => 'Phản ứng oxi hóa - khử',
                'description' => 'Phương pháp cân bằng phương trình oxi hóa khử đơn giản.',
                'content' => '<h2>Khái niệm</h2><p>Phản ứng oxi hóa - khử là phản ứng có sự thay đổi số oxi hóa của các nguyên tố.</p><h3>Các bước cân bằng</h3><ol><li>Xác định số oxi hóa của các nguyên tố</li><li>Tìm chất oxi hóa và chất khử</li><li>Viết quá trình nhường và nhận electron</li><li>Tìm hệ số thích hợp</li><li>Hoàn thành phương trình</li></ol><p>Phương pháp thăng bằng electron giúp cân bằng nhanh và chính xác các phương trình phức tạp.</p>',
                'status' => 1,
                'tags' => ['hoa-hoc', 'ly-thuyet', 'phuong-phap-hoc', 'nang-cao'],
            ],

            // Tiếng Anh
            [
                'title' => 'Thì hiện tại đơn và hiện tại tiếp diễn',
                'description' => 'Phân biệt và sử dụng đúng hai thì cơ bản trong tiếng Anh.',
                'content' => '<h2>Thì hiện tại đơn (Present Simple)</h2><p>Diễn tả hành động thường xuyên, sự thật hiển nhiên, thói quen.</p><h3>Cấu trúc</h3><ul><li>Khẳng định: S + V(s/es)</li><li>Phủ định: S + don\'t/doesn\'t + V</li><li>Nghi vấn: Do/Does + S + V?</li></ul><h2>Thì hiện tại tiếp diễn (Present Continuous)</h2><p>Diễn tả hành động đang xảy ra tại thời điểm nói.</p><h3>Cấu trúc</h3><ul><li>Khẳng định: S + am/is/are + V-ing</li><li>Phủ định: S + am/is/are + not + V-ing</li><li>Nghi vấn: Am/Is/Are + S + V-ing?</li></ul>',
                'status' => 1,
                'tags' => ['tieng-anh', 'ngu-phap', 'co-ban', 'ly-thuyet'],
            ],
            [
                'title' => '500 từ vựng tiếng Anh thông dụng nhất',
                'description' => 'Tổng hợp từ vựng tiếng Anh căn bản cho người mới bắt đầu.',
                'content' => '<h2>Nhóm từ vựng cơ bản</h2><h3>Gia đình (Family)</h3><p>Father (cha), Mother (mẹ), Brother (anh/em trai), Sister (chị/em gái), Grandfather (ông), Grandmother (bà)...</p><h3>Màu sắc (Colors)</h3><p>Red (đỏ), Blue (xanh dương), Green (xanh lá), Yellow (vàng), Black (đen), White (trắng)...</p><h3>Số đếm (Numbers)</h3><p>One, Two, Three, Four, Five... Ten, Twenty, Thirty, Hundred, Thousand...</p><p>Học từ vựng theo chủ đề giúp ghi nhớ lâu và dễ áp dụng vào giao tiếp thực tế.</p>',
                'status' => 1,
                'tags' => ['tieng-anh', 'tu-vung', 'co-ban', 'hoc-tap'],
            ],

            // Ngữ văn
            [
                'title' => 'Phân tích tác phẩm Vợ Nhặt - Kim Lân',
                'description' => 'Phân tích nội dung, nghệ thuật và ý nghĩa nhân đạo của tác phẩm.',
                'content' => '<h2>Nội dung tác phẩm</h2><p>Vợ Nhặt kể về chuyện tình yêu thương và nhân ái giữa Tràng và người vợ bị bệnh phong mà anh "nhặt" về nuôi trong thời kỳ đói kém.</p><h3>Nghệ thuật</h3><ul><li>Kết cấu tác phẩm khéo léo với cao trào cảm động</li><li>Nhân vật Tràng - người nông dân nghèo nhưng giàu lòng nhân ái</li><li>Ngôn ngữ giản dị, chân thực, gần gũi</li></ul><h3>Ý nghĩa</h3><p>Tác phẩm tôn vinh tình yêu thương, lòng nhân ái và phẩm chất cao đẹp của con người Việt Nam.</p>',
                'status' => 1,
                'tags' => ['ngu-van', 'van-hoc', 'ly-thuyet'],
            ],
            [
                'title' => 'Kỹ năng làm bài văn nghị luận',
                'description' => 'Hướng dẫn cấu trúc và cách viết bài văn nghị luận đạt điểm cao.',
                'content' => '<h2>Cấu trúc bài văn nghị luận</h2><h3>1. Mở bài</h3><p>Đặt vấn đề, dẫn dắt vào luận điểm cần chứng minh.</p><h3>2. Thân bài</h3><ul><li>Triển khai luận điểm thành các luận cứ</li><li>Phân tích, lập luận chặt chẽ</li><li>Dẫn chứng cụ thể từ văn bản, đời sống</li></ul><h3>3. Kết bài</h3><p>Khẳng định lại luận điểm, rút ra bài học, ý nghĩa.</p><h3>Lưu ý</h3><p>Sử dụng ngôn ngữ chính xác, mạch lạc. Tránh lặp từ, lan man. Phải có cái nhìn biện chứng.</p>',
                'status' => 1,
                'tags' => ['ngu-van', 'ky-nang', 'phuong-phap-hoc', 'bai-tap'],
            ],

            // Sinh học
            [
                'title' => 'Quang hợp ở thực vật',
                'description' => 'Tìm hiểu quá trình quang hợp và vai trò của nó.',
                'content' => '<h2>Khái niệm quang hợp</h2><p>Quang hợp là quá trình thực vật sử dụng năng lượng ánh sáng để tổng hợp chất hữu cơ từ CO₂ và H₂O.</p><h3>Phương trình tổng quát</h3><p>6CO₂ + 6H₂O + ánh sáng → C₆H₁₂O₆ + 6O₂</p><h3>Giai đoạn quang hợp</h3><ul><li>Giai đoạn sáng: Xảy ra ở lục lạp, tạo ATP và NADPH</li><li>Giai đoạn tối: Cố định CO₂ thành glucose</li></ul><h3>Ý nghĩa</h3><p>Quang hợp cung cấp oxy, thức ăn cho sinh vật và duy trì cân bằng khí quyển.</p>',
                'status' => 1,
                'tags' => ['sinh-hoc', 'ly-thuyet', 'thi-nghiem'],
            ],
            [
                'title' => 'Di truyền và biến dị',
                'description' => 'Các quy luật di truyền Mendel và ứng dụng trong đời sống.',
                'content' => '<h2>Định luật phân ly của Mendel</h2><p>Các tính trạng di truyền độc lập, phân ly theo tỉ lệ nhất định ở thế hệ sau.</p><h3>Quy luật phân ly</h3><p>Tỉ lệ kiểu hình F2: 3 trội : 1 lặn (khi lai một cặp tính trạng)</p><h3>Quy luật phân ly độc lập</h3><p>Các cặp tính trạng di truyền độc lập với nhau.</p><h3>Ứng dụng</h3><ul><li>Chọn giống cây trồng, vật nuôi</li><li>Tư vấn di truyền y học</li><li>Công nghệ sinh học</li></ul>',
                'status' => 0,
                'tags' => ['sinh-hoc', 'ly-thuyet', 'ung-dung-thuc-te', 'nang-cao'],
            ],

            // Lịch sử
            [
                'title' => 'Cách mạng tháng Tám 1945',
                'description' => 'Nguyên nhân, diễn biến và ý nghĩa lịch sử của Cách mạng tháng Tám.',
                'content' => '<h2>Bối cảnh lịch sử</h2><p>Sau Chiến tranh thế giới thứ hai, chế độ thực dân phong kiến tan rã, tạo thời cơ cho cách mạng.</p><h3>Diễn biến</h3><ul><li>Tổng khởi nghĩa toàn quốc từ 14-19/8/1945</li><li>Hội nghị Tân Trào, thành lập Chính phủ lâm thời</li><li>Ngày 2/9/1945: Chủ tịch Hồ Chí Minh đọc Tuyên ngôn Độc lập</li></ul><h3>Ý nghĩa</h3><p>Kết thúc ách thống trị của thực dân - phong kiến, mở ra kỷ nguyên độc lập tự do cho dân tộc.</p>',
                'status' => 1,
                'tags' => ['lich-su', 'ly-thuyet', 'hoc-tap'],
            ],

            // Địa lý
            [
                'title' => 'Khí hậu nhiệt đới gió mùa',
                'description' => 'Đặc điểm và ảnh hưởng của khí hậu nhiệt đới gió mùa đến Việt Nam.',
                'content' => '<h2>Đặc điểm khí hậu</h2><p>Việt Nam nằm trong vùng nhiệt đới gió mùa với hai mùa rõ rệt: mùa mưa và mùa khô.</p><h3>Đặc trưng</h3><ul><li>Nhiệt độ cao quanh năm (25-27°C)</li><li>Lượng mưa lớn (1500-2000mm/năm)</li><li>Độ ẩm không khí cao (80-85%)</li></ul><h3>Ảnh hưởng</h3><p>Thuận lợi cho nông nghiệp nhiệt đới, nhưng cũng gây thiên tai như bão lụt, hạn hán.</p>',
                'status' => 1,
                'tags' => ['dia-ly', 'ly-thuyet', 'hoc-tap'],
            ],

            // Tin học
            [
                'title' => 'Lập trình Python cho người mới bắt đầu',
                'description' => 'Hướng dẫn cơ bản về Python từ cài đặt đến viết chương trình đầu tiên.',
                'content' => '<h2>Giới thiệu Python</h2><p>Python là ngôn ngữ lập trình dễ học, mạnh mẽ, được sử dụng rộng rãi trong AI, web, data science.</p><h3>Cú pháp cơ bản</h3><pre><code>print("Hello World")\nx = 10\ny = 20\nsum = x + y\nprint("Tổng:", sum)</code></pre><h3>Cấu trúc điều khiển</h3><ul><li>if...else: Điều kiện</li><li>for, while: Vòng lặp</li><li>def: Định nghĩa hàm</li></ul><p>Python có cú pháp đơn giản, dễ đọc, thích hợp cho người mới học lập trình.</p>',
                'status' => 1,
                'tags' => ['tin-hoc', 'lap-trinh', 'co-ban', 'hoc-tap'],
            ],

            // GDCD
            [
                'title' => 'Quyền và nghĩa vụ của công dân',
                'description' => 'Tìm hiểu các quyền cơ bản và nghĩa vụ của công dân Việt Nam.',
                'content' => '<h2>Quyền của công dân</h2><ul><li>Quyền bình đẳng, tự do, dân chủ</li><li>Quyền sống, làm việc, học tập</li><li>Quyền tham gia quản lý nhà nước</li><li>Quyền được bảo vệ pháp luật</li></ul><h2>Nghĩa vụ của công dân</h2><ul><li>Tuân thủ pháp luật</li><li>Đóng thuế</li><li>Bảo vệ Tổ quốc</li><li>Giữ gìn trật tự công cộng</li></ul><p>Quyền và nghĩa vụ là hai mặt thống nhất, công dân cần thực hiện đầy đủ cả hai.</p>',
                'status' => 1,
                'tags' => ['giao-duc-cong-dan', 'ly-thuyet', 'hoc-tap'],
            ],

            // Giáo dục thể chất
            [
                'title' => 'Bài tập khởi động trước khi chơi thể thao',
                'description' => 'Các bài tập khởi động quan trọng giúp tránh chấn thương.',
                'content' => '<h2>Tại sao cần khởi động?</h2><p>Khởi động giúp cơ thể làm nóng, tăng lưu thông máu, tránh chấn thương khi vận động mạnh.</p><h3>Các bài tập khởi động</h3><ul><li>Xoay các khớp: cổ, vai, tay, hông, đầu gối</li><li>Chạy tại chỗ 2-3 phút</li><li>Duỗi cơ chân, tay, lưng</li><li>Bật nhảy nhẹ nhàng</li></ul><h3>Lưu ý</h3><p>Khởi động từ 5-10 phút. Không khởi động quá mạnh. Tập trung vào nhóm cơ sẽ sử dụng.</p>',
                'status' => 1,
                'tags' => ['the-duc', 'ky-nang', 'hoc-tap'],
            ],

            // Âm nhạc
            [
                'title' => 'Học đàn guitar cơ bản cho người mới',
                'description' => 'Hướng dẫn cầm đàn, đánh hợp âm cơ bản và luyện tập hiệu quả.',
                'content' => '<h2>Cách cầm đàn đúng tư thế</h2><p>Ngồi thẳng lưng, đàn tựa vào đùi, cánh tay phải đặt thoải mái trên thân đàn.</p><h3>Các hợp âm cơ bản</h3><ul><li>Am, C, G, Em, F, D</li><li>Luyện chuyển hợp âm mượt mà</li><li>Đánh theo nhịp 4/4</li></ul><h3>Lộ trình học</h3><ol><li>Học cách cầm đàn, bấm dây</li><li>Luyện hợp âm cơ bản</li><li>Tập đàn bài hát đơn giản</li><li>Nâng cao kỹ thuật</li></ol><p>Kiên trì luyện tập mỗi ngày 30-60 phút sẽ giúp bạn tiến bộ nhanh chóng.</p>',
                'status' => 1,
                'tags' => ['am-nhac', 'ky-nang', 'co-ban', 'hoc-tap'],
            ],

            // Kỹ năng học tập
            [
                'title' => 'Phương pháp Pomodoro - Học tập hiệu quả',
                'description' => 'Kỹ thuật quản lý thời gian giúp tăng hiệu suất học tập.',
                'content' => '<h2>Kỹ thuật Pomodoro là gì?</h2><p>Chia thời gian học thành các khoảng 25 phút tập trung cao độ, xen kẽ 5 phút nghỉ.</p><h3>Cách thực hiện</h3><ol><li>Chọn nhiệm vụ cần làm</li><li>Đặt đồng hồ 25 phút</li><li>Tập trung hoàn toàn vào nhiệm vụ</li><li>Nghỉ 5 phút khi hết giờ</li><li>Sau 4 Pomodoro, nghỉ dài 15-30 phút</li></ol><h3>Lợi ích</h3><ul><li>Tăng khả năng tập trung</li><li>Giảm mệt mỏi, căng thẳng</li><li>Hoàn thành nhiều công việc hơn</li></ul>',
                'status' => 1,
                'tags' => ['ky-nang', 'phuong-phap-hoc', 'hoc-tap'],
            ],

            // Ôn thi THPT Quốc gia
            [
                'title' => 'Lộ trình ôn thi THPT Quốc gia môn Toán',
                'description' => 'Kế hoạch ôn tập chi tiết và hiệu quả cho kỳ thi THPT.',
                'content' => '<h2>Giai đoạn 1: Ôn lý thuyết (3 tháng đầu)</h2><ul><li>Hệ thống lại toàn bộ kiến thức 3 năm THPT</li><li>Làm bài tập cơ bản theo từng chương</li><li>Ghi chép công thức, định lý quan trọng</li></ul><h2>Giai đoạn 2: Luyện đề (2 tháng tiếp)</h2><ul><li>Làm đề thi thử các năm</li><li>Phân tích đáp án, rút kinh nghiệm</li><li>Tập trung vào dạng bài yếu</li></ul><h2>Giai đoạn 3: Sprint cuối (1 tháng)</h2><ul><li>Làm đề thi theo đúng thời gian</li><li>Ôn lại các công thức, dạng bài quan trọng</li><li>Giữ tinh thần thoải mái</li></ul>',
                'status' => 1,
                'tags' => ['toan-hoc', 'on-thi', 'thpt-quoc-gia', 'phuong-phap-hoc'],
            ],
        ];

        foreach ($posts as $index => $postData) {
            $slug = Str::slug($postData['title']);

            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $post = Post::create([
                'title' => $postData['title'],
                'slug' => $slug,
                'description' => $postData['description'],
                'content' => $postData['content'],
                'thumbnail' => null, // Will use default no-image.svg
                'category_id' => $category->id,
                'user_id' => $users[array_rand($users)],
                'status' => $postData['status'],
                'created_at' => now()->subDays(rand(0, 60)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);

            // Attach tags to post
            if (isset($postData['tags']) && !empty($postData['tags'])) {
                $tagIds = [];
                foreach ($postData['tags'] as $tagSlug) {
                    if (isset($tagMap[$tagSlug])) {
                        $tagIds[] = $tagMap[$tagSlug]->id;
                    }
                }
                if (!empty($tagIds)) {
                    $post->tags()->attach($tagIds);
                }
            }
        }

        $this->command->info('20 posts with tags created successfully!');
    }
}
