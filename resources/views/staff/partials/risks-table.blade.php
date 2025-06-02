<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported By</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urgency</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Response</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responder</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody id="risks-table-body" class="bg-white divide-y divide-gray-200">
        @forelse ($risks as $risk)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $risk->reporter->name ?? 'Unknown' }}</td>
                <td class="px-6 py-4 whitespace-normal max-w-xs text-sm text-gray-900">{{ Str::limit($risk->description, 60) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($risk->type) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        @if ($risk->urgency == 'high') bg-red-100 text-red-800
                        @elseif ($risk->urgency == 'medium') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800 @endif">
                        {{ ucfirst($risk->urgency) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        @if ($risk->status == 'resolved') bg-status-resolved text-white
                        @elseif ($risk->status == 'in_progress') bg-status-in-progress text-white
                        @elseif ($risk->status == 'unresolved') bg-status-unresolved text-white
                        @else bg-status-pending text-white @endif">
                        {{ ucfirst(str_replace('_', ' ', $risk->status)) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-normal max-w-xs text-sm text-gray-500">{{ $risk->response ?? 'None' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $risk->responder ? $risk->responder->name : 'None' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <button onclick="document.getElementById('edit-risk-{{ $risk->id }}').classList.toggle('hidden')" class="text-blue-600 hover:text-blue-800 mr-2">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.delete.risk', $risk) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this risk?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <tr id="edit-risk-{{ $risk->id }}" class="hidden">
                <td colspan="8" class="px-6 py-4">
                    <form action="{{ route('admin.edit.risk', $risk) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" class="w-full p-2 border rounded" rows="3" required>{{ $risk->description }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type</label>
                                <select name="type" class="w-full p-2 border rounded" required>
                                    <option value="technical" {{ $risk->type == 'technical' ? 'selected' : '' }}>Technical</option>
                                    <option value="financial" {{ $risk->type == 'financial' ? 'selected' : '' }}>Financial</option>
                                    <option value="academic" {{ $risk->type == 'academic' ? 'selected' : '' }}>Academic</option>
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Urgency</label>
                                <select name="urgency" class="w-full p-2 border rounded" required>
                                    <option value="low" {{ $risk->urgency == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $risk->urgency == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ $risk->urgency == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('urgency')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="w-full p-2 border rounded" required>
                                    <option value="pending" {{ $risk->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $risk->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $risk->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="unresolved" {{ $risk->status == 'unresolved' ? 'selected' : '' }}>Unresolved</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Response</label>
                                <textarea name="response" class="w-full p-2 border rounded" rows="3">{{ $risk->response }}</textarea>
                                @error('response')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-primary-blue hover:bg-blue-700 text-white py-2 px-4 rounded">Update Risk</button>
                        </div>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center py-8">
                        <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">No risks found.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>