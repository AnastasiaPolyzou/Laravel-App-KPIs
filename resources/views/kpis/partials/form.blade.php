<form action="{{ $action }}" method="POST" class="max-w-md mx-auto bg-gray-900 p-8 rounded-lg shadow-lg text-white">
    @csrf
    @if($method === 'PATCH')
        @method('PATCH')
    @endif

    <div class="mb-6">
        <label for="name" class="block text-gray-300 font-semibold mb-2 tracking-wide">
            KPI Name <span class="text-red-500">*</span>
        </label>
        <input 
            type="text" 
            name="name" 
            id="name" 
            value="{{ old('name', $kpi->name ?? '') }}" 
            placeholder="Enter KPI name"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            required
            aria-describedby="name-error"
        >
        @error('name')
            <p id="name-error" class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="unit" class="block text-gray-300 font-semibold mb-2 tracking-wide">
            Unit 
        </label>
        <input 
            type="text" 
            name="unit" 
            id="unit" 
            value="{{ old('unit', $kpi->unit ?? '') }}" 
            placeholder="e.g. %, kg, units"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            aria-describedby="unit-error"
        >
        @error('unit')
            <p id="unit-error" class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button 
        type="submit" 
        class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-3 rounded-md shadow-md transition focus:outline-none focus:ring-4 focus:ring-blue-400"
    >
        {{ $buttonText }}
    </button>
</form>
