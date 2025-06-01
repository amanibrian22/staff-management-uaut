<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Dashboard - UAUT Staff Risk Management</title>
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
                    <p class="text-xs text-gray-400">Financial Dashboard</p>
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
                            Financial Risks
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
                    <h1 class="text-2xl font-bold text-primary-black">Financial Risk Dashboard</h1>
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
                            <textarea name="description" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green focus:border-transparent" rows="4" placeholder="Describe the risk in detail..." required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <div class="relative">
                                <select name="type" class="w-full p-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-primary-green focus:border-transparent" required>
                                    <option value="" disabled selected>Select department</option>
                                    <option value="technical">Technical</option>
                                    <option value="financial">Financial</option>
                                    <option value="academic">Academic</option>
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
                                    <input type="radio" name="urgency" value="low" class="form-radio text-primary-green">
                                    <span class="ml-2">Low</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="urgency" value="medium" class="form-radio text-primary-green" checked>
                                    <span class="ml-2">Medium</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="urgency" value="high" class="form-radio text-primary-green">
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
            <section id="reported-risks" class="bg-primary-white p-6 rounded-xl shadow-md border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary-blue rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-list-ul text-primary-white"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-primary-black">Financial Reported Risks</h2>
                    </div>
                    <div class="text-sm text-gray-500">
                        Total: {{ $risks->count() }} reports
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($risks as $risk)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $risk->reporter->name }}</td>
                                    <td class="px-6 py-4 whitespace-normal max-w-xs">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($risk->description, 60) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $risk->urgency == 'high' ? 'bg-red-100 text-red-800' : 
                                               ($risk->urgency == 'medium' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($risk->urgency) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $risk->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ ($risk->status == 'resolved' ? 'bg-status-resolved text-white' : 
                                               ($risk->status == 'in_progress' ? 'bg-status-in-progress text-white' : 
                                               ($risk->status == 'unresolved' ? 'bg-status-unresolved text-white' : 
                                               'bg-status-pending text-white'))) }}">
                                            {{ ucfirst(str_replace('_', ' ', $risk->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal max-w-xs text-sm text-gray-500">
                                        {{ $risk->response ?? 'Awaiting response' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if (in_array($risk->status, ['pending', 'in_progress']))
                                            <form action="{{ route('financial.progress', $risk) }}" method="POST" class="mb-2">
                                                @csrf
                                                <textarea name="response" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter progress update (e.g., Working on it, will be done by tomorrow)" required></textarea>
                                                <button type="submit" class="bg-status-in-progress hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-xs font-semibold transition mt-1">We are working on it</button>
                                            </form>
                                            <form action="{{ route('financial.resolve', $risk) }}" method="POST" class="mb-2">
                                                @csrf
                                                <textarea name="response" class="w-full p-2 border border-gray-300 rounded-lg {{ $risk->urgency == 'high' ? 'required' : '' }}" placeholder="Enter resolution details" {{ $risk->urgency == 'high' ? 'required' : '' }}></textarea>
                                                <button type="submit" class="bg-status-resolved hover:bg-green-700 text-white px-3 py-1 rounded-lg text-xs font-semibold transition mt-1">Resolved</button>
                                            </form>
                                            @if ($risk->urgency == 'high')
                                                <form action="{{ route('financial.suggest', $risk) }}" method="POST">
                                                    @csrf
                                                    <textarea name="response" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Suggest an alternate solution" required></textarea>
                                                    <button type="submit" class="bg-status-unresolved hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs font-semibold transition mt-1">Suggest Alternate</button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-gray-400">Actioned</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
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