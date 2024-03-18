<?php

// use Auth;
use App\Models\HRD;
use App\Models\TesSettings;
use App\Models\Company;


if(!function_exists('convertOption')){
    function convertOption($i, $value){
        if($i == 2 || $i == 4 || $i == 8 || $i == 3){
            if($value=='1'){ return "A";
            }elseif($value=='2'){ return "B";
            }elseif($value=='4'){ return "C";
            }elseif($value=='8'){ return "D";
            }elseif($value=='16'){ return "E";
            }elseif($value=='32'){ return "F";
            }elseif($value=='3'){ return "A B";
            }elseif($value=='5'){ return "A C";            
            }elseif($value=='9'){ return "A D";            
            }elseif($value=='17'){ return "A E";             
            }elseif($value=='33'){ return "A F";         
            }elseif($value=='6'){ return "B C";           
            }elseif($value=='10'){ return "B D";               
            }elseif($value=='18'){ return "B E";             
            }elseif($value=='34'){ return "B F";               
            }elseif($value=='12'){ return "C D";              
            }elseif($value=='20'){ return "C E";              
            }elseif($value=='36'){ return "C F";                
            }elseif($value=='24'){ return "D E";              
            }elseif($value=='40'){ return "D F";               
            }elseif($value=='48'){ return "E F";
            }elseif($value=='7'){ return "A B C";
            }elseif($value=='11'){ return "A B D";
            }elseif($value=='19'){ return "A B E";
            }elseif($value=='35'){ return "A B F";
            }elseif($value=='13'){ return "A C D";
            }elseif($value=='21'){ return "A C E";
            }elseif($value=='37'){ return "A C F";
            }elseif($value=='14'){ return "B C D";
            }elseif($value=='22'){ return "B C E";
            }elseif($value=='38'){ return "B C F";
            }elseif($value=='26'){ return "B D E";
            }elseif($value=='42'){ return "B D F";
            }elseif($value=='28'){ return "C D E";
            }elseif($value=='46'){ return "C D F";
            }elseif($value=='52'){ return "C E F";
            }elseif($value=='56'){ return "D E F";
            }elseif($value=='15'){ return "A B C D";
            }elseif($value=='23'){ return "A B C E";
            }elseif($value=='39'){ return "A B C F";
            }elseif($value=='30'){ return "B C D E";
            }elseif($value=='46'){ return "B C D F";
            }elseif($value=='60'){ return "C D E F";
            }elseif($value=='31'){ return "A B C D E";
            }elseif($value=='47'){ return "A B C D F";
            }elseif($value=='62'){ return "B C D E F";
            }elseif($value=='63'){ return "A B C D E F";
            }
        }
    }
}


