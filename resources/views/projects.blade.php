@php
    $dbProjects = isset($projects) && count($projects) > 0 ? $projects : \App\Models\Project::orderBy('sort_order')->get();
    
    // Extract distinct categories dynamically from the database
    $categories = $dbProjects->pluck('category')->filter()->unique()->values();

    $projectsList = [];
    foreach ($dbProjects as $p) {
        $category = is_object($p) ? ($p->category ?: 'General') : ($p['category'] ?? 'General');
        $catSlug = \Illuminate\Support\Str::slug($category);

        $tagList = [];
        $rawTech = is_object($p) ? ($p->technologies ?? $p->tags ?? []) : ($p['technologies'] ?? $p['tags'] ?? []);
        if (is_array($rawTech)) {
            foreach ($rawTech as $t) {
                $tagName = is_array($t) ? ($t['name'] ?? '') : $t;
                if (!empty($tagName)) {
                    $tagList[] = $tagName;
                }
            }
        }

        $featuresList = is_object($p) ? ($p->features ?? []) : ($p['features'] ?? []);
        if (!is_array($featuresList)) {
            $featuresList = [];
        }

        $title = is_object($p) ? $p->title : $p['title'];
        $demoUrl = is_object($p) ? ($p->demo_url ?? $p->live_url) : ($p['demo_url'] ?? $p['live_url'] ?? null);
        $githubUrl = is_object($p) ? $p->github_url : ($p['github_url'] ?? null);
        $imageUrl = is_object($p) ? ($p->image_url ?? $p->icon) : ($p['image_url'] ?? $p['icon'] ?? null);
        $description = is_object($p) ? $p->description : ($p['description'] ?? '');

        // Simulated domain for browser address bar preview
        $previewDomain = 'app.local';
        if (!empty($demoUrl) && $demoUrl !== '#') {
            $parsedHost = parse_url($demoUrl, PHP_URL_HOST);
            $previewDomain = $parsedHost ?: strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $title)) . '.dev';
        } else {
            $previewDomain = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $title)) . '.dev';
        }

        $categoryLower = strtolower($category);
        $catBadgeClass = 'bg-sky-500/10 text-sky-400 border-sky-500/30';
        if (str_contains($categoryLower, 'fintech') || str_contains($categoryLower, 'system') || str_contains($categoryLower, 'epay')) {
            $catBadgeClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30';
        } elseif (str_contains($categoryLower, 'commerce') || str_contains($categoryLower, 'store') || str_contains($categoryLower, 'shop')) {
            $catBadgeClass = 'bg-purple-500/10 text-purple-400 border-purple-500/30';
        } elseif (str_contains($categoryLower, 'travel') || str_contains($categoryLower, 'react')) {
            $catBadgeClass = 'bg-amber-500/10 text-amber-400 border-amber-500/30';
        }

        $projectsList[] = [
            'id' => is_object($p) ? $p->id : ($p['id'] ?? null),
            'title' => $title,
            'category' => $category,
            'category_slug' => $catSlug,
            'category_badge' => $catBadgeClass,
            'preview_domain' => $previewDomain,
            'image_url' => $imageUrl,
            'description' => $description,
            'features' => $featuresList,
            'tags' => $tagList,
            'live_url' => $demoUrl,
            'github_url' => $githubUrl,
        ];
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Featured Projects &amp; Case Studies | Raushan Kumar</title>
        <meta name="description" content="Explore production web applications, React frontends, and scalable Laravel systems engineered by Raushan Kumar.">

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
                <!-- Ambient Glows -->
                <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse"></div>
                <div class="absolute bottom-5 right-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
                <div class="absolute top-10 right-1/4 w-72 h-72 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

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
                        <span class="text-xs font-semibold text-slate-300">Projects</span>
                    </div>

                    <!-- Heading -->
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/90 border border-sky-500/30 text-xs font-semibold text-sky-400 mb-4 shadow-[0_0_15px_rgba(56,189,248,0.12)]">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-400"></span>
                            </span>
                            <span>🚀 Production Showcase</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                            Featured <span class="bg-gradient-to-r from-sky-400 via-blue-400 to-indigo-400 bg-clip-text text-transparent">Projects</span> &amp; Case Studies
                        </h1>
                        <p class="mt-4 text-slate-400 text-sm sm:text-base leading-relaxed">
                            A curated selection of web applications, custom business solutions, and production software projects managed directly from the database.
                        </p>
                    </div>

                    <!-- Dynamic Category Filter Tabs from Backend -->
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-8 pt-4">
                        <button type="button" 
                                class="project-filter-btn px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-300 bg-gradient-to-r from-sky-500 to-blue-600 text-white shadow-lg shadow-sky-500/25 flex items-center gap-2" 
                                data-filter="all">
                            <span>All Projects</span>
                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-[11px] font-bold">{{ count($projectsList) }}</span>
                        </button>
                        
                        @foreach($categories as $cat)
                            @php
                                $cSlug = \Illuminate\Support\Str::slug($cat);
                                $catCount = collect($projectsList)->where('category', $cat)->count();
                            @endphp
                            <button type="button" 
                                    class="project-filter-btn px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-300 bg-slate-900/90 border border-slate-800 text-slate-400 hover:text-white hover:border-slate-700 flex items-center gap-2" 
                                    data-filter="{{ $cSlug }}">
                                <span>{{ $cat }}</span>
                                <span class="px-2 py-0.5 rounded-full bg-slate-800 text-slate-400 text-[11px] font-semibold">{{ $catCount }}</span>
                            </button>
                        @endforeach
                    </div>

                </div>
            </section>

            <!-- Projects Grid Section -->
            <section class="py-16 lg:py-24 bg-[#070c18] relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    
                    <div id="projects-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($projectsList as $project)
                            <div class="project-card group relative flex flex-col justify-between rounded-3xl bg-gradient-to-b from-slate-900/95 via-slate-900/80 to-[#0b1222]/95 border border-slate-800/90 hover:border-sky-500/50 backdrop-blur-xl shadow-xl hover:shadow-[0_0_35px_rgba(56,189,248,0.15)] hover:-translate-y-2 transition-all duration-500 overflow-hidden"
                                 data-category="{{ $project['category_slug'] }}">
                                
                                <!-- Top ambient glow line on hover -->
                                <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-sky-400/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-30"></div>

                                <div>
                                    <!-- Browser Frame Header -->
                                    <div class="relative bg-slate-950/90 px-4 py-3 border-b border-slate-800/80 flex items-center justify-between z-20">
                                        <!-- Traffic Lights -->
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500/80 group-hover:bg-rose-500 transition-colors"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500/80 group-hover:bg-amber-500 transition-colors"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500/80 group-hover:bg-emerald-500 transition-colors"></span>
                                        </div>
                                        
                                        <!-- Simulated Address Bar -->
                                        <div class="px-3 py-1 rounded-lg bg-slate-900/90 border border-slate-800 text-[11px] font-mono text-slate-400 flex items-center gap-1.5 max-w-[170px] sm:max-w-[200px] truncate shadow-inner">
                                            <svg class="w-3 h-3 text-sky-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                            </svg>
                                            <span class="truncate">{{ $project['preview_domain'] }}</span>
                                        </div>

                                        <!-- Status Badge -->
                                        @if(!empty($project['live_url']) && $project['live_url'] !== '#')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/15 border border-emerald-500/30 text-emerald-300">
                                                <span class="relative flex h-1.5 w-1.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-400"></span>
                                                </span>
                                                Live
                                            </span>
                                        @else
                                            <span class="text-[10px] font-semibold text-slate-400 bg-slate-800/60 px-2 py-0.5 rounded-full border border-slate-700/50">Active</span>
                                        @endif
                                    </div>

                                    <!-- Project Thumbnail Banner with Quick Actions Overlay -->
                                    <div class="relative w-full aspect-[16/10] bg-slate-950 overflow-hidden group/img">
                                        @if(!empty($project['image_url']))
                                            <img src="{{ asset($project['image_url']) }}" 
                                                 alt="{{ $project['title'] }}" 
                                                 class="w-full h-full object-cover object-top filter brightness-[0.98] group-hover:scale-105 group-hover:brightness-105 transition-all duration-700 ease-out"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            
                                            <!-- Fallback Banner -->
                                            <div class="hidden w-full h-full bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950/40 items-center justify-center p-6">
                                                <div class="w-14 h-14 rounded-2xl bg-sky-500/10 border border-sky-500/30 text-sky-400 flex items-center justify-center shadow-inner">
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" /></svg>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Dynamic Graphic Icon Fallback from Backend Info -->
                                            <div class="w-full h-full bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950/50 flex flex-col justify-between p-5 relative overflow-hidden">
                                                <div class="flex items-center gap-1.5 opacity-60">
                                                    <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                                    <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                                    <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                                </div>

                                                <div class="self-center my-auto flex flex-col items-center text-center">
                                                    <div class="w-14 h-14 rounded-2xl bg-sky-500/10 border border-sky-500/30 text-sky-400 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"/></svg>
                                                    </div>
                                                    <span class="mt-2 text-xs font-semibold text-slate-300">{{ $project['title'] }}</span>
                                                </div>

                                                <div class="w-full h-1.5 rounded-full bg-slate-800/80 overflow-hidden">
                                                    <div class="w-1/2 h-full bg-gradient-to-r from-sky-500 to-indigo-500 rounded-full"></div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Gradient Vignette -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-black/20 pointer-events-none"></div>

                                        <!-- Floating Category Badge -->
                                        <div class="absolute bottom-3 left-3 z-10">
                                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold border backdrop-blur-md shadow-md {{ $project['category_badge'] }}">
                                                {{ $project['category'] }}
                                            </span>
                                        </div>

                                        <!-- Quick Action Overlay on Hover -->
                                        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-3 p-4 z-20">
                                            @if(!empty($project['live_url']) && $project['live_url'] !== '#')
                                                <a href="{{ $project['live_url'] }}" 
                                                   target="_blank" 
                                                   class="px-4 py-2 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white text-xs font-bold shadow-lg shadow-sky-500/30 flex items-center gap-1.5 transform hover:scale-105 active:scale-95 transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                                    <span>Preview</span>
                                                </a>
                                            @endif
                                            @if(!empty($project['github_url']))
                                                <a href="{{ $project['github_url'] }}" 
                                                   target="_blank" 
                                                   class="px-4 py-2 rounded-xl bg-slate-800/90 hover:bg-slate-700 text-white text-xs font-bold border border-slate-700/80 flex items-center gap-1.5 transform hover:scale-105 active:scale-95 transition-all shadow-md">
                                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                                                    <span>Code</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content Body -->
                                    <div class="p-6 sm:p-7 space-y-4">
                                        <!-- Title -->
                                        <h3 class="text-xl font-bold text-white group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-sky-400 group-hover:to-blue-400 transition-all duration-300 line-clamp-1">
                                            {{ $project['title'] }}
                                        </h3>

                                        <!-- Description -->
                                        @if(!empty($project['description']))
                                            <p class="text-xs sm:text-sm text-slate-300/90 leading-relaxed line-clamp-3">
                                                {{ $project['description'] }}
                                            </p>
                                        @endif

                                        <!-- Key Features Checklist from DB -->
                                        @if(count($project['features']) > 0)
                                            <div class="pt-2 space-y-2">
                                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                                    Key Features:
                                                </span>
                                                <div class="space-y-1.5">
                                                    @foreach($project['features'] as $feat)
                                                        <div class="flex items-start space-x-2.5 text-xs text-slate-300">
                                                            <div class="w-4 h-4 rounded-full bg-sky-500/15 text-sky-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                                </svg>
                                                            </div>
                                                            <span class="leading-relaxed">{{ $feat }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Tech Stack Pills from DB -->
                                        @if(count($project['tags']) > 0)
                                            <div class="flex flex-wrap gap-1.5 pt-2">
                                                @foreach(array_slice($project['tags'], 0, 5) as $tag)
                                                    <span class="px-2.5 py-1 text-[11px] font-medium rounded-lg bg-slate-800/80 border border-slate-700/60 text-slate-300 group-hover:border-slate-600 transition-all">
                                                        {{ $tag }}
                                                    </span>
                                                @endforeach
                                                @if(count($project['tags']) > 5)
                                                    <span class="px-2 py-1 text-[11px] font-medium rounded-lg bg-slate-800/40 text-slate-500">
                                                        +{{ count($project['tags']) - 5 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Footer -->
                                <div class="px-6 sm:px-7 pb-6 pt-3 border-t border-slate-800/70 bg-slate-950/40 flex items-center justify-between gap-3">
                                    @if(!empty($project['live_url']) && $project['live_url'] !== '#')
                                        <a href="{{ $project['live_url'] }}" 
                                           target="_blank" 
                                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 hover:from-sky-400 hover:via-blue-500 hover:to-indigo-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-sky-500/20 hover:shadow-sky-500/35 active:scale-95 transition-all duration-300 group/btn">
                                            <span>Live Demo</span>
                                            <svg class="w-3.5 h-3.5 transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                        </a>
                                    @else
                                        <a href="{{ route('home') }}#contact" 
                                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 border border-slate-700 text-slate-300 hover:text-white font-semibold text-xs tracking-wider transition-all">
                                            <span>Inquire Details</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                        </a>
                                    @endif

                                    @if(!empty($project['github_url']))
                                        <a href="{{ $project['github_url'] }}" 
                                           target="_blank" 
                                           title="View Source Code on GitHub"
                                           class="w-10 h-10 rounded-xl bg-slate-800/80 hover:bg-slate-700 border border-slate-700/80 hover:border-slate-600 flex items-center justify-center text-slate-400 hover:text-white transition-all duration-200 shadow-md">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                                        </a>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div class="col-span-full text-center py-16 text-slate-500">
                                No projects found in database.
                            </div>
                        @endforelse
                    </div>

                </div>
            </section>

            <!-- Interactive Filter Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const filterButtons = document.querySelectorAll('.project-filter-btn');
                    const projectCards = document.querySelectorAll('.project-card');

                    filterButtons.forEach(btn => {
                        btn.addEventListener('click', () => {
                            const filter = btn.getAttribute('data-filter');

                            // Update active button styling
                            filterButtons.forEach(otherBtn => {
                                otherBtn.classList.remove('bg-gradient-to-r', 'from-sky-500', 'to-blue-600', 'text-white', 'shadow-lg', 'shadow-sky-500/25');
                                otherBtn.classList.add('bg-slate-900/90', 'border', 'border-slate-800', 'text-slate-400');
                            });
                            btn.classList.remove('bg-slate-900/90', 'border', 'border-slate-800', 'text-slate-400');
                            btn.classList.add('bg-gradient-to-r', 'from-sky-500', 'to-blue-600', 'text-white', 'shadow-lg', 'shadow-sky-500/25');

                            // Filter cards with smooth opacity transition
                            projectCards.forEach(card => {
                                const cardCat = card.getAttribute('data-category');
                                if (filter === 'all' || cardCat === filter) {
                                    card.style.display = 'flex';
                                } else {
                                    card.style.display = 'none';
                                }
                            });
                        });
                    });
                });
            </script>

            <!-- CTA Section -->
            <section class="py-20 bg-gradient-to-r from-blue-950/40 via-indigo-950/30 to-sky-950/40 border-t border-b border-slate-800/60 relative overflow-hidden">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/10 border border-sky-500/30 text-xs font-semibold text-sky-400 mb-4">
                        <span>🤝 Let's Collaborate</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                        Have a Project in Mind?
                    </h2>
                    <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                        Whether you need a custom Laravel web application, a modern React interface, or an end-to-end full-stack platform, let's talk.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4 mt-8">
                        <a href="{{ route('home') }}#contact" 
                           class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 hover:from-sky-400 hover:via-blue-500 hover:to-indigo-500 shadow-lg shadow-sky-500/25 hover:shadow-sky-500/40 active:scale-95 transition-all duration-300">
                            <span>Get in Touch</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <a href="{{ route('about') }}" 
                           class="inline-flex items-center justify-center px-8 py-3.5 rounded-xl text-sm font-semibold text-slate-200 bg-slate-900/90 border border-slate-700/80 hover:bg-slate-800 hover:text-white transition-all duration-200">
                            Learn More About Me
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        @include('includes.footer')

    </body>
</html>
