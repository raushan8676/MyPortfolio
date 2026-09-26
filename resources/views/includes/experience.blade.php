@php
    $dbExperiences = isset($experiences) && count($experiences) > 0 ? $experiences : \App\Models\Experience::orderBy('sort_order')->get();
@endphp

<section id="experience" class="relative bg-[#070c18] py-20 lg:py-24 overflow-hidden border-t border-slate-800/50">
    <!-- Subtle Background Lighting -->
    <div
        class="absolute top-1/2 right-10 -translate-y-1/2 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none -z-10">
    </div>
    <div class="absolute bottom-5 left-1/4 w-72 h-72 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Work <span class="text-sky-400">Experience</span>
                </h2>
                <p class="mt-2 text-slate-400 text-sm">Professional software engineering journey</p>
            </div>
            <a href="{{ route('experience') }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-400 hover:text-sky-300">
                <span>View Full Timeline &rarr;</span>
            </a>
        </div>

        <!-- Experience Card List -->
        <div class="space-y-6">
            @foreach($dbExperiences as $exp)
                @php
                    $eRole = is_object($exp) ? $exp->role : $exp['role'];
                    $eCompany = is_object($exp) ? $exp->company : $exp['company'];
                    $eStartDate = is_object($exp) ? ($exp->start_date ?? '') : ($exp['start_date'] ?? '');
                    $eEndDate = is_object($exp) ? ($exp->end_date ?? 'Present') : ($exp['end_date'] ?? 'Present');
                    $eDuration = !empty($eStartDate) ? ($eStartDate . ' – ' . ($eEndDate ?: 'Present')) : ($exp->period ?? ($exp['duration'] ?? ''));
                    if (trim($eDuration) === '– Present' || trim($eDuration) === '- Present') {
                        $eDuration = 'Present';
                    }
                    $eType = is_object($exp) ? ($exp->employment_type ?? $exp->type ?? 'Full-time') : ($exp['type'] ?? 'Full-time');
                    $eLocation = is_object($exp) ? ($exp->location ?? '') : ($exp['location'] ?? '');
                    $eCurrent = is_object($exp) ? $exp->is_current : ($exp['is_current'] ?? false);
                    $eLogo = is_object($exp) ? $exp->logo : ($exp['logo'] ?? null);
                    if ($eLogo && !str_starts_with($eLogo, 'http') && !str_starts_with($eLogo, '/')) {
                        $eLogo = asset($eLogo);
                    }
                    $eCert = is_object($exp) ? ($exp->certificate_url ?? null) : ($exp['certificate_url'] ?? null);
                    if ($eCert && !str_starts_with($eCert, 'http') && !str_starts_with($eCert, '/')) {
                        $eCert = asset($eCert);
                    }

                    // Process responsibilities into clean list
                    $respItems = [];
                    if (is_object($exp) && is_array($exp->responsibilities) && count($exp->responsibilities) > 0) {
                        $respItems = $exp->responsibilities;
                    } elseif (is_object($exp) && !empty($exp->description)) {
                        $lines = preg_split('/[\r\n]+/', $exp->description);
                        $respItems = array_values(array_filter(array_map(function ($l) {
                            return trim(ltrim($l, "•-*\t "));
                        }, $lines), fn($r) => !empty($r)));
                        if (count($respItems) <= 1 && str_contains($exp->description, '.')) {
                            $sentences = preg_split('/(?<=[.?!])\s+/', $exp->description);
                            $respItems = array_values(array_filter(array_map('trim', $sentences), fn($r) => !empty($r)));
                        }
                    }

                    // Process technologies
                    $techItems = [];
                    if (is_object($exp) && is_array($exp->technologies)) {
                        $techItems = $exp->technologies;
                    }
                @endphp
                @php
                    $parsedResponsibilities = [];
                    foreach ($respItems as $idx => $item) {
                        if (str_contains($item, ':')) {
                            $parts = explode(':', $item, 2);
                            $title = trim($parts[0]);
                            $desc = trim($parts[1]);
                        } else {
                            $title = 'Key Contribution ' . ($idx + 1);
                            $desc = $item;
                        }
                        $parsedResponsibilities[] = ['title' => $title, 'desc' => $desc];
                    }

                    // Tech styling helper map
                    $techStyles = [
                        'PHP' => ['bg' => 'bg-[#777BB4]/15 border-[#777BB4]/35 text-[#a5a9d6]', 'icon' => 'php'],
                        'Laravel' => ['bg' => 'bg-[#FF2D20]/15 border-[#FF2D20]/35 text-[#ff786e]', 'icon' => 'laravel'],
                        'MySQL' => ['bg' => 'bg-[#00758F]/15 border-[#00758F]/35 text-[#38bdf8]', 'icon' => 'mysql'],
                        'JavaScript' => ['bg' => 'bg-[#F7DF1E]/15 border-[#F7DF1E]/35 text-[#fde047]', 'icon' => 'js'],
                        'React.js' => ['bg' => 'bg-[#61DAFB]/15 border-[#61DAFB]/35 text-[#61DAFB]', 'icon' => 'react'],
                        'HTML' => ['bg' => 'bg-[#E34F26]/15 border-[#E34F26]/35 text-[#fb923c]', 'icon' => 'html'],
                        'HTML5' => ['bg' => 'bg-[#E34F26]/15 border-[#E34F26]/35 text-[#fb923c]', 'icon' => 'html'],
                        'CSS' => ['bg' => 'bg-[#1572B6]/15 border-[#1572B6]/35 text-[#38bdf8]', 'icon' => 'css'],
                        'CSS3' => ['bg' => 'bg-[#1572B6]/15 border-[#1572B6]/35 text-[#38bdf8]', 'icon' => 'css'],
                        'Tailwind CSS' => ['bg' => 'bg-[#06B6D4]/15 border-[#06B6D4]/35 text-[#22d3ee]', 'icon' => 'tailwind'],
                        'Postman' => ['bg' => 'bg-[#FF6C37]/15 border-[#FF6C37]/35 text-[#fb923c]', 'icon' => 'postman'],
                        'Git' => ['bg' => 'bg-[#F05032]/15 border-[#F05032]/35 text-[#f87171]', 'icon' => 'git'],
                        'Git & GitHub' => ['bg' => 'bg-[#F05032]/15 border-[#F05032]/35 text-[#f87171]', 'icon' => 'git'],
                        'GitHub' => ['bg' => 'bg-slate-800/80 border-slate-700 text-slate-200', 'icon' => 'github'],
                    ];
                @endphp
                <div class="group relative rounded-3xl bg-[#091122]/90 border border-sky-500/30 p-6 sm:p-8 lg:p-10 backdrop-blur-xl shadow-[0_0_50px_rgba(56,189,248,0.08)] hover:border-sky-400/50 transition-all duration-300">
                    <div class="flex flex-col lg:flex-row items-stretch justify-between gap-8 lg:gap-10">
                        
                        <!-- Left Column: Company, Role & Bio + Graphic -->
                        <div class="w-full lg:w-[35%] flex flex-col justify-between space-y-6 flex-shrink-0">
                            <div>
                                <!-- Top Row: Logo, Role, Company & Status -->
                                <div class="flex items-start space-x-4">
                                    <!-- Company Logo Container (White background rounded box) -->
                                    <div class="flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white p-2.5 shadow-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                        @if($eLogo)
                                            <img src="{{ $eLogo }}" alt="{{ $eCompany }}" class="w-full h-full object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="hidden flex-col items-center justify-center text-center">
                                                <span class="text-xs font-black text-slate-900 tracking-tighter">DATAAEGIS</span>
                                            </div>
                                        @else
                                            <span class="text-xs font-black text-slate-900 tracking-tighter">DATAAEGIS</span>
                                        @endif
                                    </div>

                                    <!-- Role, Company & Current Pill -->
                                    <div class="space-y-1 flex-1 min-w-0">
                                        <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight leading-snug">
                                            {{ $eRole }}
                                        </h3>
                                        <p class="text-xs sm:text-sm font-semibold text-sky-400 truncate">
                                            {{ $eCompany }}
                                        </p>
                                        @if($eCurrent)
                                            <div class="pt-0.5">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-950/70 border border-emerald-500/40 text-emerald-400 text-[11px] font-semibold">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                    Current
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Date & Location Meta Row -->
                                <div class="flex flex-wrap items-center gap-3 pt-5 text-xs font-medium text-slate-300">
                                    <div class="flex items-center gap-1.5">
                                        <!-- Calendar Icon in blue square -->
                                        <div class="w-5 h-5 rounded-md bg-sky-500/20 text-sky-400 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/>
                                            </svg>
                                        </div>
                                        <span>{{ $eDuration }}</span>
                                    </div>

                                    @if($eLocation)
                                        <span class="text-slate-600 font-normal">|</span>
                                        <div class="flex items-center gap-1.5">
                                            <!-- Map Pin Icon -->
                                            <div class="w-5 h-5 rounded-md bg-sky-500/20 text-sky-400 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <span>{{ $eLocation }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Trainee Summary Statement -->
                                @php
                                    $eShortDesc = is_object($exp) ? ($exp->short_description ?: ($exp->summary ?: $exp->description)) : ($exp['short_description'] ?? ($exp['summary'] ?? ($exp['description'] ?? '')));
                                    if (empty($eShortDesc)) {
                                        $eShortDesc = 'As a ' . $eRole . ', I contribute to the development and maintenance of web-based applications while gaining practical experience with professional software development workflows.';
                                    }
                                @endphp
                                <p class="mt-5 text-xs sm:text-sm text-slate-300/90 leading-relaxed">
                                    {{ $eShortDesc }}
                                </p>
                            </div>

                            <!-- Bottom Left: Glowing Developer / Code SVG Illustration -->
                            <div class="pt-4 flex items-end justify-start select-none">
                                <div class="relative w-44 sm:w-48 opacity-90 group-hover:opacity-100 transition-opacity">
                                    <svg viewBox="0 0 200 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-[0_0_15px_rgba(56,189,248,0.3)]">
                                        <!-- Laptop Base & Glow -->
                                        <path d="M20 95L140 95L150 100L10 100L20 95Z" fill="#0284c7" opacity="0.8"/>
                                        <rect x="35" y="30" width="90" height="60" rx="6" fill="#0f172a" stroke="#38bdf8" stroke-width="2.5"/>
                                        <!-- Laptop Screen Header & Code Logo -->
                                        <rect x="42" y="36" width="76" height="48" rx="3" fill="#030712"/>
                                        <text x="80" y="65" font-family="monospace" font-size="16" font-weight="bold" fill="#38bdf8" text-anchor="middle">&lt;/&gt;</text>
                                        <!-- Ambient Screen Glow -->
                                        <circle cx="80" cy="60" r="25" fill="#38bdf8" opacity="0.15" filter="blur(8px)"/>
                                        <!-- Plant Pot next to laptop -->
                                        <path d="M152 75L168 75L165 95L155 95L152 75Z" fill="#0369a1"/>
                                        <ellipse cx="160" cy="74" rx="8" ry="2" fill="#38bdf8" opacity="0.6"/>
                                        <!-- Leaves -->
                                        <path d="M160 74Q155 60 150 63Q158 68 160 74Z" fill="#38bdf8"/>
                                        <path d="M160 74Q165 58 170 62Q163 67 160 74Z" fill="#38bdf8"/>
                                        <path d="M160 74Q160 50 160 74Z" stroke="#38bdf8" stroke-width="2"/>
                                        <path d="M160 62Q160 48 162 48Q160 55 160 62Z" fill="#7dd3fc"/>
                                    </svg>
                                </div>
                            </div>

                        </div>

                        <!-- Right Column: Key Responsibilities (2-Cols Grid) & Technologies Used -->
                        <div class="w-full lg:w-[65%] lg:border-l lg:border-slate-800/80 lg:pl-8 flex flex-col justify-between space-y-6 flex-1 min-w-0">
                            <div>
                                <!-- Header Row: Title & Action Buttons -->
                                <div class="flex items-center justify-between gap-4 pb-4 border-b border-slate-800/80">
                                    <div class="flex items-center space-x-2.5">
                                        <!-- Target Icon Badge -->
                                        <div class="w-7 h-7 rounded-lg bg-sky-500/20 text-sky-400 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="9" stroke="currentColor"/>
                                                <circle cx="12" cy="12" r="5" stroke="currentColor"/>
                                                <circle cx="12" cy="12" r="1.5" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-base sm:text-lg font-bold text-white tracking-tight">
                                            Key Responsibilities
                                        </h4>
                                    </div>

                                    <div class="flex items-center gap-2.5">
                                        @if($eCert)
                                            <a href="{{ $eCert }}" target="_blank" rel="noopener noreferrer" 
                                               class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-semibold transition-all hover:scale-105 active:scale-95 shadow-sm">
                                                <span>📜 Certificate</span>
                                            </a>
                                        @endif

                                        <a href="{{ route('experience') }}" 
                                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-sky-950/60 hover:bg-sky-900/80 border border-sky-500/40 text-sky-300 text-xs font-semibold transition-all hover:scale-105 active:scale-95 shadow-sm group/btn">
                                            <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                            </svg>
                                            <span>View Details</span>
                                            <svg class="w-3 h-3 transform group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                        </a>
                                    </div>
                                </div>

                                <!-- Responsibilities Grid (2-Columns Layout matching screenshot) -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 pt-4">
                                    @foreach(array_slice($parsedResponsibilities, 0, 8) as $item)
                                        <div class="flex items-start space-x-3 min-w-0">
                                            <!-- Blue Checkmark in Circle -->
                                            <div class="w-5 h-5 rounded-full bg-sky-500 text-slate-950 flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                                                <svg class="w-3.5 h-3.5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </div>
                                            <div class="space-y-0.5 min-w-0 flex-1">
                                                <h5 class="text-xs sm:text-sm font-bold text-white tracking-tight">
                                                    {{ $item['title'] }}
                                                </h5>
                                                <p class="text-[11px] sm:text-xs text-slate-400 leading-relaxed">
                                                    {{ $item['desc'] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Technologies Used Row (Rich Styled Tech Badges) -->
                            @if(count($techItems) > 0)
                                <div class="pt-4 border-t border-slate-800/80">
                                    <div class="flex items-center gap-1.5 text-xs font-bold text-slate-300 tracking-wide mb-3">
                                        <span class="text-sky-400 font-mono font-bold">&lt;/&gt;</span>
                                        <span>Technologies Used</span>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2">
                                        @foreach($techItems as $tech)
                                            @php
                                                $trimmedTech = trim($tech);
                                                $style = $techStyles[$trimmedTech] ?? ['bg' => 'bg-sky-950/60 border-sky-800/50 text-sky-300', 'icon' => 'default'];
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold rounded-lg border {{ $style['bg'] }} shadow-sm hover:scale-105 transition-transform duration-200 cursor-default">
                                                @if($style['icon'] === 'php')
                                                    <span class="px-1 py-0.2 bg-[#777BB4] text-white text-[9px] font-black rounded">PHP</span>
                                                @elseif($style['icon'] === 'laravel')
                                                    <span class="text-[#FF2D20] font-black text-xs">⚑</span>
                                                @elseif($style['icon'] === 'mysql')
                                                    <span class="text-[#00758F] font-bold text-xs">🐬</span>
                                                @elseif($style['icon'] === 'js')
                                                    <span class="px-1 py-0.2 bg-[#F7DF1E] text-black text-[9px] font-black rounded">JS</span>
                                                @elseif($style['icon'] === 'react')
                                                    <span class="text-[#61DAFB] font-bold text-xs">⚛</span>
                                                @elseif($style['icon'] === 'html')
                                                    <span class="px-1 py-0.2 bg-[#E34F26] text-white text-[9px] font-black rounded">5</span>
                                                @elseif($style['icon'] === 'css')
                                                    <span class="px-1 py-0.2 bg-[#1572B6] text-white text-[9px] font-black rounded">3</span>
                                                @elseif($style['icon'] === 'tailwind')
                                                    <span class="text-[#06B6D4] font-bold text-xs">≈</span>
                                                @elseif($style['icon'] === 'postman')
                                                    <span class="text-[#FF6C37] font-bold text-xs">🚀</span>
                                                @elseif($style['icon'] === 'git')
                                                    <span class="text-[#F05032] font-bold text-xs">⌥</span>
                                                @elseif($style['icon'] === 'github')
                                                    <span class="text-white font-bold text-xs">🐙</span>
                                                @endif
                                                <span>{{ $trimmedTech }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>