if(!function_exists('convertEPPS')){
    function convertEPPS($ceks)
    {
        $achtt="Subjek melakukan tindakan terbaik untuk dapat menyelesaikan tiap tugas yang diberikan dengan menggunakan usaha pikiran dan kemampuannya, agar dapat dipandang dapat menyelesaikan pekerjaan sulit oleh atasan. Ia tertarik untuk menyelesaikan tugas menantang dan permasalahan rumit lebih baik dari orang lain.";
        $deftt="Subjek mudah terpengaruh dengan keadaan orang lain, memiliki ketertarikan tinggi mengenai kesuksesan orang lain. Ia mudah diberi instruksi dan dapat mengikuti atau memberikan apa yang diinginkan orang lain. Ia senang menunjukkan pekerjaan yang telah diselesaikan, dapat dengan mudah mengikuti petunjuk atasan. Ia cenderung mengandalkan orang lain dalam mengambil keputusan dan tindakan konformitasnya tinggi. Ia berperilaku sesuai norma yang ada dalam lingkungannya dengan menghindari cara-cara atau tindakan yang tidak wajar.";
        $ordtt="Subjek bekerja dengan sifat keteraturan yang tinggi dan terorganisir secara rapi. Demikian pula dalam melakukan perencanaan sebelum memulai aktivitas dilakukan secara rapi dan detail. Ia bertindak sesuai keteraturan dan prosedur, detail dalam bekerja dan berusaha segala sesuatu sesuai kebiasaan dan terstruktur berdasarkan petunjuk yang ada. Ia sangat teratur bukan hanya bekerja namun pada perilaku-perilaku umum lainnya sehingga tampak dirinya beraktivitas monoton dengan ketidaktertarikan pada perubahan. Ia kurang dapat bertindak fleksibel.";
        $exhtt="Subjek senang memamerkan diri di lingkungan sosial. Ia senang menjadi perhatian orang lain, terbuka dan mudah bergaul, senang bercerita mengenai pengalaman atau cerita-cerita yang menarik dirinya. Ia bangga dengan dirinya sendiri, berusaha menunjukkan kepintarannya kepada orang lain. Ia senang apabila orang lain tidak dapat menjawab pertanyaan yang diajukannya dan seringkali menggunakan istilah-istilah asing yang kurang dimengerti oleh orang lain agar tampak pintar.";
        $auttt="Subjek mudah bertindak atau bersikap sesuai keinginannya tanpa banyak hambatan. Ia tidak tergantung dengan orang lain dan mudah mengambil keputusan. Ia kurang mempertimbangkan lingkungan atau orang lain dalam melakukan sesuatu, mudah bersikap atau beraktivitas terhadap hal-hal yang tidak lazim bagi orang lain dan cenderung menghindari situasi-situasi yang menuntut dirinya menyesuaikan dengan lingkungannya. Ia mudah mengkritisi atasan atau otoritas yang ada dan cenderung menghindar dari rutinitas dan tanggung jawab.";
        $afftt="Subjek loyal terhadap orang lain dan dapat berpartisipasi dengan baik dalam kelompok. Ia mudah melakukan aktivitas untuk orang lain, berinteraksi dengan orang baru dan mencari komunitas baru. Ia terbuka dengan lingkungan sosial, mampu mengungkapkan perasaan sesungguhnya dan lebih senang beraktivitas bersama daripada sendiri. Hubungan sosial yang dijalin erat.";
        $inttt="Subjek senang berintrospeksi dengan diri dan perasaannya. Ia senang mengamati tindakan orang lain, mencermati terhadap perilaku-perilaku yang dilakukan dan berusaha mengerti bagaimana perasaan orang lain apabila menghadapi suatu masalah. Ia seringkali menilai orang lain terhadap alasan-alasan atau dasar dari motivasi tindakan daripada apa yang mereka kerjakan. Ia senang menganalisa motivasi atau tindakan orang lain dan tertarik dengan prediksi terhadap bagaimana orang lain akan bertindak.";
        $suctt="Subjek cenderung menggantungkan dirinya kepada orang lain. Ia berusaha mencari dorongan diri dari pihak lain dan meminta bantuan apabila berhadapan dengan masalah. Ia sangat terbuka dengan masalahnya, mencari simpati dan berusaha mendapatkan pemahaman dari orang lain tentang masalahnya. Ia berusaha mendapatkan afeksi dan keramahan dari orang lain, senang dengan simpati atau perhatian yang diterimanya.";
        $domtt="Subjek mampu memberikan argumentasi pandangannya kepada orang lain dengan mudah. Ia ingin dianggap atau dipandang sebagai pemimpin atau ketua dalam kelompok. Ia mampu dengan mudah membuat keputusan berkaitan dengan permasalahan kelompok, mampu mempengaruhi keinginan dirinya kepada orang lain dan dapat melerai konflik dengan mudah. Ia senang memberikan petunjuk dan cara-cara melakukan pekerjaan.";
        $abatt="Subjek mudah merasa bersalah terhadap hal-hal yang dianggapnya tidak sesuai dan mudah menerima kesalahan dari orang lain. Ia menggangap sakit hati atau kesengsaraan diri lebih baik daripada kekerasan yang mungkin timbul. Ia merasa terlalu bersalah sehingga layak untuk dihukum. Ia kurang mampu berargumentasi atau mempertahankan pendapat. Pada situasi konflik ia cenderung diam dan cenderung menerima terhadap tuntutan yang ada. Ia menghindari konfrontasi dan akan merasa tertekan apabila tidak dapat menangani permasalahan. Ia merasa cemas terhadap tekanan yang ada. Ia merasa inferior dalam lingkungan sosial, apatis dalam pergaulan formal maupun non formal.";
        $nurtt="Subjek terbuka dan memiliki perhatian dengan orang lain. Ia senang membantu terhadap orang-orang yang mengalami permasalahan, cepat dalam memberikan bantuan tanpa adanya keinginan mendapatkan balasan. Ia santun dan memiliki simpati kepada orang lain, mudah memaafkan dan peka dalam memberikan perhatian, afeksi atau hubungan interpersonal yang dibutuhkan mereka. Hubungan sosial dapat dilakukan dengan mudah. Ia terbuka, mudah bergaul dan ramah kepada orang lain. Perilaku sosialnyalus.";
        $chgtt="Subjek tertarik dengan situasi-situasi baru, lingkungan maupun orang-orang baru. Rutinitas keseharian dilakukannya dengan cara melakukan sesuatu yang baru atau bereksperimen. Ia kurang betah terhadap rutinitas yang ada dan sulit untuk bertahan pada situasi yang monoton. Ia berusaha melakukan pekerjaan-pekerjaan dengan cara baru, berpindah tempat dengan situasi baru yang dianggapnya menantang. Pada rutinitas keseharian terlihat dengan seringkali mencari tempat makan baru atau mengikuti trend-trend sesuai dengan ketertarikan dirinya.";
        $endtt="Subjek memiliki tanggung jawab tinggi terhadap pekerjaan, senang menyelesaikan tugas sampai selesai dan bekerja keras terhadap tugas atau permasalahan yang dihadapi. Ia berusaha mendapatkan solusi terhadap permasalahan yang ada dan seringkali bekerja dengan waktu lebih untuk dapat menyelesaikan tugas. Ia tekun terhadap pekerjaan, tidak mudah jenuh terhadap pekerjaan dan mampu bertahan terhadap permasalahan rumit yang bagi orang lain dianggap terlalu menjenuhkan. Ia cenderung tidak senang apabila proses pekerjaannya diggu.";
        $hettt="Subjek tertarik bergaul dengan lawan jenis. Dalam beraktivitas sosial, ia memilih lawan jenis untuk mendapatkan perhatian dan afeksi dari mereka. Ia memiliki ketertarikan fisik yang tinggi dengan lawan jenis, memiliki dorongan seksual yang tinggi dengan menyenangi atribut-atribut seksualitas seperti buku, film dan topik-topik lainnya yang menunjukkan kenikmatan seksual.";
        $aggtt="Subjek memiliki dorongan agresi yang tinggi dan mudah terhadap konflik. Ia mudah berselisih paham atau memberi kritik terbuka dan seringkali mendapatkan kesenangan terhadap konfrontasi yang ada. Ia mudah marah terhadap situasi yang menjadikan dirinya tidak nyaman. Ia mudah menyalahkan orang lain dan memiliki ketertarikan kontak fisik yang tinggi dalam menyelesaikan permasalahan.";
        $tt1="Subjek mudah terpengaruh dengan lingkungan atau keadaan dari orang lain, suka memamerkan keberhasilan pekerjaan dan dalam mengambil keputusan banyak menggantungkan kepada orang lain. Di sisi lain ia memiliki sikap ingin bebas dalam beraktivitas sesuai keinginan dirinya. Ia kurang bertanggung jawab terhadap akibat dari aktivitas yang dihasilkan dan tidak penurut. Tampak diriya mengalami konflik kepribadian. ";
        $tt2="Subjek mudah bersosialisasi dengan lingkungan dan berinteraksi terbuka dengan orang lain. Otonomi yang tinggi menjadikan dirinya +berperilaku seenaknya sendiri tanpa memperhatikan norma atau aturan sosial yang berlaku. Hubungan yang terjalin tidak mendalam dan mudah berkonflik dengan orang lain. ";
        $tt3="Subjek memiliki ketertarikan bersosialisasi namun peran yang dilakukannya pasif. Ia banyak berperan sebagai pengamat dan mencermati tingkah laku orang lain. Ia tergantung terhadap situasi sosial akan tetapi keterlibatan dalam kelompok tidak mendalam. ";
        $tt4="Subjek memiliki konflik kepribadian. Di satu sisi ia sangat tergantung dengan orang lain untuk mencari dorongan terhadap pemecahan masalah yang dihadapi, namun di sisi lain ia memiliki penghindaran atau pertentangan terhadap norma atau aturan sosial yang ada. Ia kurang dapat bersikap terbuka dengan perasaannya, ia memiliki dorongan afeksi dan perhatian yang tinggi namun ia kurang mampu bersikap wajar dalam mengekspresikan perasaannya. ";
        $tt5="Subjek memiliki konflik kepribadian. Ia memiliki keteraturan tinggi terhadap perencanaan dan aktivitas rutin akan tetapi ia juga cepat merasa bosan dengan situasi yang monoton. ";
        $tt6="Subjek mudah merasa bersalah terhadap permasalahan yang muncul. Ia mudah menerima kesalahan dari orang lain untuk menghindari konfrontasi. Ia juga dengan mudah memberikan argumentasi terhadap pandangan yang dianggapnya benar. Dorongan untuk menguasai atau mempengaruhi orang lain tidak diperankan dengan memadai sehingga ia mudah menyerah terhadap konflik yang ada. Tampak ia memiliki konflik terhadap konsep dirinya. ";
        $tt7="Subjek memiliki dorongan yang kuat untuk menyelesaikan suatu pekerjaan. Ia tekun dan tidak mudah jenuh terhadap permasalahan rumit yang dihadapi. Aktivitas penyelesaian tugas tidak disertai dengan dorongan untuk melakukan kinerja dengan lebih baik. Tampak dirinya sebagai penyelesai tugas namun tidak memiliki motivasi yang memadai untuk mencari tugas-tugas yang menantang. ";
        $tt8="Subjek memiliki dorongan sosial tinggi, memiliki kepekaan dan simpati terhadap orang lain. Ia dengan mudah memberikan keinginan atau harapan kepada orang lain namun ia juga mudah konflik. Ia senang terhadap situasi konflik dan mudah menyalahkan orang lain. Tampak peran sosial yang dilakukannya manipulatif untuk kepentingan dirinya sendiri. ";
    
        $explanation = array();
        if($ceks['achw'] > 75){ $explanation['Ach'] = $achtt;}
        if($ceks['defw'] > 75){ $explanation['Def'] = $deftt;}
        if($ceks['ordw'] > 75){ $explanation['Ord'] = $ordtt;}
        if($ceks['exhw'] > 75){ $explanation['Exh'] = $exhtt;}
        if($ceks['autw'] > 75){ $explanation['Aut'] = $auttt;}
        if($ceks['affw'] > 75){ $explanation['Aff'] = $afftt;}
        if($ceks['intw'] > 75){ $explanation['Int'] = $inttt;}
        if($ceks['sucw'] > 75){ $explanation['Suc'] = $suctt;}
        if($ceks['domw'] > 75){ $explanation['Dom'] = $domtt;}
        if($ceks['abaw'] > 75){ $explanation['Aba'] = $abatt;}
        if($ceks['nurw'] > 75){ $explanation['Nur'] = $nurtt;}
        if($ceks['chgw'] > 75){ $explanation['Chg'] = $chgtt;}
        if($ceks['endw'] > 75){ $explanation['End'] = $endtt;}
        if($ceks['hetw'] > 75){ $explanation['Het'] = $hettt;}
        if($ceks['aggw'] > 75){ $explanation['Agg'] = $aggtt;}


        if (($ceks['defw']>60)&&($ceks['autw']>60))  $explanation['tt1'] = $tt1;
        if (($ceks['autw']>60)&&($ceks['affw']>60))  $explanation['tt2'] = $tt2;
        if (($ceks['intw']>60)&&($ceks['affw']>60))  $explanation['tt3'] = $tt3;
        if (($ceks['sucw']>60)&&($ceks['autw']>60))  $explanation['tt4'] = $tt4;
        if (($ceks['ordw']>60)&&($ceks['chgw']>60))  $explanation['tt5'] = $tt5;
        if (($ceks['abaw']>60)&&($ceks['domw']>60))  $explanation['tt6'] = $tt6;
        if (($ceks['endw']>60)&&($ceks['achw']<30))  $explanation['tt7'] = $tt7;
        if (($ceks['nurw']>60)&&($ceks['aggw']>60))  $explanation['tt8'] = $tt8;
        return $explanation;
    }
}

