
<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-gray-900 rounded-lg">
        <h1 class="text-4xl font-bold text-white text-center mb-6 animate-fadeIn">Measurements</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow">
                <strong>✅ Success:</strong> {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('measurements.create') }}"
           class="inline-block mb-6 px-6 py-2 border-2 border-blue-600 text-blue-600 font-semibold rounded hover:bg-blue-600 hover:text-white transition duration-300">
            Create Measurement
        </a>

        @include('measurements.partials.table')
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




