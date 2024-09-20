<header class="bg-gray-800 text-gray-400 shadow-lg w-full mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <a href="{{ route('register.form') }}" ><h1 class="text-4xl font-extrabold text-white tracking-wide transition-transform duration-300 transform hover:scale-110 hover:translate-y-1">Iservice</h1></a>
            <nav class="space-x-8">
                <a href="{{ route('contact') }}" class="text-white hover:text-orange-200 transition duration-300 transform hover:scale-110 relative">
                    Contact Us
                    <span class="absolute inset-x-0 -bottom-1 h-1 bg-orange-200 transition-all duration-300 transform scale-x-0 hover:scale-x-100"></span>
                </a>
                <a href="{{ route('faq') }}" class="text-white hover:text-orange-200 transition duration-300 transform hover:scale-110 relative">
                    FAQ
                    <span class="absolute inset-x-0 -bottom-1 h-1 bg-orange-200 transition-all duration-300 transform scale-x-0 hover:scale-x-100"></span>
                </a>
                <a href="{{ route('about') }}" class="text-white hover:text-orange-200 transition duration-300 transform hover:scale-110 relative">
                    About Us
                    <span class="absolute inset-x-0 -bottom-1 h-1 bg-orange-200 transition-all duration-300 transform scale-x-0 hover:scale-x-100"></span>
                </a>
            </nav>
        </div>
    </div>
</header>
