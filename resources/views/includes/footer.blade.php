@php
    $profile = $profile ?? \App\Models\ProfileSetting::first() ?? new \App\Models\ProfileSetting();
    
    $socials = [];
    if (!empty($profile->github_url)) {
        $socials[] = [
            'name' => 'GitHub',
            'url' => $profile->github_url,
            'image' => 'images/icons/github.png',
            'cdn' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg',
        ];
    }
    if (!empty($profile->linkedin_url)) {
        $socials[] = [
            'name' => 'LinkedIn',
            'url' => $profile->linkedin_url,
            'image' => 'images/icons/linkedin.png',
            'cdn' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linkedin/linkedin-original.svg',
        ];
    }
    if (!empty($profile->twitter_url)) {
        $socials[] = [
            'name' => 'Twitter / X',
            'url' => $profile->twitter_url,
            'image' => 'images/icons/x.png',
            'cdn' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/twitter/twitter-original.svg',
        ];
    }
    if (!empty($profile->email)) {
        $socials[] = [
            'name' => 'Email',
            'url' => 'mailto:' . $profile->email,
            'image' => 'images/icons/email.png',
            'cdn' => 'https://cdn-icons-png.flaticon.com/512/732/732200.png',
        ];
    }
@endphp

<footer class="relative bg-[#060a14] border-t border-slate-800/80 py-8 overflow-hidden">
    <!-- Subtle Ambient Glow -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-96 h-20 bg-sky-500/5 rounded-full blur-2xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            
            <!-- Left: RK Logo & Copyright -->
            <div class="flex items-center space-x-3">
                <!-- RK Badge -->
                <a href="#home" class="flex items-center space-x-2 group">
                    <span class="text-xl font-black tracking-tighter">
                        <span class="text-sky-400">{{ substr($profile->first_name ?? 'R', 0, 1) }}</span><span class="text-slate-100">{{ substr($profile->last_name ?? 'K', 0, 1) }}</span>
                    </span>
                </a>
                <span class="text-xs text-slate-400">
                    © {{ date('Y') }} {{ $profile->full_name ?? 'Raushan Kumar' }}. All rights reserved.
                </span>
            </div>

            <!-- Middle: Social Icons using <img> -->
            <div class="flex items-center space-x-4">
                @foreach($socials as $social)
                    <a href="{{ $social['url'] }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       title="{{ $social['name'] }}" 
                       class="w-8 h-8 rounded-lg bg-slate-900/90 border border-slate-800/90 p-1.5 flex items-center justify-center hover:border-sky-500/60 hover:bg-slate-800 hover:scale-110 active:scale-95 transition-all duration-200">
                        <img src="{{ asset($social['image']) }}" 
                             alt="{{ $social['name'] }}" 
                             class="w-full h-full object-contain filter brightness-90 hover:brightness-100"
                             onerror="this.onerror=null; this.src='{{ $social['cdn'] }}';">
                    </a>
                @endforeach
            </div>

            <!-- Right: Built with Love & Admin Link -->
            <div class="text-xs text-slate-400 flex items-center gap-3">
                <div class="flex items-center gap-1.5">
                    <span>Built with</span>
                    <span class="text-rose-500">❤️</span>
                    <span>using Laravel &amp; Tailwind CSS</span>
                </div>
                <span class="text-slate-700">•</span>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sky-400 hover:text-sky-300 font-semibold transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/></svg>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-300 transition-colors" title="Admin Login">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    </a>
                @endauth
            </div>

        </div>
    </div>
</footer>

