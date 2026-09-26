<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileSetting;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use App\Models\ContactMessage;

class PortfolioController extends Controller
{
    /**
     * Home Page (Welcome)
     */
    public function index()
    {
        $profile = ProfileSetting::first() ?? new ProfileSetting();
        $skills = Skill::where('is_active', true)->orderBy('sort_order')->get();
        $projects = Project::where('is_featured', true)->orderBy('sort_order')->get();
        if ($projects->isEmpty()) {
            $projects = Project::orderBy('sort_order')->take(6)->get();
        }
        $experiences = Experience::orderBy('sort_order')->get();
        $educations = Education::orderBy('sort_order')->get();

        return view('welcome', compact('profile', 'skills', 'projects', 'experiences', 'educations'));
    }

    /**
     * About Page
     */
    public function about()
    {
        $profile = ProfileSetting::first() ?? new ProfileSetting();
        $educations = Education::orderBy('sort_order')->get();
        $experiences = Experience::orderBy('sort_order')->get();

        return view('about', compact('profile', 'educations', 'experiences'));
    }

    /**
     * Skills Page
     */
    public function skills()
    {
        $skills = Skill::where('is_active', true)->orderBy('sort_order')->get();
        $categories = [
            'frontend' => [
                'name' => 'Frontend Development',
                'desc' => 'Building fast, responsive, and aesthetically pleasing client-side experiences.',
                'icon' => '<svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>',
                'skills' => $skills->where('category', 'frontend')
            ],
            'backend' => [
                'name' => 'Backend & APIs',
                'desc' => 'Architecting robust server-side applications, business logic, and secured APIs.',
                'icon' => '<svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.73 7.47A4.5 4.5 0 019.27 6h5.46a4.5 4.5 0 013.54 1.47l2.08 2.78c.58.78.9 1.73.9 2.7" /></svg>',
                'skills' => $skills->where('category', 'backend')
            ],
            'database' => [
                'name' => 'Database & Storage',
                'desc' => 'Designing clean relational schemas, queries, and persistent data layers.',
                'icon' => '<svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" /></svg>',
                'skills' => $skills->where('category', 'database')
            ],
            'tools' => [
                'name' => 'Tools, DevOps & Collaboration',
                'desc' => 'Version control, API validation, and development workflow automation.',
                'icon' => '<svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.67 2.67 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233l2.846-2.847a4.5 4.5 0 00-6.364-6.364l-2.847 2.846" /></svg>',
                'skills' => $skills->where('category', 'tools')
            ],
        ];

        return view('skills', compact('skills', 'categories'));
    }

    /**
     * Projects Page
     */
    public function projects()
    {
        $projects = Project::orderBy('sort_order')->get();
        return view('projects', compact('projects'));
    }

    /**
     * Experience Page
     */
    public function experience()
    {
        $experiences = Experience::orderBy('sort_order')->get();
        return view('experience', compact('experiences'));
    }

    /**
     * Education Page
     */
    public function education()
    {
        $educations = Education::orderBy('sort_order')->get();
        return view('education', compact('educations'));
    }

    /**
     * Contact Page
     */
    public function contact()
    {
        $profile = ProfileSetting::first() ?? new ProfileSetting();
        return view('contact', compact('profile'));
    }

    /**
     * Submit Contact Form (AJAX or Standard POST)
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Your message has been sent successfully!']);
        }

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
