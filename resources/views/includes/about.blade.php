@php
    $profile = $profile ?? \App\Models\ProfileSetting::first() ?? new \App\Models\ProfileSetting();
    $aboutResumeLink = $profile->resume_url ?: ($profile->resume_file ? (str_starts_with($profile->resume_file, 'http') ? $profile->resume_file : asset($profile->resume_file)) : null);
    if ($aboutResumeLink && !str_starts_with($aboutResumeLink, 'http') && !str_starts_with($aboutResumeLink, '/')) {
        $aboutResumeLink = asset($aboutResumeLink);
    }
@endphp

<section id="about" class="relative bg-[#070c18] py-20 lg:py-28 overflow-hidden border-t border-slate-800/50">
    <!-- Subtle Background Glow -->
    <div class="absolute top-1/2 left-0 -translate-y-1/2 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute bottom-0 right-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <!-- Left: Image Card with "Always Learning" Doodle -->
            <div class="lg:col-span-5 flex justify-center lg:justify-start">
                <div class="relative w-full max-w-sm sm:max-w-md group">
                    
                    <!-- Decorative Floating "Always Learning" Doodle -->
                    <div class="absolute top-4 left-4 z-20 select-none">
                        <p class="font-serif italic text-sm sm:text-base font-semibold text-slate-200 tracking-wide drop-shadow-md">
                            Always<br>Learning
                        </p>
                        <!-- Curved Arrow pointing towards photo -->
                        <svg class="w-8 h-8 text-sky-400 mt-0.5 ml-2 transform -rotate-12" viewBox="0 0 50 50" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 10 Q 18 35 38 40" />
                            <path d="M28 40 L 38 40 L 38 30" />
                        </svg>
                    </div>

                    <!-- Photo Card Container -->
                    <div class="relative rounded-2xl bg-gradient-to-b from-slate-800/40 via-slate-900/60 to-slate-950/80 border border-slate-700/60 p-2 sm:p-2.5 shadow-2xl backdrop-blur-sm overflow-hidden group-hover:border-sky-500/40 transition-all duration-300">
                        <div class="rounded-xl overflow-hidden bg-slate-900 aspect-[4/4.2] relative">
                            <img src="{{ isset($profile) && $profile->about_image_url ? asset($profile->about_image_url) : (isset($profile) && $profile->avatar_url ? asset($profile->avatar_url) : asset('images/about.jpg')) }}" 
                                 alt="{{ $profile->full_name ?? 'Raushan Kumar' }}" 
                                 class="w-full h-full object-cover object-center filter brightness-95 group-hover:scale-105 group-hover:brightness-100 transition-all duration-500"
                                 onerror="this.onerror=null; this.src='{{ asset('images/about.jpg') }}';">
                            <!-- Subtle dark vignette overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#070c18]/80 via-transparent to-transparent opacity-60"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Content & Info Badges -->
            <div class="lg:col-span-7 flex flex-col justify-center">
                
                <!-- Section Heading -->
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                    About <span class="text-sky-400">Me</span>
                </h2>

                <!-- Description Paragraphs -->
                <div class="mt-6 space-y-4 text-slate-300 text-sm sm:text-base leading-relaxed">
                    @if(!empty($profile->about_bio_1))
                        <p>{!! nl2br(e($profile->about_bio_1)) !!}</p>
                    @else
                        <p>
                            Hi, I'm <span class="text-white font-bold">{{ $profile->full_name ?? 'Raushan Kumar' }}</span>, a {{ $profile->title ?? 'Full-Stack Developer' }} and {{ $profile->degree ?? 'B.Tech CSE' }} student at <span class="text-slate-100 font-semibold underline decoration-sky-400/50 underline-offset-4">{{ $profile->university ?? 'Dr C V Raman University, Vaishali (Bihar)' }}</span>.
                        </p>
                    @endif

                    @if(!empty($profile->about_bio_2))
                        <p>{!! nl2br(e($profile->about_bio_2)) !!}</p>
                    @endif
                </div>

                <!-- Info Grid / Badges -->
                <div class="mt-8 pt-8 border-t border-slate-800/70 grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-4 items-center">
                    
                    <!-- Item 1: Location -->
                    <div class="flex items-center space-x-3.5 group">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 group-hover:scale-110 group-hover:bg-blue-500/20 transition-all duration-200">
                            <!-- Location Pin Icon -->
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-100 leading-tight">{{ $profile->location ?? 'Bihar, India' }}</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Location</p>
                        </div>
                    </div>

                    <!-- Item 2: Education -->
                    <div class="flex items-center space-x-3.5 group sm:border-l sm:border-slate-800/80 sm:pl-6">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 group-hover:scale-110 group-hover:bg-indigo-500/20 transition-all duration-200">
                            <!-- Graduation Cap Icon -->
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 002 10.057a.75.75 0 01-.23-1.337A60.653 60.653 0 0111.7 2.805z" />
                                <path d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 0110.94 15.47a2.25 2.25 0 002.12 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-100 leading-tight">{{ $profile->degree ?? 'B.Tech CSE' }}</h4>
                            <p class="text-xs text-slate-400 mt-0.5">({{ $profile->education_period ?? '2023 – 2027' }})</p>
                        </div>
                    </div>

                    <!-- Item 3: Current Semester -->
                    <div class="flex items-center space-x-3.5 group sm:border-l sm:border-slate-800/80 sm:pl-6">
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400 group-hover:scale-110 group-hover:bg-sky-500/20 transition-all duration-200">
                            <!-- Radar / Clock Target Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" />
                                <circle cx="12" cy="12" r="3" fill="currentColor" />
                                <path stroke-linecap="round" d="M12 3v3m0 12v3M3 12h3m12 0h3" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-100 leading-tight">{{ $profile->current_semester ?? 'Ongoing' }}</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Current Status</p>
                        </div>
                    </div>

                </div>

                <!-- Small Resume Preview Card & Actions -->
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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <span>Download</span>
                        </a>
                    </div>

                </div>
                @endif

                <!-- Section Footer Link -->
                <div class="mt-6 flex items-center">
                    <a href="{{ url('/about') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs sm:text-sm font-semibold text-slate-300 bg-slate-900/80 border border-slate-700/80 hover:bg-slate-800 hover:text-white transition-all duration-200 group">
                        <span>Read Full Story &amp; Timeline</span>
                        <svg class="w-4 h-4 text-sky-400 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

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
