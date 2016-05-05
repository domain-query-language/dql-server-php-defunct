<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DQLParser;

class DQLController extends Controller 
{
    public function command(Request $request, DQLParser\DQLParser $parser)
    {
        $this->validate($request, [
            'statement' => 'required',
        ]);
        
        try {
            $parser->parse($request->get('statement'));
        } catch (DQLParser\ParserError $ex) {
            return Response::create($ex->getMessage(), 400);
        }
        
        return "Success";
    }
}