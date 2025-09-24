<table class="min-w-full table-auto text-white">
    <thead>
        <tr class="bg-gray-800 text-left">
            <th class="px-4 py-2">Date</th>
            <th class="px-4 py-2">KPI</th>
            <th class="px-4 py-2">Value</th>
            <th class="px-4 py-2">User</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($measurements as $measurement)
            <tr class="border-b border-gray-700">
                <td class="px-4 py-2">{{ $measurement->date }}</td>
                <td class="px-4 py-2">{{ $measurement->kpi->name }}</td>
                <td class="px-4 py-2">{{ $measurement->value }}</td>
                <td class="px-4 py-2">{{ $measurement->user->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

