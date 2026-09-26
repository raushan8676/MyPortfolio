@php
    $profile = $profile ?? \App\Models\ProfileSetting::first() ?? new \App\Models\ProfileSetting();

    $githubUser = $profile->github_url ? basename(rtrim($profile->github_url, '/')) : 'raushan8676';
    $twitterUser = $profile->twitter_url ? basename(rtrim($profile->twitter_url, '/')) : 'raushan_dev';

    $socials = [];
    if (!empty($profile->github_url)) {
        $socials[] = [
            'name' => 'GitHub',
            'url' => $profile->github_url,
            'image' => 'images/icons/github.png',
            'cdn' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg',
            'handle' => '@' . $githubUser
        ];
    }
    if (!empty($profile->linkedin_url)) {
        $socials[] = [
            'name' => 'LinkedIn',
            'url' => $profile->linkedin_url,
            'image' => 'images/icons/linkedin.png',
            'cdn' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linkedin/linkedin-original.svg',
            'handle' => 'LinkedIn Profile'
        ];
    }
    if (!empty($profile->twitter_url)) {
        $socials[] = [
            'name' => 'Twitter / X',
            'url' => $profile->twitter_url,
            'image' => 'images/icons/x.png',
            'cdn' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/twitter/twitter-original.svg',
            'handle' => '@' . $twitterUser
        ];
    }
    if (!empty($profile->email)) {
        $socials[] = [
            'name' => 'Email',
            'url' => 'mailto:' . $profile->email,
            'image' => 'images/icons/email.png',
            'cdn' => 'https://cdn-icons-png.flaticon.com/512/732/732200.png',
            'handle' => $profile->email
        ];
    }

    $faqs = [
        [
            'q' => 'What type of projects do you work on?',
            'a' => 'I build full-stack web applications, custom Laravel backend APIs, interactive React SPAs, e-commerce stores, and enterprise merchant/KYC pipelines.'
        ],
        [
            'q' => 'Are you open to full-time roles or internships?',
            'a' => 'Yes! I am actively looking for software developer opportunities, remote positions, and collaborative tech roles.'
        ],
        [
            'q' => 'What is your preferred tech stack?',
            'a' => 'My primary stack consists of Laravel, PHP, MySQL, JavaScript, React, and Tailwind CSS, along with Git, Postman, and RESTful APIs.'
        ]
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Contact Me | Raushan Kumar - Full Stack Developer</title>
        <meta name="description" content="Get in touch with Raushan Kumar for web development projects, full-stack roles, or technical collaborations.">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

        <script>
            // Initialize theme before rendering to avoid flash
            (function() {
                const theme = localStorage.getItem('theme') || 'dark';
                if (theme === 'light') {
                    document.documentElement.classList.add('light');
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                    document.documentElement.classList.remove('light');
                }
            })();
        </script>

        @fonts

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-[#070c18] text-slate-100 min-h-screen antialiased selection:bg-sky-500 selection:text-white flex flex-col justify-between">
        
        <!-- Header -->
        @include('includes.header')

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Hero Banner -->
            <section class="relative py-16 lg:py-20 overflow-hidden border-b border-slate-800/50">
                <!-- Ambient Glow -->
                <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse"></div>
                <div class="absolute bottom-5 right-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    
                    <!-- Breadcrumbs -->
                    <div class="flex items-center gap-2 mb-6">
                        <a href="{{ route('home') }}" class="text-xs font-semibold text-sky-400 hover:text-sky-300 transition-colors flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            Home
                        </a>
                        <span class="text-slate-600">/</span>
                        <span class="text-xs font-semibold text-slate-300">Contact</span>
                    </div>

                    <!-- Heading -->
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/80 border border-slate-700/60 text-xs font-medium text-sky-400 mb-4 shadow-inner">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>📬 Let's Start a Conversation</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                            Get In <span class="text-sky-400">Touch</span>
                        </h1>
                        <p class="mt-4 text-slate-400 text-sm sm:text-base leading-relaxed">
                            Have a project in mind, an opportunity to discuss, or just want to say hi? Send me a message using the form below or connect via direct channels.
                        </p>
                    </div>

                </div>
            </section>

            <!-- Main Contact Section -->
            <section class="py-16 lg:py-24 bg-[#070c18] relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                        
                        <!-- Left: Contact Details & Status Cards -->
                        <div class="lg:col-span-5 space-y-6">
                            
                            <!-- Direct Channels Card -->
                            <div class="rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm p-7 sm:p-8 shadow-xl space-y-6">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-sky-400 border-b border-slate-800/80 pb-3">
                                    Contact Channels
                                </h3>

                                <!-- Email -->
                                @if($profile->email)
                                <a href="mailto:{{ $profile->email }}" class="flex items-center space-x-4 group">
                                    <div class="w-12 h-12 rounded-xl bg-blue-600/15 border border-blue-500/30 flex items-center justify-center text-sky-400 group-hover:scale-110 group-hover:bg-blue-600/25 transition-all duration-200 shadow-inner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Email Address</p>
                                        <h4 class="text-sm sm:text-base font-semibold text-slate-200 group-hover:text-white transition-colors">
                                            {{ $profile->email }}
                                        </h4>
                                    </div>
                                </a>
                                @endif

                                <!-- Phone -->
                                @if($profile->phone)
                                <a href="tel:{{ $profile->phone }}" class="flex items-center space-x-4 group">
                                    <div class="w-12 h-12 rounded-xl bg-indigo-600/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 group-hover:scale-110 group-hover:bg-indigo-600/25 transition-all duration-200 shadow-inner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Phone Number</p>
                                        <h4 class="text-sm sm:text-base font-semibold text-slate-200 group-hover:text-white transition-colors">
                                            {{ $profile->phone }}
                                        </h4>
                                    </div>
                                </a>
                                @endif

                                <!-- Location -->
                                @if($profile->location)
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-xl bg-emerald-600/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-inner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Current Location</p>
                                        <h4 class="text-sm sm:text-base font-semibold text-slate-200">
                                            {{ $profile->location }}
                                        </h4>
                                    </div>
                                </div>
                                @endif

                            </div>

                            <!-- Availability & Response Time Card -->
                            <div class="rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm p-6 shadow-xl space-y-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Currently Available</span>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-300">
                                    Open for full-time engineering roles, freelance contracts, and software development projects.
                                </p>
                                <div class="pt-2 flex items-center gap-2 text-xs text-slate-400">
                                    <span>⚡ Typical reply time: <strong>Under 24 hours</strong></span>
                                </div>
                            </div>

                            <!-- Social Links Card -->
                            <div class="rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm p-6 shadow-xl">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">
                                    Connect on Social Media
                                </h4>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach($socials as $social)
                                        <a href="{{ $social['url'] }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer" 
                                           class="flex items-center space-x-3 p-2.5 rounded-xl bg-slate-800/50 border border-slate-800 hover:border-sky-500/50 hover:bg-slate-800 transition-all group">
                                            <div class="w-7 h-7 rounded-lg bg-slate-900 p-1 flex items-center justify-center flex-shrink-0">
                                                <img src="{{ asset($social['image']) }}" 
                                                     alt="{{ $social['name'] }}" 
                                                     class="w-full h-full object-contain filter brightness-90 group-hover:brightness-100"
                                                     onerror="this.onerror=null; this.src='{{ $social['cdn'] }}';">
                                            </div>
                                            <span class="text-xs font-medium text-slate-300 group-hover:text-white truncate">
                                                {{ $social['name'] }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <!-- Right: Interactive Contact Form -->
                        <div class="lg:col-span-7">
                            <div class="rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm p-7 sm:p-10 shadow-xl relative">
                                
                                <h3 class="text-2xl font-bold text-white mb-2">
                                    Send a Message
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-400 mb-8 leading-relaxed">
                                    Fill out the form below and I'll get back to you as soon as possible.
                                </p>

                                <!-- Success Alert (Hidden by default) -->
                                <div id="form-success-alert" class="hidden mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-800/70 text-emerald-300 text-xs sm:text-sm flex items-center space-x-3 animate-fade-in">
                                    <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Thank you! Your message has been sent successfully. I'll get back to you shortly.</span>
                                </div>

                                <form id="contact-page-form" action="#" method="POST" class="space-y-5">
                                    @csrf
                                    
                                    <!-- Row: Name and Email -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="name" class="block text-xs font-semibold text-slate-300 mb-1.5">Your Name</label>
                                            <input type="text" 
                                                   id="name"
                                                   name="name" 
                                                   placeholder="John Doe" 
                                                   required
                                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-900/80 border border-slate-800 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500/30 transition-all duration-200">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">Your Email</label>
                                            <input type="email" 
                                                   id="email"
                                                   name="email" 
                                                   placeholder="john@example.com" 
                                                   required
                                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-900/80 border border-slate-800 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500/30 transition-all duration-200">
                                        </div>
                                    </div>

                                    <!-- Subject / Topic -->
                                    <div>
                                        <label for="subject" class="block text-xs font-semibold text-slate-300 mb-1.5">Subject / Topic</label>
                                        <input type="text" 
                                               id="subject"
                                               name="subject" 
                                               placeholder="Project Inquiry / Job Opportunity / Feedback" 
                                               required
                                               class="w-full px-4 py-3.5 rounded-xl bg-slate-900/80 border border-slate-800 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500/30 transition-all duration-200">
                                    </div>

                                    <!-- Message Textarea -->
                                    <div>
                                        <label for="message" class="block text-xs font-semibold text-slate-300 mb-1.5">Your Message</label>
                                        <textarea id="message"
                                                  name="message" 
                                                  rows="5" 
                                                  placeholder="Tell me about your project, timeline, or question..." 
                                                  required
                                                  class="w-full px-4 py-3.5 rounded-xl bg-slate-900/80 border border-slate-800 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500/30 transition-all duration-200 resize-none"></textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div>
                                        <button type="submit" 
                                                id="contact-submit-btn"
                                                class="w-full py-4 px-6 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-500 hover:from-blue-700 hover:via-indigo-700 hover:to-sky-600 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 active:scale-[0.99] transition-all duration-200 flex items-center justify-center space-x-2 cursor-pointer">
                                            <svg class="w-4 h-4 transform rotate-45 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                            </svg>
                                            <span>Send Message</span>
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <!-- FAQ Section -->
            <section class="py-16 lg:py-20 bg-[#060a14] border-t border-slate-800/60 relative">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center mb-12">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                            Frequently Asked <span class="text-sky-400">Questions</span>
                        </h2>
                    </div>

                    <div class="space-y-4">
                        @foreach($faqs as $faq)
                            <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm">
                                <h3 class="text-base font-bold text-white mb-2">
                                    {{ $faq['q'] }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                                    {{ $faq['a'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>

        <!-- Form Handling Script -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const contactForm = document.getElementById('contact-page-form');
                const successAlert = document.getElementById('form-success-alert');
                const submitBtn = document.getElementById('contact-submit-btn');

                if (contactForm) {
                    contactForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<span>Sending...</span>';
                        }

                        // Simulate smooth submission
                        setTimeout(() => {
                            if (successAlert) {
                                successAlert.classList.remove('hidden');
                            }
                            contactForm.reset();
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = '<svg class="w-4 h-4 transform rotate-45 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg><span>Send Message</span>';
                            }
                        }, 600);
                    });
                }
            });
        </script>

        <!-- Floating Back to Top Button -->
        <a href="#main-header" 
           id="back-to-top"
           title="Back to Top"
           class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/35 hover:bg-blue-500 hover:scale-110 active:scale-95 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </a>

        <!-- Footer -->
        @include('includes.footer')

    </body>
</html>
