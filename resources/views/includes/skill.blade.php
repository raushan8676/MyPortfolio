@php
    $dbSkills = isset($skills) && count($skills) > 0 ? $skills : \App\Models\Skill::where('is_active', true)->orderBy('sort_order')->get();
@endphp

<section id="skills" class="relative bg-[#070c18] py-20 lg:py-24 overflow-hidden border-t border-slate-800/50">
    <!-- Ambient Lighting -->
    <div class="absolute top-1/3 right-1/4 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header -->
        <div class="mb-12 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    My <span class="text-sky-400">Skills</span>
                </h2>
                <p class="mt-2 text-slate-400 text-sm sm:text-base">
                    Technologies and tools I work with daily
                </p>
            </div>

            <a href="{{ route('skills') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-400 hover:text-sky-300">
                <span>View Complete Skills Matrix &rarr;</span>
            </a>
        </div>

        <!-- Skills Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-12 gap-3 sm:gap-4">
            @foreach($dbSkills as $item)
                @php
                    $sName = is_object($item) ? $item->name : $item['name'];
                    $sImg = is_object($item) ? $item->image : ($item['image'] ?? null);
                    $sCdn = is_object($item) ? $item->cdn_fallback : ($item['cdn_fallback'] ?? null);
                    
                    $imageSrc = '';
                    if (!empty($sImg)) {
                        $imageSrc = (str_starts_with($sImg, 'http') || str_starts_with($sImg, '/')) ? $sImg : asset($sImg);
                    }
                    $cleanSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $sName));
                    $cdnSrc = $sCdn ?: ($imageSrc ?: 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/' . $cleanSlug . '/' . $cleanSlug . '-original.svg');
                    $finalSrc = $imageSrc ?: $cdnSrc;
                @endphp
                <div class="group flex flex-col items-center justify-center p-4 h-28 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm hover:border-sky-500/50 hover:bg-slate-800/60 hover:-translate-y-1.5 transition-all duration-300 shadow-md cursor-pointer">
                    <!-- Skill Image / Logo -->
                    <div class="w-10 h-10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ $finalSrc }}" 
                             alt="{{ $sName }}" 
                             class="w-8 h-8 object-contain"
                             onerror="this.onerror=null; this.src='{{ $cdnSrc }}';">
                    </div>
                    <!-- Skill Name -->
                    <span class="mt-2.5 text-xs font-semibold text-slate-300 group-hover:text-white transition-colors text-center truncate w-full px-1">
                        {{ $sName }}
                    </span>
                </div>
            @endforeach
        </div>

    </div>
</section>