// Subdomain Tes Psikologanda
if(!function_exists('subdomain_tes')){
    function subdomain_tes(){
        return "https://tes.psikologanda.com/";
    }
}

// STIFIn access
if(!function_exists('stifin_access')) {
    function stifin_access() {
        if(Auth::user()->role->is_global === 1)
            return true;
        elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            if($company){
                if($company->stifin == 1) return true;
                else return false;
            }
            else return false;
        }
    }
}

// Tes settings
if(!function_exists('tes_settings')){
    function tes_settings($id_paket, $key){
        if(Auth::user()->role == role_hrd()){
            $hrd = HRD::where('id_user','=',Auth::user()->id_user)->first();
            if($hrd){
                $value = TesSettings::where('id_hrd','=',$hrd->id_hrd)->where('id_paket','=',$id_paket)->pluck($key)->toArray();
                return array_key_exists(0, $value) ? $value[0] : '';
            }
            else return '';
        }
    }
}

// Get HRD tes
if(!function_exists('get_hrd_tes')){
    function get_hrd_tes(){
		$data = DB::table('hrd')->where('id_user','=',Auth::user()->id_user)->first();
        if(!$data) return [];
        else{
            if($data->akses_tes != ''){
                $akses_tes = explode(',', $data->akses_tes);
                $array = [];
                foreach($akses_tes as $id){
                    $tes = DB::table('tes')->where('id_tes','=',$id)->first();
                    if($tes) array_push($array, $tes->path);
                }
                return $array;
            }
            else return [];
        }
    }
}

