<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileSetting;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the Admin CMS Dashboard
     */
    public function index()
    {
        $profile = ProfileSetting::first() ?? ProfileSetting::create([
            'full_name' => 'Raushan Kumar',
            'title' => 'Software Engineer & Full Stack Web Developer',
        ]);

        $skills = Skill::orderBy('sort_order')->get();
        $projects = Project::orderBy('sort_order')->get();
        $experiences = Experience::orderBy('sort_order')->get();
        $educations = Education::orderBy('sort_order')->get();
        $messages = ContactMessage::latest()->get();

        $stats = [
            'total_skills' => $skills->count(),
            'total_projects' => $projects->count(),
            'total_experiences' => $experiences->count(),
            'total_educations' => $educations->count(),
            'total_messages' => $messages->count(),
            'unread_messages' => $messages->where('is_read', false)->count(),
        ];

        return view('dashboard', compact('profile', 'skills', 'projects', 'experiences', 'educations', 'messages', 'stats'));
    }

    /**
     * Update Profile Settings
     */
    public function updateProfile(Request $request)
    {
        $profile = ProfileSetting::first() ?? new ProfileSetting();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'bio_summary' => 'nullable|string',
            'bio_full' => 'nullable|string',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'resume_url' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'projects_completed' => 'nullable|integer|min:0',
            'satisfied_clients' => 'nullable|integer|min:0',
            'is_available_for_hire' => 'nullable|boolean',
            'avatar_url' => 'nullable|string|max:500',
            'avatar' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'about_image_url' => 'nullable|string|max:500',
            'about_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_url'] = '/storage/' . $avatarPath;
        }
        unset($validated['avatar']);

        if ($request->hasFile('about_image')) {
            $aboutPath = $request->file('about_image')->store('about', 'public');
            $validated['about_image_url'] = '/storage/' . $aboutPath;
        }
        unset($validated['about_image']);

        $validated['is_available_for_hire'] = $request->has('is_available_for_hire');

        $profile->fill($validated);
        $profile->save();

        return redirect()->route('dashboard', ['tab' => 'profile'])->with('success', 'Profile settings updated successfully!');
    }

    /**
     * Store a new Skill
     */
    public function storeSkill(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:frontend,backend,database,tools',
            'proficiency' => 'required|integer|min:1|max:100',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['sort_order'] = $validated['sort_order'] ?? Skill::count() + 1;

        Skill::create($validated);

        return redirect()->route('dashboard', ['tab' => 'skills'])->with('success', 'Skill added successfully!');
    }

    /**
     * Update an existing Skill
     */
    public function updateSkill(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:frontend,backend,database,tools',
            'proficiency' => 'required|integer|min:1|max:100',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $skill->update($validated);

        return redirect()->route('dashboard', ['tab' => 'skills'])->with('success', 'Skill updated successfully!');
    }

    /**
     * Delete a Skill
     */
    public function destroySkill(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('dashboard', ['tab' => 'skills'])->with('success', 'Skill deleted successfully!');
    }

    /**
     * Store a new Project
     */
    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'technologies' => 'nullable|string',
            'features' => 'nullable|string',
            'github_url' => 'nullable|url|max:255',
            'demo_url' => 'nullable|url|max:255',
            'image_url' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'project_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'is_featured' => 'nullable',
        ]);

        if ($request->hasFile('project_image')) {
            $path = $request->file('project_image')->store('projects', 'public');
            $validated['image_url'] = '/storage/' . $path;
            $validated['icon'] = '/storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $validated['icon'] = $validated['image_url'];
        }
        unset($validated['project_image']);

        // Process technologies (comma-separated string to array)
        if (!empty($validated['technologies']) && is_string($validated['technologies'])) {
            $validated['technologies'] = array_values(array_filter(array_map('trim', explode(',', $validated['technologies'])), fn($t) => !empty($t)));
            $validated['tags'] = array_map(fn($t) => ['name' => $t, 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/50'], $validated['technologies']);
        } else {
            $validated['technologies'] = [];
            $validated['tags'] = [];
        }

        // Process key features (newline or comma-separated to array)
        if (!empty($validated['features']) && is_string($validated['features'])) {
            $lines = preg_split('/[\r\n]+/', $validated['features']);
            $featuresList = array_values(array_filter(array_map(function($line) {
                return trim(ltrim($line, "•-*\t "));
            }, $lines), fn($f) => !empty($f)));

            if (count($featuresList) === 1 && str_contains($featuresList[0], ',')) {
                $featuresList = array_values(array_filter(array_map('trim', explode(',', $featuresList[0])), fn($f) => !empty($f)));
            }
            $validated['features'] = $featuresList;
        } else {
            $validated['features'] = [];
        }

        $validated['live_url'] = $validated['demo_url'] ?? null;
        $validated['category_name'] = $validated['category'];
        $validated['is_featured'] = $request->has('is_featured') ? $request->boolean('is_featured') : true;
        $validated['sort_order'] = $validated['sort_order'] ?? Project::count() + 1;

        Project::create($validated);

        return redirect()->route('dashboard', ['tab' => 'projects'])->with('success', 'Project created successfully!');
    }

    /**
     * Update an existing Project
     */
    public function updateProject(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'technologies' => 'nullable|string',
            'features' => 'nullable|string',
            'github_url' => 'nullable|url|max:255',
            'demo_url' => 'nullable|url|max:255',
            'image_url' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'project_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'is_featured' => 'nullable',
        ]);

        if ($request->hasFile('project_image')) {
            $path = $request->file('project_image')->store('projects', 'public');
            $validated['image_url'] = '/storage/' . $path;
            $validated['icon'] = '/storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $validated['icon'] = $validated['image_url'];
        }
        unset($validated['project_image']);

        // Process technologies (comma-separated string to array)
        if (!empty($validated['technologies']) && is_string($validated['technologies'])) {
            $validated['technologies'] = array_values(array_filter(array_map('trim', explode(',', $validated['technologies'])), fn($t) => !empty($t)));
            $validated['tags'] = array_map(fn($t) => ['name' => $t, 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/50'], $validated['technologies']);
        } else {
            $validated['technologies'] = [];
            $validated['tags'] = [];
        }

        // Process key features (newline or comma-separated to array)
        if (!empty($validated['features']) && is_string($validated['features'])) {
            $lines = preg_split('/[\r\n]+/', $validated['features']);
            $featuresList = array_values(array_filter(array_map(function($line) {
                return trim(ltrim($line, "•-*\t "));
            }, $lines), fn($f) => !empty($f)));

            if (count($featuresList) === 1 && str_contains($featuresList[0], ',')) {
                $featuresList = array_values(array_filter(array_map('trim', explode(',', $featuresList[0])), fn($f) => !empty($f)));
            }
            $validated['features'] = $featuresList;
        } else {
            $validated['features'] = [];
        }

        $validated['live_url'] = $validated['demo_url'] ?? $project->live_url;
        $validated['category_name'] = $validated['category'];
        $validated['is_featured'] = $request->has('is_featured') ? $request->boolean('is_featured') : true;

        $project->update($validated);

        return redirect()->route('dashboard', ['tab' => 'projects'])->with('success', 'Project updated successfully!');
    }

    /**
     * Delete a Project
     */
    public function destroyProject(Project $project)
    {
        $project->delete();
        return redirect()->route('dashboard', ['tab' => 'projects'])->with('success', 'Project deleted successfully!');
    }

    /**
     * Store a new Experience
     */
    public function storeExperience(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|string|max:100',
            'end_date' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'description' => 'nullable|string',
            'technologies' => 'nullable|string',
            'certificate_url' => 'nullable|string|max:500',
            'certificate_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,webp|max:20480',
            'logo' => 'nullable|string|max:500',
            'logo_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'is_current' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('companies', 'public');
            $validated['logo'] = '/storage/' . $path;
        }
        unset($validated['logo_file']);

        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('certificates', 'public');
            $validated['certificate_url'] = '/storage/' . $path;
        }
        unset($validated['certificate_file']);

        // Process Key Responsibilities
        $rawResp = $validated['responsibilities'] ?? $validated['description'] ?? '';
        if (!empty($rawResp) && is_string($rawResp)) {
            $lines = preg_split('/[\r\n]+/', $rawResp);
            $respList = array_values(array_filter(array_map(function($line) {
                return trim(ltrim($line, "•-*\t "));
            }, $lines), fn($r) => !empty($r)));

            if (count($respList) === 1 && str_contains($respList[0], ',')) {
                $respList = array_values(array_filter(array_map('trim', explode(',', $respList[0])), fn($r) => !empty($r)));
            }
            $validated['responsibilities'] = $respList;
            $validated['deliverables'] = array_map(function($r, $idx) {
                return [
                    'title' => 'Contribution ' . ($idx + 1),
                    'desc' => $r
                ];
            }, $respList, array_keys($respList));
            $validated['description'] = implode('. ', $respList);
            $validated['summary'] = $validated['description'];
        } else {
            $validated['responsibilities'] = [];
            $validated['deliverables'] = [];
            $validated['description'] = $validated['description'] ?? '';
            $validated['summary'] = $validated['description'];
        }

        // Process Technologies
        if (!empty($validated['technologies']) && is_string($validated['technologies'])) {
            $validated['technologies'] = array_values(array_filter(array_map('trim', explode(',', $validated['technologies'])), fn($t) => !empty($t)));
            $validated['tags'] = array_map(fn($t) => ['name' => $t, 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/60'], $validated['technologies']);
        } else {
            $validated['technologies'] = [];
            $validated['tags'] = [];
        }

        $validated['type'] = $validated['employment_type'] ?? 'Full-time';
        $validated['is_current'] = $request->has('is_current') ? $request->boolean('is_current') : false;
        if ($validated['is_current']) {
            $validated['end_date'] = 'Present';
        }
        $validated['period'] = $validated['start_date'] . ' – ' . ($validated['end_date'] ?? 'Present');
        $validated['sort_order'] = $validated['sort_order'] ?? Experience::count() + 1;

        Experience::create($validated);

        return redirect()->route('dashboard', ['tab' => 'experience'])->with('success', 'Work experience record created successfully!');
    }

    /**
     * Update an existing Experience
     */
    public function updateExperience(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|string|max:100',
            'end_date' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'description' => 'nullable|string',
            'technologies' => 'nullable|string',
            'certificate_url' => 'nullable|string|max:500',
            'certificate_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,webp|max:20480',
            'logo' => 'nullable|string|max:500',
            'logo_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'is_current' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('companies', 'public');
            $validated['logo'] = '/storage/' . $path;
        }
        unset($validated['logo_file']);

        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('certificates', 'public');
            $validated['certificate_url'] = '/storage/' . $path;
        }
        unset($validated['certificate_file']);

        // Process Key Responsibilities
        $rawResp = $validated['responsibilities'] ?? $validated['description'] ?? '';
        if (!empty($rawResp) && is_string($rawResp)) {
            $lines = preg_split('/[\r\n]+/', $rawResp);
            $respList = array_values(array_filter(array_map(function($line) {
                return trim(ltrim($line, "•-*\t "));
            }, $lines), fn($r) => !empty($r)));

            if (count($respList) === 1 && str_contains($respList[0], ',')) {
                $respList = array_values(array_filter(array_map('trim', explode(',', $respList[0])), fn($r) => !empty($r)));
            }
            $validated['responsibilities'] = $respList;
            $validated['deliverables'] = array_map(function($r, $idx) {
                return [
                    'title' => 'Contribution ' . ($idx + 1),
                    'desc' => $r
                ];
            }, $respList, array_keys($respList));
            $validated['description'] = implode('. ', $respList);
            $validated['summary'] = $validated['description'];
        } else {
            $validated['responsibilities'] = [];
            $validated['deliverables'] = [];
            $validated['description'] = $validated['description'] ?? '';
            $validated['summary'] = $validated['description'];
        }

        // Process Technologies
        if (!empty($validated['technologies']) && is_string($validated['technologies'])) {
            $validated['technologies'] = array_values(array_filter(array_map('trim', explode(',', $validated['technologies'])), fn($t) => !empty($t)));
            $validated['tags'] = array_map(fn($t) => ['name' => $t, 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/60'], $validated['technologies']);
        } else {
            $validated['technologies'] = [];
            $validated['tags'] = [];
        }

        $validated['type'] = $validated['employment_type'] ?? $experience->type ?? 'Full-time';
        $validated['is_current'] = $request->has('is_current') ? $request->boolean('is_current') : false;
        if ($validated['is_current']) {
            $validated['end_date'] = 'Present';
        }
        $validated['period'] = $validated['start_date'] . ' – ' . ($validated['end_date'] ?? 'Present');

        $experience->update($validated);

        return redirect()->route('dashboard', ['tab' => 'experience'])->with('success', 'Work experience record updated successfully!');
    }

    /**
     * Delete an Experience
     */
    public function destroyExperience(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('dashboard', ['tab' => 'experience'])->with('success', 'Experience deleted successfully!');
    }

    /**
     * Store Education
     */
    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_year' => 'required|string|max:50',
            'end_year' => 'nullable|string|max:50',
            'grade_or_score' => 'nullable|string|max:100',
            'certificate_url' => 'nullable|string|max:500',
            'certificate_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,webp|max:20480',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('education_certificates', 'public');
            $validated['certificate_url'] = '/storage/' . $path;
        }
        unset($validated['certificate_file']);

        $validated['period'] = $validated['start_year'] . ' – ' . ($validated['end_year'] ?? 'Present');
        $validated['sort_order'] = $validated['sort_order'] ?? Education::count() + 1;

        Education::create($validated);

        return redirect()->route('dashboard', ['tab' => 'education'])->with('success', 'Education record added successfully!');
    }

    /**
     * Update Education
     */
    public function updateEducation(Request $request, Education $education)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_year' => 'required|string|max:50',
            'end_year' => 'nullable|string|max:50',
            'grade_or_score' => 'nullable|string|max:100',
            'certificate_url' => 'nullable|string|max:500',
            'certificate_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,webp|max:20480',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('education_certificates', 'public');
            $validated['certificate_url'] = '/storage/' . $path;
        }
        unset($validated['certificate_file']);

        $validated['period'] = $validated['start_year'] . ' – ' . ($validated['end_year'] ?? 'Present');

        $education->update($validated);

        return redirect()->route('dashboard', ['tab' => 'education'])->with('success', 'Education record updated successfully!');
    }

    /**
     * Delete Education
     */
    public function destroyEducation(Education $education)
    {
        $education->delete();
        return redirect()->route('dashboard', ['tab' => 'education'])->with('success', 'Education record deleted successfully!');
    }

    /**
     * Mark Contact Message as Read / Unread
     */
    public function toggleMessageRead(ContactMessage $message)
    {
        $message->update(['is_read' => !$message->is_read]);
        return redirect()->route('dashboard', ['tab' => 'messages'])->with('success', 'Message status updated.');
    }

    /**
     * Delete Contact Message
     */
    public function destroyMessage(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('dashboard', ['tab' => 'messages'])->with('success', 'Message deleted successfully!');
    }
}
