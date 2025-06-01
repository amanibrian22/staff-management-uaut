<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UAUT Staff Risk Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700" rel="stylesheet">
    <link rel="shortcut icon" href="{{ url('/img/uaut-logo.jpg') }}" type="image/x-icon">
</head>
<body class="bg-gray-100 font-muli flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-6">
        <div class="bg-primary-white rounded-xl shadow-lg p-8">
            <!-- Logo and Title -->
            <div class="text-center mb-6">
                <img src="{{ url('/img/uaut-logo.jpg') }}" alt="UAUT Logo" class="w-24 mx-auto mb-4">
                <h1 class="text-2xl font-bold text-primary-black">Staff Risk Management</h1>
                <p class="text-sm text-gray-600">Login to your account</p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-primary-green text-primary-white p-3 rounded mb-6">{{ session('success') }}</div>
            @endif
            @if ($errors->has('email'))
                <div class="bg-red-500 text-primary-white p-3 rounded mb-6">{{ $errors->first('email') }}</div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('staff.login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-primary-black">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full p-3 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-primary-black">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" class="w-full p-3 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green" required>
                </div>
                <button type="submit" class="w-full bg-primary-green text-primary-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">Login</button>
            </form>

            <!-- Register Link -->
            <p class="text-center text-sm text-gray-600 mt-4">
                Don't have an account? <a href="{{ route('staff.register') }}" class="text-primary-green hover:underline">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>