<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-tr from-sky-500 to-indigo-600 text-white shadow-lg shadow-sky-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/></svg>
                    </span>
                    Portfolio Control Center
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Manage all public content, projects, skills, education, and user inquiries in real-time.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-sky-400 bg-sky-500/10 hover:bg-sky-500/20 border border-sky-500/20 rounded-xl transition-all shadow-sm">
                    <span>View Live Portfolio</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-900 min-h-screen" x-data="{ 
        activeTab: '{{ request()->get('tab', 'overview') }}',
        editSkillModal: false,
        activeSkill: {},
        editProjectModal: false,
        activeProject: {},
        editExpModal: false,
        activeExp: {},
        editEduModal: false,
        activeEdu: {},
        viewMsgModal: false,
        activeMsg: {}
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Success Alert Notification -->
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-between animate-fade-in shadow-lg shadow-emerald-500/5">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="$el.parentElement.remove()" class="text-emerald-400/60 hover:text-emerald-400">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 shadow-lg shadow-rose-500/5">
                    <p class="text-sm font-semibold mb-1">Please fix the following errors:</p>
                    <ul class="text-xs list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Navigation Tab Bar -->
            <div class="flex flex-wrap items-center gap-2 p-1.5 bg-slate-800/80 backdrop-blur-md rounded-2xl border border-slate-700/60 shadow-xl overflow-x-auto">
                <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    <span>Overview</span>
                </button>
                <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    <span>Profile & Bio</span>
                </button>
                <button @click="activeTab = 'skills'" :class="activeTab === 'skills' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    <span>Skills ({{ $stats['total_skills'] }})</span>
                </button>
                <button @click="activeTab = 'projects'" :class="activeTab === 'projects' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/></svg>
                    <span>Projects ({{ $stats['total_projects'] }})</span>
                </button>
                <button @click="activeTab = 'experience'" :class="activeTab === 'experience' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    <span>Experience ({{ $stats['total_experiences'] }})</span>
                </button>
                <button @click="activeTab = 'education'" :class="activeTab === 'education' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-5.25 6.557c0 1.5 1.5 3 5.25 3s5.25-1.5 5.25-3"/></svg>
                    <span>Education ({{ $stats['total_educations'] }})</span>
                </button>
                <button @click="activeTab = 'messages'" :class="activeTab === 'messages' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all relative">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    <span>Inquiries</span>
                    @if($stats['unread_messages'] > 0)
                        <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold bg-rose-500 text-white rounded-full leading-none">{{ $stats['unread_messages'] }}</span>
                    @endif
                </button>
            </div>

            <!-- TAB 1: OVERVIEW -->
            <div x-show="activeTab === 'overview'" class="space-y-6">
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/50 hover:border-sky-500/40 transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-400">Total Skills</span>
                            <span class="p-2 rounded-xl bg-sky-500/10 text-sky-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg></span>
                        </div>
                        <p class="text-3xl font-extrabold text-white mt-3">{{ $stats['total_skills'] }}</p>
                        <p class="text-[11px] text-slate-500 mt-1">Across 4 tech domains</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/50 hover:border-indigo-500/40 transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-400">Projects Showcase</span>
                            <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/></svg></span>
                        </div>
                        <p class="text-3xl font-extrabold text-white mt-3">{{ $stats['total_projects'] }}</p>
                        <p class="text-[11px] text-slate-500 mt-1">Full stack & web apps</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/50 hover:border-emerald-500/40 transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-400">Work Experience</span>
                            <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706"/></svg></span>
                        </div>
                        <p class="text-3xl font-extrabold text-white mt-3">{{ $stats['total_experiences'] }} Positions</p>
                        <p class="text-[11px] text-slate-500 mt-1">Full Stack & IT Roles</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/50 hover:border-purple-500/40 transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-400">Contact Messages</span>
                            <span class="p-2 rounded-xl bg-purple-500/10 text-purple-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75"/></svg></span>
                        </div>
                        <div class="flex items-baseline gap-2 mt-3">
                            <p class="text-3xl font-extrabold text-white">{{ $stats['total_messages'] }}</p>
                            @if($stats['unread_messages'] > 0)
                                <span class="text-xs font-bold text-rose-400">({{ $stats['unread_messages'] }} new)</span>
                            @endif
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">From contact form</p>
                    </div>
                </div>

                <!-- Quick Control & Profile Snapshot -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl space-y-4">
                        <h3 class="text-lg font-bold text-white flex items-center justify-between">
                            <span>Portfolio Profile Overview</span>
                            <button @click="activeTab = 'profile'" class="text-xs font-semibold text-sky-400 hover:text-sky-300">Edit Details &rarr;</button>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/40 space-y-2">
                                <span class="text-slate-500 font-semibold block uppercase tracking-wider text-[10px]">Name & Title</span>
                                <p class="text-white font-bold text-sm">{{ $profile->full_name }}</p>
                                <p class="text-slate-300">{{ $profile->title }}</p>
                                <div class="pt-2 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $profile->is_available_for_hire ? 'bg-emerald-400 animate-pulse' : 'bg-slate-500' }}"></span>
                                    <span class="text-[11px] text-slate-400">{{ $profile->is_available_for_hire ? 'Available for Hire' : 'Currently Busy' }}</span>
                                </div>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/40 space-y-2">
                                <span class="text-slate-500 font-semibold block uppercase tracking-wider text-[10px]">Contact Info</span>
                                <p class="text-slate-300"><strong class="text-slate-400">Email:</strong> {{ $profile->email }}</p>
                                <p class="text-slate-300"><strong class="text-slate-400">Phone:</strong> {{ $profile->phone ?? 'Not set' }}</p>
                                <p class="text-slate-300"><strong class="text-slate-400">Location:</strong> {{ $profile->location ?? 'Not set' }}</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/40">
                            <span class="text-slate-500 font-semibold block uppercase tracking-wider text-[10px] mb-1">Bio Summary</span>
                            <p class="text-slate-300 text-xs leading-relaxed">{{ $profile->bio_summary }}</p>
                        </div>
                    </div>

                    <!-- Recent Messages Preview -->
                    <div class="p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-white">Recent Inquiries</h3>
                            <button @click="activeTab = 'messages'" class="text-xs font-semibold text-sky-400 hover:text-sky-300">View All &rarr;</button>
                        </div>

                        <div class="space-y-3">
                            @forelse($messages->take(3) as $msg)
                                <div class="p-3 rounded-xl bg-slate-900/60 border {{ $msg->is_read ? 'border-slate-700/40' : 'border-sky-500/40 bg-sky-500/5' }} space-y-1">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="font-bold text-white">{{ $msg->name }}</span>
                                        <span class="text-[10px] text-slate-500">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-slate-400 truncate">{{ $msg->message }}</p>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-500 text-xs">
                                    No contact inquiries received yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: PROFILE & BIO SETTINGS -->
            <div x-show="activeTab === 'profile'" class="p-6 md:p-8 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl">
                <div class="max-w-4xl">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white">Profile & Bio Management</h3>
                        <p class="text-xs text-slate-400 mt-1">These details power the Hero section, About page, and Header/Footer contact links.</p>
                    </div>

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Full Name</label>
                                <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">
                            </div>

                            <!-- Professional Title -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Professional Title / Headline</label>
                                <input type="text" name="title" value="{{ old('title', $profile->title) }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">
                            </div>

                            <!-- Tagline -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Tagline (Hero Badge)</label>
                                <input type="text" name="tagline" value="{{ old('tagline', $profile->tagline) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Crafting Next-Gen Web Solutions">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Primary Email</label>
                                <input type="email" name="email" value="{{ old('email', $profile->email) }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="+91 9934336069">
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Location / Base</label>
                                <input type="text" name="location" value="{{ old('location', $profile->location) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="Delhi, India">
                            </div>

                            <!-- Resume Link -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Resume File / URL</label>
                                <input type="text" name="resume_url" value="{{ old('resume_url', $profile->resume_url) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="/resume.pdf">
                            </div>
                        </div>

                        <!-- Statistics Counter Values -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Years of Experience</label>
                                <input type="number" name="years_experience" value="{{ old('years_experience', $profile->years_experience) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Projects Completed</label>
                                <input type="number" name="projects_completed" value="{{ old('projects_completed', $profile->projects_completed) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Satisfied Clients</label>
                                <input type="number" name="satisfied_clients" value="{{ old('satisfied_clients', $profile->satisfied_clients) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">GitHub URL</label>
                                <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="https://github.com/username">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">LinkedIn URL</label>
                                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="https://linkedin.com/in/username">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Twitter / X URL</label>
                                <input type="url" name="twitter_url" value="{{ old('twitter_url', $profile->twitter_url) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="https://x.com/username">
                            </div>
                        </div>

                        <!-- Short Bio Summary -->
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Hero Short Bio</label>
                            <textarea name="bio_summary" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">{{ old('bio_summary', $profile->bio_summary) }}</textarea>
                        </div>

                        <!-- Detailed Bio (About Page) -->
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Detailed Biography (About Page)</label>
                            <textarea name="bio_full" rows="6" class="w-full px-4 py-2.5 rounded-xl bg-slate-900/80 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all">{{ old('bio_full', $profile->bio_full) }}</textarea>
                        </div>

                        <!-- Home & About Imagery Management Card -->
                        <div class="p-6 rounded-2xl bg-slate-900/90 border border-slate-700/80 space-y-6">
                            <div>
                                <h4 class="text-sm font-bold uppercase tracking-wider text-sky-400 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                    <span>Website Imagery (Home &amp; About Pages)</span>
                                </h4>
                                <p class="text-xs text-slate-400 mt-1">Upload images directly from your computer or enter an external URL to customize your Home Hero and About pages.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- 1. Home Page Hero Avatar -->
                                <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700/60 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-white uppercase tracking-wider">1. Home Page Hero Image</label>
                                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-sky-500/20 text-sky-300 font-semibold">Homepage Hero</span>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-20 rounded-2xl bg-slate-900 border border-slate-700 overflow-hidden flex-shrink-0 flex items-center justify-center relative">
                                            <img src="{{ $profile->avatar_url ? asset($profile->avatar_url) : asset('images/profile.jpg') }}" 
                                                 alt="Hero Preview" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.onerror=null; this.src='{{ asset('images/profile.jpg') }}';">
                                        </div>
                                        <div class="space-y-1.5 flex-1">
                                            <label class="block text-[11px] font-medium text-slate-300">Upload New File (.png, .jpg, .webp)</label>
                                            <input type="file" name="avatar" accept="image/*" class="block w-full text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-500 file:text-white hover:file:bg-sky-400 cursor-pointer">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-medium text-slate-400 mb-1">Or Direct Image URL / Path</label>
                                        <input type="text" name="avatar_url" value="{{ old('avatar_url', $profile->avatar_url) }}" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. /images/profile.jpg or https://...">
                                    </div>
                                </div>

                                <!-- 2. About Page Portrait -->
                                <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700/60 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-white uppercase tracking-wider">2. About Page Portrait</label>
                                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 font-semibold">About Section &amp; Page</span>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-20 rounded-2xl bg-slate-900 border border-slate-700 overflow-hidden flex-shrink-0 flex items-center justify-center relative">
                                            <img src="{{ $profile->about_image_url ? asset($profile->about_image_url) : ($profile->avatar_url ? asset($profile->avatar_url) : asset('images/about.jpg')) }}" 
                                                 alt="About Preview" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.onerror=null; this.src='{{ asset('images/about.jpg') }}';">
                                        </div>
                                        <div class="space-y-1.5 flex-1">
                                            <label class="block text-[11px] font-medium text-slate-300">Upload New File (.png, .jpg, .webp)</label>
                                            <input type="file" name="about_image" accept="image/*" class="block w-full text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-400 cursor-pointer">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-medium text-slate-400 mb-1">Or Direct Image URL / Path</label>
                                        <input type="text" name="about_image_url" value="{{ old('about_image_url', $profile->about_image_url) }}" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="e.g. /images/about.jpg or https://...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability & Profile Image -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-4 border-t border-slate-700/60">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_available_for_hire" value="1" {{ old('is_available_for_hire', $profile->is_available_for_hire) ? 'checked' : '' }} class="w-5 h-5 rounded-lg bg-slate-900 border-slate-700 text-sky-500 focus:ring-sky-500 focus:ring-offset-0">
                                <div>
                                    <span class="text-sm font-semibold text-white block">Available for Freelance / Full-Time</span>
                                    <span class="text-xs text-slate-500">Shows the green glowing badge in Hero section</span>
                                </div>
                            </label>

                            <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-sky-500/25 transition-all">
                                Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 3: SKILLS MANAGEMENT -->
            <div x-show="activeTab === 'skills'" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl">
                    <div>
                        <h3 class="text-xl font-bold text-white">Skills Matrix Management</h3>
                        <p class="text-xs text-slate-400 mt-1">Add, modify, or reorder technical skills shown on your Skills page and Homepage.</p>
                    </div>

                    <!-- Add Skill Button Trigger -->
                    <button @click="activeSkill = { name: '', category: 'frontend', proficiency: 90, is_active: 1, sort_order: {{ $skills->count() + 1 }} }; editSkillModal = true;" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold text-xs tracking-wider shadow-lg shadow-sky-500/20 hover:opacity-95 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Add New Skill</span>
                    </button>
                </div>

                <!-- Skills List Grouped By Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach(['frontend' => 'Frontend Development', 'backend' => 'Backend & APIs', 'database' => 'Database & Storage', 'tools' => 'Tools, DevOps & Collaboration'] as $catKey => $catTitle)
                        <div class="p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-700/60 pb-3">
                                <h4 class="text-sm font-bold text-white flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                                    {{ $catTitle }}
                                </h4>
                                <span class="text-xs font-semibold text-slate-500">{{ $skills->where('category', $catKey)->count() }} skills</span>
                            </div>

                            <div class="space-y-3">
                                @forelse($skills->where('category', $catKey) as $skill)
                                    <div class="p-3.5 rounded-2xl bg-slate-900/60 border border-slate-700/40 hover:border-sky-500/30 flex items-center justify-between gap-4 transition-all">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1.5">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-bold text-white">{{ $skill->name }}</span>
                                                    @if(!$skill->is_active)
                                                        <span class="text-[10px] px-1.5 py-0.2 rounded bg-amber-500/20 text-amber-300 font-semibold">Hidden</span>
                                                    @endif
                                                </div>
                                                <span class="text-xs font-bold text-sky-400">{{ $skill->proficiency }}%</span>
                                            </div>
                                            <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-gradient-to-r from-sky-400 to-indigo-500 h-1.5 rounded-full" style="width: {{ $skill->proficiency }}%"></div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <button @click="activeSkill = {{ json_encode($skill) }}; editSkillModal = true;" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-all" title="Edit Skill">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                            </button>

                                            <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" onsubmit="return confirm('Delete this skill permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-all" title="Delete Skill">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-slate-500 text-xs">No skills in this category yet.</div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB 4: PROJECTS MANAGEMENT -->
            <div x-show="activeTab === 'projects'" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl">
                    <div>
                        <h3 class="text-xl font-bold text-white">Projects Showcase Management</h3>
                        <p class="text-xs text-slate-400 mt-1">Publish full stack applications, featured client works, and repository links.</p>
                    </div>

                    <button @click="activeProject = { title: '', category: 'Full Stack Web App', description: '', technologies: '', features: '', github_url: '', demo_url: '', image_url: '', is_featured: 1, sort_order: {{ $projects->count() + 1 }} }; editProjectModal = true;" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold text-xs tracking-wider shadow-lg shadow-sky-500/20 hover:opacity-95 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Add New Project</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($projects as $project)
                        <div class="rounded-3xl bg-slate-800/80 border border-slate-700/60 overflow-hidden shadow-xl flex flex-col justify-between hover:border-sky-500/40 transition-all group">
                            <div>
                                <div class="relative h-44 bg-slate-900 overflow-hidden">
                                    @if($project->image_url ?? $project->icon)
                                        <img src="{{ asset($project->image_url ?? $project->icon) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-900 to-slate-800 text-slate-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/></svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 right-3 flex items-center gap-2">
                                        @if($project->is_featured)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/90 text-slate-950 uppercase tracking-wider backdrop-blur-md">Featured</span>
                                        @endif
                                    </div>
                                    <div class="absolute bottom-3 left-3">
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-slate-950/80 text-sky-400 border border-sky-500/20 backdrop-blur-md">{{ $project->category }}</span>
                                    </div>
                                </div>

                                <div class="p-6 space-y-3">
                                    <h4 class="text-lg font-bold text-white group-hover:text-sky-400 transition-colors">{{ $project->title }}</h4>
                                    <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed">{{ $project->description }}</p>

                                    @if(is_array($project->technologies) && count($project->technologies) > 0)
                                        <div class="flex flex-wrap gap-1.5 pt-2">
                                            @foreach($project->technologies as $tech)
                                                <span class="px-2 py-0.5 rounded-md bg-slate-900/80 border border-slate-700/60 text-slate-300 text-[10px]">{{ $tech }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if(is_array($project->features) && count($project->features) > 0)
                                        <div class="pt-2 border-t border-slate-700/40">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Key Features:</span>
                                            <ul class="text-[11px] text-slate-300 space-y-1 list-disc list-inside">
                                                @foreach(array_slice($project->features, 0, 2) as $feat)
                                                    <li class="truncate">{{ $feat }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6 pt-0 border-t border-slate-700/40 mt-4 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" class="p-2 rounded-lg bg-slate-900 text-slate-400 hover:text-white transition-colors" title="GitHub Repo">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                        </a>
                                    @endif
                                    @if($project->demo_url ?? $project->live_url)
                                        <a href="{{ $project->demo_url ?? $project->live_url }}" target="_blank" class="p-2 rounded-lg bg-slate-900 text-sky-400 hover:text-sky-300 transition-colors" title="Live Demo">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                        </a>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <button @click="activeProject = {
                                        id: {{ $project->id }},
                                        title: '{{ addslashes($project->title) }}',
                                        category: '{{ addslashes($project->category) }}',
                                        description: '{{ addslashes($project->description) }}',
                                        technologies: '{{ is_array($project->technologies) ? implode(', ', $project->technologies) : (is_array($project->tags) ? implode(', ', array_map(fn($t) => is_array($t) ? $t['name'] : $t, $project->tags)) : '') }}',
                                        features: `{!! is_array($project->features) ? addslashes(implode("\n", $project->features)) : '' !!}`,
                                        github_url: '{{ $project->github_url }}',
                                        demo_url: '{{ $project->demo_url ?? $project->live_url }}',
                                        image_url: '{{ $project->image_url ?? $project->icon }}',
                                        is_featured: {{ $project->is_featured ? 1 : 0 }},
                                        sort_order: {{ $project->sort_order }}
                                    }; editProjectModal = true;" class="p-2 rounded-lg bg-slate-900 hover:bg-slate-700 text-slate-300 hover:text-white transition-all text-xs font-semibold flex items-center gap-1">
                                        <span>Edit</span>
                                    </button>

                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Delete this project permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-slate-500 text-sm">No projects listed yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 5: EXPERIENCE MANAGEMENT -->
            <div x-show="activeTab === 'experience'" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl">
                    <div>
                        <h3 class="text-xl font-bold text-white">Experience Timeline Management</h3>
                        <p class="text-xs text-slate-400 mt-1">Manage your employment history, roles, key achievements, and technologies.</p>
                    </div>

                    <button @click="activeExp = { company: '', role: '', employment_type: 'Full-time', location: '', start_date: '', end_date: '', is_current: 0, short_description: '', responsibilities: '', technologies: '', logo: '', certificate_url: '', sort_order: {{ $experiences->count() + 1 }} }; editExpModal = true;" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold text-xs tracking-wider shadow-lg shadow-sky-500/20 hover:opacity-95 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Add Work Experience</span>
                    </button>
                </div>

                <div class="space-y-4">
                    @forelse($experiences as $exp)
                        <div class="p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl flex flex-col md:flex-row md:items-start justify-between gap-6 hover:border-sky-500/40 transition-all">
                            <div class="flex items-start gap-4 flex-1">
                                <!-- Company Logo Preview -->
                                <div class="w-14 h-14 rounded-2xl bg-slate-900 border border-slate-700 flex items-center justify-center p-2 flex-shrink-0 shadow-inner">
                                    @if($exp->logo)
                                        <img src="{{ asset($exp->logo) }}" alt="{{ $exp->company }}" class="w-full h-full object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div class="hidden text-xs font-bold text-sky-400 uppercase">{{ substr($exp->company, 0, 2) }}</div>
                                    @else
                                        <span class="text-xs font-bold text-sky-400 uppercase">{{ substr($exp->company, 0, 2) }}</span>
                                    @endif
                                </div>

                                <div class="space-y-2 flex-1">
                                    <div class="flex flex-wrap items-center gap-2.5">
                                        <h4 class="text-lg font-bold text-white">{{ $exp->role }}</h4>
                                        <span class="text-xs font-semibold text-sky-400 bg-sky-500/10 px-2.5 py-0.5 rounded-full border border-sky-500/20">{{ $exp->company }}</span>
                                        @if($exp->is_current)
                                            <span class="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">Present / Current</span>
                                        @endif
                                        @if($exp->certificate_url)
                                            <a href="{{ asset($exp->certificate_url) }}" target="_blank" class="inline-flex items-center gap-1 text-[10px] font-semibold text-amber-300 bg-amber-500/10 hover:bg-amber-500/20 px-2 py-0.5 rounded-full border border-amber-500/30 transition-colors">
                                                <span>📜 Certificate</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                            </a>
                                        @endif
                                    </div>

                                    <p class="text-xs text-slate-400 flex flex-wrap items-center gap-x-4 gap-y-1">
                                        <span>🗓️ {{ $exp->start_date }} - {{ $exp->end_date ?? 'Present' }}</span>
                                        @if($exp->location) <span>📍 {{ $exp->location }}</span> @endif
                                        @if($exp->employment_type ?? $exp->type) <span>💼 {{ $exp->employment_type ?? $exp->type }}</span> @endif
                                    </p>

                                    <!-- Responsibilities Display -->
                                    @if(is_array($exp->responsibilities) && count($exp->responsibilities) > 0)
                                        <div class="pt-1">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Key Responsibilities:</span>
                                            <ul class="text-xs text-slate-300 space-y-1 list-disc list-inside">
                                                @foreach($exp->responsibilities as $resp)
                                                    <li>{{ $resp }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p class="text-xs text-slate-300 leading-relaxed">{{ $exp->description }}</p>
                                    @endif

                                    @if(is_array($exp->technologies) && count($exp->technologies) > 0)
                                        <div class="flex flex-wrap gap-1.5 pt-2">
                                            @foreach($exp->technologies as $tech)
                                                <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-slate-700/50 text-slate-300 text-[10px]">{{ $tech }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-2 self-end md:self-start">
                                <button @click="activeExp = {
                                    id: {{ $exp->id }},
                                    company: '{{ addslashes($exp->company) }}',
                                    role: '{{ addslashes($exp->role) }}',
                                    employment_type: '{{ addslashes($exp->employment_type ?? $exp->type ?? 'Full-time') }}',
                                    location: '{{ addslashes($exp->location ?? '') }}',
                                    start_date: '{{ $exp->start_date }}',
                                    end_date: '{{ $exp->end_date }}',
                                    is_current: {{ $exp->is_current ? 1 : 0 }},
                                    short_description: `{!! addslashes($exp->short_description ?? '') !!}`,
                                    responsibilities: `{!! is_array($exp->responsibilities) ? addslashes(implode("\n", $exp->responsibilities)) : addslashes($exp->description) !!}`,
                                    technologies: '{{ is_array($exp->technologies) ? implode(', ', $exp->technologies) : '' }}',
                                    logo: '{{ $exp->logo }}',
                                    certificate_url: '{{ $exp->certificate_url }}',
                                    sort_order: {{ $exp->sort_order }}
                                }; editExpModal = true;" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold transition-all">
                                    Edit
                                </button>

                                <form action="{{ route('admin.experience.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Delete this experience record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-500 text-sm">No experience entries found.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 6: EDUCATION MANAGEMENT -->
            <div x-show="activeTab === 'education'" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl">
                    <div>
                        <h3 class="text-xl font-bold text-white">Education History Management</h3>
                        <p class="text-xs text-slate-400 mt-1">Manage your academic degrees, institutes, graduating years, and grade scores.</p>
                    </div>

                    <button @click="activeEdu = { id: null, degree: '', institution: '', location: '', field_of_study: '', start_year: '', end_year: '', grade_or_score: '', certificate_url: '', description: '', sort_order: {{ $educations->count() + 1 }} }; editEduModal = true;" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold text-xs tracking-wider shadow-lg shadow-sky-500/20 hover:opacity-95 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Add Education Record</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($educations as $edu)
                        <div class="p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl flex flex-col justify-between hover:border-sky-500/40 transition-all">
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="text-xs font-semibold text-sky-400 bg-sky-500/10 px-2.5 py-0.5 rounded-full border border-sky-500/20">
                                        {{ $edu->start_year }} - {{ $edu->end_year ?? 'Present' }}
                                    </span>
                                    <div class="flex items-center gap-1.5">
                                        @if($edu->grade_or_score)
                                            <span class="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2.5 py-0.5 rounded-full border border-emerald-500/20" title="Grade / Percentage">
                                                📊 {{ $edu->grade_or_score }}
                                            </span>
                                        @endif
                                        @if($edu->certificate_url)
                                            <a href="{{ $edu->certificate_url }}" target="_blank" class="text-xs font-semibold text-amber-400 bg-amber-500/10 hover:bg-amber-500/20 px-2.5 py-0.5 rounded-full border border-amber-500/30 transition-all flex items-center gap-1" title="View Certificate">
                                                <span>📜</span> Certificate
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <h4 class="text-base font-bold text-white pt-1">{{ $edu->degree }}</h4>
                                <p class="text-xs text-slate-300 font-medium">
                                    {{ $edu->institution }}
                                    @if($edu->location)
                                        <span class="text-slate-500 font-normal">• 📍 {{ $edu->location }}</span>
                                    @endif
                                </p>
                                @if($edu->field_of_study)
                                    <p class="text-[11px] text-sky-400/90 font-medium">{{ $edu->field_of_study }}</p>
                                @endif
                                @if($edu->description)
                                    <p class="text-xs text-slate-400 pt-2 leading-relaxed">{{ $edu->description }}</p>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-slate-700/40 mt-4 flex items-center justify-end gap-2">
                                <button @click="activeEdu = {
                                    id: {{ $edu->id }},
                                    degree: '{{ addslashes($edu->degree) }}',
                                    institution: '{{ addslashes($edu->institution) }}',
                                    location: '{{ addslashes($edu->location ?? '') }}',
                                    field_of_study: '{{ addslashes($edu->field_of_study ?? '') }}',
                                    start_year: '{{ $edu->start_year }}',
                                    end_year: '{{ $edu->end_year }}',
                                    grade_or_score: '{{ addslashes($edu->grade_or_score ?? '') }}',
                                    certificate_url: '{{ addslashes($edu->certificate_url ?? '') }}',
                                    description: '{{ addslashes($edu->description ?? '') }}',
                                    sort_order: {{ $edu->sort_order }}
                                }; editEduModal = true;" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold transition-all">
                                    Edit
                                </button>

                                <form action="{{ route('admin.education.destroy', $edu->id) }}" method="POST" onsubmit="return confirm('Delete this education entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 text-slate-500 text-sm">No education records found.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 7: INBOX / CONTACT MESSAGES -->
            <div x-show="activeTab === 'messages'" class="space-y-6">
                <div class="p-6 rounded-3xl bg-slate-800/80 border border-slate-700/60 shadow-xl">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-white">Contact Inquiries Inbox</h3>
                            <p class="text-xs text-slate-400 mt-1">Direct inquiries submitted by visitors from the contact form.</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-sky-500/10 text-sky-400 border border-sky-500/20">
                            {{ $messages->count() }} Total ({{ $stats['unread_messages'] }} Unread)
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-900/60 text-slate-400 uppercase font-semibold text-[10px] tracking-wider border-b border-slate-700">
                                <tr>
                                    <th class="px-4 py-3.5">Status</th>
                                    <th class="px-4 py-3.5">Sender</th>
                                    <th class="px-4 py-3.5">Subject</th>
                                    <th class="px-4 py-3.5">Message Snippet</th>
                                    <th class="px-4 py-3.5">Date</th>
                                    <th class="px-4 py-3.5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/40 text-slate-300">
                                @forelse($messages as $msg)
                                    <tr class="hover:bg-slate-700/20 transition-colors {{ !$msg->is_read ? 'bg-sky-500/5 font-semibold text-white' : '' }}">
                                        <td class="px-4 py-3.5">
                                            @if(!$msg->is_read)
                                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-400 border border-rose-500/30">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400 animate-pulse"></span>
                                                    New
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-800 text-slate-400">Read</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <div class="font-bold text-white">{{ $msg->name }}</div>
                                            <div class="text-[11px] text-slate-400">{{ $msg->email }}</div>
                                        </td>
                                        <td class="px-4 py-3.5 max-w-[150px] truncate">{{ $msg->subject ?? 'No Subject' }}</td>
                                        <td class="px-4 py-3.5 max-w-[250px] truncate text-slate-400">{{ $msg->message }}</td>
                                        <td class="px-4 py-3.5 text-[11px] text-slate-500 whitespace-nowrap">{{ $msg->created_at->format('M d, Y h:i A') }}</td>
                                        <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-2">
                                                <button @click="activeMsg = {{ json_encode($msg) }}; viewMsgModal = true;" class="px-2.5 py-1 rounded-lg bg-sky-500/10 hover:bg-sky-500/20 text-sky-400 text-xs font-semibold">
                                                    Read
                                                </button>

                                                <form action="{{ route('admin.messages.toggle', $msg->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="p-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white" title="{{ $msg->is_read ? 'Mark Unread' : 'Mark Read' }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-slate-500">No contact inquiries found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= MODALS SECTION ================= -->

        <!-- 1. SKILL ADD / EDIT MODAL -->
        <div x-show="editSkillModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-cloak>
            <div @click.away="editSkillModal = false" class="bg-slate-900 border border-slate-700 rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl space-y-5">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="text-lg font-bold text-white" x-text="activeSkill.id ? 'Edit Skill' : 'Add New Skill'"></h3>
                    <button @click="editSkillModal = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
                </div>

                <form :action="activeSkill.id ? '/admin/skills/' + activeSkill.id : '{{ route('admin.skills.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="activeSkill.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Skill Name</label>
                        <input type="text" name="name" x-model="activeSkill.name" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Category</label>
                        <select name="category" x-model="activeSkill.category" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500">
                            <option value="frontend">Frontend Development</option>
                            <option value="backend">Backend & APIs</option>
                            <option value="database">Database & Storage</option>
                            <option value="tools">Tools, DevOps & Collaboration</option>
                        </select>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-semibold uppercase text-slate-400">Proficiency Level (%)</label>
                            <span class="text-xs font-bold text-sky-400" x-text="activeSkill.proficiency + '%'"></span>
                        </div>
                        <input type="range" name="proficiency" min="10" max="100" step="5" x-model="activeSkill.proficiency" class="w-full accent-sky-500 cursor-pointer">
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" :checked="activeSkill.is_active == 1 || activeSkill.is_active === true || activeSkill.id === undefined" class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-sky-500">
                            <span class="text-xs font-semibold text-white">Active (Visible on public portfolio)</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                        <button type="button" @click="editSkillModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-semibold">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold text-xs">Save Skill</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. PROJECT ADD / EDIT MODAL -->
        <div x-show="editProjectModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-cloak>
            <div @click.away="editProjectModal = false" class="bg-slate-900 border border-slate-700 rounded-3xl p-6 md:p-8 max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto space-y-5">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div>
                        <h3 class="text-lg font-bold text-white" x-text="activeProject.id ? 'Edit Project Details' : 'Add New Showcase Project'"></h3>
                        <p class="text-xs text-slate-400 mt-0.5">Fill in the project information to display on your featured showcase and portfolio.</p>
                    </div>
                    <button @click="editProjectModal = false" class="text-slate-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>

                <form :action="activeProject.id ? '/admin/projects/' + activeProject.id : '{{ route('admin.projects.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <template x-if="activeProject.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- 1. Project Name & 2. Category -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Project Name *</label>
                            <input type="text" name="title" x-model="activeProject.title" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Grocify - Grocery Platform">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Category *</label>
                            <input type="text" name="category" list="project-categories" x-model="activeProject.category" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Full Stack Web App">
                            <datalist id="project-categories">
                                <option value="Full Stack Web App">
                                <option value="React / Frontend">
                                <option value="Laravel / Backend">
                                <option value="Fintech / SaaS Platform">
                                <option value="E-Commerce Store">
                                <option value="API & Microservices">
                            </datalist>
                        </div>
                    </div>

                    <!-- 3. Screenshot / Image Upload & URL -->
                    <div class="p-4 rounded-2xl bg-slate-800/60 border border-slate-700/60 space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-semibold uppercase text-slate-300">Project Screenshot / Cover Image</label>
                            <span class="text-[10px] text-slate-400 font-medium">Upload file or enter URL</span>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <template x-if="activeProject.image_url">
                                <div class="w-20 h-14 rounded-xl bg-slate-900 border border-slate-700 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    <img :src="activeProject.image_url.startsWith('http') || activeProject.image_url.startsWith('/') ? activeProject.image_url : '/' + activeProject.image_url" alt="Preview" class="w-full h-full object-cover">
                                </div>
                            </template>

                            <div class="flex-1 w-full space-y-2">
                                <input type="file" name="project_image" accept="image/*" class="w-full text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-500 file:text-white hover:file:bg-sky-400 cursor-pointer">
                                <input type="text" name="image_url" x-model="activeProject.image_url" placeholder="Or image path e.g. images/projects/grocify.png or https://..." class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:border-sky-500 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- 4. Description -->
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Description *</label>
                        <textarea name="description" x-model="activeProject.description" rows="3" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="Summary of what the project does, key problem solved, and architecture overview..."></textarea>
                    </div>

                    <!-- 5. Tech Stack -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold uppercase text-slate-400">Tech Stack (Technologies)</label>
                            <span class="text-[10px] text-slate-500">Comma-separated</span>
                        </div>
                        <input type="text" name="technologies" x-model="activeProject.technologies" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. React, Tailwind CSS, Laravel, MySQL, REST API">
                    </div>

                    <!-- 6. Key Features -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold uppercase text-slate-400">Key Features</label>
                            <span class="text-[10px] text-slate-500">1 feature per line or comma-separated</span>
                        </div>
                        <textarea name="features" x-model="activeProject.features" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="• Real-time shopping cart state management&#10;• Instant keyword search and filter by category&#10;• Mobile-first responsive UI with micro-animations"></textarea>
                    </div>

                    <!-- 7. GitHub URL & 8. Live Demo URL -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">GitHub Repository URL</label>
                            <input type="url" name="github_url" x-model="activeProject.github_url" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="https://github.com/username/project">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Live Demo URL</label>
                            <input type="url" name="demo_url" x-model="activeProject.demo_url" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="https://project-demo.com">
                        </div>
                    </div>

                    <!-- Options: Featured & Sort Order -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-t border-slate-800">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" :checked="activeProject.is_featured == 1 || activeProject.is_featured === true || activeProject.id === undefined" class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-sky-500">
                            <span class="text-xs font-semibold text-white">Showcase on Home Page (Featured)</span>
                        </label>

                        <div class="flex items-center gap-2">
                            <label class="text-xs text-slate-400 font-semibold uppercase">Sort Order:</label>
                            <input type="number" name="sort_order" x-model="activeProject.sort_order" min="1" class="w-16 px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs text-center focus:border-sky-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                        <button type="button" @click="editProjectModal = false" class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold transition-all">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-sky-500/25 transition-all">
                            <span x-text="activeProject.id ? 'Save Changes' : 'Create Project'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 3. EXPERIENCE ADD / EDIT MODAL -->
        <div x-show="editExpModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-cloak>
            <div @click.away="editExpModal = false" class="bg-slate-900 border border-slate-700 rounded-3xl p-6 md:p-8 max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto space-y-5">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div>
                        <h3 class="text-lg font-bold text-white" x-text="activeExp.id ? 'Edit Work Experience' : 'Add Work Experience'"></h3>
                        <p class="text-xs text-slate-400 mt-0.5">Manage your career history, role highlights, company branding, and certificates.</p>
                    </div>
                    <button @click="editExpModal = false" class="text-slate-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>

                <form :action="activeExp.id ? '/admin/experience/' + activeExp.id : '{{ route('admin.experience.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <template x-if="activeExp.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- 1. Job Title & 2. Company -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Job Title *</label>
                            <input type="text" name="role" x-model="activeExp.role" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Software Developer Trainee">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Company / Organization *</label>
                            <input type="text" name="company" x-model="activeExp.company" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. DataAegis Software Private Limited">
                        </div>
                    </div>

                    <!-- 3. Start Date & 4. End Date -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Starting Date *</label>
                            <input type="text" name="start_date" x-model="activeExp.start_date" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Jan 2024">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">End Date</label>
                            <input type="text" name="end_date" x-model="activeExp.end_date" :disabled="activeExp.is_current == 1" :class="activeExp.is_current == 1 ? 'opacity-50 cursor-not-allowed' : ''" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Present or Dec 2024">
                        </div>
                    </div>

                    <!-- 5. Location & 6. Work Type -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Location</label>
                            <input type="text" name="location" x-model="activeExp.location" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Begusarai / Remote / Delhi, India">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Work Type</label>
                            <input type="text" name="employment_type" list="exp-types" x-model="activeExp.employment_type" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Full-time, Traineeship, Internship, Contract, Remote">
                            <datalist id="exp-types">
                                <option value="Full-time">
                                <option value="Software Developer Trainee">
                                <option value="Internship">
                                <option value="Contract / Freelance">
                                <option value="Part-time">
                                <option value="Remote">
                            </datalist>
                        </div>
                    </div>

                    <!-- Short Description / Summary Statement -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold uppercase text-slate-400">Short Description / Role Overview</label>
                            <span class="text-[10px] text-slate-500">Left-side bio summary shown on card</span>
                        </div>
                        <textarea name="short_description" x-model="activeExp.short_description" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. As a Software Developer Trainee, I contribute to the development and maintenance of web-based applications while gaining practical experience with professional software development workflows."></textarea>
                    </div>

                    <!-- 7. Key Responsibility (comma separated / multiline) -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold uppercase text-slate-400">Key Responsibilities &amp; Highlights</label>
                            <span class="text-[10px] text-slate-500">1 per line or comma-separated</span>
                        </div>
                        <textarea name="responsibilities" x-model="activeExp.responsibilities" rows="3" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="• Developed scalable REST APIs with Laravel and MySQL&#10;• Implemented secure user authentication and permissions&#10;• Collaborated with frontend team to integrate dynamic interfaces"></textarea>
                    </div>

                    <!-- 8. Tech Used -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold uppercase text-slate-400">Technologies Used</label>
                            <span class="text-[10px] text-slate-500">Comma-separated</span>
                        </div>
                        <input type="text" name="technologies" x-model="activeExp.technologies" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. PHP, Laravel, MySQL, Git, Postman, JavaScript">
                    </div>

                    <!-- 9. Certificate & 10. Company Logo Uploads -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Company Logo -->
                        <div class="p-3.5 rounded-2xl bg-slate-800/60 border border-slate-700/60 space-y-2">
                            <label class="block text-xs font-semibold uppercase text-slate-300">Company Logo (Image)</label>
                            <div class="flex items-center gap-3">
                                <template x-if="activeExp.logo">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-700 overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
                                        <img :src="activeExp.logo.startsWith('http') || activeExp.logo.startsWith('/') ? activeExp.logo : '/' + activeExp.logo" alt="Logo" class="w-full h-full object-contain">
                                    </div>
                                </template>
                                <div class="flex-1 space-y-1.5">
                                    <input type="file" name="logo_file" accept="image/*" class="w-full text-xs text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-sky-500 file:text-white hover:file:bg-sky-400 cursor-pointer">
                                    <input type="text" name="logo" x-model="activeExp.logo" placeholder="Or logo path e.g. images/experience/dataaegis.png" class="w-full px-2.5 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-sky-500">
                                </div>
                            </div>
                        </div>

                        <!-- Certificate Upload / URL -->
                        <div class="p-3.5 rounded-2xl bg-slate-800/60 border border-slate-700/60 space-y-2">
                            <label class="block text-xs font-semibold uppercase text-slate-300">Certificate / Document (Optional)</label>
                            <div class="flex items-center gap-3">
                                <template x-if="activeExp.certificate_url">
                                    <a :href="activeExp.certificate_url.startsWith('http') || activeExp.certificate_url.startsWith('/') ? activeExp.certificate_url : '/' + activeExp.certificate_url" target="_blank" class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 overflow-hidden flex-shrink-0 flex items-center justify-center text-xs font-bold" title="View Document">
                                        📜
                                    </a>
                                </template>
                                <div class="flex-1 space-y-1.5">
                                    <input type="file" name="certificate_file" accept="image/*,application/pdf" class="w-full text-xs text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer">
                                    <input type="text" name="certificate_url" x-model="activeExp.certificate_url" placeholder="Or certificate URL / path" class="w-full px-2.5 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-sky-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Options: Currently working here & Sort Order -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-t border-slate-800">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_current" value="1" :checked="activeExp.is_current == 1" @change="if ($el.checked) { activeExp.end_date = 'Present'; activeExp.is_current = 1; } else { activeExp.is_current = 0; }" class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-sky-500">
                            <span class="text-xs font-semibold text-white">Currently working in this role (Present)</span>
                        </label>

                        <div class="flex items-center gap-2">
                            <label class="text-xs text-slate-400 font-semibold uppercase">Sort Order:</label>
                            <input type="number" name="sort_order" x-model="activeExp.sort_order" min="1" class="w-16 px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs text-center focus:border-sky-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                        <button type="button" @click="editExpModal = false" class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold transition-all">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-sky-500/25 transition-all">
                            <span x-text="activeExp.id ? 'Save Changes' : 'Add Experience'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 4. EDUCATION ADD / EDIT MODAL -->
        <div x-show="editEduModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-cloak>
            <div @click.away="editEduModal = false" class="bg-slate-900 border border-slate-700 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl max-h-[90vh] overflow-y-auto space-y-5">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="text-lg font-bold text-white" x-text="activeEdu.id ? 'Edit Education' : 'Add Education Record'"></h3>
                    <button @click="editEduModal = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
                </div>

                <form :action="activeEdu.id ? '/admin/education/' + activeEdu.id : '{{ route('admin.education.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <template x-if="activeEdu.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Degree / Qualification *</label>
                        <input type="text" name="degree" x-model="activeEdu.degree" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. B.Tech Computer Science &amp; Engineering">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Institution / University *</label>
                            <input type="text" name="institution" x-model="activeEdu.institution" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Dr C V Raman University">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Location</label>
                            <input type="text" name="location" x-model="activeEdu.location" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Begusarai, Bihar">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Field of Study / Specialization</label>
                        <input type="text" name="field_of_study" x-model="activeEdu.field_of_study" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. Artificial Intelligence, Web Development, CSE">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Start Year *</label>
                            <input type="text" name="start_year" x-model="activeEdu.start_year" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="2023">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">End Year</label>
                            <input type="text" name="end_year" x-model="activeEdu.end_year" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="2027 / Present">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Grade / Percentage</label>
                            <input type="text" name="grade_or_score" x-model="activeEdu.grade_or_score" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="e.g. 8.5 CGPA / 85%">
                        </div>
                    </div>

                    <!-- Certificate / Marksheet Upload -->
                    <div class="p-3.5 rounded-2xl bg-slate-800/60 border border-slate-700/60 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-semibold uppercase text-slate-300">Degree Certificate / Marksheet (Optional)</label>
                            <span class="text-[10px] text-slate-500">PDF or Image</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <template x-if="activeEdu.certificate_url">
                                <a :href="activeEdu.certificate_url.startsWith('http') || activeEdu.certificate_url.startsWith('/') ? activeEdu.certificate_url : '/' + activeEdu.certificate_url" target="_blank" class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 overflow-hidden flex-shrink-0 flex items-center justify-center text-xs font-bold hover:bg-amber-500/20 transition-all" title="View Document">
                                    📜
                                </a>
                            </template>
                            <div class="flex-1 space-y-1.5">
                                <input type="file" name="certificate_file" accept="image/*,application/pdf" class="w-full text-xs text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer">
                                <input type="text" name="certificate_url" x-model="activeEdu.certificate_url" placeholder="Or document URL / path" class="w-full px-2.5 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:border-sky-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Coursework Highlights &amp; Description (Optional)</label>
                        <textarea name="description" x-model="activeEdu.description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-all" placeholder="Key subjects, achievements, honors, or thesis details..."></textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-800">
                        <div class="flex items-center gap-2">
                            <label class="text-xs text-slate-400 font-semibold uppercase">Sort Order:</label>
                            <input type="number" name="sort_order" x-model="activeEdu.sort_order" min="1" class="w-16 px-2.5 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs text-center focus:border-sky-500">
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="editEduModal = false" class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold transition-all">Cancel</button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-sky-500/25 transition-all">
                                <span x-text="activeEdu.id ? 'Save Changes' : 'Add Education'"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- 5. INQUIRY MESSAGE VIEW MODAL -->
        <div x-show="viewMsgModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-cloak>
            <div @click.away="viewMsgModal = false" class="bg-slate-900 border border-slate-700 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl space-y-5">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-white">Message Details</h3>
                        <p class="text-xs text-slate-400" x-text="'From: ' + activeMsg.name + ' (' + activeMsg.email + ')'"></p>
                    </div>
                    <button @click="viewMsgModal = false" class="text-slate-400 hover:text-white text-xl">&times;</button>
                </div>

                <div class="space-y-3">
                    <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/40">
                        <span class="text-[10px] uppercase font-bold text-slate-500 block mb-1">Subject</span>
                        <p class="text-sm font-semibold text-white" x-text="activeMsg.subject || 'No Subject'"></p>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700/40">
                        <span class="text-[10px] uppercase font-bold text-slate-500 block mb-1">Message</span>
                        <p class="text-xs text-slate-200 leading-relaxed whitespace-pre-line" x-text="activeMsg.message"></p>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                    <a :href="'mailto:' + activeMsg.email + '?subject=Re: ' + encodeURIComponent(activeMsg.subject || '')" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        <span>Reply via Email</span>
                    </a>

                    <button type="button" @click="viewMsgModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-semibold">Close</button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
