<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UAUT | Staff Risk Management</title>
    <meta name="description" content="UAUT Staff Risk Management System - Quick, Secure, and Confidential Risk Reporting">
    <meta name="author" content="UAUT">
    <meta name="robots" content="noindex, nofollow">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="shortcut icon" href="{{ url('/img/uaut-logo.jpg') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ url('/img/uaut-logo.jpg') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'uaut-green': '#28a745',
                        'uaut-dark': '#1a1c23',
                        'uaut-gray': '#f5f7fa',
                        'uaut-white': '#ffffff',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Hero Background */
        .hero {
            background: linear-gradient(135deg, rgba(26, 28, 35, 0.9), rgba(26, 28, 35, 0.9)), url('/img/baraka_hall.png');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        /* Navbar */
        .navbar {
            transition: background 0.3s ease, box-shadow 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 50%;
            background: #28a745;
            transition: width 0.3s ease, left 0.3s ease;
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: 70%;
            left: 15%;
        }

        /* Buttons */
        .btn-custom {
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-uaut-gray font-sans antialiased">
    <div id="page-container">
        <!-- Hero Section -->
        <section class="hero text-uaut-white">
            <div class="w-full">
                <!-- Navbar -->
                <nav class="navbar fixed top-0 left-0 w-full z-50 bg-uaut-white bg-opacity-10 p-4 lg:px-8">
                    <div class="container mx-auto flex items-center justify-between">
                        <a href="/" class="flex items-center">
                            <img src="{{ url('/img/uaut-logo.jpg') }}" alt="UAUT Logo" class="h-12 w-12 rounded-full transition-transform hover:scale-105">
                            <span class="ml-3 text-xl font-bold text-uaut-white lg:text-uaut-dark">UAUT</span>
                        </a>
                        <div class="hidden lg:flex space-x-8">
                            <a href="/" class="nav-link text-uaut-white lg:text-uaut-dark font-semibold hover:text-uaut-green active">Home</a>
                            <a href="#about" class="nav-link text-uaut-white lg:text-uaut-dark font-semibold hover:text-uaut-green">About Us</a>
                            <a href="#contact" class="nav-link text-uaut-white lg:text-uaut-dark font-semibold hover:text-uaut-green">Contact</a>
                        </div>
                        <button class="lg:hidden text-uaut-white focus:outline-none" onclick="toggleMenu()">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                    <!-- Mobile Menu -->
                    <div id="mobile-menu" class="hidden lg:hidden bg-uaut-white shadow-lg mt-4 p-4">
                        <a href="/" class="block py-2 text-uaut-dark font-semibold hover:text-uaut-green">Home</a>
                        <a href="#about" class="block py-2 text-uaut-dark font-semibold hover:text-uaut-green">About Us</a>
                        <a href="#contact" class="block py-2 text-uaut-dark font-semibold hover:text-uaut-green">Contact</a>
                    </div>
                </nav>

                <!-- Hero Content -->
                <div class="container mx-auto pt-24 pb-12 text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                        Welcome to UAUT Staff Risk Management System
                    </h1>
                    <p class="text-lg md:text-xl text-uaut-white opacity-80 mb-8 max-w-2xl mx-auto">
                        Quick, Secure, and Confidential Risk Reporting System
                    </p>
                    <div class="flex justify-center gap-4 flex-wrap">
                        <a href="/staff/register" class="btn-custom bg-uaut-green text-uaut-white font-semibold py-3 px-6 rounded-lg flex items-center">
                            <i class="fas fa-check-circle mr-2"></i> Register Now
                        </a>
                        <a href="/staff/login" class="btn-custom bg-uaut-white text-uaut-green font-semibold py-3 px-6 rounded-lg border-2 border-uaut-green hover:bg-uaut-green hover:text-uaut-white flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feature #1 - About Us Section -->
        <section id="about" class="py-16 bg-uaut-white">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2">
                        <img src="{{ url('/img/uaut-staff.jpg') }}" alt="UAUT Staff" class="w-full max-w-md mx-auto rounded-lg shadow-lg transition-transform hover:scale-105">
                    </div>
                    <div class="lg:w-1/2 text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-uaut-dark mb-4">About Us</h2>
                        <p class="text-lg text-gray-600 mb-6">
                            The UAUT Staff Risk Management System is designed to empower our staff to identify, report, and manage workplace risks effectively. Our mission is to create a safer and more transparent working environment for all UAUT employees.
                        </p>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center"><i class="fas fa-check text-uaut-green mr-2"></i> Our role in making UAUT safer starts here!</li>
                            <li class="flex items-center"><i class="fas fa-check text-uaut-green mr-2"></i> Report Financial, Technical, and Academic risks seamlessly</li>
                            <li class="flex items-center"><i class="fas fa-check text-uaut-green mr-2"></i> A proactive platform for a better workplace</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feature #2 -->
        <section class="py-16 bg-uaut-gray">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row-reverse items-center gap-12">
                    <div class="lg:w-1/2">
                        <img src="{{ url('/img/uaut.jpg') }}" alt="UAUT Campus" class="w-full max-w-md mx-auto rounded-lg shadow-lg transition-transform hover:scale-105">
                    </div>
                    <div class="lg:w-1/2 text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-uaut-dark mb-4">Stay Updated on Risk Management</h2>
                        <p class="text-lg text-gray-600 mb-6">
                            Monitor reported issues, track progress, and stay informed.
                        </p>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center"><i class="fas fa-check text-uaut-green mr-2"></i> Efficiently report, track, and resolve risks</li>
                            <li class="flex items-center"><i class="fas fa-check text-uaut-green mr-2"></i> Secure and confidential reporting system</li>
                            <li class="flex items-center"><i class="fas fa-check text-uaut-green mr-2"></i> Foster a safer UAUT through proactive reporting</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer - Contact Section -->
        <footer id="contact" class="bg-uaut-dark text-uaut-white py-12">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">Contact Us</h2>
                <p class="text-lg opacity-80 mb-8 max-w-2xl mx-auto">
                    Have questions or need assistance? Reach out to our team.
                </p>
                <div class="flex flex-col md:flex-row justify-center gap-8 mb-8">
    <div class="bg-uaut-dark-light p-6 rounded-lg max-w-xs mx-auto">
        <i class="fas fa-envelope text-uaut-green text-3xl mb-4"></i>
        <h3 class="text-xl font-semibold mb-2">Email</h3>
        <p>admin@uaut.ac.tz</p>
    </div>
    <div class="bg-uaut-dark-light p-6 rounded-lg max-w-xs mx-auto">
        <i class="fas fa-phone-alt text-uaut-green text-3xl mb-4"></i>
        <h3 class="text-xl font-semibold mb-2">Phone</h3>
        <p>+255 684 505 012</p>
    </div>
    <div class="bg-uaut-dark-light p-6 rounded-lg max-w-xs mx-auto">
        <i class="fas fa-globe text-uaut-green text-3xl mb-4"></i>
        <h3 class="text-xl font-semibold mb-2">Website</h3>
        <p><a href="https://www.uaut.ac.tz" target="_blank" class="hover:text-uaut-green underline">www.uaut.ac.tz</a></p>
    </div>
</div>

<!-- In the footer copyright section -->

                <hr class="border-gray-700 my-8">
                <div class="text-sm opacity-80">
    <p>Copyright © 2025 UAUT. All rights reserved.</p>
    <p class="mt-2">P.O. Box 12345, Kisiwani Dar es Salaam, Tanzania | 
        <a href="https://www.uaut.ac.tz" target="_blank" class="hover:text-uaut-green underline">Official Website</a>
    </p>
</div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>