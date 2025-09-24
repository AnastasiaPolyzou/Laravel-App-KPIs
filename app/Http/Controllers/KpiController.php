<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;
use App\Models\Measurements;

class KpiController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $kpis = Kpi::where('company_id', $companyId)->get();
        //return view('kpis.index',compact('kpis'));
        
        
        $measurements = Measurements::where('company_id', $companyId)->get();
        $average = $measurements->avg('value');
        $max = $measurements->max('value');
        $min = $measurements->min('value');

        $totalKpis = $kpis->count();
        $totalMeasurements = $measurements->count();
        $lastUpdate = $measurements->first(); 

        $avgGrowth = $this->calculateGrowth();

        return view('kpis.index', compact(
            'kpis', 'measurements', 'average', 'max', 'min', 
            'totalKpis', 'totalMeasurements', 'lastUpdate', 'avgGrowth'
        ));
    }
       private function calculateGrowth()
       {
          $lastMonth = Measurements::where('created_at', '>', now()->subMonth())
        ->avg('value');

        $previousMonth = Measurements::where('created_at', '<', now()->subMonth())
        ->avg('value');

        if ($previousMonth == 0 || $previousMonth === null) {
        return 0; 
    }

    return (($lastMonth - $previousMonth) / $previousMonth) * 100;
}
        
    

    public function create()
    {
        return view('kpis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
        ]);

        $kpi = new Kpi();
        $kpi->company_id = auth()->user()->company_id;
        $kpi->name = $request->name;
        $kpi->unit = $request->unit;
        $kpi->save();

        return redirect()->route('kpis.index')->with('success', 'KPI created successfully!');

    }

    public function edit(Kpi $kpi)
    {
        if ($kpi->company_id !==auth()->user()->company_id){
            abort(403);
        }
        return view('kpis.edit', compact('kpi'));
    }

    public function update(Request $request, Kpi $kpi)
    {
        if ($kpi->company_id !==auth()->user()->company_id){
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
        ]);
         $kpi->name = $request->name;
        $kpi->unit = $request->unit;
        $kpi->save();
        return redirect()->route('kpis.index')->with('success', 'KPI updated successfully!');

    }

    public function destroy(Kpi $kpi)
    {
        if ($kpi->company_id !==auth()->user()->company_id){
            abort(403);
        }
        $kpi->delete();
        return redirect()->route('kpis.index')->with('success', 'KPI deleted successfully!');
    }

}








