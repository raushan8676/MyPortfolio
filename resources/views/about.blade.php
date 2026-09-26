@php
    $profile = $profile ?? \App\Models\ProfileSetting::first() ?? new \App\Models\ProfileSetting();
    $dbEducations = $educations ?? \App\Models\Education::orderBy('sort_order')->get();
    $dbExperiences = $experiences ?? \App\Models\Experience::orderBy('sort_order')->get();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>About Me | {{ $profile->full_name ?? 'Raushan Kumar' }} - {{ $profile->title ?? 'Full Stack Developer' }}</title>
        <meta name="description" content="Learn more about {{ $profile->full_name ?? 'Raushan Kumar' }}, {{ $profile->title ?? 'Full Stack Developer' }}.">

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

        <!-- Main About Page Content -->
        <main class="flex-grow">
            <!-- Hero / Banner Section -->
            <section class="relative py-16 lg:py-24 overflow-hidden border-b border-slate-800/50">
                <!-- Ambient Glow Effects -->
                <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse"></div>
                <div class="absolute bottom-5 right-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    
                    <!-- Breadcrumbs & Badge -->
                    <div class="flex flex-wrap items-center gap-3 mb-8">
                        <a href="{{ url('/') }}" class="text-xs font-semibold text-sky-400 hover:text-sky-300 transition-colors flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            Back to Home
                        </a>
                        <span class="text-slate-600">/</span>
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900/80 border border-slate-700/60 text-xs font-medium text-slate-300 shadow-inner">
                            <span class="w-2 h-2 rounded-full {{ $profile->is_available_for_hire ? 'bg-emerald-400 animate-ping' : 'bg-slate-500' }}"></span>
                            {{ $profile->is_available_for_hire ? 'Available for Opportunities' : 'Currently Engaged' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                        
                        <!-- Left: Portrait & Fast Facts Card -->
                        <div class="lg:col-span-5 flex flex-col items-center lg:items-start">
                            <div class="relative w-full max-w-sm sm:max-w-md group">
                                
                                <!-- Floating "Always Learning" Doodle -->
                                <div class="absolute top-4 left-4 z-20 select-none">
                                    <p class="font-serif italic text-sm sm:text-base font-semibold text-slate-200 tracking-wide drop-shadow-md">
                                        Always<br>Learning
                                    </p>
                                    <svg class="w-8 h-8 text-sky-400 mt-0.5 ml-2 transform -rotate-12" viewBox="0 0 50 50" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 10 Q 18 35 38 40" />
                                        <path d="M28 40 L 38 40 L 38 30" />
                                    </svg>
                                </div>

                                <!-- Photo Frame -->
                                <div class="relative rounded-2xl bg-gradient-to-b from-slate-800/40 via-slate-900/60 to-slate-950/80 border border-slate-700/60 p-2.5 shadow-2xl backdrop-blur-sm overflow-hidden group-hover:border-sky-500/40 transition-all duration-300">
                                    <div class="rounded-xl overflow-hidden bg-slate-900 aspect-[4/4.4] relative">
                                        <img src="{{ $profile->about_image_url ? asset($profile->about_image_url) : ($profile->avatar_url ? asset($profile->avatar_url) : asset('images/about.jpg')) }}" 
                                             alt="{{ $profile->full_name ?? 'Raushan Kumar' }}" 
                                             class="w-full h-full object-cover object-center filter brightness-95 group-hover:scale-105 group-hover:brightness-100 transition-all duration-500"
                                             onerror="this.onerror=null; this.src='{{ asset('images/about.jpg') }}';">
                                        <div class="absolute inset-0 bg-gradient-to-t from-[#070c18]/80 via-transparent to-transparent opacity-60"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fast Facts Card -->
                            <div class="mt-8 w-full max-w-sm sm:max-w-md rounded-2xl bg-slate-900/60 border border-slate-800/80 p-6 backdrop-blur-sm shadow-xl space-y-4">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-sky-400 border-b border-slate-800/80 pb-3">
                                    Quick Overview
                                </h3>
                                
                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-slate-400">Full Name</span>
                                    <span class="font-semibold text-slate-200">{{ $profile->full_name ?? 'Raushan Kumar' }}</span>
                                </div>

                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-slate-400">Location</span>
                                    <span class="font-semibold text-slate-200">{{ $profile->location ?? 'Bihar, India' }}</span>
                                </div>

                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-slate-400">Email</span>
                                    <span class="font-semibold text-slate-200">{{ $profile->email }}</span>
                                </div>

                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-slate-400">Years Experience</span>
                                    <span class="font-semibold text-sky-400">{{ $profile->years_experience ?? 1 }}+ Years</span>
                                </div>

                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-slate-400">Projects Built</span>
                                    <span class="font-semibold text-slate-200">{{ $profile->projects_completed ?? 4 }}+</span>
                                </div>
                            </div>

                        </div>

                        <!-- Right: Story, Background & Expertise -->
                        <div class="lg:col-span-7 flex flex-col justify-center">
                            
                            <!-- Main Heading -->
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                                Hello! I'm <span class="text-sky-400">{{ $profile->full_name ?? 'Raushan Kumar' }}</span>
                            </h1>
                            <p class="text-lg sm:text-xl font-medium text-slate-300 mt-2">
                                {{ $profile->title ?? 'Full-Stack Developer & Software Engineer' }}
                            </p>

                            <!-- Detailed Narrative Bio -->
                            <div class="mt-6 space-y-4 text-slate-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                                {{ $profile->bio_full ?? $profile->bio_summary }}
                            </div>

                            <!-- Small Resume Preview Card & Actions -->
                            @php
                                $aboutResumeLink = $profile->resume_url ?: ($profile->resume_file ? (str_starts_with($profile->resume_file, 'http') ? $profile->resume_file : asset($profile->resume_file)) : null);
                                if ($aboutResumeLink && !str_starts_with($aboutResumeLink, 'http') && !str_starts_with($aboutResumeLink, '/')) {
                                    $aboutResumeLink = asset($aboutResumeLink);
                                }
                            @endphp
                            @if($aboutResumeLink)
                            <div class="mt-8 p-4 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-lg group hover:border-sky-500/40 transition-all duration-300">
                                
                                <!-- Left: Mini Document Info -->
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-11 h-11 rounded-xl bg-red-500/10 border border-red-500/25 flex items-center justify-center text-red-400 flex-shrink-0 group-hover:scale-105 transition-transform">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M7 2a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V8l-6-6H7zm7 1.5L18.5 8H14V3.5zM8.5 13.5h7a.75.75 0 010 1.5h-7a.75.75 0 010-1.5zm0 3h5a.75.75 0 010 1.5h-5a.75.75 0 010-1.5zM8.5 10.5h3a.75.75 0 010 1.5h-3a.75.75 0 010-1.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm font-bold text-slate-100 group-hover:text-white">Curriculum Vitae</h4>
                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-red-500/10 text-red-400 border border-red-500/20">PDF</span>
                                        </div>
                                        <p class="text-xs text-slate-400 mt-0.5">Raushan Kumar • Full Stack Resume</p>
                                    </div>
                                </div>

                                <!-- Right: Preview & Download Actions -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <!-- Quick Preview Modal Button -->
                                    <button type="button" 
                                            onclick="openResumeModal('{{ $aboutResumeLink }}')" 
                                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-sky-400 bg-sky-950/60 border border-sky-800/60 hover:bg-sky-900/60 hover:text-sky-300 active:scale-95 transition-all cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Preview</span>
                                    </button>

                                    <!-- View in New Tab -->
                                    <a href="{{ $aboutResumeLink }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 bg-slate-800/80 border border-slate-700/70 hover:bg-slate-700 hover:text-white active:scale-95 transition-all">
                                        <span>Open in Tab</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                        </svg>
                                    </a>

                                    <!-- Download Resume Button -->
                                    <a href="{{ $aboutResumeLink }}" 
                                       download="Raushan_Kumar_Resume.pdf"
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-gradient-to-r from-blue-500 to-sky-500 hover:from-blue-600 hover:to-sky-400 shadow-md shadow-blue-500/20 active:scale-95 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        <span>Download</span>
                                    </a>
                                </div>

                            </div>
                            @endif

                            <div class="mt-4 flex items-center">
                                <a href="{{ url('/#contact') }}" 
                                   class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-xs sm:text-sm font-semibold text-slate-200 bg-slate-900/70 border border-slate-700/80 hover:bg-slate-800 hover:text-white hover:border-slate-500 active:scale-95 transition-all duration-200">
                                    Get In Touch
                                </a>
                            </div>

                            <!-- Key Highlight Metrics -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-10 pt-8 border-t border-slate-800/80">
                                <div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800/80 text-center">
                                    <p class="text-2xl font-black text-sky-400">{{ $profile->years_experience ?? 1 }}+</p>
                                    <p class="text-xs text-slate-400 mt-1">Years Exp</p>
                                </div>

                                <div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800/80 text-center">
                                    <p class="text-2xl font-black text-sky-400">12+</p>
                                    <p class="text-xs text-slate-400 mt-1">Tech Skills</p>
                                </div>

                                <div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800/80 text-center">
                                    <p class="text-2xl font-black text-sky-400">{{ $profile->projects_completed ?? 4 }}+</p>
                                    <p class="text-xs text-slate-400 mt-1">Major Projects</p>
                                </div>

                                <div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800/80 text-center">
                                    <p class="text-2xl font-black text-sky-400">100%</p>
                                    <p class="text-xs text-slate-400 mt-1">Dedication</p>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </section>


            <!-- Education & Experience Timeline -->
            <section class="py-20 lg:py-24 bg-[#070c18] border-b border-slate-800/50 relative">
                <!-- Subtle Background Lighting -->
                <div class="absolute top-1/2 left-10 -translate-y-1/2 w-80 h-80 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
                <div class="absolute bottom-5 right-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    
                    <div class="text-center max-w-2xl mx-auto mb-16">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-slate-900/90 border border-sky-500/30 text-xs font-semibold text-sky-400 mb-3 shadow-[0_0_15px_rgba(56,189,248,0.12)]">
                            <span>Academic &amp; Professional</span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                            Education &amp; <span class="text-sky-400">Experience</span>
                        </h2>
                        <p class="mt-3 text-slate-400 text-sm sm:text-base">
                            My academic background and professional journey in software engineering.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                        @php
                            $topEdu = $dbEducations->first();
                            $topExp = $dbExperiences->first();

                            // Education Data Processing
                            $eduDegree = $topEdu ? $topEdu->degree : 'Bachelor of Technology (B.Tech)';
                            $eduInst = $topEdu ? $topEdu->institution : 'Dr C V Raman University';
                            $eduLoc = $topEdu ? ($topEdu->location ?? 'Vaishali, Bihar, India') : 'Vaishali, Bihar, India';
                            $eduPeriod = $topEdu ? ($topEdu->start_year . ' – ' . ($topEdu->end_year ?? 'Present')) : '2023 – 2027';
                            $eduGrade = $topEdu ? ($topEdu->grade_or_score ?? '7.90 CGPA') : null;
                            
                            $eduPoints = [];
                            if ($topEdu && is_array($topEdu->highlights) && count($topEdu->highlights) > 0) {
                                $eduPoints = $topEdu->highlights;
                            } elseif ($topEdu && is_array($topEdu->courses) && count($topEdu->courses) > 0) {
                                foreach (array_slice($topEdu->courses, 0, 4) as $c) {
                                    $eduPoints[] = is_array($c) ? ($c['name'] ?? '') : $c;
                                }
                            }
                            if (empty($eduPoints)) {
                                $eduPoints = [
                                    'Data Structures & Algorithms (DSA)',
                                    'Database Management Systems (DBMS & SQL)',
                                    'Object-Oriented Programming (OOP & Design Patterns)',
                                    'Full-Stack Web Technologies & REST APIs'
                                ];
                            }

                            // Experience Data Processing
                            $expRole = $topExp ? $topExp->role : 'Software Developer Trainee';
                            $expComp = $topExp ? $topExp->company : 'DataAegis Software Private Limited';
                            $expStartDate = $topExp ? trim($topExp->start_date ?? '') : '';
                            $expStartDate = ucwords(preg_replace('/\s*,\s*/', ' ', $expStartDate));
                            $expEndDate = $topExp ? trim($topExp->end_date ?? 'Present') : 'Present';
                            $expPeriod = !empty($expStartDate) ? ($expStartDate . ' – ' . $expEndDate) : ($topExp->period ?? '2024 – Present');
                            $expType = $topExp ? ($topExp->employment_type ?? $topExp->type ?? 'Internship') : 'Internship';

                            $expPoints = [];
                            if ($topExp && is_array($topExp->responsibilities) && count($topExp->responsibilities) > 0) {
                                $expPoints = $topExp->responsibilities;
                            } elseif ($topExp && !empty($topExp->description)) {
                                $lines = preg_split('/[\r\n]+/', $topExp->description);
                                foreach ($lines as $l) {
                                    $clean = trim(ltrim($l, "•-*\t "));
                                    if (!empty($clean) && !str_starts_with(strtolower($clean), 'my responsibilit')) {
                                        $expPoints[] = $clean;
                                    }
                                }
                            }
                            if (empty($expPoints)) {
                                $expPoints = [
                                    'Develop and maintain web application features using Laravel, PHP & JavaScript',
                                    'Build responsive and user-friendly interfaces with React & Tailwind CSS',
                                    'Design and optimize MySQL database schemas, queries, and relations',
                                    'Work on real-world merchant onboarding and KYC management workflows'
                                ];
                            }
                        @endphp
                        
                        <!-- Education Card -->
                        <div class="rounded-3xl bg-slate-900/70 border border-slate-800/80 p-7 sm:p-8 backdrop-blur-md shadow-xl hover:border-indigo-500/40 hover:shadow-2xl hover:shadow-indigo-500/5 transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <!-- Header: Icon, Badge & Title -->
                                <div class="flex items-start space-x-4 mb-6">
                                    <div class="w-13 h-13 rounded-2xl bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 shadow-inner group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 002 10.057a.75.75 0 01-.23-1.337A60.653 60.653 0 0111.7 2.805z" />
                                            <path d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 0110.94 15.47a2.25 2.25 0 002.12 0z" />
                                        </svg>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                            Academic Education
                                        </span>
                                        <h3 class="text-lg sm:text-xl font-bold text-white group-hover:text-indigo-300 transition-colors">
                                            {{ $eduDegree }}
                                        </h3>
                                        <p class="text-xs sm:text-sm font-semibold text-slate-300">
                                            {{ $eduInst }} <span class="text-slate-500 font-normal">({{ $eduLoc }})</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Metadata Chips -->
                                <div class="flex flex-wrap items-center gap-2 pb-5 border-b border-slate-800/80">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-medium bg-slate-800/80 border border-slate-700/60 text-slate-300">
                                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/></svg>
                                        {{ $eduPeriod }}
                                    </span>
                                    @if($eduGrade)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-semibold bg-emerald-500/10 border border-emerald-500/30 text-emerald-400">
                                            CGPA: {{ $eduGrade }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Description Summary -->
                                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed py-4">
                                    {{ $topEdu && $topEdu->description ? $topEdu->description : 'Specializing in core computer science, software engineering, relational databases, data structures & algorithms, and modern full-stack web technologies.' }}
                                </p>

                                <!-- Core Focus Areas List -->
                                <div class="space-y-2.5 pb-6">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Key Coursework &amp; Competencies:</h4>
                                    @foreach(array_slice($eduPoints, 0, 4) as $point)
                                        <div class="flex items-start space-x-2.5 text-xs sm:text-sm text-slate-300">
                                            <div class="w-4 h-4 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                            </div>
                                            <span>{{ $point }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Footer Link -->
                            <div class="pt-4 border-t border-slate-800/80">
                                <a href="{{ route('education') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-indigo-400 hover:text-indigo-300 transition-colors group/link">
                                    <span>View Full Academic Details</span>
                                    <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Professional Traineeship Card -->
                        <div class="rounded-3xl bg-slate-900/70 border border-slate-800/80 p-7 sm:p-8 backdrop-blur-md shadow-xl hover:border-sky-500/40 hover:shadow-2xl hover:shadow-sky-500/5 transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <!-- Header: Icon, Badge & Title -->
                                <div class="flex items-start space-x-4 mb-6">
                                    <div class="w-13 h-13 rounded-2xl bg-sky-500/15 border border-sky-500/30 flex items-center justify-center text-sky-400 shadow-inner group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-sky-500/10 text-sky-400 border border-sky-500/20">
                                            Industry Experience
                                        </span>
                                        <h3 class="text-lg sm:text-xl font-bold text-white group-hover:text-sky-300 transition-colors">
                                            {{ $expRole }}
                                        </h3>
                                        <p class="text-xs sm:text-sm font-semibold text-slate-300">
                                            {{ $expComp }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Metadata Chips -->
                                <div class="flex flex-wrap items-center gap-2 pb-5 border-b border-slate-800/80">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-medium bg-slate-800/80 border border-slate-700/60 text-slate-300">
                                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/></svg>
                                        {{ $expPeriod }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-semibold bg-sky-500/10 border border-sky-500/30 text-sky-300">
                                        {{ $expType }}
                                    </span>
                                    @php
                                        $topExpCert = $topExp ? $topExp->certificate_url : null;
                                        if ($topExpCert && !str_starts_with($topExpCert, 'http') && !str_starts_with($topExpCert, '/')) {
                                            $topExpCert = asset($topExpCert);
                                        }
                                    @endphp
                                    @if($topExpCert)
                                        <a href="{{ $topExpCert }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 transition-colors">
                                            <span>📜 View Certificate</span>
                                            <svg class="w-3 h-3 text-amber-400/80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                        </a>
                                    @endif
                                </div>

                                <!-- Description Summary -->
                                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed py-4">
                                    Actively contributing to enterprise web platforms, merchant registration, and KYC verification pipelines using Laravel, PHP, MySQL, and modern JavaScript tools.
                                </p>

                                <!-- Responsibilities List -->
                                <div class="space-y-2.5 pb-6">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Core Responsibilities &amp; Impact:</h4>
                                    @foreach(array_slice($expPoints, 0, 4) as $point)
                                        <div class="flex items-start space-x-2.5 text-xs sm:text-sm text-slate-300">
                                            <div class="w-4 h-4 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                            </div>
                                            <span>{{ $point }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Footer Link -->
                            <div class="pt-4 border-t border-slate-800/80">
                                <a href="{{ route('experience') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-sky-400 hover:text-sky-300 transition-colors group/link">
                                    <span>View Full Experience Timeline</span>
                                    <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <!-- What Drives Me / Core Philosophy Section -->
            <section class="py-20 lg:py-24 bg-[#060a14] relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    
                    <div class="text-center max-w-2xl mx-auto mb-16">
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                            My Principles &amp; <span class="text-sky-400">Work Ethic</span>
                        </h2>
                        <p class="mt-3 text-slate-400 text-sm sm:text-base">
                            The standards and values I bring to every line of code and project.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <!-- Value 1 -->
                        <div class="p-8 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                            <div class="w-12 h-12 rounded-xl bg-sky-500/15 border border-sky-500/30 flex items-center justify-center text-sky-400 mb-6 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Clean &amp; Maintainable Code</h3>
                            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                                I prioritize writing readable, scalable, and modular code that adheres to industry design patterns and MVC standards.
                            </p>
                        </div>

                        <!-- Value 2 -->
                        <div class="p-8 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                            <div class="w-12 h-12 rounded-xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-400 mb-6 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Rapid Problem Solving</h3>
                            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                                Whether debugging API responses or optimizing frontend rendering, I enjoy untangling complex logic and solving challenges efficiently.
                            </p>
                        </div>

                        <!-- Value 3 -->
                        <div class="p-8 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                            <div class="w-12 h-12 rounded-xl bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 mb-6 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Continuous Evolution</h3>
                            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                                Technology never stands still, and neither do I. I actively explore new tools, modern libraries, and optimal architectural approaches.
                            </p>
                        </div>

                    </div>

                </div>
            </section>

            <!-- CTA Banner -->
            <section class="py-16 bg-gradient-to-r from-blue-900/40 via-indigo-900/30 to-sky-900/40 border-t border-b border-slate-800/60 relative overflow-hidden">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                        Interested in collaborating or hiring?
                    </h2>
                    <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-xl mx-auto">
                        I am always open to discussing new web development projects, creative ideas, or opportunities to be part of your vision.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4 mt-8">
                        <a href="{{ url('/#contact') }}" 
                           class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-blue-500 via-indigo-500 to-sky-400 hover:from-blue-600 hover:via-indigo-600 hover:to-sky-500 shadow-lg shadow-blue-500/25 active:scale-95 transition-all duration-200">
                            <span>Get in Touch</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <a href="{{ url('/#projects') }}" 
                           class="inline-flex items-center justify-center px-8 py-3.5 rounded-full text-sm font-semibold text-slate-200 bg-slate-900/80 border border-slate-700/80 hover:bg-slate-800 hover:text-white transition-all duration-200">
                            Explore Projects
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        @include('includes.footer')

        <!-- Reusable Resume Preview Modal -->
        <div id="resumePreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-6 bg-black/80 backdrop-blur-md transition-opacity duration-300">
            <div class="relative w-full max-w-4xl h-[90vh] sm:h-[85vh] bg-slate-900 border border-slate-700/80 rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-800 bg-slate-950/80">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-lg bg-red-500/15 border border-red-500/30 flex items-center justify-center text-red-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M7 2a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V8l-6-6H7zm7 1.5L18.5 8H14V3.5z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white leading-tight">Resume Preview</h3>
                            <p class="text-[11px] text-slate-400">Raushan Kumar • Curriculum Vitae</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a id="modalResumeNewTab" href="#" target="_blank" rel="noopener noreferrer" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-300 bg-slate-800 hover:bg-slate-700 hover:text-white transition-colors">
                            <span>Open in Tab</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        </a>
                        <a id="modalResumeDownload" href="#" download="Raushan_Kumar_Resume.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-sky-600 hover:bg-sky-500 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            <span>Download</span>
                        </a>
                        <button type="button" onclick="closeResumeModal()" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-red-500/20 hover:text-red-400 text-slate-400 flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Iframe Container -->
                <div class="flex-1 w-full h-full bg-slate-950 relative">
                    <iframe id="resumeModalIframe" src="" class="w-full h-full border-0" title="Resume Preview"></iframe>
                </div>

            </div>
        </div>

        <script>
            function openResumeModal(url) {
                const modal = document.getElementById('resumePreviewModal');
                const iframe = document.getElementById('resumeModalIframe');
                const tabLink = document.getElementById('modalResumeNewTab');
                const downloadLink = document.getElementById('modalResumeDownload');

                if (modal && iframe) {
                    iframe.src = url;
                    if (tabLink) tabLink.href = url;
                    if (downloadLink) downloadLink.href = url;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeResumeModal() {
                const modal = document.getElementById('resumePreviewModal');
                const iframe = document.getElementById('resumeModalIframe');
                if (modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    if (iframe) iframe.src = '';
                    document.body.style.overflow = '';
                }
            }

            // Close on backdrop click & ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeResumeModal();
            });
            document.getElementById('resumePreviewModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeResumeModal();
            });
        </script>

    </body>
</html>
