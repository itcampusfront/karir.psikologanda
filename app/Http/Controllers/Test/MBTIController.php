<?php

namespace App\Http\Controllers\Test;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MBTIController extends Controller
{
    public static function detail($result)
    {
        
        $cek_personali_1 = $result['result'][1][3];
        $cek_personali_2 = $result['result'][1][4];
        $cek_mbti = $result['result'][1][2];

        $result_mbti = self::resultMBTI($cek_mbti);
        $result_personaly_1 = self::resultPower($cek_personali_1);
        $result_personaly_2 = self::resultPower($cek_personali_2);
  

        return view('admin.result.mbti.detail', [
            'result' => $result,
            'result_mbti' => $result_mbti,
            'result_p1' => $result_personaly_1,
            'result_p2' => $result_personaly_2
        ]);
    }

    public static function print(Request $request)
    {
        if($request->pendukung !=null){
            $pendukung1 = $request->pendukung;
        }else{
            $pendukung1 = null;
        }

        $pdf = PDF::loadview('admin/result/mbti/pdf', [
            'test' => 'MBTI',
            'tipe' => $request->tipe,
            'name'=> $request->name,
            'kepanjangan'=> $request->kepanjangan,
            'penjelasan' =>$request->penjelasan,
            'preferensi' =>json_decode($request->preferensi,true),
            'lingkungan' =>json_decode($request->lingkungan,true),
            'keseimbangan' =>json_decode($request->keseimbangan,true),
            'pendukung' => json_decode($pendukung1,true),
            'penilaian1' => json_decode($request->penilaian1,true),
            'penilaian10' => $request->penilaian10,
            'penilaian2' => json_decode($request->penilaian2,true),
            'penilaian20' => $request->penilaian20,
        ]);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('MBTI.pdf');
    }

