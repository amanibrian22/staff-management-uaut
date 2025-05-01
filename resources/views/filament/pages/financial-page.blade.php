<x-filament::page>
    <div class="w-full py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border-t-4 border-blue-500 dark:border-blue-400">
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ $this->getHeading() }}</h1>
            <p class="text-gray-600 dark:text-gray-300 mb-6">View financial risks reported by staff.</p>
            {{ $this->table }}
        </div>
    </div>
</x-filament::page>
