<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';
use Illuminate\Http\Request;
use DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class VerifikasiPembayaranController extends Controller
{
    public function index(){

        $data = DB::table('bukti')
            ->join('tiket','bukti.kode','=','tiket.kode_pembayaran')
            ->select('bukti.*','tiket.nama')
            ->get();
    	return view('verifikasi-pembayaran',['data' => $data]);
    }

    public function gantiStatus($kode){
        DB::table('bukti')
            ->where('kode',$kode)
            ->update(['verifikasi' => 'sudah']);

        $this->kirimEmail($kode);
        return redirect('verifikasi-pembayaran');
    }

    public function kirimEmail($kode) {
        
        $email = DB::table('tiket')
            ->select('email')
            ->where('kode_pembayaran', '=' ,$kode)
            ->first();

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'daus0827@gmail.com';                     // SMTP username
            $mail->Password   = 'M3galodon@Indonesia0827';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('daus0827@gmail.com');
            $mail->addAddress($email->email);     // Add a recipient
            
           

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = '<div style="color:blue;"> '.$kode.' </div>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }



}