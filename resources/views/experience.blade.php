@php
    $dbExperiences = isset($experiences) && count($experiences) > 0 ? $experiences : \App\Models\Experience::orderBy('sort_order')->get();
    
    $experiencesData = [];
    foreach ($dbExperiences as $e) {
        $tagList = [];
        $rawTags = $e->technologies ?? $e->tags ?? [];
        if (is_array($rawTags)) {
            foreach ($rawTags as $t) {
                $tagName = is_array($t) ? ($t['name'] ?? '') : $t;
                if (!empty($tagName)) {
                    $tagList[] = ['name' => $tagName, 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/60'];
                }
            }
        }

        $deliverables = [];
        if (is_array($e->deliverables) && count($e->deliverables) > 0) {
            foreach ($e->deliverables as $d) {
                if (is_array($d)) {
                    $deliverables[] = [
                        'title' => $d['title'] ?? 'Core Contribution',
                        'desc' => $d['desc'] ?? ''
                    ];
                } else {
                    $deliverables[] = [
                        'title' => 'Key Contribution',
                        'desc' => (string)$d
                    ];
                }
            }
        } elseif (is_array($e->responsibilities) && count($e->responsibilities) > 0) {
            foreach ($e->responsibilities as $idx => $resp) {
                $deliverables[] = [
                    'title' => 'Key Responsibility ' . ($idx + 1),
                    'desc' => is_array($resp) ? ($resp['desc'] ?? $resp['title'] ?? '') : $resp
                ];
            }
        } elseif (!empty($e->description)) {
            $deliverables[] = [
                'title' => 'Core Deliverable & Responsibilities',
                'desc' => $e->description
            ];
        }

        $logoPath = $e->logo;
        if ($logoPath && !str_starts_with($logoPath, 'http') && !str_starts_with($logoPath, '/')) {
            $logoPath = asset($logoPath);
        }

        $certPath = $e->certificate_url;
        if ($certPath && !str_starts_with($certPath, 'http') && !str_starts_with($certPath, '/')) {
            $certPath = asset($certPath);
        }

        $startDate = $e->start_date ?? '';
        $endDate = $e->end_date ?? 'Present';
        $period = !empty($startDate) ? ($startDate . ' – ' . ($endDate ?: 'Present')) : ($e->period ?? '');
        if (trim($period) === '– Present' || trim($period) === '- Present') {
            $period = 'Present';
        }

        $experiencesData[] = [
            'id' => $e->id,
            'role' => $e->role,
            'company' => $e->company,
            'period' => $period,
            'type' => $e->employment_type ?? ($e->type ?? 'Full-time / Trainee'),
            'location' => $e->location ?? '',
            'logo' => $logoPath,
            'certificate_url' => $certPath,
            'current' => $e->is_current,
            'summary' => $e->short_description ?: ($e->summary ?: $e->description),
            'deliverables' => $deliverables,
            'tags' => $tagList
        ];
    }
    $experiences = $experiencesData;
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Work Experience &amp; Career | Raushan Kumar</title>
        <meta name="description" content="Detailed work experience, traineeship milestones, and technical contributions of Raushan Kumar at DataAegis Software Private Limited.">

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
                        <span class="text-xs font-semibold text-slate-300">Experience</span>
                    </div>

                    <!-- Heading -->
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/80 border border-slate-700/60 text-xs font-medium text-sky-400 mb-4 shadow-inner">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>💼 Professional Career &amp; Traineeship</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                            Work <span class="text-sky-400">Experience</span> &amp; Industry Impact
                        </h1>
                        <p class="mt-4 text-slate-400 text-sm sm:text-base leading-relaxed">
                            A breakdown of my software engineering traineeship at DataAegis Software Private Limited, production fintech deliverables, and hands-on full-stack development experience.
                        </p>
                    </div>

                </div>
            </section>

            <!-- Experience Timeline Section -->
            <section class="py-16 lg:py-24 bg-[#070c18] relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 relative z-10">
                    
                    @foreach($experiences as $exp)
                        <div class="rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm p-7 sm:p-9 shadow-xl relative hover:border-sky-500/40 transition-all duration-300">
                            
                            <!-- Header Row: Company Logo, Role & Period -->
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-slate-800/80">
                                
                                <div class="flex items-start sm:items-center space-x-5">
                                    <!-- Company Logo Container -->
                                    <div class="flex-shrink-0 w-16 h-16 rounded-2xl bg-slate-800/80 border border-slate-700/60 p-2.5 flex items-center justify-center shadow-inner">
                                        <img src="{{ $exp['logo'] }}" 
                                             alt="{{ $exp['company'] }}" 
                                             class="w-full h-full object-contain"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden flex-col items-center justify-center text-center">
                                            <svg class="w-8 h-8 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="9" stroke="currentColor"/>
                                                <path d="M12 7a5 5 0 0 1 5 5c0 2.76-2.24 5-5 5s-5-2.24-5-5" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex flex-wrap items-center gap-2.5">
                                            <h2 class="text-xl sm:text-2xl font-bold text-white">
                                                {{ $exp['role'] }}
                                            </h2>
                                            @if($exp['current'])
                                                <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full bg-emerald-950/70 border border-emerald-800/60 text-emerald-400">
                                                    Current Role
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm font-semibold text-sky-400 mt-1">
                                            {{ $exp['company'] }} <span class="text-slate-500 font-normal">• {{ $exp['location'] }}</span>
                                        </p>
                                        @if(!empty($exp['certificate_url']))
                                            <div class="pt-2">
                                                <a href="{{ $exp['certificate_url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-semibold transition-all hover:scale-105 active:scale-95 shadow-sm">
                                                    <span>📜 View Certificate</span>
                                                    <svg class="w-3 h-3 text-amber-400/80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col lg:items-end">
                                    <span class="text-sm font-bold text-slate-200 bg-slate-800/80 px-4 py-1.5 rounded-full border border-slate-700/60">
                                        {{ $exp['period'] }}
                                    </span>
                                    <span class="text-xs text-slate-400 mt-1.5">
                                        {{ $exp['type'] }}
                                    </span>
                                </div>

                            </div>

                            <!-- Overview Description -->
                            <p class="text-sm sm:text-base text-slate-300 leading-relaxed mt-6">
                                {{ $exp['summary'] }}
                            </p>

                            <!-- Key Deliverables Grid -->
                            <div class="mt-8">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">
                                    Key Contributions &amp; Deliverables
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($exp['deliverables'] as $item)
                                        <div class="p-4 rounded-xl bg-slate-800/40 border border-slate-800/80 flex items-start space-x-3.5">
                                            <div class="w-6 h-6 rounded-full bg-sky-500/15 text-sky-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-semibold text-slate-200">
                                                    {{ $item['title'] }}
                                                </h4>
                                                <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                                    {{ $item['desc'] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tech Stack & Certificate -->
                            <div class="mt-8 pt-6 border-t border-slate-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-semibold text-slate-400 mr-2">Technologies Used:</span>
                                    @foreach($exp['tags'] as $tag)
                                        <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full border {{ $tag['color'] }}">
                                            {{ $tag['name'] }}
                                        </span>
                                    @endforeach
                                </div>
                                @if(!empty($exp['certificate_url']))
                                    <a href="{{ $exp['certificate_url'] }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-semibold transition-all">
                                        <span>📜</span>
                                        <span>View Certificate</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                    </a>
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>
            </section>

            <!-- Competency Matrix / Impact Highlights -->
            <section class="py-16 lg:py-20 bg-[#060a14] border-t border-slate-800/60 relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center max-w-2xl mx-auto mb-14">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                            Core Engineering <span class="text-sky-400">Strengths</span>
                        </h2>
                        <p class="mt-2.5 text-slate-400 text-sm sm:text-base">
                            The practical competencies honed across production fintech and full-stack projects.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Card 1 -->
                        <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-md">
                            <div class="w-10 h-10 rounded-xl bg-sky-500/15 border border-sky-500/30 flex items-center justify-center text-sky-400 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-white">KYC &amp; Onboarding</h3>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Form validation, secure file uploads, multi-step progress wizards, and verification callbacks.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-md">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.73 7.47A4.5 4.5 0 019.27 6h5.46a4.5 4.5 0 013.54 1.47l2.08 2.78c.58.78.9 1.73.9 2.7" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-white">RESTful API Design</h3>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Clean endpoint structure, Sanctum authentication, HTTP status handling, and Postman testing.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-md">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-white">MySQL Architecture</h3>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Normalized schemas, foreign keys, database migrations, indexes, and database transactions.
                            </p>
                        </div>

                        <!-- Card 4 -->
                        <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm shadow-md">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/15 border border-purple-500/30 flex items-center justify-center text-purple-400 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-white">Agile &amp; Team Git</h3>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Branch management, pull requests, sprint syncs, issue tracking, and cross-team communication.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-16 bg-gradient-to-r from-blue-900/40 via-indigo-900/30 to-sky-900/40 border-t border-b border-slate-800/60 relative overflow-hidden">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        Looking for a Dedicated Developer for Your Team?
                    </h2>
                    <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-xl mx-auto">
                        I am eager to contribute my full-stack skills, problem-solving mindset, and software development passion to forward-thinking projects.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4 mt-8">
                        <a href="{{ route('home') }}#contact" 
                           class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-blue-500 via-indigo-500 to-sky-400 hover:from-blue-600 hover:via-indigo-600 hover:to-sky-500 shadow-lg shadow-blue-500/25 active:scale-95 transition-all duration-200">
                            <span>Get in Touch</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <a href="{{ route('projects') }}" 
                           class="inline-flex items-center justify-center px-8 py-3.5 rounded-full text-sm font-semibold text-slate-200 bg-slate-900/80 border border-slate-700/80 hover:bg-slate-800 hover:text-white transition-all duration-200">
                            View Featured Projects
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        @include('includes.footer')

    </body>
</html>