// Role admin
if(!function_exists('role_admin')){
    function role_admin(){
        return 1;
    }
}

// Role HRD
if(!function_exists('role_hrd')){
    function role_hrd(){
        return 2;
    }
}

// Role karyawan
if(!function_exists('role_karyawan')){
    function role_karyawan(){
        return 3;
    }
}

// Role pelamar
if(!function_exists('role_pelamar')){
    function role_pelamar(){
        return 4;
    }
}

// Role umum
if(!function_exists('role_umum')){
    function role_umum(){
        return 5;
    }
}

// Role magang
if(!function_exists('role_magang')){
    function role_magang(){
        return 6;
    }
}

// Mencari index array multidimensional
if(!function_exists('searchIndex')){
    function searchIndex($array, $key, $value){
        for($i = 0; $i < count($array); $i++){
            if($array[$i][$key] == $value){
                return $i;
            }
        }
    }
}

// Get HRD
if(!function_exists('get_hrd')){
    function get_hrd(){
		$data = DB::table('hrd')->get();
		return $data;
    }
}

// Get Data Tes
if(!function_exists('get_data_tes')){
    function get_data_tes(){
        $data = DB::table('tes')->orderBy('nama_tes','asc')->get();
        return $data;
    }
}

// Get Data Update
if(!function_exists('get_data_update')){
    function get_data_update(){
        $data = DB::table('update_sistem')->orderBy('update_at','desc')->get();
        return $data;
    }
}

// Get User HRD
if(!function_exists('get_user_hrd')) {
    function get_user_hrd() {
        if(Auth::user()->role->is_global === 0) {
            $data = DB::table('hrd')->where('id_user','=',Auth::user()->id)->first();
            return $data->id_hrd;
        }
        return null;
    }
}

// Get nama role
if(!function_exists('get_role_name')){
    function get_role_name($id){
		$data = DB::table('role')->where('id_role','=',$id)->first();
		return $data ? $data->nama_role : '-';
    }
}

// Get nama posisi
if(!function_exists('get_posisi_name')){
    function get_posisi_name($id){
		$data = DB::table('posisi')->where('id_posisi','=',$id)->first();
		return $data ? $data->nama_posisi : '-';
    }
}

// Get nama kantor
if(!function_exists('get_kantor_name')){
    function get_kantor_name($id){
		$data = DB::table('kantor')->where('id_kantor','=',$id)->first();
		return $data ? $data->nama_kantor : '-';
    }
}

// Get nama perusahaan
if(!function_exists('get_perusahaan_name')){
    function get_perusahaan_name($id){
		$data = DB::table('hrd')->where('id_hrd','=',$id)->first();
		return $data ? $data->perusahaan : '-';
    }
}

// Get nama HRD
if(!function_exists('get_hrd_name')){
    function get_hrd_name($id){
        $data = DB::table('hrd')->where('id_hrd','=',$id)->first();
        return $data ? $data->nama_lengkap : '-';
    }
}

// Get id posisi
if(!function_exists('get_posisi_id')){
    function get_posisi_id($hrd, $name){
        $data = DB::table('posisi')->where('id_hrd','=',$hrd)->where('nama_posisi','=',$name)->first();
        return $data ? $data->id_posisi : 0;
    }
}

// Get id kantor
if(!function_exists('get_kantor_id')){
    function get_kantor_id($hrd, $name){
        $data = DB::table('kantor')->where('id_hrd','=',$hrd)->where('nama_kantor','=',$name)->first();
        return $data ? $data->id_kantor : 0;
    }
}

// Get perusahaan tes
if(!function_exists('get_perusahaan_tes')){
    function get_perusahaan_tes($id){
		$data = DB::table('hrd')->where('id_hrd','=',$id)->first();
        if(!$data) return null;
        else{
            if($data->akses_tes != ''){
                $akses_tes = explode(',', $data->akses_tes);
                $array = [];
                foreach($akses_tes as $id){
                    $tes = DB::table('tes')->where('id_tes','=',$id)->first();
                    array_push($array, $tes);
                }
                return $array;
            }
            else return null;
        }
    }
}

