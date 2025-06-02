<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody id="users-table-body" class="bg-white divide-y divide-gray-200">
        @forelse ($users as $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone ?? 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($user->role) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <button onclick="document.getElementById('edit-user-{{ $user->id }}').classList.toggle('hidden')" class="text-blue-600 hover:text-blue-800 mr-2">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.delete.user', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <tr id="edit-user-{{ $user->id }}" class="hidden">
                <td colspan="5" class="px-6 py-4">
                    <form action="{{ route('admin.edit.user', $user) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" class="w-full p-2 border rounded" required value="{{ $user->name }}">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" class="w-full p-2 border rounded" required value="{{ $user->email }}">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" class="w-full p-2 border rounded" required value="{{ $user->phone ?? '' }}">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" class="w-full p-2 border rounded" required>
                                    <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="technical" {{ $user->role == 'technical' ? 'selected' : '' }}>Technical</option>
                                    <option value="financial" {{ $user->role == 'financial' ? 'selected' : '' }}>Financial</option>
                                    <option value="academic" {{ $user->role == 'academic' ? 'selected' : '' }}>Academic</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                                <input type="password" name="password" class="w-full p-2 border rounded">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-primary-blue hover:bg-blue-700 text-white py-2 px-4 rounded">Update User</button>
                        </div>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center py-8">
                        <i class="fas fa-users text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">No users found.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>