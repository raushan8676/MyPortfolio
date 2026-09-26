@php
    $headerProfile = $profile ?? \App\Models\ProfileSetting::first() ?? new \App\Models\ProfileSetting();
    $resumeLink = $headerProfile->resume_url ?: ($headerProfile->resume_file ? (str_starts_with($headerProfile->resume_file, 'http') ? $headerProfile->resume_file : asset($headerProfile->resume_file)) : null);
    if ($resumeLink && !str_starts_with($resumeLink, 'http') && !str_starts_with($resumeLink, '/')) {
        $resumeLink = asset($resumeLink);
    }
@endphp

<header id="main-header" class="sticky top-0 z-50 w-full bg-[#0a0f1d]/85 backdrop-blur-md border-b border-slate-800/70 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Left: Logo & Name -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#home" class="flex items-center gap-3 group">
                    <!-- Stylized RK Badge -->
                    <div class="w-10 h-10 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center shadow-inner group-hover:border-sky-500/50 transition-all duration-300">
                        <span class="text-xl font-black tracking-tighter">
                            <span class="text-sky-400">R</span><span class="text-slate-100">K</span>
                        </span>
                    </div>
                    <span class="text-slate-100 font-semibold text-lg tracking-tight group-hover:text-white transition-colors">
                        Raushan Kumar
                    </span>
                </a>
            </div>

            <!-- Center: Navigation Links (Desktop) -->
            <nav id="desktop-nav" class="hidden md:flex items-center space-x-7 lg:space-x-8">
                <!-- Home -->
                <div class="relative py-2 nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link text-sm font-medium {{ request()->routeIs('home') ? 'text-white' : 'text-slate-400 hover:text-slate-200' }} transition-colors">
                        Home
                    </a>
                    <span class="nav-indicator {{ request()->routeIs('home') ? '' : 'hidden' }} absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-sky-500 rounded-full"></span>
                </div>

                <!-- About -->
                <div class="relative py-2 nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}" class="nav-link text-sm font-medium {{ request()->routeIs('about') ? 'text-white' : 'text-slate-400 hover:text-slate-200' }} transition-colors">
                        About
                    </a>
                    <span class="nav-indicator {{ request()->routeIs('about') ? '' : 'hidden' }} absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-sky-500 rounded-full"></span>
                </div>

                <!-- Skills -->
                <div class="relative py-2 nav-item {{ request()->routeIs('skills') ? 'active' : '' }}">
                    <a href="{{ route('skills') }}" class="nav-link text-sm font-medium {{ request()->routeIs('skills') ? 'text-white' : 'text-slate-400 hover:text-slate-200' }} transition-colors">
                        Skills
                    </a>
                    <span class="nav-indicator {{ request()->routeIs('skills') ? '' : 'hidden' }} absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-sky-500 rounded-full"></span>
                </div>

                <!-- Projects -->
                <div class="relative py-2 nav-item {{ request()->routeIs('projects') ? 'active' : '' }}">
                    <a href="{{ route('projects') }}" class="nav-link text-sm font-medium {{ request()->routeIs('projects') ? 'text-white' : 'text-slate-400 hover:text-slate-200' }} transition-colors">
                        Projects
                    </a>
                    <span class="nav-indicator {{ request()->routeIs('projects') ? '' : 'hidden' }} absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-sky-500 rounded-full"></span>
                </div>

                <!-- Experience -->
                <div class="relative py-2 nav-item {{ request()->routeIs('experience') ? 'active' : '' }}">
                    <a href="{{ route('experience') }}" class="nav-link text-sm font-medium {{ request()->routeIs('experience') ? 'text-white' : 'text-slate-400 hover:text-slate-200' }} transition-colors">
                        Experience
                    </a>
                    <span class="nav-indicator {{ request()->routeIs('experience') ? '' : 'hidden' }} absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-sky-500 rounded-full"></span>
                </div>

                <!-- Education -->
                <div class="relative py-2 nav-item {{ request()->routeIs('education') ? 'active' : '' }}">
                    <a href="{{ route('education') }}" class="nav-link text-sm font-medium {{ request()->routeIs('education') ? 'text-white' : 'text-slate-400 hover:text-slate-200' }} transition-colors">
                        Education
                    </a>
                    <span class="nav-indicator {{ request()->routeIs('education') ? '' : 'hidden' }} absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-sky-500 rounded-full"></span>
                </div>

                <!-- Contact -->
                <div class="relative py-2 nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}" class="nav-link text-sm font-medium {{ request()->routeIs('contact') ? 'text-white' : 'text-slate-400 hover:text-slate-200' }} transition-colors">
                        Contact
                    </a>
                    <span class="nav-indicator {{ request()->routeIs('contact') ? '' : 'hidden' }} absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-sky-500 rounded-full"></span>
                </div>
            </nav>

            <!-- Right: Theme Switcher & Action Button -->
            <div class="hidden md:flex items-center space-x-5">
                <!-- Theme Toggle Button -->
                <button type="button" 
                        id="theme-toggle-btn"
                        title="Toggle Light/Dark Theme"
                        aria-label="Toggle Theme"
                        class="p-2 rounded-full text-amber-400 hover:text-amber-300 hover:bg-slate-800/60 focus:outline-none transition-all duration-200 cursor-pointer">
                    <!-- Sun Icon (Active in Dark Mode) -->
                    <svg id="theme-sun-icon" class="w-5 h-5 block text-amber-400 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon Icon (Active in Light Mode) -->
                    <svg id="theme-moon-icon" class="w-5 h-5 hidden text-slate-700 hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Download CV Button -->
                @if($resumeLink)
                <a href="{{ $resumeLink }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-sm font-medium text-white bg-gradient-to-r from-blue-500 via-indigo-500 to-sky-400 hover:from-blue-600 hover:via-indigo-600 hover:to-sky-500 shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/40 active:scale-95 transition-all duration-200">
                    Download CV
                </a>
                @endif
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center space-x-3 md:hidden">
                <!-- Theme Toggle Mobile -->
                <button type="button" 
                        id="theme-toggle-mobile-btn"
                        title="Toggle Light/Dark Theme"
                        aria-label="Toggle Theme"
                        class="p-2 rounded-full text-amber-400 hover:bg-slate-800/60 focus:outline-none cursor-pointer">
                    <!-- Sun Icon Mobile -->
                    <svg id="theme-sun-icon-mobile" class="w-5 h-5 block text-amber-400 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon Icon Mobile -->
                    <svg id="theme-moon-icon-mobile" class="w-5 h-5 hidden text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Hamburger Button -->
                <button id="mobile-menu-btn" 
                        type="button" 
                        aria-label="Toggle Menu"
                        class="p-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800/60 focus:outline-none transition">
                    <!-- Hamburger Icon -->
                    <svg id="hamburger-icon" class="w-6 h-6 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <!-- Close (X) Icon -->
                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-slate-800 bg-[#0a0f1d]/95 backdrop-blur-lg px-4 pt-3 pb-6 space-y-2">
        <a href="{{ route('home') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-white bg-slate-800/60' : 'text-slate-300 hover:text-white hover:bg-slate-800/40' }}">Home</a>
        <a href="{{ route('about') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'text-white bg-slate-800/60' : 'text-slate-300 hover:text-white hover:bg-slate-800/40' }}">About</a>
        <a href="{{ route('skills') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('skills') ? 'text-white bg-slate-800/60' : 'text-slate-300 hover:text-white hover:bg-slate-800/40' }}">Skills</a>
        <a href="{{ route('projects') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('projects') ? 'text-white bg-slate-800/60' : 'text-slate-300 hover:text-white hover:bg-slate-800/40' }}">Projects</a>
        <a href="{{ route('experience') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('experience') ? 'text-white bg-slate-800/60' : 'text-slate-300 hover:text-white hover:bg-slate-800/40' }}">Experience</a>
        <a href="{{ route('education') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('education') ? 'text-white bg-slate-800/60' : 'text-slate-300 hover:text-white hover:bg-slate-800/40' }}">Education</a>
        <a href="{{ route('contact') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'text-white bg-slate-800/60' : 'text-slate-300 hover:text-white hover:bg-slate-800/40' }}">Contact</a>
        
        @if($resumeLink)
        <div class="pt-4">
            <a href="{{ $resumeLink }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="w-full inline-flex items-center justify-center px-5 py-2.5 rounded-full text-sm font-medium text-white bg-gradient-to-r from-blue-500 via-indigo-500 to-sky-400 shadow-md shadow-blue-500/25">
                Download CV
            </a>
        </div>
        @endif
    </div>
</header>

<!-- Pure JavaScript Interactivity -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Theme Switcher Functionality ---
        const themeToggleBtn = document.getElementById('theme-toggle-btn');
        const themeToggleMobileBtn = document.getElementById('theme-toggle-mobile-btn');
        
        const sunIcon = document.getElementById('theme-sun-icon');
        const moonIcon = document.getElementById('theme-moon-icon');
        const sunIconMobile = document.getElementById('theme-sun-icon-mobile');
        const moonIconMobile = document.getElementById('theme-moon-icon-mobile');

        function applyTheme(theme) {
            if (theme === 'light') {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
                if (sunIcon) sunIcon.classList.add('hidden');
                if (sunIcon) sunIcon.classList.remove('block');
                if (moonIcon) moonIcon.classList.remove('hidden');
                if (moonIcon) moonIcon.classList.add('block');
                if (sunIconMobile) sunIconMobile.classList.add('hidden');
                if (sunIconMobile) sunIconMobile.classList.remove('block');
                if (moonIconMobile) moonIconMobile.classList.remove('hidden');
                if (moonIconMobile) moonIconMobile.classList.add('block');
            } else {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
                if (sunIcon) sunIcon.classList.remove('hidden');
                if (sunIcon) sunIcon.classList.add('block');
                if (moonIcon) moonIcon.classList.add('hidden');
                if (moonIcon) moonIcon.classList.remove('block');
                if (sunIconMobile) sunIconMobile.classList.remove('hidden');
                if (sunIconMobile) sunIconMobile.classList.add('block');
                if (moonIconMobile) moonIconMobile.classList.add('hidden');
                if (moonIconMobile) moonIconMobile.classList.remove('block');
            }
            localStorage.setItem('theme', theme);
        }

        // Initialize icons based on current active theme
        const currentTheme = localStorage.getItem('theme') || 'dark';
        applyTheme(currentTheme);

        function toggleTheme() {
            const isLight = document.documentElement.classList.contains('light');
            const newTheme = isLight ? 'dark' : 'light';
            applyTheme(newTheme);
        }

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', toggleTheme);
        }
        if (themeToggleMobileBtn) {
            themeToggleMobileBtn.addEventListener('click', toggleTheme);
        }

        // --- Mobile Menu Toggle ---
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');

        function toggleMenu() {
            const isClosed = mobileMenu.classList.contains('hidden');
            if (isClosed) {
                mobileMenu.classList.remove('hidden');
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        }

        if (menuBtn) {
            menuBtn.addEventListener('click', toggleMenu);
        }

        // Close mobile menu when a link is clicked
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (!mobileMenu.classList.contains('hidden')) {
                    toggleMenu();
                }
            });
        });

        // Desktop nav item active indicator switcher
        const navItems = document.querySelectorAll('#desktop-nav .nav-item');
        navItems.forEach(item => {
            const link = item.querySelector('.nav-link');
            const indicator = item.querySelector('.nav-indicator');

            link.addEventListener('click', () => {
                navItems.forEach(otherItem => {
                    const otherLink = otherItem.querySelector('.nav-link');
                    const otherIndicator = otherItem.querySelector('.nav-indicator');
                    otherLink.classList.remove('text-white');
                    otherLink.classList.add('text-slate-400');
                    if (otherIndicator) otherIndicator.classList.add('hidden');
                });

                link.classList.remove('text-slate-400');
                link.classList.add('text-white');
                if (indicator) indicator.classList.remove('hidden');
            });
        });
    });
</script>
