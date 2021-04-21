<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/home');
    }

  
    public function formGraphic(Request $request)
    {
        $dateFrom = $request->get("datetimepickerFrom");
        $dateTo = $request->get("datetimepickerTo");
        $numberFundos = $request->get("checkbox");
        
        $query = DB::select("SELECT date, fundo_id, sum(value) FROM patrimonios
        where date between ('".$dateFrom."') and ('".$dateTo."')
        and fundo_id in(1,2,3)
        group by date, fundo_id");

        //$query = json_decode(json_encode($query), true);        
        
        //$query = DB::table('patrimonios')
                //->select('date', 'fundo_id', DB::raw('SUM(value)'))
                //->whereBetween('date', [$dateFrom, $dateTo])
                //->orWhere('fundo_id', '=', 1)
                //->groupBy('date', 'fundo_id')
                //->get();

        //dd($query, $numberFundos, $dateFrom, $dateTo);       

        return view('/home', compact('dateFrom', 'dateTo', 'numberFundos', 'query'));

    }

   
}
