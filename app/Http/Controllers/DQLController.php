<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DQLController extends Controller 
{
    public function command(Request $request)
    {
        $this->validate($request, [
            'statement' => 'required',
        ]);
        return "Response";
    }
}