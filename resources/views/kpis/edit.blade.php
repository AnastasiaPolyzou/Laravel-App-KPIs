<x-app-layout>
    <h1 class="text-3xl font-bold mb-6 text-center text-white">Edit KPI</h1>

    @include('kpis.partials.form', [
        'action' => route('kpis.update', $kpi),
        'method' => 'PATCH',
        'buttonText' => 'Update KPI',
        'kpi' => $kpi
    ])
</x-app-layout>