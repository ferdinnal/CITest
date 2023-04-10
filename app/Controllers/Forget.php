<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Forget extends BaseController
{
    public function index()
    {
        return view('forget');
    }

    public function ForgotPassword()
   {
    $model = new UserModel();
         $email = $this->request->getVar('email');      
         $findemail = $model->ForgotPassword($email);  
         if($findemail){
          $model->sendpassword($findemail);
          return redirect()->to('/login');        
           }else{
            return redirect()->back()->withInput()->with('error', 'Email Not Found');
      }
   }
}
