@php
    $dbEducations = isset($educations) && count($educations) > 0 ? $educations : \App\Models\Education::orderBy('sort_order')->get();
@endphp

<section id="education" class="relative bg-[#070c18] py-20 lg:py-24 overflow-hidden border-t border-slate-800/50">
    <!-- Subtle Background Lighting -->
    <div
        class="absolute top-1/2 left-10 -translate-y-1/2 w-80 h-80 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none -z-10">
    </div>
    <div class="absolute bottom-5 right-1/4 w-72 h-72 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
            <div class="flex items-start gap-4">
                <!-- Glossy Icon Box with Gradient -->
                <div
                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-tr from-sky-400 via-sky-500 to-indigo-600 p-2.5 sm:p-3 shadow-lg shadow-sky-500/25 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 002 10.057a.75.75 0 01-.23-1.337A60.653 60.653 0 0111.7 2.805z" />
                        <path
                            d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 0110.94 15.47a2.25 2.25 0 002.12 0z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight flex items-center gap-2">
                        <span>Academic</span>
                        <span
                            class="bg-gradient-to-r from-sky-400 via-blue-400 to-indigo-400 bg-clip-text text-transparent">Education</span>
                    </h2>
                    <p class="mt-1 text-slate-400 text-xs sm:text-sm">
                        My educational background and foundational computer science studies.
                    </p>
                    <!-- Glowing Underline Accent -->
                    <div
                        class="w-14 h-1 rounded-full bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-500 mt-2.5 shadow-sm shadow-sky-400/50">
                    </div>
                </div>
            </div>

            <!-- Tilted Tagline on Right -->
            <div class="hidden sm:flex flex-col items-end justify-center select-none text-right">
                <div
                    class="transform -rotate-6 font-['Caveat',_cursive,_system-ui] text-sky-400/90 hover:text-sky-300 transition-colors text-xl lg:text-2xl font-bold leading-tight drop-shadow-[0_0_10px_rgba(56,189,248,0.4)]">
                    <span>Learning</span><br>
                    <span class="pl-2">Today</span><br>
                    <span>Building</span><br>
                    <span class="pl-2">Tomorrow</span>
                </div>
            </div>
        </div>

        <!-- Education Card List (2-Columns Grid) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-stretch">
            @foreach($dbEducations as $idx => $edu)
                @php
                    $edDegree = is_object($edu) ? $edu->degree : $edu['degree'];
                    $edInst = is_object($edu) ? $edu->institution : $edu['institution'];
                    $edLocation = is_object($edu) ? $edu->location : ($edu['location'] ?? null);
                    $startYear = is_object($edu) ? ($edu->start_year ?? '') : ($edu['start_year'] ?? '');
                    $endYear = is_object($edu) ? ($edu->end_year ?? 'Present') : ($edu['end_year'] ?? 'Present');
                    $edPeriod = !empty($startYear) ? ($startYear . ' – ' . ($endYear ?: 'Present')) : ($edu->period ?? ($edu['period'] ?? ''));
                    if (trim($edPeriod) === '– Present' || trim($edPeriod) === '- Present') {
                        $edPeriod = 'Present';
                    }
                    $edBadge = is_object($edu) ? ($edu->field_of_study ?? $edu->status) : ($edu['field_of_study'] ?? ($edu['status'] ?? ''));
                    $edGrade = is_object($edu) ? $edu->grade_or_score : ($edu['grade_or_score'] ?? null);
                    $edCert = is_object($edu) ? $edu->certificate_url : ($edu['certificate_url'] ?? null);
                    if ($edCert && !str_starts_with($edCert, 'http') && !str_starts_with($edCert, '/')) {
                        $edCert = asset($edCert);
                    }
                    $edDesc = is_object($edu) ? ($edu->description ?? $edu->summary) : ($edu['description'] ?? ($edu['summary'] ?? ''));

                    // Check if card is Sky Theme (1st card / 12th) or Purple Theme (2nd card / B.Tech)
                    $isPurple = str_contains(strtolower($edDegree), 'b.tech') || str_contains(strtolower($edDegree), 'bachelor') || $idx % 2 === 1;

                    // Tags/Subjects directly from backend
                    $tagList = [];
                    if (is_object($edu) && is_array($edu->tags)) {
                        foreach ($edu->tags as $t) {
                            $tagList[] = is_array($t) ? ($t['name'] ?? '') : $t;
                        }
                    } elseif (is_array($edu) && isset($edu['tags']) && is_array($edu['tags'])) {
                        foreach ($edu['tags'] as $t) {
                            $tagList[] = is_array($t) ? ($t['name'] ?? '') : $t;
                        }
                    }
                    $tagList = array_values(array_filter($tagList));

                    $tagLabel = $isPurple ? 'Key Technologies' : 'Key Subjects';
                @endphp

                @if(!$isPurple)
                    <!-- Cyan / Sky Glowing Card (Higher Secondary) -->
                    <div
                        class="group relative rounded-3xl bg-[#081126]/90 border border-sky-500/50 p-6 sm:p-7 backdrop-blur-xl shadow-[0_0_35px_rgba(56,189,248,0.12)] hover:border-sky-400 hover:shadow-[0_0_45px_rgba(56,189,248,0.22)] transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <!-- Header Row: Icon, Degree, Stream & Period -->
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <!-- Glossy Cyan Gradient Icon Box (Book) -->
                                    <div
                                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-sky-400 via-sky-500 to-blue-600 p-3.5 shadow-lg shadow-sky-500/30 flex items-center justify-center text-white flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                                        <svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </div>

                                    <div>
                                        <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight leading-snug">
                                            {{ $edDegree }}
                                        </h3>
                                        @if($edBadge)
                                            <div class="mt-1.5">
                                                <span
                                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-semibold bg-emerald-950/70 border border-emerald-500/40 text-emerald-400">
                                                    {{ $edBadge }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Date Pill -->
                                <div
                                    class="px-3 py-1 rounded-xl bg-sky-950/60 border border-sky-500/30 text-sky-300 text-xs font-semibold flex items-center gap-1.5 flex-shrink-0 self-start shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                    </svg>
                                    <span>{{ $edPeriod }}</span>
                                </div>
                            </div>

                            <!-- Institution & Location -->
                            <div class="mt-4 space-y-1">
                                <div class="flex items-center gap-2 text-xs sm:text-sm font-medium text-slate-300">
                                    <svg class="w-4 h-4 text-sky-400/90 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 7.868V14a1 1 0 001 1h1v3a1 1 0 001 1h8a1 1 0 001-1v-3h1a1 1 0 001-1V7.868a1 1 0 00.496-1.736l-7-4zM6 14v-4h2v4H6zm4 0v-4h2v4h-2zm4 0v-4h2v4h-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $edInst }}</span>
                                </div>
                                @if($edLocation)
                                    <div class="flex items-center gap-2 text-xs text-slate-400">
                                        <svg class="w-3.5 h-3.5 text-sky-400/80 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433 1.244-.77 2.879-2.028 4.098-3.753C16.666 13.14 17.5 10.99 17.5 8.5c0-4.142-3.358-7.5-7.5-7.5S2.5 4.358 2.5 8.5c0 2.49.834 4.64 2.03 6.099 1.22 1.725 2.854 2.983 4.098 3.753.311.193.571.337.757.433a5.742 5.742 0 00.281.14l.018.008.006.003zM10 11.5a3 3 0 100-6 3 3 0 000 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $edLocation }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Divider -->
                            <div class="border-b border-slate-800/80 my-4"></div>

                            <!-- Description -->
                            <p class="text-xs sm:text-sm text-slate-300/90 leading-relaxed">
                                {{ $edDesc }}
                            </p>
                        </div>

                        <!-- Bottom Section: Key Subjects -->
                        <div class="mt-5 pt-3">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2.5 block">
                                {{ $tagLabel }}
                            </span>
                            <div class="flex flex-wrap items-center gap-2">
                                @foreach($tagList as $tag)
                                    <span
                                        class="px-3 py-1 text-xs font-medium text-sky-300 bg-sky-950/60 border border-sky-800/60 hover:border-sky-500/50 rounded-full transition-all">
                                        {{ $tag }}
                                    </span>
                                @endforeach

                                @if($edCert)
                                    <a href="{{ $edCert }}" target="_blank" rel="noopener noreferrer"
                                        class="ml-auto inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-semibold transition-all">
                                        <span>📜 Certificate</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                @else

                    <!-- Purple / Violet Glowing Card (B.Tech CSE) -->
                    <div
                        class="group relative rounded-3xl bg-[#0d0c26]/90 border border-purple-500/50 p-6 sm:p-7 backdrop-blur-xl shadow-[0_0_35px_rgba(168,85,247,0.12)] hover:border-purple-400 hover:shadow-[0_0_45px_rgba(168,85,247,0.22)] transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <!-- Header Row: Icon, Degree, Stream & Period -->
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <!-- Glossy Purple Gradient Icon Box (Grad Cap) -->
                                    <div
                                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-600 to-purple-700 p-3.5 shadow-lg shadow-purple-500/30 flex items-center justify-center text-white flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 002 10.057a.75.75 0 01-.23-1.337A60.653 60.653 0 0111.7 2.805z" />
                                            <path
                                                d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 0110.94 15.47a2.25 2.25 0 002.12 0z" />
                                        </svg>
                                    </div>

                                    <div>
                                        <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight leading-snug">
                                            {{ $edDegree }}
                                        </h3>
                                        @if($edBadge)
                                            <div class="mt-1.5">
                                                <span
                                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-semibold bg-purple-950/70 border border-purple-500/40 text-purple-300">
                                                    {{ $edBadge }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Date Pill -->
                                <div
                                    class="px-3 py-1 rounded-xl bg-purple-950/60 border border-purple-500/30 text-purple-300 text-xs font-semibold flex items-center gap-1.5 flex-shrink-0 self-start shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                    </svg>
                                    <span>{{ $edPeriod }}</span>
                                </div>
                            </div>

                            <!-- Institution & Location -->
                            <div class="mt-4 space-y-1">
                                <div class="flex items-center gap-2 text-xs sm:text-sm font-medium text-slate-300">
                                    <svg class="w-4 h-4 text-purple-400/90 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 7.868V14a1 1 0 001 1h1v3a1 1 0 001 1h8a1 1 0 001-1v-3h1a1 1 0 001-1V7.868a1 1 0 00.496-1.736l-7-4zM6 14v-4h2v4H6zm4 0v-4h2v4h-2zm4 0v-4h2v4h-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $edInst }}</span>
                                </div>
                                @if($edLocation)
                                    <div class="flex items-center gap-2 text-xs text-slate-400">
                                        <svg class="w-3.5 h-3.5 text-purple-400/80 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433 1.244-.77 2.879-2.028 4.098-3.753C16.666 13.14 17.5 10.99 17.5 8.5c0-4.142-3.358-7.5-7.5-7.5S2.5 4.358 2.5 8.5c0 2.49.834 4.64 2.03 6.099 1.22 1.725 2.854 2.983 4.098 3.753.311.193.571.337.757.433a5.742 5.742 0 00.281.14l.018.008.006.003zM10 11.5a3 3 0 100-6 3 3 0 000 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $edLocation }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Divider -->
                            <div class="border-b border-slate-800/80 my-4"></div>

                            <!-- Description -->
                            <p class="text-xs sm:text-sm text-slate-300/90 leading-relaxed">
                                {{ $edDesc }}
                            </p>
                        </div>

                        <!-- Bottom Section: Key Technologies -->
                        <div class="mt-5 pt-3">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2.5 block">
                                {{ $tagLabel }}
                            </span>
                            <div class="flex flex-wrap items-center gap-2">
                                @foreach($tagList as $tag)
                                    <span
                                        class="px-3 py-1 text-xs font-medium text-purple-300 bg-purple-950/60 border border-purple-800/60 hover:border-purple-500/50 rounded-full transition-all">
                                        {{ $tag }}
                                    </span>
                                @endforeach

                                @if($edCert)
                                    <a href="{{ $edCert }}" target="_blank" rel="noopener noreferrer"
                                        class="ml-auto inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-semibold transition-all">
                                        <span>📜 Certificate</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                @endif
            @endforeach
        </div>

    </div>
</section>