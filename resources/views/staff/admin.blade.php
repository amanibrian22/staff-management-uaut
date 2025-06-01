<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UAUT Risk Management</title>
    <link rel="shortcut icon" href="{{ url('/img/uaut-logo.jpg') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ url('/img/uaut-logo.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-black': '#1a1c23',
                        'primary-white': '#ffffff',
                        'primary-green': '#2e7d32',
                        'primary-blue': '#1976d2',
                        'primary-gray': '#f5f7fa',
                        'status-resolved': '#4caf50',
                        'status-pending': '#ff9800',
                        'status-in-progress': '#0288d1',
                        'status-unresolved': '#f44336'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-primary-gray font-sans">
    <div class="flex h-screen">
        <aside class="w-72 bg-primary-black text-primary-white p-6 flex flex-col">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center overflow-hidden">
                    <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                </div>
                <div class="ml-3">
                    <h2 class="text-xl font-bold">Risk Management</h2>
                    <p class="text-xs text-gray-400">Admin Dashboard</p>
                </div>
            </div>
            <div class="mb-8">
                <div class="bg-gray-800 p-4 rounded-lg border-l-4 border-primary-green">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-id-card text-primary-green mr-2"></i>
                        <h3 class="font-semibold">Admin Profile</h3>
                    </div>
                    <div class="space-y-2 text-sm">
                        <p class="flex items-center">
                            <i class="fas fa-user mr-2 text-gray-400 w-4"></i>
                            {{ Auth::user()->name }}
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-gray-400 w-4"></i>
                            {{ Auth::user()->email }}
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-phone mr-2 text-gray-400 w-4"></i>
                            {{ Auth::user()->phone ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
            <nav class="mb-8">
                <ul class="space-y-2">
                    <li>
                        <a href="#add-risk" class="flex items-center p-2 rounded-lg hover:bg-gray-700 text-gray-300 hover:text-primary-white transition">
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            Add Risk
                        </a>
                    </li>
                    <li>
                        <a href="#manage-risks" class="flex items-center p-2 rounded-lg hover:bg-gray-700 text-gray-300 hover:text-primary-white transition">
                            <i class="fas fa-list-ul mr-3"></i>
                            Manage Risks
                        </a>
                    </li>
                    <li>
                        <a href="#manage-users" class="flex items-center p-2 rounded-lg hover:bg-gray-700 text-gray-300 hover:text-primary-white transition">
                            <i class="fas fa-users mr-3"></i>
                            Manage Users
                        </a>
                    </li>
                    <li>
                        <a href="#metrics-reports" class="flex items-center p-2 rounded-lg hover:bg-gray-700 text-gray-300 hover:text-primary-white transition">
                            <i class="fas fa-chart-bar mr-3"></i>
                            Metrics & Reports
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="mt-auto">
                <form action="{{ route('staff.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center bg-gray-700 hover:bg-gray-600 text-primary-white py-2 px-4 rounded-lg transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-primary-black">Admin Dashboard</h1>
                    <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}</p>
                </div>
                <div class="bg-primary-white p-3 rounded-lg shadow-sm">
                    <span class="text-sm text-gray-500">Last login: {{ now()->format('M d, Y H:i') }}</span>
                </div>
            </div>
            @if (session('success'))
                <div class="bg-primary-green text-primary-white p-3 rounded mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            <section id="metrics-reports" class="bg-primary-white p-6 rounded-xl shadow-md mb-8 border border-gray-200">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-primary-blue rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-chart-bar text-primary-white"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-primary-black">Metrics & Reports</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-sm font-medium text-gray-500">Total Risks</h3>
                        <p class="text-2xl font-bold text-primary-black">{{ $metrics['total_risks'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-sm font-medium text-gray-500">Resolved Risks</h3>
                        <p class="text-2xl font-bold text-status-resolved">{{ $metrics['resolved_risks'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-sm font-medium text-gray-500">Pending Risks</h3>
                        <p class="text-2xl font-bold text-status-pending">{{ $metrics['pending_risks'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-sm font-medium text-gray-500">In Progress</h3>
                        <p class="text-2xl font-bold text-status-in-progress">{{ $metrics['in_progress_risks'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-sm font-medium text-gray-500">Unresolved Risks</h3>
                        <p class="text-2xl font-bold text-status-unresolved">{{ $metrics['unresolved_risks'] }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold mb-4">Risks by Department</h3>
                        <ul class="space-y-2">
                            @foreach ($metrics['by_department'] as $dept => $count)
                                <li class="flex justify-between">
                                    <span>{{ ucfirst($dept) }}</span>
                                    <span class="font-semibold">{{ $count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold mb-4">Risks by Urgency</h3>
                        <ul class="space-y-2">
                            @foreach ($metrics['by_urgency'] as $urgency => $count)
                                <li class="flex justify-between">
                                    <span>{{ ucfirst($urgency) }}</span>
                                    <span class="font-semibold">{{ $count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Generate Report</h3>
                    <a href="{{ route('admin.generate.report') }}" class="bg-primary-blue hover:bg-blue-700 text-primary-white py-2 px-6 rounded-lg inline-flex items-center transition">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Download PDF Report
                    </a>
                </div>
            </section>
            <section id="add-risk" class="bg-primary-white p-6 rounded-xl shadow-md mb-8 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-primary-green rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-plus text-primary-white"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-primary-black">Add New Risk</h2>
                </div>
                <form action="{{ route('admin.add.risk') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Reported By</label>
                            <select name="reported_by" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green" required>
                                <option value="" disabled selected>Select user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select name="type" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green" required>
                                <option value="" disabled selected>Select department</option>
                                <option value="technical" {{ old('type') == 'technical' ? 'selected' : '' }}>Technical</option>
                                <option value="financial" {{ old('type') == 'financial' ? 'selected' : '' }}>Financial</option>
                                <option value="academic" {{ old('type') == 'academic' ? 'selected' : '' }}>Academic</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Urgency</label>
                            <select name="urgency" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green" required>
                                <option value="" disabled selected>Select urgency</option>
                                <option value="low" {{ old('urgency') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('urgency') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('urgency') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-primary-green hover:bg-green-700 text-primary-white py-2 px-6 rounded-lg flex items-center transition">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Add Risk
                        </button>
                    </div>
                </form>
            </section>
            <section id="manage-risks" class="bg-primary-white p-6 rounded-xl shadow-md mb-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary-blue rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-list-ul text-primary-white"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-primary-black">Manage Risks</h2>
                    </div>
                    <div class="text-sm text-gray-500">
                        Total: {{ $risks->count() }} risks
                    </div>
                </div>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
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
                        <tbody class="bg-white divide-y divide-gray-200">
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
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">
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
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Type</label>
                                                    <select name="type" class="w-full p-2 border rounded" required>
                                                        <option value="technical" {{ $risk->type == 'technical' ? 'selected' : '' }}>Technical</option>
                                                        <option value="financial" {{ $risk->type == 'financial' ? 'selected' : '' }}>Financial</option>
                                                        <option value="academic" {{ $risk->type == 'academic' ? 'selected' : '' }}>Academic</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Urgency</label>
                                                    <select name="urgency" class="w-full p-2 border rounded" required>
                                                        <option value="low" {{ $risk->urgency == 'low' ? 'selected' : '' }}>Low</option>
                                                        <option value="medium" {{ $risk->urgency == 'medium' ? 'selected' : '' }}>Medium</option>
                                                        <option value="high" {{ $risk->urgency == 'high' ? 'selected' : '' }}>High</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                                    <select name="status" class="w-full p-2 border rounded" required>
                                                        <option value="pending" {{ $risk->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="in_progress" {{ $risk->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="resolved" {{ $risk->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                                        <option value="unresolved" {{ $risk->status == 'unresolved' ? 'selected' : '' }}>Unresolved</option>
                                                    </select>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="block text-sm font-medium text-gray-700">Response</label>
                                                    <textarea name="response" class="w-full p-2 border rounded" rows="3">{{ $risk->response }}</textarea>
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
                                            <p class="text-gray-500">No risks reported yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
            <section id="manage-users" class="bg-primary-white p-6 rounded-xl shadow-md mb-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary-blue rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-users text-primary-white"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-primary-black">Manage Users</h2>
                    </div>
                    <div class="text-sm text-gray-500">
                        Total: {{ $users->count() }} users
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Add New User</h3>
                    <form action="{{ route('admin.add.user') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" class="w-full p-2 border rounded" required value="{{ old('name') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" class="w-full p-2 border rounded" required value="{{ old('email') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" class="w-full p-2 border rounded" required value="{{ old('phone') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" class="w-full p-2 border rounded" required>
                                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="technical" {{ old('role') == 'technical' ? 'selected' : '' }}>Technical</option>
                                    <option value="financial" {{ old('role') == 'financial' ? 'selected' : '' }}>Financial</option>
                                    <option value="academic" {{ old('role') == 'academic' ? 'selected' : '' }}>Academic</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" class="w-full p-2 border rounded" required>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-primary-green hover:bg-green-700 text-white py-2 px-4 rounded">Add User</button>
                        </div>
                    </form>
                </div>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
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
                        <tbody class="bg-white divide-y divide-gray-200">
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
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">
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
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                                    <input type="email" name="email" class="w-full p-2 border rounded" required value="{{ $user->email }}">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                                    <input type="text" name="phone" class="w-full p-2 border rounded" required value="{{ $user->phone ?? '' }}">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                                    <select name="role" class="w-full p-2 border rounded" required>
                                                        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                                        <option value="technical" {{ $user->role == 'technical' ? 'selected' : '' }}>Technical</option>
                                                        <option value="financial" {{ $user->role == 'financial' ? 'selected' : '' }}>Financial</option>
                                                        <option value="academic" {{ $user->role == 'academic' ? 'selected' : '' }}>Academic</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                                                    <input type="password" name="password" class="w-full p-2 border rounded">
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
                </div>
            </section>
        </main>
    </div>
</body>
</html>