// Menghitung jumlah data duplikat
if(!function_exists('count_existing_data')){
    function count_existing_data($table, $field, $keyword, $primaryKey, $id = null){
        if($id == null) $data = DB::table($table)->where($field,'=',$keyword)->get();
        else $data = DB::table($table)->where($field,'=',$keyword)->where($primaryKey,'!=',$id)->get();
        return count($data);
    }
}

// Menghitung jumlah kantor berdasarkan perusahaan
if(!function_exists('count_kantor_by_perusahaan')){
    function count_kantor_by_perusahaan($id){
        $data = DB::table('kantor')->where('id_hrd','=',$id)->count();
        return $data;
    }
}

// Menghitung jumlah jabatan berdasarkan perusahaan
if(!function_exists('count_jabatan_by_perusahaan')){
    function count_jabatan_by_perusahaan($id){
        $data = DB::table('posisi')->where('id_hrd','=',$id)->count();
        return $data;
    }
}

// Menghitung jumlah karyawan berdasarkan perusahaan
if(!function_exists('count_karyawan_by_perusahaan')){
    function count_karyawan_by_perusahaan($id){
        $data = DB::table('karyawan')->join('users','karyawan.id_user','=','users.id_user')->where('id_hrd','=',$id)->where('status','=',1)->count();
        return $data;
    }
}

// Menghitung jumlah karyawan berdasarkan kantor
if(!function_exists('count_karyawan_by_kantor')){
    function count_karyawan_by_kantor($id){
        $data = DB::table('karyawan')->join('users','karyawan.id_user','=','users.id')->where('kantor','=',$id)->where('status','=',1)->count();
        return $data;
    }
}

// Menghitung jumlah karyawan berdasarkan jabatan
if(!function_exists('count_karyawan_by_jabatan')){
    function count_karyawan_by_jabatan($id){
		$data = DB::table('karyawan')->join('users','karyawan.id_user','=','users.id')->where('posisi','=',$id)->where('status','=',1)->count();
		return $data;
    }
}

// Menghitung jumlah pelamar berdasarkan perusahaan
if(!function_exists('count_pelamar_by_perusahaan')){
    function count_pelamar_by_perusahaan($id){
        $data = DB::table('pelamar')->where('id_hrd','=',$id)->count();
        return $data;
    }
}

// Menghitung jumlah pelamar belum diseleksi berdasarkan lowongan
if(!function_exists('count_pelamar_belum_diseleksi_by_lowongan')) {
    function count_pelamar_belum_diseleksi_by_lowongan($id){
        if(Auth::user()->role->is_global === 1)
            $pelamar = DB::table('pelamar')->join('users','pelamar.id_user','=','users.id')->join('lowongan','pelamar.posisi','=','lowongan.id_lowongan')->join('posisi','lowongan.posisi','=','posisi.id_posisi')->where('id_lowongan','=',$id)->get();
        elseif(Auth::user()->role->is_global === 0)
            $pelamar = DB::table('pelamar')->join('users','pelamar.id_user','=','users.id')->join('lowongan','pelamar.posisi','=','lowongan.id_lowongan')->join('posisi','lowongan.posisi','=','posisi.id_posisi')->where('pelamar.id_hrd','=',get_user_hrd())->where('id_lowongan','=',$id)->get();

        $count = 0;
        if(count($pelamar)>0){
            foreach($pelamar as $data){
                $seleksi = DB::table('seleksi')->where('id_pelamar','=',$data->id_pelamar)->where('id_lowongan','=',$id)->first();
                if(!$seleksi) $count++;
            }
        }

        return $count;
    }
}

// Menghitung jumlah pelamar belum dites berdasarkan lowongan
if(!function_exists('count_pelamar_belum_dites_by_lowongan')) {
    function count_pelamar_belum_dites_by_lowongan($id) {
        if(Auth::user()->role->is_global === 1)
            $data = DB::table('seleksi')->join('pelamar','seleksi.id_pelamar','=','pelamar.id_pelamar')->join('users','pelamar.id_user','=','users.id')->join('lowongan','seleksi.id_lowongan','=','lowongan.id_lowongan')->join('posisi','lowongan.posisi','=','posisi.id_posisi')->where('lowongan.id_lowongan','=',$id)->where('seleksi.hasil','=',99)->count();
        elseif(Auth::user()->role->is_global === 0)
            $data = DB::table('seleksi')->join('pelamar','seleksi.id_pelamar','=','pelamar.id_pelamar')->join('users','pelamar.id_user','=','users.id')->join('lowongan','seleksi.id_lowongan','=','lowongan.id_lowongan')->join('posisi','lowongan.posisi','=','posisi.id_posisi')->where('lowongan.id_lowongan','=',$id)->where('seleksi.hasil','=',99)->where('seleksi.id_hrd','=',get_user_hrd())->count();
        return $data;
    }
}

// Menghitung jumlah pelamar belum diseleksi
if(!function_exists('count_pelamar_belum_diseleksi')) {
    function count_pelamar_belum_diseleksi() {
        if(Auth::user()->role->is_global === 1)
            $pelamar = DB::table('pelamar')->join('users','pelamar.id_user','=','users.id')->join('lowongan','pelamar.posisi','=','lowongan.id_lowongan')->join('posisi','lowongan.posisi','=','posisi.id_posisi')->get();
        elseif(Auth::user()->role->is_global === 0)
            $pelamar = DB::table('pelamar')->join('users','pelamar.id_user','=','users.id')->join('lowongan','pelamar.posisi','=','lowongan.id_lowongan')->join('posisi','lowongan.posisi','=','posisi.id_posisi')->where('pelamar.id_hrd','=',get_user_hrd())->get();

        $count = 0;
        if(count($pelamar)>0) {
            foreach($pelamar as $data){
                $seleksi = DB::table('seleksi')->where('id_pelamar','=',$data->id_pelamar)->first();
                if(!$seleksi) $count++;
            }
        }

        return $count;
    }
}

