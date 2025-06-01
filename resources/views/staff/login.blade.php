<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UAUT Risk Management</title>
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
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-primary-gray flex items-center justify-center min-h-screen">
    <div class="bg-primary-white p-8 rounded-xl shadow-md w-full max-w-md border border-gray-200">
        <div class="flex justify-center mb-6">
            <img src="{{ url('/img/uaut-logo.jpg') }}" alt="UAUT Logo" class="w-16 h-16 rounded-full">
        </div>
        <h1 class="text-2xl font-bold text-primary-black text-center mb-2">UAUT Risk Management</h1>
        <p class="text-gray-600 text-center mb-6">Sign in to your account</p>
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('staff.login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </span>
                    <input type="email" name="email" id="email" class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-blue" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-lock text-gray-400"></i>
                    </span>
                    <input type="password" name="password" id="password" class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-blue" required>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-primary-blue hover:bg-blue-700 text-primary-white py-3 rounded-lg flex items-center justify-center transition">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign In
            </button>
        </form>
    </div>
</body>
</html>