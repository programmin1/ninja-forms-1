<?php

namespace NinjaForms\Services\Transactional_Email;

class Fake_Mailer
{
  public function send(){
    return true;
  }
}