// Menghitung jumlah pelamar belum dites
if(!function_exists('count_pelamar_belum_dites')){
    function count_pelamar_belum_dites(){
        if(Auth::user()->role == role_admin())
            $data = DB::table('seleksi')->join('pelamar','seleksi.id_pelamar','=','pelamar.id_pelamar')->join('users','pelamar.id_user','=','users.id_user')->join('lowongan','seleksi.id_lowongan','=','lowongan.id_lowongan')->join('posisi','lowongan.posisi','=','posisi.id_posisi')->where('seleksi.hasil','=',99)->count();
        elseif(Auth::user()->role == role_hrd())
            $data = DB::table('seleksi')->join('pelamar','seleksi.id_pelamar','=','pelamar.id_pelamar')->join('users','pelamar.id_user','=','users.id_user')->join('lowongan','seleksi.id_lowongan','=','lowongan.id_lowongan')->join('posisi','lowongan.posisi','=','posisi.id_posisi')->where('seleksi.hasil','=',99)->where('seleksi.id_hrd','=',get_user_hrd())->count();
        return $data;
    }
}

// Pesan validasi form
if(!function_exists('validationMessages')){
    function validationMessages(){
        // Pesan Error
        $messages = [
            'required' => 'wajib diisi.',
            'numeric' => 'wajib dengan nomor atau angka.',
            'unique' => 'sudah ada.',
            'min' => 'harus diisi minimal :min karakter.',
            'max' => 'harus diisi maksimal :max karakter.',
            'alpha' => 'hanya bisa diisi dengan huruf.',
        ];
        
        return $messages;
    }
}

// Set tanggal lengkap
if(!function_exists('setFullDate')){
    function setFullDate($date){
        $explode1 = explode(" ", $date);
        $explode2 = explode("-", $explode1[0]);
        $month = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        return $explode2[2]." ".$month[$explode2[1]-1]." ".$explode2[0];
    }
}
	
// Menghapus array yang bervalue kosong
if(!function_exists('removeEmptyArray')){
    function removeEmptyArray($array, $key = null){
        if($key == null){
            $array_count_values = array_count_values($array);
            if($array_count_values[""] == count($array)){
                unset($array);
            }
        }
        else{
            $array_count_values = array_count_values($array[$key]);
            if($array_count_values[""] == count($array[$key])){
                unset($array[$key]);
            }
        }
    }
}

// Mengganti nama permalink jika ada yang sama
if(!function_exists('rename_permalink')){
    function rename_permalink($permalink, $count){
        return $permalink."-".($count+1);
    }
}

// Generate string ke url
if(!function_exists('generate_url')){
    function generate_url($string){
        $url = trim($string);
        $url = strtolower($url);
        $url = str_replace(" ", "-", $url);
        return $url;
    }
}

// Generate permalink
if(!function_exists('generate_permalink')){
    function generate_permalink($string){
        $result = strtolower($string);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = preg_replace("/\s+/", " ",$result);
        $result = str_replace(" ", "-", $result);
        return $result;
    }
}

// Hitung umur / usia
if(!function_exists('generate_age')){
    function generate_age($dateFrom, $dateTo = 'today'){
        $from = new DateTime($dateFrom);
        $to = new DateTime($dateTo);
        $y = $to->diff($from)->y;
        
        return $y;
    }
}

// Diff date
if(!function_exists('diff_date')){
    function diff_date($dateFrom, $dateTo){
        $from = new DateTime($dateFrom);
        $to = new DateTime($dateTo);
        $y = $to->diff($from)->y;
        
        return $y;
    }
}

// Generate tanggal
if(!function_exists('generate_date')){
    function generate_date($date){
        $explode1 = explode(" ", $date);
        $explode2 = explode("-", $explode1[0]);
        $month = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        return $explode2[2]." ".$month[$explode2[1]-1]." ".$explode2[0];
    }
}

// Generate format tanggal
if(!function_exists('generate_date_format')){
    function generate_date_format($date, $format){
        if($format == 'd/m/y'){
            $explode = explode("-", $date);
            return count($explode) == 3 ? $explode[2].'/'.$explode[1].'/'.$explode[0] : '';
        }
        elseif($format == 'y-m-d'){
            $explode = explode("/", $date);
            return count($explode) == 3 ? $explode[2].'-'.$explode[1].'-'.$explode[0] : '';
        }
        else
            return '';
    }
}

// Generate username
if(!function_exists('generate_username')){
    function generate_username($username = null, $prefix){
        if($username != null){
            if(substr($username,3,5) === "00000"){
                $affix = (int)substr($username,8);
            }
            elseif(substr($username,3,4) === "0000"){
                $affix = (int)substr($username,7);
            }
            elseif(substr($username,3,3) === "000"){
                $affix = (int)substr($username,6);
            }
            elseif(substr($username,3,2) === "00"){
                $affix = (int)substr($username,5);
            }
            elseif(substr($username,3,1) === "0"){
                $affix = (int)substr($username,4);
            }
            else{
                $affix = (int)substr($username,3);
            }
    
            // Max 999.999
            if($affix + 1 >= 0 && $affix + 1 < 10)
                $username = $prefix."00000".($affix + 1);
            elseif($affix + 1 >= 10 && $affix + 1 < 100)
                $username = $prefix."0000".($affix + 1);
            elseif($affix + 1 >= 100 && $affix + 1 < 1000)
                $username = $prefix."000".($affix + 1);
            elseif($affix + 1 >= 1000 && $affix + 1 < 10000)
                $username = $prefix."00".($affix + 1);
            elseif($affix + 1 >= 10000 && $affix + 1 < 100000)
                $username = $prefix."0".($affix + 1);
            elseif($affix + 1 >= 100000 && $affix + 1 < 1000000)
                $username = $prefix.($affix + 1);
        }
        else{
            $username = $prefix."000001";
        }
        return $username;
    }
}

