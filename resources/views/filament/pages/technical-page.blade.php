<x-filament::page class="p-0">
    <div class="w-full py-8 px-4 sm:px-6 lg:px-8">
        <!-- Response Form Section -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border-t-4 border-blue-500 dark:border-blue-400 transition-colors duration-200">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Respond to a Risk</h2>
            <form wire:submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="response" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Response</label>
                    <textarea 
                        wire:model.defer="response" 
                        id="response" 
                        class="mt-2 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm transition duration-150 ease-in-out" 
                        rows="4" 
                        required
                        placeholder="e.g., 'Working on a fix' or 'Issue resolved'"
                    ></textarea>
                    @error('response') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select 
                        wire:model.defer="status" 
                        id="status" 
                        class="mt-2 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm transition duration-150 ease-in-out" 
                        required
                    >
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-yellow-500 text-gray-900 font-semibold rounded-md shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out z-10"
                        {{ $selectedRiskId ? '' : 'disabled' }}
                    >
                        Update Risk
                    </button>
                    <button 
                        type="button" 
                        wire:click="resetForm" 
                        class="inline-flex items-center px-6 py-2 bg-yellow-500 text-gray-900 font-semibold rounded-md shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out z-10"
                    >
                        Clear Form
                    </button>
                </div>
            </form>
        </div>

        <!-- Risks Table Section -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg border-t-4 border-blue-500 dark:border-blue-400 transition-colors duration-200">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Assigned Technical Risks</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Response</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($this->getRisks() as $risk)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $risk->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ ucfirst($risk->type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                        <span class="w-2 h-2 rounded-full mr-1 {{ $risk->status === 'pending' ? 'bg-green-500' : ($risk->status === 'in_progress' ? 'bg-blue-500' : 'bg-gray-500') }}"></span>
                                        {{ ucfirst($risk->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $risk->response ?? 'No response yet' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button 
                                        wire:click="selectRisk({{ $risk->id }})" 
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium"
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No risks assigned yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament::page>