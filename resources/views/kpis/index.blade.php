<x-app-layout>
  <div class="w-full px-8 py-10 bg-gray-900 rounded-lg min-h-[600px] flex gap-6 overflow-x-auto">
    
    {{-- Column 1-6: KPIs Table --}}
    <div class="bg-gray-800 rounded-lg p-6" style="flex: 1 1 40%;">
      <h1 class="text-4xl font-bold text-white text-center mb-6 animate-fadeIn">KPIs</h1>

      @if(session('success'))
        <div class="mb-4 p-4 bg-green-700 text-green-100 rounded shadow">
          <strong>✅ Success:</strong> {{ session('success') }}
        </div>
      @endif

      <a href="{{ route('kpis.create') }}"
         class="inline-block mb-6 px-6 py-2 border-2 border-blue-600 text-blue-600 font-semibold rounded hover:bg-blue-600 hover:text-white transition">
        ➕ Create KPI
      </a>

      @include('kpis.partials.kpi-table')
    </div>

    {{-- Column 7-9: Measurements Card --}}
     <div class="bg-gradient-to-b from-blue-800 to-indigo-900 rounded-lg p-8 text-white flex flex-col justify-between" style="flex: 1 1 30%;">
      <div>
        <h2 class="text-2xl font-bold mb-4">Measurements Overview</h2>
        <p class="text-gray-200 mb-8">
          Track the values of your KPIs over time, analyze trends, compare data and export reports.
        </p>

        <div class="flex space-x-5 mb-8">
          <div class="bg-blue-700 rounded-lg p-5 w-1/3 text-center">
            <div class="text-sm text-blue-300">Average Value</div>
            <div class="text-3xl font-bold">{{ number_format($average ?? 0, 1) }}</div>
          </div>
          <div class="bg-blue-700 rounded-lg p-5 w-1/3 text-center">
            <div class="text-sm text-blue-300">Max Value</div>
            <div class="text-3xl font-bold">{{ number_format($max, 1) }}</div>
          </div>
          <div class="bg-blue-700 rounded-lg p-5 w-1/3 text-center">
            <div class="text-sm text-blue-300">Min Value</div>
            <div class="text-3xl font-bold">{{ number_format($min, 1) }}</div>
          </div>
        </div>
      </div>

      <a href="{{ route('measurements.index') }}"
         class="mt-auto inline-block bg-white text-blue-700 font-bold px-5 py-3 rounded hover:bg-blue-100 transition text-center">
        View Detailed Measurements →
      </a>
    </div>

    {{-- Column 10-12: Quick Stats Sidebar --}}
    <div class="bg-gray-800 rounded-lg p-8 text-white flex flex-col justify-between" style="flex: 1 1 30%;">
      <h3 class="text-xl font-bold mb-6 border-b border-gray-600 pb-3">Quick Stats</h3>

      <div class="space-y-7">
        <div>
          <p class="text-gray-400 text-sm">Total KPIs Tracked</p>
          <p class="text-lg font-semibold">{{ $totalKpis }}</p>
        </div>
        <div>
          <p class="text-gray-400 text-sm">Measurements Taken</p>
          <p class="text-lg font-semibold">{{ $totalMeasurements }}</p>
        </div>
        <div>
          <p class="text-gray-400 text-sm">Last Update</p>
          <p class="text-lg font-semibold">{{ $lastUpdate ? $lastUpdate->created_at->format('M d, Y') : 'N/A' }}</p>
        </div>

        <div>
          <p class="text-gray-400 text-sm">Average Growth</p>
          <p class="text-lg font-semibold text-green-400">{{ number_format($avgGrowth ?? 0, 2) }}%</p>
        </div>

        <div>
          <p class="text-gray-400 text-sm mb-3">Recent Measurements</p>
          <ul class="list-disc list-inside text-gray-300 text-sm space-y-1 max-h-32 overflow-y-auto">
            @foreach($measurements as $measurement)
              <li>{{ $measurement->kpi->name }}: {{ number_format($measurement->value, 1) }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      @php
       $maxValue = $measurements->max('value');
      @endphp
      <div class="mt-8">
        <p class="text-gray-400 text-sm mb-3">Recent Trends</p> 
        <div class="w-full h-40 flex items-end space-x-3 px-2 "> 
          @foreach($measurements as $measurement) 
           @php
            $height = max((log($measurement->value + 1) / log($maxValue + 1)) * 100, 5);
           @endphp 
          <div class="w-4 rounded" 
          style=" height: {{ $height }}%; background-color: rgba(0, 123, 255, {{ max($height / 100, 0.2) }})">
          </div> 
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
      animation: fadeIn 1s ease forwards;
    }
  </style>
</x-app-layout>





