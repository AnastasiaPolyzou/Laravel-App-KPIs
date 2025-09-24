<x-app-layout>
    <h1 class="text-3xl font-bold mb-6 text-center text-white">Create KPI</h1>

    @include('kpis.partials.form', [
        'action' => route('kpis.store'),
        'method' => 'POST',
        'buttonText' => 'Create KPI'
    ])
</x-app-layout>