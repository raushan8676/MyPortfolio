@php
    $profile = $profile ?? \App\Models\ProfileSetting::first() ?? new \App\Models\ProfileSetting();
@endphp

<section id="home" class="relative min-h-[calc(100vh-5rem)] flex items-center justify-center bg-[#070c18] overflow-hidden py-16 lg:py-24">
    <!-- Ambient Background Lighting / Glow Effects -->
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Left Column: Content -->
            <div class="lg:col-span-7 flex flex-col items-start text-left">
                
                <!-- Greeting Badge -->
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-slate-900/90 border border-slate-700/60 shadow-inner backdrop-blur-md mb-6">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-sky-500/20 text-sky-400 text-xs">
                        <!-- Bot/Greeting Icon -->
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a2 2 0 012 2c0 .74-.4 1.38-1 1.72V7h2a5 5 0 015 5v1h1a2 2 0 012 2v3a2 2 0 01-2 2h-1v1a5 5 0 01-5 5H9a5 5 0 01-5-5v-1H3a2 2 0 01-2-2v-3a2 2 0 012-2h1v-1a5 5 0 015-5h2V5.72A2.002 2.002 0 0110 4a2 2 0 012-2zm-3 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/>
                        </svg>
                    </span>
                    <span class="text-xs font-semibold text-slate-200 tracking-wide">{{ $profile->tagline ?? "Hello, I'm" }}</span>
                    @if($profile->is_available_for_hire)
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-bold text-emerald-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Available for Hire
                        </span>
                    @endif
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-none">
                    @php
                        $nameParts = explode(' ', $profile->full_name ?? 'Raushan Kumar');
                        $firstName = $nameParts[0] ?? 'Raushan';
                        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
                    @endphp
                    {{ $firstName }} @if($lastName)<span class="text-sky-400">{{ $lastName }}</span>@endif
                </h1>

                <!-- Subtitle / Role -->
                <h2 class="text-xl sm:text-2xl font-bold text-slate-200 tracking-tight mt-3">
                    {{ $profile->title ?? 'Full Stack Web Developer' }}
                </h2>

                <!-- Short Bio -->
                <p class="mt-4 text-slate-400 text-base sm:text-lg leading-relaxed max-w-xl">
                    {{ $profile->bio_summary ?? 'I build modern, responsive and user-friendly web applications using React, Laravel, PHP and more. I love solving problems and turning ideas into real products.' }}
                </p>

                <!-- Call to Action Buttons -->
                <div class="flex flex-wrap items-center gap-4 mt-8">
                    <!-- Primary Button: View Projects -->
                    <a href="#projects" 
                       class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-blue-500 via-indigo-500 to-sky-400 hover:from-blue-600 hover:via-indigo-600 hover:to-sky-500 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        <span>View My Projects</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>

                    <!-- Secondary Button: Contact Me -->
                    <a href="#contact" 
                       class="inline-flex items-center justify-center px-7 py-3.5 rounded-full text-sm font-semibold text-slate-200 bg-slate-900/70 border border-slate-700/80 hover:bg-slate-800 hover:text-white hover:border-slate-500 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        Contact Me
                    </a>
                </div>

                <!-- Social Media Links -->
                <div class="flex items-center space-x-6 mt-10">
                    <!-- GitHub -->
                    @if($profile->github_url)
                    <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" 
                       title="GitHub" 
                       class="text-slate-400 hover:text-white hover:scale-110 active:scale-95 transition-all duration-200">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                        </svg>
                    </a>
                    @endif

                    <!-- LinkedIn -->
                    @if($profile->linkedin_url)
                    <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer" 
                       title="LinkedIn" 
                       class="text-slate-400 hover:text-white hover:scale-110 active:scale-95 transition-all duration-200">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.2V10.9H6.46M7.83 6.45a1.64 1.64 0 1 0 0 3.28 1.64 1.64 0 0 0 0-3.28z"/>
                        </svg>
                    </a>
                    @endif

                    <!-- X (Twitter) -->
                    @if($profile->twitter_url)
                    <a href="{{ $profile->twitter_url }}" target="_blank" rel="noopener noreferrer" 
                       title="X" 
                       class="text-slate-400 hover:text-white hover:scale-110 active:scale-95 transition-all duration-200">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    @endif

                    <!-- Email -->
                    <a href="mailto:{{ $profile->email ?? 'contact@raushankumar.com' }}" 
                       title="Send Email" 
                       class="text-slate-400 hover:text-white hover:scale-110 active:scale-95 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right Column: Profile Image & Creative Backdrop -->
            <div class="lg:col-span-5 relative flex items-center justify-center lg:justify-end">
                
                <!-- Floating Handwritten Tagline: "Code Build Grow" -->
                <div class="absolute -top-6 right-2 sm:right-6 lg:-right-4 z-20 select-none transform rotate-3">
                    <div class="text-right font-serif italic text-slate-300 space-y-0.5">
                        <p class="text-base sm:text-lg font-semibold tracking-wide text-sky-200/90 drop-shadow">Code</p>
                        <p class="text-base sm:text-lg font-semibold tracking-wide text-sky-200/90 drop-shadow">Build</p>
                        <p class="text-base sm:text-lg font-semibold tracking-wide text-sky-200/90 drop-shadow">Grow</p>
                    </div>
                    <!-- Hand-drawn style doodle underline -->
                    <svg class="w-14 h-4 text-sky-400 -mt-1 ml-auto" viewBox="0 0 100 25" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                        <path d="M5 12 Q 50 22 95 8 Q 65 24 25 18" />
                    </svg>
                </div>

                <!-- Organic Glowing Blue Blob Shape behind Avatar -->
                <div class="relative w-72 h-72 sm:w-88 sm:h-88 lg:w-96 lg:h-96 flex items-center justify-center">
                    
                    <!-- Gradient Fluid Shape -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 via-indigo-600 to-sky-400 rounded-[35%_65%_70%_30%/45%_45%_55%_55%] opacity-90 shadow-[0_0_80px_rgba(14,165,233,0.35)] transition-all duration-700 animate-[pulse_6s_ease-in-out_infinite]"></div>

                    <!-- Profile Image with Smooth Bottom Fade -->
                    <div class="relative w-full h-full flex items-end justify-center overflow-visible z-10">
                        <img src="{{ $profile->avatar_url ? asset($profile->avatar_url) : asset('images/profile.jpg') }}" 
                             alt="{{ $profile->full_name ?? 'Raushan Kumar' }}" 
                             class="w-[88%] sm:w-[92%] max-h-[110%] object-contain object-bottom drop-shadow-[0_20px_35px_rgba(0,0,0,0.6)] transform scale-105 transition-transform duration-300 hover:scale-110"
                             onerror="this.onerror=null; this.src='{{ asset('images/profile.jpg') }}';">
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

