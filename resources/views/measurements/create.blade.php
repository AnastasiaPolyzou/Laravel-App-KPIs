<x-app-layout>
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-3xl font-bold mb-6">Create Measurement</h1>

        <form action="{{ route('measurements.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Date -->
            <div>
                <label for="date" class="block mb-1 font-semibold">Date</label>
                <input type="date" name="date" id="date" class="w-full p-2 rounded text-black" required>
            </div>

            <!-- KPI Selection -->
            <div>
                <label for="kpi_id" class="block mb-1 font-semibold">KPI</label>
                <select name="kpi_id" id="kpi_id" class="w-full p-2 rounded text-black" required>
                    @foreach ($kpis as $kpi)
                        <option value="{{ $kpi->id }}">{{ $kpi->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Value -->
            <div>
                <label for="value" class="block mb-1 font-semibold">Value</label>
                <input type="number" name="value" id="value" step="0.01" class="w-full p-2 rounded text-black" required>
            </div>

            <!-- Submit -->
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Save Measurement
            </button>
        </form>

        <!-- Success & Error Messages -->
        @if (session('success'))
            <div class="mt-4 p-4 bg-green-600 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-600 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</x-app-layout>



