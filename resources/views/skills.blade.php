@php
    $dbSkills = isset($skills) && count($skills) > 0 ? $skills : \App\Models\Skill::where('is_active', true)->orderBy('sort_order')->get();
    
    $categoryInfo = [
        'frontend' => [
            'name' => 'Frontend Development',
            'icon' => '<svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>',
            'description' => 'Building fast, responsive, and aesthetically pleasing client-side experiences.',
        ],
        'backend' => [
            'name' => 'Backend & APIs',
            'icon' => '<svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.73 7.47A4.5 4.5 0 019.27 6h5.46a4.5 4.5 0 013.54 1.47l2.08 2.78c.58.78.9 1.73.9 2.7" /></svg>',
            'description' => 'Architecting robust server-side applications, business logic, and secured APIs.',
        ],
        'database' => [
            'name' => 'Database & Storage',
            'icon' => '<svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" /></svg>',
            'description' => 'Designing clean relational schemas, queries, and persistent data layers.',
        ],
        'tools' => [
            'name' => 'Tools, DevOps & Collaboration',
            'icon' => '<svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.67 2.67 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233l2.846-2.847a4.5 4.5 0 00-6.364-6.364l-2.847 2.846" /></svg>',
            'description' => 'Version control, API validation, and development workflow automation.',
        ],
    ];

    $categories = [];
    foreach ($dbSkills->groupBy('category') as $catKey => $catSkills) {
        $meta = $categoryInfo[strtolower($catKey)] ?? [
            'name' => ucfirst($catKey),
            'icon' => '<svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>',
            'description' => 'Technical competencies and tools for ' . ucfirst($catKey) . ' engineering.',
        ];

        $skillList = [];
        foreach ($catSkills as $sk) {
            $imageSrc = '';
            if (!empty($sk->image)) {
                $imageSrc = (str_starts_with($sk->image, 'http') || str_starts_with($sk->image, '/')) ? $sk->image : asset($sk->image);
            }
            $cleanSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $sk->name));
            $cdnSrc = $sk->cdn_fallback ?: ($imageSrc ?: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/' . $cleanSlug . '/' . $cleanSlug . '-original.svg');
            
            $proficiency = $sk->proficiency ?: 80;
            $level = $sk->level ?: ($proficiency >= 85 ? 'Expert' : ($proficiency >= 70 ? 'Advanced' : 'Intermediate'));
            $levelColor = $sk->level_color ?: ($proficiency >= 85 ? 'text-sky-400 bg-sky-950/60 border-sky-800/60' : 'text-indigo-400 bg-indigo-950/60 border-indigo-800/60');
            $desc = $sk->description ?: ($sk->name . ' technology applied across production applications.');

            $skillList[] = [
                'name' => $sk->name,
                'image' => $imageSrc ?: $cdnSrc,
                'cdn' => $cdnSrc,
                'level' => $level . ' (' . $proficiency . '%)',
                'level_color' => $levelColor,
                'desc' => $desc,
            ];
        }

        $categories[] = [
            'category' => $meta['name'],
            'icon' => $meta['icon'],
            'description' => $meta['description'],
            'skills' => $skillList
        ];
    }
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Technical Skills &amp; Stack | Raushan Kumar</title>
        <meta name="description" content="Explore the technical skills, programming languages, frameworks, and developer tools used by Raushan Kumar.">

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
                <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse"></div>
                <div class="absolute bottom-5 left-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

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
                        <span class="text-xs font-semibold text-slate-300">Technical Skills</span>
                    </div>

                    <!-- Heading -->
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/80 border border-slate-700/60 text-xs font-medium text-sky-400 mb-4 shadow-inner">
                            <span>⚡ Tech Stack &amp; Capabilities</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                            Technologies &amp; <span class="text-sky-400">Tools</span> I Work With
                        </h1>
                        <p class="mt-4 text-slate-400 text-sm sm:text-base leading-relaxed">
                            A curated overview of my programming languages, frameworks, libraries, database systems, and development tools honed through academic training and enterprise industry projects.
                        </p>
                    </div>

                </div>
            </section>

            <!-- Skills Categories Grid -->
            <section class="py-16 lg:py-24 bg-[#070c18] relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 relative z-10">
                    
                    @foreach($categories as $cat)
                        <div class="space-y-6">
                            <!-- Category Header -->
                            <div class="flex items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-800/80">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900/90 border border-slate-800 flex items-center justify-center shadow-inner">
                                        {!! $cat['icon'] !!}
                                    </div>
                                    <div>
                                        <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                                            {{ $cat['category'] }}
                                        </h2>
                                        <p class="text-xs sm:text-sm text-slate-400 mt-0.5">
                                            {{ $cat['description'] }}
                                        </p>
                                    </div>
                                </div>
                                <span class="hidden sm:inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-slate-900/80 border border-slate-800 text-slate-400">
                                    {{ count($cat['skills']) }} {{ count($cat['skills']) === 1 ? 'Technology' : 'Technologies' }}
                                </span>
                            </div>

                            <!-- Skills Cards Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                                @foreach($cat['skills'] as $skill)
                                    <div class="group relative flex flex-col justify-between p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm hover:border-sky-500/50 hover:bg-slate-800/50 hover:-translate-y-1.5 transition-all duration-300 shadow-lg">
                                        <div>
                                            <!-- Card Header: Logo & Badge -->
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="w-12 h-12 rounded-xl bg-slate-800/80 border border-slate-700/60 p-2.5 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                                                    <img src="{{ asset($skill['image']) }}" 
                                                         alt="{{ $skill['name'] }}" 
                                                         class="w-full h-full object-contain"
                                                         onerror="this.onerror=null; this.src='{{ $skill['cdn'] }}';">
                                                </div>
                                                <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full border {{ $skill['level_color'] }}">
                                                    {{ $skill['level'] }}
                                                </span>
                                            </div>

                                            <!-- Skill Title -->
                                            <h3 class="text-base sm:text-lg font-bold text-slate-100 group-hover:text-white transition-colors">
                                                {{ $skill['name'] }}
                                            </h3>

                                            <!-- Skill Description -->
                                            <p class="mt-2 text-xs sm:text-sm text-slate-400 leading-relaxed">
                                                {{ $skill['desc'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
            </section>

            <!-- How I Build & Apply Section -->
            <section class="py-16 lg:py-20 bg-[#060a14] border-t border-slate-800/60 relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center max-w-2xl mx-auto mb-14">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                            My Development <span class="text-sky-400">Workflow</span>
                        </h2>
                        <p class="mt-2.5 text-slate-400 text-sm sm:text-base">
                            How I combine these technologies into full-fledged, high-performance web products.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                        <!-- Step 1 -->
                        <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-md">
                            <span class="text-3xl font-black text-sky-400/80">01</span>
                            <h3 class="text-base font-bold text-white mt-3">Architecture &amp; Schema Design</h3>
                            <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                                Planning relational MySQL schemas, entity relationships, and RESTful API endpoint contracts before writing application code.
                            </p>
                        </div>

                        <!-- Step 2 -->
                        <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-md">
                            <span class="text-3xl font-black text-indigo-400/80">02</span>
                            <h3 class="text-base font-bold text-white mt-3">Robust Backend &amp; Business Logic</h3>
                            <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                                Developing secured Laravel controller logic, Eloquent models, validation rules, authentication, and testing with Postman.
                            </p>
                        </div>

                        <!-- Step 3 -->
                        <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-md">
                            <span class="text-3xl font-black text-blue-400/80">03</span>
                            <h3 class="text-base font-bold text-white mt-3">Fluid UI &amp; Responsive Polish</h3>
                            <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                                Creating reactive interfaces with React and Tailwind CSS, prioritizing fast load times, accessible design, and smooth transitions.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Banner -->
            <section class="py-16 bg-gradient-to-r from-blue-900/40 via-indigo-900/30 to-sky-900/40 border-t border-b border-slate-800/60 relative overflow-hidden">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        See These Technologies In Action
                    </h2>
                    <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-xl mx-auto">
                        Check out the live featured projects built with React, Laravel, MySQL, and Tailwind CSS.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4 mt-8">
                        <a href="{{ route('home') }}#projects" 
                           class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-blue-500 via-indigo-500 to-sky-400 hover:from-blue-600 hover:via-indigo-600 hover:to-sky-500 shadow-lg shadow-blue-500/25 active:scale-95 transition-all duration-200">
                            <span>View Featured Projects</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <a href="{{ route('home') }}#contact" 
                           class="inline-flex items-center justify-center px-8 py-3.5 rounded-full text-sm font-semibold text-slate-200 bg-slate-900/80 border border-slate-700/80 hover:bg-slate-800 hover:text-white transition-all duration-200">
                            Contact Me
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        @include('includes.footer')

    </body>
</html>