// Generate string that be able to read by url...
if(!function_exists('generate_path_url')){
	function generate_path_url($string){
		// Convert string to lowercase...
		$result = strtolower($string);
		// Only accept letters, numbers, and whitespaces...
		$result = preg_replace("/[^a-z0-9\s]/", "", $result);
		// Remove double whitespaces and make it into one whitespace only...
		$result = preg_replace("/\s+/", " ",$result);
		// Replace whitespaces to "-" characters...
		$result = str_replace(" ", "-", $result);
		// Return the result...
		return $result;
	}
}

// Acak huruf
if(!function_exists('shuffleString')){
    function shuffleString($length){
        $string = '1234567890QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm';
        $shuffle = substr(str_shuffle($string), 0, $length);
        return $shuffle;
    }
}

// Mengganti key pada json pelamar
if(!function_exists('replaceJsonKey')){
    function replaceJsonKey($string){
        $string = str_replace('_', ' ', $string);
        $string = str_replace('hp', 'HP', $string);
        $string = ucwords($string);
        return $string;
    }
}

if(!function_exists('time_elapsed_string')){
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                // $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'Baru saja';
    }
}

/* DISC 40 SOAL */
/* ======================================================================= */

// Scoring DISC MOST
if(!function_exists('discScoringM')){
    function discScoringM($number){
        $score = round(50 * pow(2, log($number / 10, 4)));
        return $score;
    }
}

// Scoring DISC LEAST
if(!function_exists('discScoringL')){
    function discScoringL($number){
        $score = 100 - round(50 * pow(2, log($number / 10, 4)));
        return $score;
    }
}

// Meranking score
if(!function_exists('sortScore')){
    function sortScore($array){
        $ordered_array = $array;
        arsort($ordered_array);
        $i = 1;
        $last_value = '';
        foreach($ordered_array as $ordered_key=>$ordered_value){
            $ordered_array[$ordered_key] = array();
            $ordered_array[$ordered_key]['rank'] = $ordered_value == $last_value ? ($i-1) : $i;
            $ordered_array[$ordered_key]['score'] = $ordered_value;
            $last_value = $ordered_value;
            $i++;
        }
        return $ordered_array;
    }
}

// Membuat kode
if(!function_exists('setCode')){
    function setCode($array){
        $new_array = array();
        $i = 1;
        while($i<=4){
            foreach($array as $key=>$value){
                if($array[$key]['rank'] == $i){
                    if($array[$key]['score'] < 50){
                        $new_value = "L".$key;
                        array_push($new_array, $new_value);
                    }
                    else{
                        $new_value = "H".$key;
                        array_push($new_array, $new_value);
                    }
                }
            }
            $i++;
        }
        return $new_array;
    }
}

/* DISC 24 SOAL */
/* ======================================================================= */

