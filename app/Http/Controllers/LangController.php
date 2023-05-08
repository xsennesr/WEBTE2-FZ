<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

    */

    public function index()

    {
        return view('lang.lang');

    }
    public function login() {
        return view('auth.login');
    }
    public function registration() {
        return view('auth.register');
    }


    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

    */

    public function change(Request $request)

    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();

    }
}
