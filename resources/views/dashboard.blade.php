<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight text-center">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-2xl px-4 lg:px-0 mx-auto" x-data="measurementDashboard()">
            <div class="flex flex-col lg:flex-row gap-6 items-stretch justify-center">
                <div class="w-full lg:w-3/4 flex flex-col gap-6">
                    <form @submit.prevent="fetchLineData" 
                          class="bg-gray-800 p-6 rounded-lg shadow-lg w-full flex flex-col lg:flex-row gap-6 items-center justify-center text-center">
                        
                        <div class="flex flex-row gap-6 items-center justify-center w-full relative">
                            <div class="flex-1" x-data="{ open: false }" @click.away="open = false">
                                <label class="text-gray-300 font-semibold block mb-1 text-center">Choose KPI:</label>
                                <button type="button" @click="open = !open" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 text-center flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                                    <span x-text="selectedLineKpis.length ? `${selectedLineKpis.length} selected` : 'Select KPIs'"></span>
                                    <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" x-transition class="absolute left-0 right-0 mt-2 max-h-60 overflow-y-auto bg-gray-800 border border-gray-600 rounded-md shadow-lg z-20">
                                    <ul class="divide-y divide-gray-700">
                                        @foreach ($kpis as $kpi)
                                            <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex justify-between items-center space-x-2">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" :value="'{{ $kpi->id }}'" x-model="selectedLineKpis" class="form-checkbox h-4 w-4 text-blue-500 border-gray-500 bg-gray-700 rounded">
                                                    <label class="text-white text-sm select-none cursor-pointer">{{ $kpi->name }} ({{ $kpi->unit }})</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="flex-1 flex flex-col items-center">
                                <label class="text-gray-300 font-semibold mb-1 text-center">From:</label>
                                <input type="date" x-model="startDate" required class="w-full max-w-xs bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                            </div>

                            <div class="flex-1 flex flex-col items-center">
                                <label class="text-gray-300 font-semibold mb-1 text-center">To:</label>
                                <input type="date" x-model="endDate" required class="w-full max-w-xs bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                            </div>

                            <div class="flex-1 flex flex-col items-center">
                                <label class="text-gray-300 font-semibold mb-1 text-center">Chart Type:</label>
                                <select x-model="chartType" class="w-full max-w-xs bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                                    <option value="line">Line</option>
                                    <option value="bar">Bar</option>
                                </select>
                            </div>

                            <div class="flex items-center mt-6 lg:mt-0">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow-md transition-all duration-300 transform hover:scale-105 mt-6">
                                    Load
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="bg-gray-800 rounded-lg p-4 shadow-xl w-full flex justify-center items-center">
                        <canvas id="chart" class="w-full h-full"></canvas>
                    </div>
                </div>
                
                <div class="w-full lg:w-1/4 bg-gray-800 rounded-lg p-4 shadow-xl flex flex-col gap-6">
    <h3 class="text-white text-lg font-semibold mb-2"></h3>
    
    <form @submit.prevent="fetchPieData">
        @csrf

        <div class="w-full relative" x-data="{ open: false }" @click.away="open = false">
            <label class="text-gray-300 font-semibold block mb-1 text-center">Choose KPI:</label>
            <button type="button" @click="open = !open" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 text-center flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                <span x-text="selectedPieKpis.length ? `${selectedPieKpis.length} selected` : 'Select KPIs'"></span>
                <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition class="absolute left-0 right-0 mt-2 max-h-60 overflow-y-auto bg-gray-800 border border-gray-600 rounded-md shadow-lg z-20">
                <ul class="divide-y divide-gray-700">
                    @foreach ($kpis as $kpi)
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex justify-between items-center space-x-2">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" :value="'{{ $kpi->id }}'" x-model="selectedPieKpis" class="form-checkbox h-4 w-4 text-blue-500 border-gray-500 bg-gray-700 rounded">
                                <label class="text-white text-sm select-none cursor-pointer">{{ $kpi->name }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="w-full relative" x-data="{ open: false }" @click.away="open = false">
            <label class="text-gray-300 font-semibold block mb-1 text-center">Choose Unit:</label>
            <button type="button" @click="open = !open" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 text-center flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                <span x-text="selectedUnits.length ? `${selectedUnits.length} selected` : 'Select Units'"></span>
                <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition class="absolute left-0 right-0 mt-2 max-h-60 overflow-y-auto bg-gray-800 border border-gray-600 rounded-md shadow-lg z-20">
                <ul class="divide-y divide-gray-700">
                    @foreach ($kpis->unique('unit') as $kpi)
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex justify-between items-center space-x-2">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" :value="'{{ $kpi->unit }}'" x-model="selectedUnits" class="form-checkbox h-4 w-4 text-blue-500 border-gray-500 bg-gray-700 rounded">
                                <label class="text-white text-sm select-none cursor-pointer">{{ $kpi->unit }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

         <!-- From Date Picker for Pie Chart -->
        <div class="flex-1 flex flex-col items-center mt-6">
            <label class="text-gray-300 font-semibold mb-1 text-center">From:</label>
            <input type="date" x-model="startDate" required class="w-full max-w-xs bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
        </div>

        <!-- To Date Picker for Pie Chart -->
        <div class="flex-1 flex flex-col items-center mt-6">
            <label class="text-gray-300 font-semibold mb-1 text-center">To:</label>
            <input type="date" x-model="endDate" required class="w-full max-w-xs bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 text-center focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
        </div>
        
        <div class="w-full flex justify-center items-center mt-6">
            <canvas id="pieChart" class="w-full h-full" style="height: 300px;"></canvas>
        </div>

        <div class="flex-1 w-full flex flex-col items-center mt-40">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow-md transition-all duration-300 transform hover:scale-105 mt-6">
                Submit
            </button>
        </div>
    </form>
</div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        @vite('resources/js/dashboard.js')
    @endpush
</x-app-layout>
             