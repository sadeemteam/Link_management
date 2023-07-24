<?php

use App\Models\SmtpSetting;

function setSmtpConfig() {
   $smtp = SmtpSetting::first();
   // dd(
   //    strlen($smtp->host) > 0, 
   //    strlen($smtp->port) > 0, 
   //    strlen($smtp->username) > 0, 
   //    strlen($smtp->password) > 0, 
   //    strlen($smtp->encryption) > 0, 
   //    strlen($smtp->sender_email) > 0, 
   //    strlen($smtp->sender_name) > 0
   // );

   if (
      strlen($smtp->host) > 0 && 
      strlen($smtp->port) > 0 && 
      strlen($smtp->username) > 0 && 
      strlen($smtp->password) > 0 && 
      strlen($smtp->encryption) > 0 && 
      strlen($smtp->sender_email) > 0 && 
      strlen($smtp->sender_name) > 0
   ) {
      config(['mail.mailers.smtp.host' => $smtp->host]);
      config(['mail.mailers.smtp.port' => $smtp->port]);
      config(['mail.mailers.smtp.username' => $smtp->username]);
      config(['mail.mailers.smtp.password' => $smtp->password]);
      config(['mail.mailers.smtp.encryption' => $smtp->encryption]);
      config(['mail.from.address' => $smtp->sender_email]);
      config(['mail.from.name' => $smtp->sender_name]);

      return true;
   } else {
      return false;
   }
}
