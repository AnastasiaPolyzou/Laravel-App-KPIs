<div class="overflow-hidden rounded-lg shadow-lg" style="background-color: #1e293b;">
    <table class="min-w-full text-left text-gray-100">
        <thead class="bg-gradient-to-r from-blue-700 to-blue-800">
            <tr>
                <th class="py-3 px-6 font-semibold uppercase tracking-wide text-sm md:text-base">Name</th>
                <th class="py-3 px-6 font-semibold uppercase tracking-wide text-center text-sm md:text-base">Unit</th>
                <th class="py-3 px-6 font-semibold uppercase tracking-wide text-center text-sm md:text-base">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kpis as $kpi)
            <tr class="border-b border-gray-700 hover:bg-gray-800 hover:shadow-md transition duration-300 cursor-pointer">
                <td class="py-4 px-6 font-semibold text-lg md:text-xl text-blue-300">{{ $kpi->name }}</td>
                <td class="py-4 px-6 text-center text-gray-400 italic">{{ $kpi->unit ?? '-' }}</td>
                <td class="py-4 px-6 text-center space-x-3">
                    <a href="{{ route('kpis.edit', $kpi) }}" 
                       class="inline-flex items-center gap-2 px-4 py-1 bg-blue-600 text-white font-semibold rounded-lg
                              hover:bg-blue-700 hover:scale-105 transform transition duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6m2-13a2.828 2.828 0 114 4L7 21H3v-4L16 5z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('kpis.destroy', $kpi) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure?')" 
                                class="inline-flex items-center gap-2 px-4 py-1 bg-red-500 text-white font-semibold rounded-lg
                                       hover:bg-red-600 hover:scale-105 transform transition duration-200 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 21M5 7l14 14" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="py-6 px-6 text-center text-gray-500 italic">No KPIs found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