if(!function_exists('analisis_disc_24')){
	function analisis_disc_24($x, $d, $i, $s, $c){
        if($x == 1) return ($d <= 0 && $i <= 0 && $s <= 0 && $c > 0) ? 1 : 0;
        elseif($x == 2) return ($d > 0 && $i <= 0 && $s <= 0 && $c <= 0) ? 1 : 0;
        elseif($x == 3) return ($d > 0 && $i <= 0 && $s <= 0 && $c > 0 && $c >= $d) ? 1 : 0;
        elseif($x == 4) return ($d > 0 && $i > 0 && $s <= 0 && $c <= 0 && $i >= $d) ? 1 : 0;
        elseif($x == 5) return ($d > 0 && $i > 0 && $s < $c && $i && $d && $c > 0 && $i >= $d && $d >= $c) ? 1 : 0;
        elseif($x == 6) return ($d > 0 && $i > 0 && $s > 0 && $c < $i && $d && $s && $i >= $d && $d >= $s) ? 1 : 0;
        elseif($x == 7) return ($d > 0 && $i > 0 && $s > 0 && $c < $i && $d && $s && $i >= $s && $s >= $d) ? 1 : 0;
        elseif($x == 8) return ($d > 0 && $i <= 0 && $s > 0 && $c > 0 && $s >= $d && $d >= $c) ? 1 : 0;
        elseif($x == 9) return ($d > 0 && $i > 0 && $s <= 0 && $c <= 0 && $d >= $i) ? 1 : 0;
        elseif($x == 10) return ($d > 0 && $i > 0 && $s > 0 && $c < $i && $d && $s && $d >= $i && $i >= $s) ? 1 : 0;
        elseif($x == 11) return ($d > 0 && $i <= 0 && $s > 0 && $c <= 0 && $d >= $s) ? 1 : 0;
        elseif($x == 12) return ($d <= 0 && $i > 0 && $s > 0 && $c > 0 && $c >= $i && $i >= $s) ? 1 : 0;
        elseif($x == 13) return ($d <= 0 && $i > 0 && $s > 0 && $c > 0 && $c >= $s && $s >= $i) ? 1 : 0;
        elseif($x == 14) return ($d <= 0 && $i > 0 && $s > 0 && $c > 0 && $i >= $s && $i >= $c) ? 1 : 0;
        elseif($x == 15) return ($d <= 0 && $i <= 0 && $s > 0 && $c <= 0) ? 1 : 0;
        elseif($x == 16) return ($d <= 0 && $i <= 0 && $s > 0 && $c > 0 && $c >= $s) ? 1 : 0;
        elseif($x == 17) return ($d <= 0 && $i <= 0 && $s > 0 && $c > 0 && $s >= $c) ? 1 : 0;
        elseif($x == 18) return ($d > 0 && $i <= 0 && $s <= 0 && $c > 0 && $d >= $c) ? 1 : 0;
        elseif($x == 19) return ($d > 0 && $i > 0 && $c > 0 && $s < $c && $i && $d && $d >= $i && $i >= $c) ? 1 : 0;
        elseif($x == 20) return ($d > 0 && $i > 0 && $s > 0 && $c < $i && $d && $s && $d >= $s && $s >= $i) ? 1 : 0;
        elseif($x == 21) return ($d > 0 && $i <= 0 && $s > 0 && $c > 0 && $d >= $s && $s >= $c) ? 1 : 0;
        elseif($x == 22) return ($d > 0 && $i > 0 && $c > 0 && $s < $c && $i && $d && $d >= $c && $c >= $i) ? 1 : 0;
        elseif($x == 23) return ($d > 0 && $i <= 0 && $s > 0 && $c > 0 && $d >= $c && $c >= $i) ? 1 : 0;
        elseif($x == 24) return ($d <= 0 && $i > 0 && $s <= 0 && $c <= 0) ? 1 : 0;
        elseif($x == 25) return ($d <= 0 && $i > 0 && $s > 0 && $c <= 0 && $i >= $s) ? 1 : 0;
        elseif($x == 26) return ($d <= 0 && $i > 0 && $s <= 0 && $c > 0 && $i >= $c) ? 1 : 0;
        elseif($x == 27) return ($d > 0 && $i > 0 && $c > 0 && $s < $c && $i && $d && $i >= $c && $c >= $d) ? 1 : 0;
        elseif($x == 28) return ($d <= 0 && $i > 0 && $s > 0 && $c < 0 && $i >= $c && $c >= $s) ? 1 : 0;
        elseif($x == 29) return ($d > 0 && $i <= 0 && $s > 0 && $c <= 0 && $s >= $d) ? 1 : 0;
        elseif($x == 30) return ($d <= 0 && $i > 0 && $s > 0 && $c <= 0 && $s >= $i) ? 1 : 0;
        elseif($x == 31) return ($d > 0 && $i > 0 && $s > 0 && $c < $i && $d && $s && $s >= $d && $d >= $i) ? 1 : 0;
        elseif($x == 32) return ($d > 0 && $i > 0 && $s > 0 && $c < $i && $d && $s && $s >= $i && $i >= $d) ? 1 : 0;
        elseif($x == 33) return ($d <= 0 && $i > 0 && $s > 0 && $c > 0 && $s >= $i && $i >= $c) ? 1 : 0;
        elseif($x == 34) return ($d > 0 && $i <= 0 && $s > 0 && $c > 0 && $s >= $c && $c >= $d) ? 1 : 0;
        elseif($x == 35) return ($d <= 0 && $i > 0 && $s > 0 && $c > 0 && $s >= $c && $c >= $i) ? 1 : 0;
        elseif($x == 36) return ($d <= 0 && $i > 0 && $s <= 0 && $c > 0 && $c >= $i) ? 1 : 0;
        elseif($x == 37) return ($d > 0 && $i > 0 && $c > 0 && $s < $c && $i && $d && $c >= $d && $d >= $i) ? 1 : 0;
        elseif($x == 38) return ($d > 0 && $s > 0 && $c > 0 && $i < $c && $s && $d && $c >= $d && $d >= $s) ? 1 : 0;
        elseif($x == 39) return ($d > 0 && $i > 0 && $c > 0 && $s < $c && $i && $d && $c >= $i && $i >= $d) ? 1 : 0;
        elseif($x == 40) return ($d > 0 && $s > 0 && $c > 0 && $i < $c && $s && $d && $c >= $s && $s >= $d) ? 1 : 0;
    }
}

/* PAPIKOSTICK */
/* ======================================================================= */

// Menghapus array yang bervalue kosong
if(!function_exists('analisisPapikostick')){
	function analisisPapikostick($jawaban, $array){
	    // Menghitung jumlah if else
		$count = count($array);

	    	// Jika jumlah if else 2
		if($count == 2){
			if($jawaban <= $array[0]["syarat"]) return $array[0]["deskripsi"];
			else return $array[1]["deskripsi"];
		}
	    	// Jika jumlah if else 3
		elseif($count == 3){
			if($jawaban <= $array[0]["syarat"]) return $array[0]["deskripsi"];
			elseif($jawaban <= $array[1]["syarat"]) return $array[1]["deskripsi"];
			else return $array[2]["deskripsi"];
		}
	    	// Jika jumlah if else 4
		elseif($count == 4){
			if($jawaban <= $array[0]["syarat"]) return $array[0]["deskripsi"];
			elseif($jawaban <= $array[1]["syarat"]) return $array[1]["deskripsi"];
			elseif($jawaban <= $array[2]["syarat"]) return $array[2]["deskripsi"];
			else return $array[3]["deskripsi"];
		}
			//Jika jumlah if else 5
		elseif($count == 5){
			if($jawaban <= $array[0]["syarat"]) return $array[0]["deskripsi"];
			elseif($jawaban <= $array[1]["syarat"]) return $array[1]["deskripsi"];
			elseif($jawaban <= $array[2]["syarat"]) return $array[2]["deskripsi"];
			elseif($jawaban <= $array[3]["syarat"]) return $array[3]["deskripsi"];
			else return $array[4]["deskripsi"];
		}
	}
}