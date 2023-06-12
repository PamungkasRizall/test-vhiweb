<?php

namespace App\Http\Controllers;

use app\Libraries\Core;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $core ;

    public function __construct(){
        
        $this->core = new Core();

    }

    public function missingMethod(){

        return $this->core->setResponse();
    }
}
