<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;
use App\Models\Measurements;

class MeasurementController extends Controller
{   
    public function index()
{
    $measurements = Measurements::with(['kpi', 'user'])
        ->where('company_id', auth()->user()->company_id)
        ->orderBy('date', 'desc')
        ->get();

    return view('measurements.index', compact('measurements'));
}

    public function create() 
    {
        $companyId = auth()->user()->company_id;

        $kpis = Kpi::where('company_id', $companyId)->get();

        return view('measurements.create', compact('kpis'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'date' => 'required|date',
        'kpi_id' => 'required|exists:kpis,id',
        'value' => 'required|numeric'
    ]);
        $companyId = auth()->user()->company_id;
        $userId = auth()->id();

        
            Measurements::updateOrCreate([
            'company_id' => $companyId,
            'user_id' => $userId,
            'kpi_id' => $request->kpi_id,
            'date' => $request->date,
        ], [
            'value' => $request->value,
        ]);
        
      
        return redirect()->back()->with('success','Measurements was recorded!');
    }
    
    public function fetchMeasurements(Request $request)
    {
    $request->validate([
        'kpi_ids' => 'required|array',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $companyId = auth()->user()->company_id;

    $measurements = Measurements::with('kpi:id,name,unit')
        ->where('company_id', $companyId)
        ->whereIn('kpi_id', $request->kpi_ids)
        ->whereBetween('date', [$request->start_date, $request->end_date])
        ->orderBy('date')
        ->get(['kpi_id', 'date', 'value']);

    return response()->json(
        $measurements->map(function($m){
            return[
                'kpi_id'=> $m->kpi_id,
                'kpi_name'=> $m->kpi->name ?? 'UnknownKPI',
                'kpi_unit'=> $m->kpi->unit ?? 'UnknownUnit',
                'date'=> $m->date,
                'value'=>$m->value,
            ];
        })

    );
    }


    

}

