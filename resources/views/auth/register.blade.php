<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - UAUT Staff Risk Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700" rel="stylesheet">
    <link rel="shortcut icon" href="{{ url('/img/uaut-logo.jpg') }}" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Muli', sans-serif;
        }
        .container {
            max-width: 450px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            background: #fff;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 1.5rem;
        }
        h2 {
            color: #2c3e50;
            font-weight: 700;
        }
        .form-group label {
            font-weight: 600;
            color: #34495e;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.3);
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .alert {
            border-radius: 8px;
        }
        .text-muted a {
            color: #28a745;
            text-decoration: none;
        }
        .text-muted a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="text-center">
                <img src="{{ url('/img/uaut-logo.jpg') }}" alt="UAUT Logo" class="logo">
                <h2 style="font-size: larger">STAFF RISK MANAGEMENT</h2>
                <h2 style="font-size: medium">REGISTRATION FORM</h2>
            </div>

            @if (session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('staff.register') }}" class="mt-4">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="technical" {{ old('role') == 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="financial" {{ old('role') == 'financial' ? 'selected' : '' }}>Financial</option>
                        <option value="academic" {{ old('role') == 'academic' ? 'selected' : '' }}>Academic</option> <!-- Added -->
                    </select>
                </div>
                <button type="submit" class="btn btn-success btn-block">Register</button>
            </form>
            <p class="text-center text-muted mt-3">Already have an account? <a href="/staff/login">Login here</a></p>
        </div>
    </div>
</body>
</html>