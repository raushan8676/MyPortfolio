@php
    $dbProjects = isset($projects) && count($projects) > 0
        ? $projects
        : \App\Models\Project::orderBy('sort_order')->take(6)->get();
@endphp

<section id="projects"
    class="relative bg-[#070c18] pt-20 pb-24 lg:pt-28 lg:pb-32 overflow-hidden border-t border-slate-800/60">
    <!-- Ambient Background Lighting Glows -->
    <div
        class="absolute top-1/4 left-1/4 w-[550px] h-[550px] bg-blue-600/10 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse">
    </div>
    <div
        class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10">
    </div>
    <div class="absolute -top-10 right-1/3 w-80 h-80 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none -z-10">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-4 sm:pt-6">

        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900/90 border border-sky-500/30 text-xs font-semibold text-sky-400 mb-3 shadow-[0_0_15px_rgba(56,189,248,0.12)]">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-400"></span>
                    </span>
                    <span>Portfolio Showcase</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                    Featured <span class="text-sky-400">Projects</span>
                </h2>
                <p class="mt-2 text-slate-400 text-sm sm:text-base max-w-xl">
                    A curated selection of full-stack web applications, fintech systems, and modern digital experiences
                    I've engineered.
                </p>
            </div>

            <div class="pt-2 sm:pt-0 shrink-0">
                <a href="{{ route('projects') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900/90 hover:bg-slate-800 border border-slate-700/80 hover:border-sky-500/50 text-xs sm:text-sm font-semibold text-slate-200 hover:text-white transition-all duration-300 shadow-md hover:shadow-sky-500/10 group">
                    <span>Explore All Projects</span>
                    <svg class="w-4 h-4 text-sky-400 transform group-hover:translate-x-1 transition-transform"
                        fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Projects Grid (Modern 3-Column / 2-Column Responsive Showcase) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($dbProjects as $project)
                @php
                    $pTitle = is_object($project) ? $project->title : $project['title'];
                    $pCategory = is_object($project) ? ($project->category ?? 'Full Stack') : ($project['category_name'] ?? 'Web App');
                    $pDesc = is_object($project) ? $project->description : $project['description'];
                    $pDemo = is_object($project) ? ($project->demo_url ?? $project->live_url) : ($project['demo_url'] ?? $project['live_url'] ?? null);
                    $pGithub = is_object($project) ? $project->github_url : ($project['github_url'] ?? null);
                    $pTags = is_object($project) ? ($project->technologies ?? $project->tags ?? []) : ($project['technologies'] ?? $project['tags'] ?? []);
                    $pImg = is_object($project) ? ($project->image_url ?? $project->icon) : ($project['image_url'] ?? $project['icon'] ?? null);
                    $pFeatures = is_object($project) ? ($project->features ?? []) : ($project['features'] ?? []);

                    // Category Color Styles
                    $catBg = 'bg-sky-500/10 text-sky-400 border-sky-500/20';
                    if (stripos($pCategory, 'fintech') !== false || stripos($pCategory, 'epay') !== false || stripos($pCategory, 'system') !== false) {
                        $catBg = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                    } elseif (stripos($pCategory, 'commerce') !== false || stripos($pCategory, 'store') !== false) {
                        $catBg = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
                    } elseif (stripos($pCategory, 'travel') !== false || stripos($pCategory, 'react') !== false) {
                        $catBg = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                    }

                    // Simulated Domain Preview
                    $previewDomain = 'app.local';
                    if (!empty($pDemo) && $pDemo !== '#') {
                        $parsedHost = parse_url($pDemo, PHP_URL_HOST);
                        $previewDomain = $parsedHost ?: strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $pTitle)) . '.dev';
                    } else {
                        $previewDomain = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $pTitle)) . '.dev';
                    }
                @endphp

                <div
                    class="group relative flex flex-col justify-between rounded-3xl bg-gradient-to-b from-slate-900/95 via-slate-900/80 to-[#0b1222]/95 border border-slate-800/90 hover:border-sky-500/50 backdrop-blur-xl shadow-xl hover:shadow-[0_0_35px_rgba(56,189,248,0.15)] hover:-translate-y-2 transition-all duration-500 overflow-hidden">

                    <!-- Top ambient glow line on hover -->
                    <div
                        class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-sky-400/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-30">
                    </div>

                    <div>
                        <!-- Realistic Browser Window Mockup Frame -->
                        <div
                            class="relative bg-slate-950/90 px-4 py-3 border-b border-slate-800/80 flex items-center justify-between z-20">
                            <!-- Traffic Light Dots -->
                            <div class="flex items-center gap-1.5">
                                <span
                                    class="w-2.5 h-2.5 rounded-full bg-rose-500/80 group-hover:bg-rose-500 transition-colors"></span>
                                <span
                                    class="w-2.5 h-2.5 rounded-full bg-amber-500/80 group-hover:bg-amber-500 transition-colors"></span>
                                <span
                                    class="w-2.5 h-2.5 rounded-full bg-emerald-500/80 group-hover:bg-emerald-500 transition-colors"></span>
                            </div>

                            <!-- Simulated Address Bar -->
                            <div
                                class="px-3 py-1 rounded-lg bg-slate-900/90 border border-slate-800 text-[11px] font-mono text-slate-400 flex items-center gap-1.5 max-w-[170px] sm:max-w-[200px] truncate shadow-inner">
                                <svg class="w-3 h-3 text-sky-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <span class="truncate">{{ $previewDomain }}</span>
                            </div>

                            <!-- Live status indicator or version -->
                            @if($pDemo && $pDemo !== '#')
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/15 border border-emerald-500/30 text-emerald-300">
                                    <span class="relative flex h-1.5 w-1.5">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-400"></span>
                                    </span>
                                    Live
                                </span>
                            @else
                                <span
                                    class="text-[10px] font-semibold text-slate-400 bg-slate-800/60 px-2 py-0.5 rounded-full border border-slate-700/50">v1.0</span>
                            @endif
                        </div>

                        <!-- Project Visual Thumbnail Banner with Hover Overlay -->
                        <div class="relative w-full aspect-[16/10] bg-slate-950 overflow-hidden group/img">
                            @if($pImg)
                                <img src="{{ asset($pImg) }}" alt="{{ $pTitle }}"
                                    class="w-full h-full object-cover object-top filter brightness-[0.98] group-hover:scale-105 group-hover:brightness-105 transition-all duration-700 ease-out"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                <!-- Fallback Banner if image fails to load -->
                                <div
                                    class="hidden w-full h-full bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950/40 items-center justify-center relative p-6">
                                    <div
                                        class="w-14 h-14 rounded-2xl bg-sky-500/10 border border-sky-500/30 text-sky-400 flex items-center justify-center shadow-inner">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                        </svg>
                                    </div>
                                </div>
                            @else
                                <!-- Modern Code Mockup Pattern Fallback -->
                                <div
                                    class="w-full h-full bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950/50 flex flex-col justify-between p-5 relative overflow-hidden">
                                    <div class="flex items-center gap-1.5 opacity-60">
                                        <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                        <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                        <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                    </div>

                                    <!-- Graphic Icon -->
                                    <div class="self-center my-auto flex flex-col items-center">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-sky-500/10 border border-sky-500/30 text-sky-400 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="w-full h-1.5 rounded-full bg-slate-800/80 overflow-hidden">
                                        <div class="w-1/2 h-full bg-gradient-to-r from-sky-500 to-indigo-500 rounded-full">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Bottom Vignette Overlay to blend seamlessly with card body -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-black/20 pointer-events-none">
                            </div>

                            <!-- Floating Category Badge -->
                            <div class="absolute bottom-3 left-3 z-10">
                                <span
                                    class="px-2.5 py-1 rounded-lg text-[11px] font-bold border backdrop-blur-md shadow-md {{ $catBg }}">
                                    {{ $pCategory }}
                                </span>
                            </div>

                            <!-- Quick Action Hover Overlay -->
                            <div
                                class="absolute inset-0 bg-slate-950/80 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-3 p-4 z-20">
                                @if($pDemo && $pDemo !== '#')
                                    <a href="{{ $pDemo }}" target="_blank"
                                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white text-xs font-bold shadow-lg shadow-sky-500/30 flex items-center gap-1.5 transform hover:scale-105 active:scale-95 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>
                                        <span>Preview</span>
                                    </a>
                                @endif
                                @if($pGithub)
                                    <a href="{{ $pGithub }}" target="_blank"
                                        class="px-4 py-2 rounded-xl bg-slate-800/90 hover:bg-slate-700 text-white text-xs font-bold border border-slate-700/80 flex items-center gap-1.5 transform hover:scale-105 active:scale-95 transition-all shadow-md">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                            <path
                                                d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                                        </svg>
                                        <span>Code</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Project Details Content Body -->
                        <div class="p-6 sm:p-7 space-y-4">
                            <!-- Title -->
                            <h3
                                class="text-xl font-bold text-white group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-sky-400 group-hover:to-blue-400 transition-all duration-300 line-clamp-1">
                                {{ $pTitle }}
                            </h3>

                            <!-- Description -->
                            <p class="text-xs sm:text-sm text-slate-300/90 leading-relaxed line-clamp-3">
                                {{ $pDesc }}
                            </p>

                            <!-- Key Features Checklist -->
                            @if(is_array($pFeatures) && count($pFeatures) > 0)
                                <div class="pt-1 space-y-1.5">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                        Key Features:
                                    </span>
                                    @foreach($pFeatures as $feat)
                                        <div class="flex items-start space-x-2 text-xs text-slate-300">
                                            <div
                                                class="w-4 h-4 rounded-full bg-sky-500/15 text-sky-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </div>
                                            <span class="leading-relaxed">{{ $feat }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Technologies Tags -->
                            @if(is_array($pTags) && count($pTags) > 0)
                                <div class="flex flex-wrap gap-1.5 pt-2">
                                    @foreach(array_slice($pTags, 0, 4) as $tag)
                                        @php
                                            $tagName = is_array($tag) ? ($tag['name'] ?? '') : $tag;
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 text-[11px] font-medium rounded-lg bg-slate-800/80 border border-slate-700/60 text-slate-300 group-hover:border-slate-600 transition-all">
                                            {{ $tagName }}
                                        </span>
                                    @endforeach
                                    @if(count($pTags) > 4)
                                        <span class="px-2 py-1 text-[11px] font-medium rounded-lg bg-slate-800/40 text-slate-500">
                                            +{{ count($pTags) - 4 }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Footer with Links -->
                    <div
                        class="px-6 sm:px-7 pb-6 pt-3 border-t border-slate-800/70 bg-slate-950/40 flex items-center justify-between gap-3">
                        @if($pDemo && $pDemo !== '#')
                            <a href="{{ $pDemo }}" target="_blank"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 hover:from-sky-400 hover:via-blue-500 hover:to-indigo-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-sky-500/20 hover:shadow-sky-500/35 transition-all duration-300 group/btn">
                                <span>Live Demo</span>
                                <svg class="w-3.5 h-3.5 transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition-transform"
                                    fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('projects') }}"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 border border-slate-700 text-slate-300 hover:text-white font-semibold text-xs tracking-wider transition-all">
                                <span>View Details</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        @endif

                        @if($pGithub)
                            <a href="{{ $pGithub }}" target="_blank" title="View Source Code on GitHub"
                                class="w-10 h-10 rounded-xl bg-slate-800/80 hover:bg-slate-700 border border-slate-700/80 hover:border-slate-600 flex items-center justify-center text-slate-400 hover:text-white transition-all duration-200 shadow-md">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                                </svg>
                            </a>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>