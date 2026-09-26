@php
    $dbEducations = \App\Models\Education::orderBy('sort_order')->get();

    $educations = [];
    foreach ($dbEducations as $idx => $ed) {
        $certPath = $ed->certificate_url;
        if ($certPath && !str_starts_with($certPath, 'http') && !str_starts_with($certPath, '/')) {
            $certPath = asset($certPath);
        }

        $degreeName = $ed->degree;
        $isPurple = str_contains(strtolower($degreeName), 'b.tech') || str_contains(strtolower($degreeName), 'bachelor') || $idx % 2 === 1;

        $startYear = $ed->start_year ?? '';
        $endYear = $ed->end_year ?? 'Present';
        $period = !empty($startYear) ? ($startYear . ' – ' . ($endYear ?: 'Present')) : ($ed->period ?? '');
        if (trim($period) === '– Present' || trim($period) === '- Present') {
            $period = 'Present';
        }

        // Tags / Subjects directly from backend
        $tagList = [];
        if (is_array($ed->tags)) {
            foreach ($ed->tags as $t) {
                $tagList[] = is_array($t) ? ($t['name'] ?? '') : $t;
            }
        }
        $tagList = array_values(array_filter($tagList));

        // Courses / Curriculum directly from backend
        $courses = is_array($ed->courses) ? $ed->courses : [];

        $educations[] = [
            'id' => $ed->id,
            'degree' => $degreeName,
            'institution' => $ed->institution,
            'location' => $ed->location ?: '',
            'period' => $period,
            'badge' => $ed->field_of_study ?? ($ed->status ?? ''),
            'grade' => $ed->grade_or_score,
            'certificate_url' => $certPath,
            'current' => str_contains(strtolower($endYear), 'present') || empty($endYear),
            'description' => $ed->description ?? ($ed->summary ?? ''),
            'is_purple' => $isPurple,
            'tag_label' => $isPurple ? 'Key Technologies' : 'Key Subjects',
            'tags' => $tagList,
            'courses' => $courses,
        ];
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Education &amp; Academic Journey | Raushan Kumar</title>
    <meta name="description"
        content="Explore Raushan Kumar's educational background, B.Tech CSE degree at Dr C V Raman University, and coursework specializations.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

    <script>
        // Initialize theme before rendering to avoid flash
        (function () {
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

<body
    class="bg-[#070c18] text-slate-100 min-h-screen antialiased selection:bg-sky-500 selection:text-white flex flex-col justify-between">

    <!-- Header -->
    @include('includes.header')

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Hero Banner -->
        <section class="relative py-16 lg:py-20 overflow-hidden border-b border-slate-800/50">
            <!-- Ambient Glows -->
            <div
                class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse">
            </div>
            <div
                class="absolute bottom-5 left-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10">
            </div>
            <div
                class="absolute top-10 right-1/3 w-72 h-72 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none -z-10">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 mb-6">
                    <a href="{{ route('home') }}"
                        class="text-xs font-semibold text-sky-400 hover:text-sky-300 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Home
                    </a>
                    <span class="text-slate-600">/</span>
                    <span class="text-xs font-semibold text-slate-300">Education</span>
                </div>

                <!-- Header Content -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex items-start gap-4 max-w-3xl">
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
                            <h1
                                class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight flex flex-wrap items-center gap-2">
                                <span>Academic</span>
                                <span
                                    class="bg-gradient-to-r from-sky-400 via-blue-400 to-indigo-400 bg-clip-text text-transparent">Education</span>
                            </h1>
                            <p class="mt-2 text-slate-400 text-sm sm:text-base leading-relaxed">
                                My educational background, computer science engineering foundations, and coursework
                                specializations.
                            </p>
                            <!-- Glowing Underline Accent -->
                            <div
                                class="w-16 h-1 rounded-full bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-500 mt-3 shadow-sm shadow-sky-400/50">
                            </div>
                        </div>
                    </div>

                    <!-- Tilted Tagline on Right -->
                    <div class="hidden sm:flex flex-col items-end justify-center select-none text-right flex-shrink-0">
                        <div
                            class="transform -rotate-6 font-['Caveat',_cursive,_system-ui] text-sky-400/90 hover:text-sky-300 transition-colors text-2xl lg:text-3xl font-bold leading-tight drop-shadow-[0_0_12px_rgba(56,189,248,0.4)]">
                            <span>Learning</span><br>
                            <span class="pl-3">Today</span><br>
                            <span>Building</span><br>
                            <span class="pl-3">Tomorrow</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Education Cards Section (2-Columns Grid) -->
        <section class="py-16 lg:py-24 bg-[#070c18] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-stretch">
                    @foreach($educations as $edu)
                        @if(!$edu['is_purple'])
                            <!-- Cyan / Sky Glowing Card (Higher Secondary - 12th) -->
                            <div
                                class="group relative rounded-3xl bg-[#081126]/90 border border-sky-500/50 p-6 sm:p-8 backdrop-blur-xl shadow-[0_0_35px_rgba(56,189,248,0.12)] hover:border-sky-400 hover:shadow-[0_0_45px_rgba(56,189,248,0.22)] transition-all duration-300 flex flex-col justify-between">
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
                                                <h2
                                                    class="text-xl sm:text-2xl font-bold text-white tracking-tight leading-snug">
                                                    {{ $edu['degree'] }}
                                                </h2>
                                                @if($edu['badge'])
                                                    <div class="mt-1.5 flex flex-wrap items-center gap-2">
                                                        <span
                                                            class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-semibold bg-emerald-950/70 border border-emerald-500/40 text-emerald-400">
                                                            {{ $edu['badge'] }}
                                                        </span>
                                                        @if(!empty($edu['grade']))
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-950/70 border border-sky-500/30 text-sky-300">
                                                                Score: {{ $edu['grade'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Date Pill -->
                                        <div
                                            class="px-3.5 py-1.5 rounded-xl bg-sky-950/60 border border-sky-500/30 text-sky-300 text-xs font-semibold flex items-center gap-1.5 flex-shrink-0 self-start shadow-sm">
                                            <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                            </svg>
                                            <span>{{ $edu['period'] }}</span>
                                        </div>
                                    </div>

                                    <!-- Institution & Location -->
                                    <div class="mt-5 space-y-1.5">
                                        <div class="flex items-center gap-2 text-sm font-medium text-slate-300">
                                            <svg class="w-4 h-4 text-sky-400/90 flex-shrink-0" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 7.868V14a1 1 0 001 1h1v3a1 1 0 001 1h8a1 1 0 001-1v-3h1a1 1 0 001-1V7.868a1 1 0 00.496-1.736l-7-4zM6 14v-4h2v4H6zm4 0v-4h2v4h-2zm4 0v-4h2v4h-2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $edu['institution'] }}</span>
                                        </div>
                                        @if($edu['location'])
                                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                                <svg class="w-3.5 h-3.5 text-sky-400/80 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433 1.244-.77 2.879-2.028 4.098-3.753C16.666 13.14 17.5 10.99 17.5 8.5c0-4.142-3.358-7.5-7.5-7.5S2.5 4.358 2.5 8.5c0 2.49.834 4.64 2.03 6.099 1.22 1.725 2.854 2.983 4.098 3.753.311.193.571.337.757.433a5.742 5.742 0 00.281.14l.018.008.006.003zM10 11.5a3 3 0 100-6 3 3 0 000 6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>{{ $edu['location'] }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Divider -->
                                    <div class="border-b border-slate-800/80 my-5"></div>

                                    <!-- Description -->
                                    <p class="text-xs sm:text-sm text-slate-300/90 leading-relaxed">
                                        {{ $edu['description'] }}
                                    </p>

                                    <!-- Curriculum Highlights -->
                                    <div class="mt-5 space-y-2.5">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                                            Curriculum Modules &amp; Focus:
                                        </span>
                                        <div class="grid grid-cols-1 gap-2.5">
                                            @foreach($edu['courses'] as $course)
                                                <div
                                                    class="p-3 rounded-xl bg-slate-900/60 border border-slate-800/70 flex items-start space-x-2.5">
                                                    <div
                                                        class="w-4 h-4 rounded-full bg-sky-500/15 text-sky-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-xs font-semibold text-slate-200">{{ $course['name'] }}</h4>
                                                        <p class="text-[11px] text-slate-400 leading-relaxed mt-0.5">
                                                            {{ $course['desc'] }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom Section: Key Subjects -->
                                <div class="mt-6 pt-4 border-t border-slate-800/80">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2.5 block">
                                        {{ $edu['tag_label'] }}
                                    </span>
                                    <div class="flex flex-wrap items-center gap-2">
                                        @foreach($edu['tags'] as $tag)
                                            <span
                                                class="px-3 py-1 text-xs font-medium text-sky-300 bg-sky-950/60 border border-sky-800/60 hover:border-sky-500/50 rounded-full transition-all">
                                                {{ $tag }}
                                            </span>
                                        @endforeach

                                        @if($edu['certificate_url'])
                                            <a href="{{ $edu['certificate_url'] }}" target="_blank" rel="noopener noreferrer"
                                                class="ml-auto inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-semibold transition-all">
                                                <span>📜 View Certificate</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @else

                            <!-- Purple / Violet Glowing Card (B.Tech in CSE) -->
                            <div
                                class="group relative rounded-3xl bg-[#0d0c26]/90 border border-purple-500/50 p-6 sm:p-8 backdrop-blur-xl shadow-[0_0_35px_rgba(168,85,247,0.12)] hover:border-purple-400 hover:shadow-[0_0_45px_rgba(168,85,247,0.22)] transition-all duration-300 flex flex-col justify-between">
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
                                                <h2
                                                    class="text-xl sm:text-2xl font-bold text-white tracking-tight leading-snug">
                                                    {{ $edu['degree'] }}
                                                </h2>
                                                @if($edu['badge'])
                                                    <div class="mt-1.5 flex flex-wrap items-center gap-2">
                                                        <span
                                                            class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-semibold bg-purple-950/70 border border-purple-500/40 text-purple-300">
                                                            {{ $edu['badge'] }}
                                                        </span>
                                                        @if(!empty($edu['grade']))
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-950/70 border border-purple-500/30 text-purple-300">
                                                                GPA: {{ $edu['grade'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Date Pill -->
                                        <div
                                            class="px-3.5 py-1.5 rounded-xl bg-purple-950/60 border border-purple-500/30 text-purple-300 text-xs font-semibold flex items-center gap-1.5 flex-shrink-0 self-start shadow-sm">
                                            <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                            </svg>
                                            <span>{{ $edu['period'] }}</span>
                                        </div>
                                    </div>

                                    <!-- Institution & Location -->
                                    <div class="mt-5 space-y-1.5">
                                        <div class="flex items-center gap-2 text-sm font-medium text-slate-300">
                                            <svg class="w-4 h-4 text-purple-400/90 flex-shrink-0" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 003 7.868V14a1 1 0 001 1h1v3a1 1 0 001 1h8a1 1 0 001-1v-3h1a1 1 0 001-1V7.868a1 1 0 00.496-1.736l-7-4zM6 14v-4h2v4H6zm4 0v-4h2v4h-2zm4 0v-4h2v4h-2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $edu['institution'] }}</span>
                                        </div>
                                        @if($edu['location'])
                                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                                <svg class="w-3.5 h-3.5 text-purple-400/80 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433 1.244-.77 2.879-2.028 4.098-3.753C16.666 13.14 17.5 10.99 17.5 8.5c0-4.142-3.358-7.5-7.5-7.5S2.5 4.358 2.5 8.5c0 2.49.834 4.64 2.03 6.099 1.22 1.725 2.854 2.983 4.098 3.753.311.193.571.337.757.433a5.742 5.742 0 00.281.14l.018.008.006.003zM10 11.5a3 3 0 100-6 3 3 0 000 6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>{{ $edu['location'] }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Divider -->
                                    <div class="border-b border-slate-800/80 my-5"></div>

                                    <!-- Description -->
                                    <p class="text-xs sm:text-sm text-slate-300/90 leading-relaxed">
                                        {{ $edu['description'] }}
                                    </p>

                                    <!-- Curriculum Highlights -->
                                    <div class="mt-5 space-y-2.5">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                                            Curriculum Modules &amp; Focus:
                                        </span>
                                        <div class="grid grid-cols-1 gap-2.5">
                                            @foreach($edu['courses'] as $course)
                                                <div
                                                    class="p-3 rounded-xl bg-slate-900/60 border border-slate-800/70 flex items-start space-x-2.5">
                                                    <div
                                                        class="w-4 h-4 rounded-full bg-purple-500/15 text-purple-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-xs font-semibold text-slate-200">{{ $course['name'] }}</h4>
                                                        <p class="text-[11px] text-slate-400 leading-relaxed mt-0.5">
                                                            {{ $course['desc'] }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom Section: Key Technologies -->
                                <div class="mt-6 pt-4 border-t border-slate-800/80">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2.5 block">
                                        {{ $edu['tag_label'] }}
                                    </span>
                                    <div class="flex flex-wrap items-center gap-2">
                                        @foreach($edu['tags'] as $tag)
                                            <span
                                                class="px-3 py-1 text-xs font-medium text-purple-300 bg-purple-950/60 border border-purple-800/60 hover:border-purple-500/50 rounded-full transition-all">
                                                {{ $tag }}
                                            </span>
                                        @endforeach

                                        @if($edu['certificate_url'])
                                            <a href="{{ $edu['certificate_url'] }}" target="_blank" rel="noopener noreferrer"
                                                class="ml-auto inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-semibold transition-all">
                                                <span>📜 View Certificate</span>
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

        <!-- Learning Philosophy & Foundation -->
        <section class="py-16 lg:py-20 bg-[#060a14] border-t border-slate-800/60 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-500/10 border border-sky-500/30 text-xs font-semibold text-sky-400 mb-3">
                        <span>🧠 Academic Engineering Principles</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        Theory Into <span
                            class="bg-gradient-to-r from-sky-400 to-indigo-400 bg-clip-text text-transparent">Practice</span>
                    </h2>
                    <p class="mt-2.5 text-slate-400 text-sm sm:text-base">
                        Bridging solid computer science academic theory with enterprise production software engineering.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8">
                    <div
                        class="p-6 sm:p-7 rounded-3xl bg-slate-900/60 border border-slate-800/80 hover:border-sky-500/40 backdrop-blur-sm shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-400 mb-5 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Algorithmic Thinking</h3>
                        <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                            Applying complexity optimization, efficient data structures, and clean algorithmic logic to
                            real-world database queries and API payloads.
                        </p>
                    </div>

                    <div
                        class="p-6 sm:p-7 rounded-3xl bg-slate-900/60 border border-slate-800/80 hover:border-indigo-500/40 backdrop-blur-sm shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 mb-5 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Secure Architecture</h3>
                        <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                            Implementing role-based authentication, sanitized data inputs, and robust MVC separation
                            learned through formal software engineering principles.
                        </p>
                    </div>

                    <div
                        class="p-6 sm:p-7 rounded-3xl bg-slate-900/60 border border-slate-800/80 hover:border-emerald-500/40 backdrop-blur-sm shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 mb-5 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Continuous Growth</h3>
                        <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                            Staying curious, reading documentation, exploring emerging frameworks, and mastering modern
                            full-stack developer ecosystems.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section
            class="py-20 bg-gradient-to-r from-blue-950/40 via-indigo-950/30 to-sky-950/40 border-t border-b border-slate-800/60 relative overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/10 border border-sky-500/30 text-xs font-semibold text-sky-400 mb-4">
                    <span>🚀 Production Impact</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Explore My Work Experience &amp; Projects
                </h2>
                <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                    See how academic computer science fundamentals translate into production-grade applications.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4 mt-8">
                    <a href="{{ route('experience') }}"
                        class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 hover:from-sky-400 hover:via-blue-500 hover:to-indigo-500 shadow-lg shadow-sky-500/25 active:scale-95 transition-all duration-300">
                        <span>View Work Experience</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>

                    <a href="{{ route('projects') }}"
                        class="inline-flex items-center justify-center px-8 py-3.5 rounded-xl text-sm font-semibold text-slate-200 bg-slate-900/90 border border-slate-700/80 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        Explore Projects
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    @include('includes.footer')

</body>

</html>