<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - UAUT Staff Risk Management</title>
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
                    <p class="text-xs text-gray-400">Staff Dashboard</p>
                </div>
            </div>
            <div class="mb-8">
                <div class="bg-gray-800 p-4 rounded-lg border-l-4 border-primary-green">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-id-card text-primary-green mr-2"></i>
                        <h3 class="font-semibold">My Profile</h3>
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
                        <a href="#report-risk" class="flex items-center p-2 rounded-lg hover:bg-gray-700 text-gray-300 hover:text-primary-white transition">
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            Report Risk
                        </a>
                    </li>
                    <li>
                        <a href="#reported-risks" class="flex items-center p-2 rounded-lg bg-gray-700 text-primary-white">
                            <i class="fas fa-list-ul mr-3"></i>
                            Reported Risks
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
                    <h1 class="text-2xl font-bold text-primary-black">Staff Risk Dashboard</h1>
                    <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}</p>
                </div>
                <div class="bg-primary-white p-3 rounded-lg shadow-sm">
                    <span class="text-sm text-gray-500">Last login: {{ now()->format('M d, Y H:i') }}</span>
                </div>
            </div>
            <section id="report-risk" class="bg-primary-white p-6 rounded-xl shadow-md mb-8 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-primary-green rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-plus text-primary-white"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-primary-black">Report a New Risk</h2>
                </div>
                @if (session('success'))
                    <div class="bg-primary-green text-primary-white p-3 rounded mb-4 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <strong>Please fix these issues:</strong>
                        </div>
                        <ul class="mt-1 ml-6 list-disc">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('staff.report') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Risk Description</label>
                            <textarea name="description" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green focus:border-transparent" rows="4" placeholder="Describe the risk in detail..." required>{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <div class="relative">
                                <select name="type" class="w-full p-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-primary-green focus:border-transparent" required>
                                    <option value="" disabled selected>Select department</option>
                                    <option value="technical" {{ old('type') == 'technical' ? 'selected' : '' }}>Technical</option>
                                    <option value="financial" {{ old('type') == 'financial' ? 'selected' : '' }}>Financial</option>
                                    <option value="academic" {{ old('type') == 'academic' ? 'selected' : '' }}>Academic</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Urgency</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="urgency" value="low" class="form-radio text-primary-green" {{ old('urgency') == 'low' ? 'checked' : '' }}>
                                    <span class="ml-2">Low</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="urgency" value="medium" class="form-radio text-primary-green" {{ old('urgency', 'medium') == 'medium' ? 'checked' : '' }}>
                                    <span class="ml-2">Medium</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="urgency" value="high" class="form-radio text-primary-green" {{ old('urgency') == 'high' ? 'checked' : '' }}>
                                    <span class="ml-2">High</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-primary-green hover:bg-green-700 text-primary-white py-2 px-6 rounded-lg flex items-center transition">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Risk Report
                        </button>
                    </div>
                </form>
            </section>
            {{-- <section id="notifications" class="bg-primary-white p-6 rounded-xl shadow-md mb-8 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-primary-blue rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-bell text-primary-white"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-primary-black">Notifications</h2>
                </div>
                @forelse (auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                    <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700">
                            Risk #{{ $notification->data['risk_id'] }}: {{ $notification->data['description'] }}
                            <span class="font-semibold">{{ ucfirst($notification->data['status']) }}</span>
                            @if ($notification->data['response'])
                                - {{ $notification->data['response'] }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No notifications yet.</p>
                @endforelse
            </section> --}}
            <section id="reported-risks" class="bg-primary-white p-6 rounded-xl shadow-md border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary-blue rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-list-ul text-primary-white"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-primary-black">Reported Risks</h2>
                    </div>
                    <div class="text-sm text-gray-500">
                        Total: {{ isset($risks) ? $risks->count() : 0 }} reports
                    </div>
                </div>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported By</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urgency</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Response</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responder Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responder Phone</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($risks ?? [] as $risk)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $risk->reporter->name ?? 'Unknown' }}</td>
                                    <td class="px-6 py-4 whitespace-normal max-w-xs">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($risk->description ?? '', 60) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if ($risk->urgency == 'high')
                                                bg-red-100 text-red-800
                                            @elseif ($risk->urgency == 'medium')
                                                bg-yellow-100 text-yellow-800
                                            @else
                                                bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($risk->urgency ?? 'low') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $risk->created_at ? $risk->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if ($risk->status == 'resolved')
                                                bg-status-resolved text-white
                                            @elseif ($risk->status == 'in_progress')
                                                bg-status-in-progress text-white
                                            @elseif ($risk->status == 'unresolved')
                                                bg-status-unresolved text-white
                                            @else
                                                bg-status-pending text-white
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $risk->status ?? 'pending')) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal max-w-xs text-sm text-gray-500">
                                        {{ $risk->response ?? 'Awaiting response' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $risk->responder ? $risk->responder->name : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $risk->responder ? ($risk->responder->phone ?? 'N/A') : 'N/A' }}
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
        </main>
    </div>
</body>
</html>