    public static function resultMBTI($psikologi){
        $result_psikolog = array();
        $preferensi = array();
        $lingkungan = array();
        $keseimbangan = array();
        $pendukung = array();
        if($psikologi == 'ENFJ'){
            $cek_preferensi = ["Tindakan eksekutif dan perencanaan jangka panjang","Bersifat logis, analitis, dan kritis secara obyektif",
                                "Bersandar pada pemikiran",
                                "Fokus pada gagasan, bukan orang di balik gagasan",
                                "Berpikir lebih dulu, mengatur perencanaan, situasi, dan operasi yang berhubungan dengan suatu proyek",
                                "Membuat usaha sistematis untuk mencapai sasaran pribadi dengan waktunya",
                                "Kurang kesabaran terhadap situasi kebingungan atau ketidakefisienan",
                                "Kepercayaan bahwa perilaku harus dikendalikan oleh logika",
                                "Hidup dengan serangkaian aturan yang tertentu yang merangkum penilaian dasar dengan lingkungannya",
                                "Memandang apa yang tidak logis dan tidak konsisten"];
            
            for($i=0;$i<10;$i++){
                $preferensi[$i] = $cek_preferensi[$i];
            }

            $cek_lingkungan = ["Melihat kemungkinan-kemungkinan melampaui apa yang ada pada saat ini, yang kelihatan atau diketahui",
                                "Kemampuan menggunakan minat-minat intelektual, keingintahuan terhadap gagasan-gagasan baru, toleransi terhadap teori, dan cita rasa",
                                "terhadap masalah-masalah kompleks",
                                "Peluang menggunakan intuisi",
                                "Peluang-peluang pemecahan masalah, seperti pada posisi-posisi eksekutif"];
            for($i=0;$i<5;$i++){
                $lingkungan[$i] = $cek_lingkungan[$i];
            }

            $cek_keseimbangan = ["Memiliki orang-orang pendukung untuk memperhatikan hal-hal detil tertentu",
            "Memiliki orang-orang pendukung di sekitarnya dengan akal sehat untuk mengemukakan fakta-fakta yang luput dari perhatian",
                        "Sepenuhnya menguji suatu situasi sebelum mengambil suatu keputusan",
                        "Berhenti dan mendengarkan sudut pandang orang-orang lain",
                        "Berusaha memperhatikan nilai-nilai PERASAAN",
                        "Mengembangkan seni menghargai gagasan dan prestasi orang-orang lain",
                        "Belajar mengemukakan apa yang disukai, bukan sekedar apa yang perlu dikoreksi",
                        "Memiliki lebih banyak waktu-waktu ekstrovert dibandingkan waktu-waktu introvert",
                        "Pekerjaan yang memungkinkan ybs merencanakan gambaran besar."
            ];

            for($i=0;$i<9;$i++){
                $keseimbangan[$i] = $cek_keseimbangan[$i];
            }

            $result_psikolog[0] = "Extraverted iNtuitive Feeling Judging";
            $result_psikolog[1] = "Terlihat meyakinkan, terbuka dan siap memimpin. Dengan cepat ia melihat ketidaklogisan dan ketidakefisienan suatu kebijakan atau prosedur, mengembangkan dan melaksanakan sistem komprehensif untuk memecahkan masalah organisasi. Ia menyenangi perencanaan dan tujuan jangka panjang. Biasanya mudah mendapatkan informasi, senang membaca dan tertarik untuk mengembangkan kemampuan dan membaginya ke orang lain. Sangat cakap dalam menelorkan suatu ide.";
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'ENFP'){
            $cek_preferensi = ["Mencari kemungkinan-kemungkinan dan cara-cara baru melakukan berbagai hal",
            "Memecahkan masalah-masalah sulit dengan cara-cara yang sederhana",
                        "Mengubah proyek dan peluang-peluang baru demi kreativitas",
                        "Kesempatan untuk mengembangkan dan mengilhami potensi dalam diri orang-orang lain",
                        "Membangkitkan semangat",
                        "Menciptakan lingkungan yang penuh semangat dan motivasi",
                        "Mengkaji hal-hal, sementara terus mempertimbangkan pemecahannya"
            ];
            for($i=0;$i<7;$i++){$preferensi[$i] = $cek_preferensi[$i];}

            $cek_lingkungan = ["Kebebasan untuk berinovasi dengan proyek-proyek baru",
            "Mengejar minat-minat diri yang berubah-ubah",
            "Dapat memperoleh penghargaan atas kemampuan diri",
                "Kebebasan dari kendali dan hal-hal detil",
                "Mengejar dan menasihati mengenai peluang-peluang"
            ];

            for($i=0;$i<5;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}

            $cek_pendukung = [
                "Menolong diri sendiri melaksanankan dan menyelesaikan proyek yang telah dimulai",
                "Dapat mengambil alih bilamana suatu proyek telah berjalan lancar sehingga ybs dapat mengejar minat-minat baru yang lain",
                "Memperhatikan hal-hal detil yang penting namun tak berhubungan dengan minat yang utama",
            ];
            for($i=0;$i<3;$i++){$pendukung[$i] = $cek_pendukung[$i];}

            $cek_keseimbangan = [
                "Mengembangkan penilaian diri berdasarkan perasaan",
                "Belajar meneruskan dan menyelesaikan apa yang telah dimulai",
                "Menyeimbangkan waktu ekstrovert dan introvert (untuk diri dan lingkungan)",
                "Perasaan introvert berkembang baik.",
            ];
            for($i=0;$i<4;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[0] = "Extraverted iNtuitive Feeling Perceiving";
            $result_psikolog[1] = "Dengan tipe ini <xxx> menunjukkan kehangatan, antusias dan imajinatif. Ia melihat hidup penuh dengan kemungkian. Merangkai antara kejadian dan informasi secara cepat, dan secara meyakinkan menindaklanjutinya berdasarkan pola-pola yang mudah dilihatnya. Ia menginginkan banyak dukungan dari orang lain, dan ia pun cepat memberikan sanjungan ataupun dukungan. Secara spontan dan fleksibel seringkali ia mengandalkan kemampuannya untuk berimprovisasi secara verbal.";
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
            $result_psikolog[5] = $pendukung;

            
        }
        if($psikologi == 'ENTJ'){
           
            $cek_preferensi = ["Tindakan eksekutif dan perencanaan jangka panjang",
                        "Bersifat logis, analitis, dan kritis secara obyektif",
                        "Bersandar pada pemikiran",
                        "Fokus pada gagasan, bukan orang di balik gagasan",
                        "Berpikir lebih dulu, mengatur perencanaan, situasi, dan operasi yang berhubungan dengan suatu proyek",
                        "Membuat usaha sistematis untuk mencapai sasaran pribadi dengan waktunya",
                        "Kurang kesabaran terhadap situasi kebingungan atau ketidakefisienan",
                        "Kepercayaan bahwa perilaku harus dikendalikan oleh logika",
                        "Hidup dengan serangkaian aturan yang tertentu yang merangkum penilaian dasar dengan lingkungannya",
                        "Memandang apa yang tidak logis dan tidak konsisten"];
            for($i=0;$i<10;$i++){$preferensi[$i] = $cek_preferensi[$i];}

            $cek_lingkungan = ["Melihat kemungkinan-kemungkinan melampaui apa yang ada pada saat ini, yang kelihatan atau diketahui",
                            "Kemampuan menggunakan minat-minat intelektual, keingintahuan terhadap gagasan-gagasan baru, toleransi terhadap teori, dan cita rasa ",
                            "terhadap masalah-masalah kompleks",
                            "Peluang menggunakan intuisi",
                            "Peluang-peluang pemecahan masalah, seperti pada posisi-posisi eksekutif"];
            for($i=0;$i<5;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}
            
            $cek_keseimbangan = [
                "Memiliki orang-orang pendukung untuk memperhatikan hal-hal detil tertentu",
                        "Memiliki orang-orang pendukung di sekitarnya dengan akal sehat untuk mengemukakan fakta-fakta yang luput dari perhatian",
                        "Sepenuhnya menguji suatu situasi sebelum mengambil suatu keputusan",
                        "Berhenti dan mendengarkan sudut pandang orang-orang lain",
                        "Berusaha memperhatikan nilai-nilai PERASAAN",
                        "Mengembangkan seni menghargai gagasan dan prestasi orang-orang lain",
                        "Belajar mengemukakan apa yang disukai, bukan sekedar apa yang perlu dikoreksi",
                        "Memiliki lebih banyak waktu-waktu ekstrovert dibandingkan waktu-waktu introvert",
                        "Pekerjaan yang memungkinkan ybs merencanakan gambaran besar."
            ];
            for($i=0;$i<9;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[0] ="Extraverted iNtuitive Thinking Judging";
            $result_psikolog[1] = "terlihat meyakinkan, terbuka dan siap memimpin. Dengan cepat ia melihat ketidaklogisan dan ketidakefisienan suatu kebijakan atau prosedur, mengembangkan dan melaksanakan sistem komprehensif untuk memecahkan masalah organisasi. Ia menyenangi perencanaan dan tujuan jangka panjang. Biasanya mudah mendapatkan informasi, senang membaca dan tertarik untuk mengembangkan kemampuan dan membaginya ke orang lain. Sangat cakap dalam menelorkan suatu ide.";
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;

        }
        if($psikologi == 'ENTP'){
           
            $cek_preferensi = [
                "Mahir berurusan dengan teori dan hal-hal abstrak",
                "Mencari kemungkinan-kemungkinan dan cara-cara baru melakukan banyak hal",
                "Imajinasi dan inisiatif memulai proyek-proyek",
                "Perseptif terhadap sikap orang-orang lain",
                "Bertujuan untuk memahami daripada menghakimi orang",
                "Proyek yang berubah-ubah dan kesempatan-kesempatan baru demi kreativitas",
                "Kesempatan untuk mengembangkan dan mengilhami potensi dalam diri orang lain",
                "Membangkitkan semangat dan efektif dalam memotivasi orang lain",
                "Nakal dan mencintai kesenangan (fun)",
                "Membenci rutinitas yang tak memberi ilham"
            ];
            for($i=0;$i<10;$i++){$preferensi[$i] = $cek_preferensi[$i];}
                        
            $cek_lingkungan = [
                "Kebebasan untuk berinovasi dengan proyek-proyek baru",
                "Mengejar minat-minat yang berubah-ubah",
                "Dapat memperoleh penghargaan atas kemampuan diri",
                "Kebebasan dari kendali dan hal-hal detil",
                "Mengajar dan menasihati mengenai peluang-peluang"
            ];
            for($i=0;$i<5;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}

            $cek_pendukung = [
                "Menolong diri sendiri melaksanakan dan menyelesaikan proyek yang telah di mulai",
                "Dapat mengambil alih bilamana suatu proyek telah berjalan lancar sehingga ybs dapat mengejar minat-minat baru yang lain",
                "Memperhatikan hal-hal detil yang penting namun tak berhubungan dengan minat yang utama"
            ];
            for($i=0;$i<3;$i++){$pendukung[$i] = $cek_pendukung[$i];}
             
            $cek_keseimbangan = [
                "Mengembangkan penilaian diri",
                "Belajar meneruskan dan menyelesaikan apa yang telah dimulai",
                "Menyeimbangkan waktu ekstrovert dan introvert",
                "Mengembangkan dengan baik perasaan introvert."
            ];
            for($i=0;$i<4;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[0]="Extraverted iNtuitive Thinking Perceiving";
            $result_psikolog[1]="Cepat, pintar, mudah terpacu, waspada dan banyak bicara, tipe <xxx> sebagai ENTP. Ia memiliki banyak cara dalam menangani permasalahan baru atau menantang. Memiliki kemampuan dalam melaksanakan berbagai kemungkinan yang masih berupa konsep dan menganalisa secara strategis. Ia cakap dan peka terhadap orang lain, jenuh apabila dihadapkan situasi rutiin dan jarang melakukan sesuatu sama seperti yang dilakukan sebelumnya. Ia mudah berpindah ketertarikan dari satu ke lain hal.";
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;

        }
        if($psikologi == 'ESFJ'){
            
            $cek_preferensi = [
                        "Memancarkan simpati dan persekutuan",
                        "Hubungan manusiawi yang harmonis",
                        "Bersahabat, bijaksana dan simpatik",
                        "Tekun, teliti dan teratur",
                        "Dihangatkan karena persetujuan dan peka terhadap sikap masa bodoh",
                        "Berkonsentrasi pada sifat-sifat orang lain yang patut dipuji",
                        "Kesetiaan terhadap orang-orang yang dihormati, lembaga atau pelayanan",
                        "Mengidealkan apa yang dikagumi",
                        "Kemampuan melihat nilain pada pendapat orang lain",
                        "Mudah setuju terhadap pendapat orang lain dalam batas-batas yang masuk akal",
                        "Belas kasihan dan kesadaran akan kondisi fisik"
                    ];
            for($i=0;$i<11;$i++){$preferensi[$i] = $cek_preferensi[$i];}

            $cek_lingkungan = [
                "Kesempatan untuk melihat realita yang ditangkap oleh kelima indera",
                        "Minat pada perbedaan-perbedaan unik dalam setiap pengalaman",
                        "Menikmati milik diri sendiri",
                        "Variasi kegiatan, tetapi dapat beradaptasi dengan baik terhadap rutinitas",
                        "Dapat menerapkan minat terhadap buku-buku",
                        "Hanya sekadarnya membutuhkan teori",
                        "Dapat menggunakan talenta dalam berekspresi, misalnya berbicara di depan banyak orang dari pada menulis",
                        "Berbicara dengan orang-orang",
                        "Membangun kerja sama",
                        "Mendasarkan keputusan pada nila-nilai pribadi",
            ];
            for($i=0;$i<10;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}
                   
            $cek_keseimbangan = [
                "Memiliki orang-orang pendukung yang mengelola bidang-bidang yang menuntut ketelitian fakta seperti akuntansi",
                        "Berusaha untuk bersikap ringkas dan profesional",
                        "Tidak membiarkan sikap-sikap sosial memperlambat diri dalam pekerjaan",
                        "Mengambil waktu untuk memperoleh pengetahuan tangan pertama tentang seseorang atau situasi sebelum membuat suatu asumsi",
                        "Menghadapi fakta-fakta yang tak dapat disetujui, daripada mengabaikan masalah-masalah sendiri",
                        "Memiliki lebih banyak waktu-waktu ekstrovert daripada waktu introvert."
            ];
            for($i=0;$i<6;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[0]="Extraverted Sensing Feeling Judging";
            $result_psikolog[1]="Hangat, simpatik, hati-hati dan mudah bekerjasama. <xxx> sebagai ESFJ menginginkan keharmonisan dalam lingkungan, bekerja dengan ketekunan dalam meningkatkan kinerjanya. Ia menyukai bekerja dengan orang lain untuk menyelesaikan tugas secara akurat dan tepat waktu. Ia loyal, mengikuti segala sesuatu meski hal-hal kecil. Ia mencatat apa yang orang lain butuhkan di kesehariannya dan berusaha menyediakannya. Ia membutuhkan sanjungan sebagai apa dirinya dan terhadap kontribusinya dalam kelompok.";
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'ESFP'){
            $result_psikolog[0]="Extraverted Sensing Feeling Perceiving";
            $result_psikolog[1]="Terbuka, bersahabat dan menerima. Ia pecinta antusias dalam kehidupannya, orang dan keseimbangan materi. Ia menikmati kerja dengan orang lain untuk menjadikannya sesuatu berharga. Membawa isu-isu umum dan realistis dalam pendekatannya pada suatu tugas sehingga pekerjaanya tampak menyenangkan. <xxx> tipe yang fleksibel sebagai ESFP dan spontan, mudah menyesuaikan diri dengan lingkungan atau orang baru. Ia belajar terbaik dari orang lain mengenai kemampuan baru.";
            $cek_preferensi = [
                        "Bersandar pada apa yang dilihat, dengar dan ketahui dari tangan pertama",
                        "Menerima dan menggunakan fakta di sekitar diri sendiri",
                        "Mencari solusi-solusi yang memuaskan",
                        "Kemampuan beradaptasi",
                        "Berpikirang terbuka dan toleransi",
                        "Keterampilan pemecahan masalah",
                        "Menggunakan aturan-aturan, sistem atau situasi saat ini sebagai penolong, bukan penghalang",
                        "Keingintahuan terhadap orang, kegiatan, makanan, obyek atau pemandangan",
                        "Membuat keputusan berdasarkan nilai-nilai perasaan pribadi bukan analisis logis",
                        "Tertarik pada orang, penuh akal dan simpatik"
            ];
             
            for($i=0;$i<10;$i++){$preferensi[$i] = $cek_preferensi[$i];}

            $cek_lingkungan = [
                "Kemampuan untuk menggunakan indera untuk melihat kebutuhan saat ini",
                "Mangatasi orang dan konflik dengan terampil",
                "Dapat menyerap, menerapkan dan mengingat banyak sekal fakta",
                "Dapat menerapkan cita rasa artistik dan penilaian",
                "Dapat menerapkan realisme, tindakan dan kemampuan beradaptasi",
                "Kebebasan untuk melakukan berbagai tindakan"
            ];
            for($i=0;$i<6;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}
             
            $cek_keseimbangan = [
                        "Lebih berdisiplin dengan orang-orang lain",
                        "Gagasan abstrak dan teori dijelaskan kepada dirinya sendiri dan diuji dengan pengalaman",
                        "Dapat melihat relevansi suatu gagasan atau teori",
                        "PERASAAN dikembangkan sehingga nilai-nilai memberikan standar bagi perilaku diri sendiri",
                        "Penilaian dikembangkan untuk memberikan watak dan sikap ketekunan/kesetiaan",
                        "Waktu-waktu ekstrovert diseimbangkan dengan waktu introvert."
            ];

            for($i=0;$i<6;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'ESTJ'){
            $result_psikolog[0]="Extraverted Sensing Thinking Judging";
            $result_psikolog[1]="<xxx> dengan ESTJ-nya terlihat praktis, realistis dan berorientasi pada fakta. Keakurasian dan kecepatannya bertindak untuk mengambil keputusan. Ia mengatur tugas dan orang agar dapat dikerjakan dengan baik. Ia mudah menangani hal-hal rutin dan detail. Memiliki kejelasan dalam bertindak secara logis dan standar, sistematis mengikuti prosedur tersebut dan menuntut orang lain sama seperti dirinya. Ia memiliki kemampuan dalam mendorong dan merealisasikan perencanaan.";

            $cek_preferensi =[
                    "Menggunakan pikiran untuk mengendalikan sebisa mungkin dunia",
                    "Mengorganisir proyek-proyek, lalu mengusahakan agar terselesaikan",
                    "Bersifat logis, analitis dan kritis secara obyektif",
                    "Bersandar pada pemikiran",
                    "Fokus pada pekerjaan, bukan orang di balik pekerjaan",
                    "Mengorganisir fakta-fakta, situasi dan operasi yang berhubungan dengan suatu proyek",
                    "Membuat usaha sistematis untuk mencapai sasaran diri dengan waktu yang ada",
                    "Kurang kesabaran terhadap situasi kebingungan atau ketidakefisienan",
                    "Kepercayaan bahwa perilaku harus dikendalikan oleh logika",
                    "Hidup dengan serangkaian aturan yang tertentu yang merangkum penilaian dasar diri mengenai dunia",
                    "Memandang realita-realita saat ini, bukan kemungkinan-kemungkinan masa depan",
                    "Tidak berbelit-belit, praktis, realistis dan terbeban pada keadaan saat ini"
            ];
            for($i=0;$i<12;$i++){$preferensi[$i] = $cek_preferensi[$i];} 

            $cek_lingkungan = [
                    "Melihat hasi pekerjaan sebagai sesuatu yang segera, nyata dan dapat dirasakan",
                    "Kemampuan menggunakan kecenderungan alami terhadap bisnis, industri, produksi dan konstruksi",
                    "Pemanfaatan kemampuan administratif",
                    "Kesempatan menggunakan kemampuan untuk menetapkan tujuan, membuat keputusan dan memberikan perintah yang perlu",
                    "Peluang-peluang pemecahan masalah, seperti pada posisi-posisi eksekutif"
            ];
            
            for($i=0;$i<5;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}

            $cek_keseimbangan = [
                    "Memiliki orang-orang pendukung untuk memperhatikan beberapa hal detil tertentu",
                    "Memiliki orang-orang pendukung di sekitar diri dengan akal sehat untuk mengemukakan fakta-fakta yang luput dari perhatian",
                    "Sepenuhnya menguji suatu situasi sebelum mengambil suatu keputusan",
                    "Berhenti dan mendengarkan sudut pandang orang-orang lain",
                    "Berusaha memperhatikan nilai-nilai PERASAAN",
                    "Mengembangkan seni menghargai gagasan dan prestasi orang-orang lain",
                    "Belajar mengemukakan apa yang disukai, bukan sekedar apa yang perlu dikoreksi",
                    "Memiliki lebih banyak waktu-waktu ekstrovert dibandingkan waktu-waktu introvert"
            ];
            
            for($i=0;$i<8;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;

        }
        if($psikologi == 'ESTP'){
            $result_psikolog[0]="Extraverted Sensing Thinking Perceiving";
            $result_psikolog[1] = "Tipe ESTP, <xxx> orang yang fleksibel dan toleran, menggunakan pendekatan pragmatis untuk dalam menghasilkan sesuatu secara cepat. Teoritis dan konseptual membosankan dirinya. Ia menginginkan gerak cepat dalam memecahkan masalah. Berorientasi pada kini dan saat ini, spontan dan menikmati saat-saat dimana ia dapat secara aktif berinteraksi dengan orang lain. Ia menikmati kestabilan materi dan gaya hidup. B;elajar banyak dengan melakukan sesuatu.";

            $cek_preferensi = [
                "Menghadapi hidup secara realistik dan tak pribadi",
                        "Bersahabat, realisme yang dapat beradaptasi",
                        "Bersandar pada apa yang dilihat, dengar dan ketahui dari tangan pertama",
                        "Menerima dengan baik dan menggunakan fakta di sekitar dirinya",
                        "Mencari solusi-solusi yang memuaskan",
                        "Kemampuan beradaptasi",
                        "Berpikiran terbuka dan toleransi",
                        "Keterampilan pemecahan masalah",
                        "Menggunakan aturan-aturan, sistem atau situasi saat ini sebagai penolong, bukan penghalang",
                        "Keingintahuan terhadap orang, kegiatan, makanan, obyek atau pemandangan",
                        "Membuat keputusan berdasarkan analisis logis pikiran bukan nilai-nilai perasaan pribadi",
                        "Keuletan bila dituntut situasi"
            ];
            for($i=0;$i<12;$i++){$preferensi[$i] = $cek_preferensi[$i];}

            $cek_lingkungan = [
                "Kemampuan untuk menggunakan indera untuk melihat kebutuhan saat ini",
                "Mengatasi orang dan konflik dengan terampil",
                "Dapat menyerap, menerapkan dan mengingat banyak sekali fakta",
                "Dapat menerapkan cita rasa artistik dan penilaian",
                "Dapat menerapkan realisme, tindakan dan kemampuan beradaptasi",
                "Kebebasan untuk melakukan berbagai kegiatan"
            ];

            for($i=0;$i<6;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}

            $cek_keseimbangan = [
                "Memiliki orang-orang pendukung yang intuitif di sekitar diri sendiri",
                        "Memiliki orang-orang yang berpikiran positif di sekitar diri untuk menghindarkan dari hal-hal negatif",
                        "Mengembangkan PIKIRAN sehingga dapat menggunakan prinsip-prinsip untuk memberikan standar bagi perilaku, arah dan tujuan dalam hidup",
                        "Mengembangkan PENILAIAN dengan memadai untuk memberikan watak dan sikap ketekunan/kesetiaan",
                        "Waktu-waktu ekstrovert diseimbangkan untuk menghindarkan dari sikap impulsif"
            ];
            for($i=0;$i<5;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'INFJ'){
            $result_psikolog[0]="Introverted iNtuitive Feeling Judging";
            $result_psikolog[1] = "<xxx> sebagai INFJ senang dalam mencari arti dari suatu hubungan atau ide, interaksi dan ketertarikan materi. Ia ingin paham mengenai motivasi orang terhadap hal atau orang lain. Kehati-hatian dan komitmen terhadap organisasi atau kelompok tinggi. Ia mengembangkan kejelasan pandangan mengenai bagaimana cara terbaik dalam melayani atau mengerjakan sesuatu. Ia sangat teratur dan yakin dala;m melaksanakan konsep dan pandangannya.";

            $cek_preferensi = [
                        "Intuisi dan pemahaman",
                        "Kesempatan untuk bersikap inovatif dengan gagasan baru",
                        "Pemecahan masalah",
                        "Keharmonisan dan persekutuan",
                        "Mahir membujuk orang-orang lain untuk menyetujui dan bekerja sama",
                        "Memenangkan penerimaan gagasan-gagasan",
                        "Intuisi yang diperkuat oleh perasaan",
                        "Memvisualisasikan potensi manusiawi",
                        "Menggunakan suatu proses subyektif dalam menimbang dan menerapkan nilai-nilai"
                    ];

                    for($i=0;$i<9;$i++){$preferensi[$i] = $cek_preferensi[$i];}
            $cek_lingkungan = [
                "Kemandirian dan kebebasan pribadi",
                "Memimpin orang-orang lain menuju keputusan",
                "Bekerja dengan orang-orang untuk mengembangkan pemahaman dan individualitas",
            ];

            for($i=0;$i<3;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}

            $cek_keseimbangan =[
                "Mencari hal-hal yang mungkin bertentangan dengan tujuan",
                "Perasaan dan penilaian dikembangkan",
                "Belajar mendasarkan keputusan pada logika",
                "Berdisiplin antara waktu introvert dan ekstrovert"
            ];

            for($i=0;$i<4;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'INFP'){
            $result_psikolog[0]="Introverted iNtuitive Feeling Perceiving";
            $result_psikolog[1] = "Sebagai INFP <xxx> pribadi yang idealistis, loyal kepada nilai-nilai dan kepada orang lain yang dianggap penting oleh dirinya. Ia menginginkan kehidupan luar selaras dengan nilai-nilai yang dianut. Keingintahuan, cepat melihat segala kemungkinan dan dapat menjadi penengah dalam melaksanakan suatu ide. Ia mencari untuk mengerti orang lain dan membantu potensi. Ia cepat menyesuaikan diri, fleksibel dan menerima terkecuali apabila nilai-nilai dirinya terancam.";

            $cek_preferensi =  [
                        "Kesetiaan terhadap tugas dan kewajiban yang berhubungan dengan gagasan atau orang yang dipedulikan",
                        "Perfeksionisme bila menyukai sesuatu",
                        "Mengambil pendekatan yang sangat pribadi terhadap hidup",
                        "Menilai segala sesuatu dengan cita-cita batiniah dan nilai-nilai pribadi",
                        "Berpegang teguh pada impian ideal dengan keyakinan yang bersemangat",
                        "Kesetiaan batiniah dan impian ideal mengendalikan hidup",
                        "Enggan membuka perasaan yang terdalam",
                        "Toleransi, berpikiran terbuka, pemahaman, fleksibilitas dan kemampuan beradaptasi dalam masalah-masalah sehari-hari",
                        "Sedikut kerinduan untuk mengesankan atau mendominasi",
                        "Menghargai diri dengan memahami nilai-nilai dan tujuan"
            ];
            for($i=0;$i<10;$i++){$preferensi[$i] = $cek_preferensi[$i];}

            $cek_lingkungan =[
                "Kesempatan untuk melihat kemungkinan melampaui apa yang ada sekarang, yang kelihatan atau diketahui",
                "Bekerja dalam pekerjaan yang dipercayai",
                "Berkontribusi pada sesuatu yang meningkatkan pemahaman, kebahagiaan, atau kesehatan manusia",
                "Ada tujuan di balik penghasilan",
                "Karunia berekspresi"
            ];

            for($i=0;$i<5;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}
                        
            $cek_pendukung = [
                "Menolong diri melaksanakan dan menyelesaikan proyek yang telah dimulai",
                "Dapat mengambil alih bilamana suatu proyek tela berjalan lancar sehingga dapat mengejar minat-minat baru yang lain",
                "Memperhatikan hal-hal detil yang penting namun tak berhubungan dengan minat yang utama"
            ];
            for($i=0;$i<3;$i++){$pendukung[$i] = $cek_pendukung[$i];}

            $cek_keseimbangan = [
                "Tidak menghabiskan terlalu banyak waktu sendirian mengembangkan nilai-nilai yang hanya memiliki potensi yang kecil
                Tidak menghabiskan terlalu banyak waktu dalam kegiatan-kegiatan ekstrovert yang menyebabkan diri menjadi berserakan dan tak teratur
                Memiliki seorang pendukung yang dapat menjaga agar tetap berfokus pada tujuan
                Dapat menemukan saluran untuk mengekspresikan gagasan-gagasan"
            ];
            for($i=0;$i<1;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
            $result_psikolog[5] = $pendukung;

        }
        if($psikologi == 'INTJ'){
            $result_psikolog[0]="Introverted iNtuitive Thinking Judging";
            $result_psikolog[1]="<xxx> memiliki pola pikir original dan dorongan kuat untuk melaksanakan ide-ide dan berhasil dalam suatu tujuan. Sebagai INTJ akan cepat melihat suatu gambaran di lingkungan luar dan mengembangkan gambarannya tersebut secara jelas dan meluas. Ketika berkomitmen terhadap tugas, ia mengatur pekerjaan dan terlibat secara mendalam sampai proses berakhir. Ia cenderung ragu (bahkan terkadang sinis) dan mandiri, memiliki standar kemampuan dan kinerja untuk dirinya dan orang lain.";

            $cek_preferensi = [
                "Pikiran-pikiran dan juga tindakan-tindakan inovatif",
                "Mempercayai pemahaman intuitif terhadap hubungan sejati dan makna dari ha-hal",
                "Iman terhadap visi batiniah, cukup untuk memindahkan gunung",
                "Mandiri, kadang-kadang sampai pada titik keras kepala",
                "Nilai tinggi pada kompetensi, terhadap diri sendiri atau orang lain",
                "Kerinduan untuk menghabiskan waktu dan berusaha untuk melihat inspirasi dilaksanakan dalam praktek",
                "Mendorong orang lain hampir sekeras mendorong diri sendiri"
            ];
            for($i=0;$i<7;$i++){$preferensi[$i] = $cek_preferensi[$i];}

            $cek_lingkungan = [
                "Suatu kemampuan untuk menggunakan intuisi",
                "Tidak ada pekerjaan rutin",
                "Membangkitkan kemungkinan-kemungkinan yang berjangkauan jauh",
                "Menggunakan logika untuk mengubah kemungkinan menhadi realita",
                "Menggunakan pemikiran konseptual dan analitis",
                "Menggunakan teori dan abstraksi"
            ];

            for($i=0;$i<6;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}
           
            $cek_keseimbangan = [
                "Memiliki orang-orang lain di sekitar yang dapat menolong dengan gambaran menyeluruh",
                "Membuat usaha untuk melihat nilai-nilai dan perasaan orang lain",
                "Tidak menekan nila-nilai pribadi sendiri",
                "Mencari cara yang tepat untuk mengatasi tekanan",
                "Belajar menunjukkan penghargaan dalam pekerjaan dan hubungan pribadi",
                "Mengembangkan PIKIRAN untuk memberikan penilaian yang diperlukan",
                "Mendengarkan pendapat orang-orang lain"
            ];

            for($i=0;$i<7;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}
            
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'INTP'){
            $result_psikolog[0]="Introverted iNtuitive Thinking Perceiving";
            $result_psikolog[1]="<xxx> dengan INTP-nya berusaha mencari dan mengembangkan penjelasan logis terhadap segala sesuatu yang menarik dirinya. Pendekatan teoritis dan abstraktif lebih disukai daripada dengan interaksi sosial. Ia tenang, terkendali dan dapat pula fleksibel, mudah menyesuaikan diri. Ia memiliki kemampuan yang tidak umum untuk mencermati secara mendalam terhadap pemecahan masalah, pada bidang-bidang yang menarik dirinya. Ia ragu cenderung sinis, terkadang kritis dan selalu analitis.";
            $cek_preferensi = [
                "Membuat penilaian logis tentang kemungkinan-kemungkinan non-personal",
                "Konseptual dan analitis",
                "Kritis secara obyektif",
                "Berfokus lebih pada gagasan daripada orang di balik gagasan",
                "Lingkaran kecil sahabat-sahabat dekat",
                "Pendiam dan penyegan",
                "Sangat ingin tahu mengenai gagasan-gagasan baru",
                "Menjadi terlalu tenggelam dalam gagasan dan mengabaikan situasi-situasi eksternal",
                "Kerinduan untuk memahami misteri kompleks dari hal-hal yang bukan pribadi",
                "Pada umumnya gampangan (easy-going) dan mudah beradaptasi"
            ];

            for($i=0;$i<10;$i++){$preferensi[$i] = $cek_preferensi[$i];}
            $cek_lingkungan =[
                "Kemampuan menggunakan intuisi",
                "Mengambil pemahaman intuitif dan mengkajinya secara logis",
                "Membangkitkan kemungkinan-kemungkinan yang berjangkauan jauh",
                "Menggunakan logika untuk mengubah kemungkinan menjadi realita",
                "Menggunakan pemikiran konseptual dan analitis",
                "Menggunakan teori dan daya khayal",
            ];

            for($i=0;$i<6;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}
            
            $cek_keseimbangan = [
                "Memiliki orang-orang lain di sekitar diri yang dapat menolong dengan gambaran menyeluruh",
                        "Berusaha untuk melihat nilai-nilai dan perasaan orang lain",
                        "Tidak menekan nilai-nilai pribadi sendiri",
                        "Mencari cara yang tepat untuk mengatasi tekanan",
                        "Belajar menyederhanakan argumentasi",
                        "Mengembangkan PERSEPSI",
                        "Memiliki lebih banyak kontak dengan dunia luar",
                        "Belajar menyatakan penghargaan terhadap pekerjaan dan hubungan pribadi",
                        "Menyeimbangkan waktu-waktu ekstrovert dan introvert",
            ];

            for($i=0;$i<9;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'ISFJ'){
            $result_psikolog[0]="<h1>Introverted Sensing Feeling Judging</h1>";
                    $result_psikolog[1]=" Sebagai ISFJ, <xxx> pendiam, hangat dan bertanggung jawab. Ia juga berhati-hati dalam bertindak. Memiliki komitmen tinggi dan stabil apabila dihadapkan pada tugas. Ia sistematis, hati-hati dan akurat. Loyalitas tinggi, penuh pertimbangan, mencatat segala sesuatu dan mengingat-ingat hal-hal spesifik mengenai orang yang dianggap penting bagi dirinya. Ia penuh perhatian dengan bagaimana orang lain merasa. Ia berusaha menciptakan keteraturan dan keharmonisan lingkungan kerja maupun rumah tangga.";
            $cek_preferensi = [
                        "Mendasarkan keputusan pada nilai-nilai pribadi",
                        "Dapat diandalkan, akurat",
                        "Penghargaan yang lengkap, realistik dan praktis terhadap fakta",
                        "Menerima tanggung jawab melampaui panggilan tugas",
                        "Terampil, tenang dan tegar dalam suatu krisis",
                        "Mendalam, bekerja keras, stabil",
                        "Ketekunan yang menstabilkan",
                        "Pilihan yang berhati-gati terhadap proyek",
                        "Kemampuan berorganisasi",
                        "Ramah, simpatik, banyak akal dan terbeban dengan tulus",
                        "Kemampuan untuk mengingat hal-hal detil",
            ];
            for($i=0;$i<11;$i++){$preferensi[$i] = $cek_preferensi[$i];}

            $cek_lingkungan = [
                "Peranan manajemen dan supervisi",
                "Menemukan solusi terhadap masalah-masalah saat ini",
                "Kesempatan untuk mengumpulkan fakta untuk mendukung evaluasi",
                "Tetap dalam dunia realita",
            ];

            for($i=0;$i<4;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}

            $cek_keseimbangan = [
                "Tidak menghabiskan waktu terlalu banyak dalam kegiatan-kegiatan ekstrovert",
                "Menggunakan persepsi diri untuk memahami orang-orang lain",
                "Mengembangkan PENILAIAN dan PERASAAN",
                "Membagikan dunia batiniah tentang hal-hal detil dan informasi dengan orang-orang lain",
                "Tidak menghabiskan terlalu banyak waktu sendiri karena hal itu menyebabkan pikiran-pikiran tak produktif dan mungkin depresi",
            ];

            for($i=0;$i<5;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'ISFP'){
            $result_psikolog[0]="Introverted Sensing Feeling Perceiving";
            $result_psikolog[1]="Sebagai IFSP <xxx> menunjukkan ketenangan, pendiam, ramah dan sensitif. Ia menikmati situasi yang ada, apa yang terjadi di sekitarnya. Ia senang mendapatkan apa yang ada di lingkungannya sendiri dan bekerja dengan jadwal dibuat. Ia mudah dipercaya dan berkomitmen dengan nilai-nilai dan orang yang dianggap penting. Tidak menyukai ketidaksetujuan dan konflik, dan tidak memaksa pendapat atau nilai kepada orang lain.";
            $cek_preferensi = [
                "Menilai hidup dengan impian ideal batiniah dan nilai-nilai pribadi",
                "Bekerja dengan cara khusus dengan orang-orang atau makhluk hidup lain",
                "Menjaga diri sesuai standar yang tinggi",
                "Hewan dapat menjadi bagian penting dalam hidup",
                "Setia kepada tugas, dapat diandalkan, akurat",
                "Toleran, berpikiran terbuka, fleksibel dan mampu beradaptasi",
                "Tampil tenang dan tegar dalam suatu krisis",
                "Mendalam, bekerja keras, stabil",
                "Ketekunan yang menstabilkan",
                "Menikmati saat-saat sekarang, tidak terburu-buru beralih",
                "Ramah, simpatik, banyak akal dan terbeban dengan tulus",
                "Sedikit kerinduan untuk mengesankan atau mendominasi",
                "Perfeksionis bila menyukai sesuatu secara mendalam",
            ];

            for($i=0;$i<13;$i++){$preferensi[$i] = $cek_preferensi[$i];}
            
            $cek_lingkungan = [
                "Kemampuan untuk menikmati ciat rasa, diskriminasi dan makna keindahan dan proporsi",
                        "Cinta yang khusus akan alam dan simpati terhadap hewan",
                        "Kesempatan untuk bekerja dengan tangannya sendiri, mencipta dan berkarya",
                        "Pekerjaan yang berkontribusi terhadap sesuatu yang berarti bagi diri sendiri",
                        "Cara-cara praktis untuk mengekspresikan impian ideal",
            ];

            for($i=0;$i<5;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}

            $cek_keseimbangan = [
                "Tidak menghabiskan waktu terlalu banyak dalam kegiatan ekstrovert karena hal itu menyebabkan ybs menjadi berserakan dan tak teratur",
                "Menggunakan persepsi untuk memahami orang-orang lain",
                "Tidak menghabiskan waktu terlalu banyak sendirian karena hal itu membuat penilaian yang tidakk realistis dan bersikap kaku",
            ];

            for($i=0;$i<3;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
            
        }
        if($psikologi == 'ISTJ'){
            $result_psikolog[0]="Introverted Sensing Thinking Judging";
            $result_psikolog[1]="Ia pendiam, tenang, serius dan mendapatkan keberhasilan dari ketekuan dan kehati-hatiannya. Ia dapat diandalkan, praktis, berdasarkan fakta yang ada, realistis dan bertanggung jawab. Keputusan yang diambil logis dengan apa yang harus dikerjakannya secara tegas dan jelas, menghindari kekacauan yang mungkin terjadi. Ia menyenangi segala hal secara teratur dan terorganisasi dengan baik, baik kehidupan pribadi, rumah tangga maupun pekerjaan. Ia berpegang pada nilai tradisi dan kepercayaan.";
            $cek_preferensi = [
                "Dapat diandalkan, akurat",
                "Penghargaan yang lengkap, realistik dan praktis terhadap fakta",
                "Menerima tanggung jawab melampaui panggilan tugas",
                "Tampil tenang dan tegar dalam suatu krisis",
                "Mendalam, bekerja keras, stabil",
                "Pilihan yang berhati-hati terhadap proyek",
                "Kemampuan berorganisasi",
            ];

            for($i=0;$i<7;$i++){$preferensi[$i] = $cek_preferensi[$i];}
            
            $cek_lingkungan = [
                "Peranan manajemen dan supervisi",
                "Menemukan solusi terhadap masalah-masalah saat ini",
            ];

            for($i=0;$i<2;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}

            $cek_keseimbangan = [
                "Tidak mengharapkan orang-orang lain sama logis dan analitisnya seperti diri sendiri",
                "Menggunakan persepsi untuk memahami orang-orang lain",
                "Mengembangkan PIKIRAN",
                "Membagikan dunia batiniah tentang hal-hal detil dan informasi dengan orang-orang lain",
                "Mengijinkan beberapa perasaan atau emosi memiliki kepentingan, baik dari diri sendiri dan orang-orang lain",
                "Tidak menghabiskan terlalu banyak waktu ekstrovert atau terlalu banyak waktu sendirian",
            ];

            for($i=0;$i<6;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}
            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }
        if($psikologi == 'ISTP'){
            $result_psikolog[0]="Introverted Sensing Thinking Perceiving";
            $result_psikolog[1]="Sebagai ISTP, <xxx> toleran dan fleksibel, tenang dalam mengamati sampai permasalahan jelas, kemudian bertindak cepat untuk mendapatkan solusi praktis. Ia melakukan analisa terhadap apa yang bisa dikerjakan dengan membatasi pada data-data dan inti masalah. Ia tertarik dengan sebab akibat, mengatur fakta menggunakan prinsip logis, nilai dan efisiensi.";
            $cek_preferensi = [
                "Logis, analitis dan kritis secara obyektif",
                "Kesenangan mengorganisir fakta dan data",
                "Keinginan tahu yang besar namun secara diam-diam",
                "Pemalu secara sosial kecuali bila salah satu prinsip penting dilanggar",
                "Mudah beradaptasi kecuali bila salah satu prinsip penting dilanggar",
                "Terampil dengan tangannya",
                "Menyukai olah raga dan kegiatan luar rumah (outdoor)",
                "Menyukai segala sesuatu yang memberikan banyak informasi bagi indera",
                "Tertarik pada bagaimana dan mengapa hal-hal bekerja",
                "Biasanya gampangan (easy-going), menyukai kesenangan (fun) dan mudah beradaptasi",
                "Kemampuan berorganisasi",
            ];

            for($i=0;$i<11;$i++){$preferensi[$i] = $cek_preferensi[$i];}
            $cek_lingkungan = [
                "Kesempatan untuk memahami rahasia cara kerja hal-hal konkrit: mesin, peralatan, hukum, program komputer",
                "Mencari solusi terhadap masalah-masalah saat ini",
            ];

            for($i=0;$i<2;$i++){$lingkungan[$i] = $cek_lingkungan[$i];}
                        
            $cek_keseimbangan = [
                "Tidak mengharapkan orang-orang lain sama logis dan analitisnya seperti dirinya sendiri",
                "Mengembangkan PERASAAN",
                "Membagikan dunia batiniah tentang hal-hal detil dan informasi dengan orang-orang lain",
                "Mengijinkan beberapa perasaan atau emosi memiliki kepentingan, baik dari diri sendiri dan orang-orang lain",
                "Tidak menghabiskan terlalu banyak waktu ekstrovert karena hal itu menyebabkannya menjadi tidak konsisten dan tak dapat diandalkan, tak ",
                "mampu mengikuti",
                "Tidak menghabiskan terlalu banyak waktu introvert karena hal itu menyebabkannya memiliki penilaian yang rapuh",
            ];

            for($i=0;$i<7;$i++){$keseimbangan[$i] = $cek_keseimbangan[$i];}

            $result_psikolog[2] = $preferensi;
            $result_psikolog[3] = $lingkungan;
            $result_psikolog[4] = $keseimbangan;
        }

        return $result_psikolog;
    }

    public static function resultPower($penilaian){
        $hasil = array();
        if (($penilaian=="SN")){
            $hasil[0]="Sensors need Intuitives";
            $hasil[1] = [
                "Menyajikan berbagai kemungkinan.",
                "Memberi kejelasan pada masalah.",
                "Melihat tanda-tanda perubahan.",
                "Bagaimana mempersiapkan masa depan.",
                "Mendapatkan antusiasme.",
                "Mencari esensi baru.",
                "Menghadapi kesulitan dengan antusiasme.",
                "Menunjukkan ketertarikan masa depan yang dicari.",
            ];
        };
        if (($penilaian=="NS")){
            $hasil[0]="Intuitive need Sensors";
            $hasil[1]= [
                "Menyajikan fakta relevan.",
                "Menerapkan pengalaman terhadap masalah.",
                "Membaca petunjuk jelas.",
                "Mencatat apa yang menjadi perhatian saat ini.",
                "Menjaga alur inti dan detail.",
                "Menghadapi kesulitan dengan realitas.",
                "Menikmati situasi saat ini.",
            ];
        };
        if (($penilaian=="SJ")){

            $hasil[0]="Sebagai pemimpin menunjukkan : sifat tradisional, stabil dan menggabungkan.";
            // kekuatan
            $hasil[1] = [
                    "Menciptakan stabilitas dalam sistem.",
                    "Perhitungan.",
                    "Mengerti dan menerjemahkan nilai organisasi.",
                    "Perhatian terhadap penghargaan dan kebijakan.",
                    "Meyakinkan.",
                    "Menilai secara realistis suatu tugas.",
                    "Ketepatan dalam bekerja.",
                    "Memperhitungkan resiko sebelum bertindak.",
                    "Pola pandang luas.",
                    "Tepat waktu, terencana dan teratur.",
            ];
            // kelemahan
            $hasil[2] = [
                "Kurang sabar terhadap hal-hal yang tertunda.",
                "Mengambil keputusan terlalu cepat.",
                "Kurang perhatian terhadap hal-hal baru.",
                "Terlalu yakin dengan cara atau aturan lama.",
                "Sulit berubah.",
                "Menilai hitam dan putih.",
                "Terlalu memperhatikan kesempurnaan.",
            ];
            // <p>Hubungan dengan Orang:</p>

            $hasil[3] = [
                "Menginginkan orang lain langsung pada inti masalah.",
                "Lebih akurat dengan sistem data daripada sistem sosial.",
                "Langsung dalam berinteraksi tanpa basa-basi terutama dalam situasi sosial.",
            ];
            // <p>Kontribusi Kelompok:</p>
            $hasil[4] = [
                "Efektif, menjalankan dengan halus.",
                "Menentukan perencanaan.",
                "Memanfaatkan data.",
                "Mengerti hal-hal detail.",
            ];
        };
        if (($penilaian=="SP")){
            $hasil[0]="Sebagai pemimpin menunjukkan : pemecah masalah, diplomat.";
            // <p>Kekuatan:</p>
            $hasil[1]= [
                "Praktis.",
                "Menyesuaikan diri dengan cepat dalam lingkungan baru.",
                "Mampu memperhitungkan situasi.",
                "Pergerakan ekonomis.",
            ];
            // <p>Kelemahan:</p>
            $hasil[2] = [
                "Kurang sabar dalam teori dan abstraks.",
                "Masa lalu cepat dilupakan.",
                "Sesuatu yang rutin menjadikannya pasif.",
            ];
            // <p>Hubungan dengan Orang:</p>
            $hasil[3] = [
                "Merespon terhadap ide-ide khusus.",
                "Fleksibel, sabar dengan orang lain.",
                "Mendorong untuk mengambil resiko.",
                "Tidak melawan atasan.",
                "Menerima sebagai pengikut.",
                "Apresiasi verbal.",
            ];
            // <p>Kontribusi dalam kelompok:</p>
            $hasil[4] = [
                "Mendorong kelompok untuk bertindak.",
                "Baik dalam perencanaan verbal dan pengambilan keputusan.",
                "Tidak menikmati penugasan tertulis.",
                "Dapat mengetahui permasalahan secara dini dalam tim.",
            ];
        };
        if (($penilaian=="NT")){
            $hasil[0]="Sebagai pemimpin menunjukkan : Pandangan yang luas.";
            // <p>Kekuatan:</p>
            $hasil[1]= [
                "Arsitektur perubahan.",
                    "Menanyakan segala sesuatu.",
                    "Memahami berbagai sudut pandang organisasi.",
                    "Memfokuskan pada berbagai kemungkinan.",
            ];
                // <p>Kelemahan:</p>
            $hasil[2] = [
                "Mendesain, bukan membangun.",
                "Prinsip, bukan perasaan.",
                "Terlalu berpegang pada intelektualitas.",
                "Mengharapkan lebih banyak dari realitas.",
                "Tidak tenang, kurang terpenuhi.",
                "Kurang sabar.",
            ];
            // <p>Hubungan dengan Orang:</p>
            $hasil[3] = [
                "Melihat pola pikir orang lain.",
                "Responsif terhadap ide baru.",
                "Terpicu untuk memecahkan permasalahan orang lain.",
                "Kokoh pendirian.",
                "Menganggap orang lain mengerti posisi dirinya.",
                "Tidak senang diceramahi.",
                "Kurang kompetitif.",
            ];
        };
        if (($penilaian=="NF")){
            $hasil[0]="Sebagai pemimpin menunjukkan : Penengah.";
            // <p>Kekuatan:</p>
            $hasil[1]= [
                "Kharismatik dan berkomitmen terhadap orang lain.",
                "Peduli dan antusiasme tinggi.",
                "Penuh kemungkinan.",
                "Karakter demokratis.",
                "Menilai budaya.",
                "Memberikan apresiasi kepada orang lain.",
            ];
            // <p>Kelemahan:</p>
            $hasil[2] = [
                "Banyak hal yang diinginkan menjadi kurang produktif.",
                "Keputusan berdasar suka tidak suka.",
                "Menghindari hubungan yang tidak menyenangkan.",
            ];
            // <p>Hubungan dengan Orang lain:</p>
            $hasil[3]=[
                "Mudah menjalin relasi.",
                "Mencari hubungan yang berarti bukan hanya tugas.",
                "Bekerja secara sosial dan produktif.",
            ];
        };  
        
        return $hasil;

    }
}
