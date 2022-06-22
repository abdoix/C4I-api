<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CatController extends Controller
{
    use GeneralTrait;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.guard:api');

    }



    public function index(){
        $cats = Cat::get();
        if(!$cats){
            return $this->returnError("E404","THIS CAT IS NOT FOUND!!");
        }
        return $this->returnData("cats",$cats);
    }
}
