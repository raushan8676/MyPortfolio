@php
    $profile = $profile ?? \App\Models\ProfileSetting::first() ?? new \App\Models\ProfileSetting();
@endphp

<section id="contact" class="relative bg-[#070c18] py-20 lg:py-28 overflow-hidden border-t border-slate-800/50">
    <!-- Ambient Glow Effects -->
    <div class="absolute top-1/3 left-1/4 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Left Column: Heading & Contact Info -->
            <div class="lg:col-span-5 flex flex-col justify-between h-full">
                <div>
                    <!-- Heading -->
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                        Get <span class="text-sky-400">In Touch</span>
                    </h2>
                    
                    <!-- Subtitle -->
                    <p class="mt-4 text-slate-400 text-sm sm:text-base leading-relaxed max-w-md">
                        Have a project in mind, an opportunity to discuss, or just want to say hello? Send a message and I'll get back to you!
                    </p>
                </div>

                <!-- Contact Details List -->
                <div class="mt-10 space-y-5 sm:space-y-6">
                    <!-- Email -->
                    @if($profile->email)
                    <a href="mailto:{{ $profile->email }}" class="flex items-center space-x-4 group">
                        <div class="w-12 h-12 rounded-full bg-blue-600/15 border border-blue-500/30 flex items-center justify-center text-sky-400 group-hover:scale-110 group-hover:bg-blue-600/25 transition-all duration-200">
                            <!-- Mail Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-medium text-slate-300 group-hover:text-white transition-colors">
                            {{ $profile->email }}
                        </span>
                    </a>
                    @endif

                    <!-- Phone -->
                    @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" class="flex items-center space-x-4 group">
                        <div class="w-12 h-12 rounded-full bg-blue-600/15 border border-blue-500/30 flex items-center justify-center text-sky-400 group-hover:scale-110 group-hover:bg-blue-600/25 transition-all duration-200">
                            <!-- Phone Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-medium text-slate-300 group-hover:text-white transition-colors">
                            {{ $profile->phone }}
                        </span>
                    </a>
                    @endif

                    <!-- Location -->
                    @if($profile->location)
                    <div class="flex items-center space-x-4 group">
                        <div class="w-12 h-12 rounded-full bg-blue-600/15 border border-blue-500/30 flex items-center justify-center text-sky-400 group-hover:scale-110 group-hover:bg-blue-600/25 transition-all duration-200">
                            <!-- Pin Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-medium text-slate-300">
                            {{ $profile->location }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Contact Form -->
            <div class="lg:col-span-7">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Row: Name and Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <input type="text" 
                                   name="name" 
                                   placeholder="Your Name" 
                                   required
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-900/70 border border-slate-800 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-sky-500/70 focus:ring-1 focus:ring-sky-500/30 transition-all duration-200">
                        </div>
                        <div>
                            <input type="email" 
                                   name="email" 
                                   placeholder="Your Email" 
                                   required
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-900/70 border border-slate-800 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-sky-500/70 focus:ring-1 focus:ring-sky-500/30 transition-all duration-200">
                        </div>
                    </div>

                    <div>
                        <input type="text" 
                               name="subject" 
                               placeholder="Subject (Optional)" 
                               value="{{ old('subject') }}"
                               class="w-full px-4 py-3.5 rounded-xl bg-slate-900/70 border border-slate-800 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-sky-500/70 focus:ring-1 focus:ring-sky-500/30 transition-all duration-200">
                    </div>

                    <!-- Message Textarea -->
                    <div>
                        <textarea name="message" 
                                  rows="5" 
                                  placeholder="Your Message..." 
                                  required
                                  class="w-full px-4 py-3.5 rounded-xl bg-slate-900/70 border border-slate-800 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-sky-500/70 focus:ring-1 focus:ring-sky-500/30 transition-all duration-200 resize-none">{{ old('message') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full py-4 px-6 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-500 hover:from-blue-700 hover:via-indigo-700 hover:to-sky-600 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 active:scale-[0.99] transition-all duration-200 flex items-center justify-center space-x-2">
                            <!-- Paper Plane / Send Icon -->
                            <svg class="w-4 h-4 transform rotate-45 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                            <span>Send Message</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Floating Back to Top Button -->
    <a href="#home" 
       id="back-to-top"
       title="Back to Top"
       class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/35 hover:bg-blue-500 hover:scale-110 active:scale-95 transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </a>
</section>

