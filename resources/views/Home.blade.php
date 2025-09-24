<x-app-layout>
    <div class="text-center mt-10">
        <h1 class="text-3xl font-bold mb-4">Welcome, {{ Auth::user()->name}}!</h1>
        <p class text-lg text-gray-700 dark:text-gray-300>
            Choose from Menu Dashboard,KPIs or Profile to begin
        </p>
    </div>
</x-app-layout>
