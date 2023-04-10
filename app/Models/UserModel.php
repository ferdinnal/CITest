<?php

namespace App\Models;

use CodeIgniter\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class UserModel extends Model
{
    protected function initialize()
    {
        $this->allowedFields = ['name', 'email','password'];
    }
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function ForgotPassword($email) {
      $user = $this->where('email', $email)->first();
        return $user;
    }

 public function sendpassword($data) {
        
        $email = $data['email'];
        if ($email) {
        $passwordplain = "";
        $passwordplain  = rand(999999999,9999999999);
        $newpass['password'] = password_hash($passwordplain, PASSWORD_DEFAULT);
        $this->where('email', $email);
        $this->update($data['id'], [
          "password" => $newpass
         ]); 
        $mail_message='Dear '.$data['name'].','. "\r\n";
        $mail_message.='Thanks for contacting regarding to forgot password,<br> Your <b>Password</b> is <b>'.$passwordplain.'</b>'."\r\n";
        $mail_message.='<br>Please Update your password.';
        $mail_message.='<br>Thanks & Regards';
        $mail_message.='<br>Company Name';        
        date_default_timezone_set('Etc/UTC');
        $mail = new PHPMailer(true);
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.googlemail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'testwork754@gmail.com';                     //SMTP username
        $mail->Password   = 'dhzhwwiahkyeeofg';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->setFrom('testwork754@gmail.com', 'Admin');
        $mail->addAddress($email);
        $mail->isHTML(true);  
        $mail->Subject = 'Password from company';
        $mail->Body    = $mail_message;
        $mail->AltBody = $mail_message;

        }
        else
        {  
          return redirect()->to('/login');
        }
  }
   
}
