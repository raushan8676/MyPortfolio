<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfileSetting;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create or ensure Admin User exists
        if (!User::where('email', 'admin@example.com')->exists() && !User::where('email', 'contact@raushankumar.com')->exists()) {
            User::create([
                'name' => 'Raushan Kumar',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }

        // 2. Profile Setting
        ProfileSetting::firstOrCreate([], [
            'full_name' => 'Raushan Kumar',
            'first_name' => 'Raushan',
            'last_name' => 'Kumar',
            'title' => 'Full Stack Developer',
            'tagline' => 'Code Build Grow',
            'greeting' => "Hello, I'm",
            'short_bio' => 'I build modern, responsive and user-friendly web applications using React, Laravel, PHP and more. I love solving problems and turning ideas into real products.',
            'about_bio_1' => "Hi, I'm Raushan Kumar, a B.Tech CSE student from Dr C V Raman University, Vaishali (Bihar). I'm passionate about web development and currently working as a Software Developer Trainee at DataAegis Software Private Limited.",
            'about_bio_2' => "I enjoy building web applications, learning new technologies and solving real-world problems.",
            'location' => 'Teghra, Begusarai, Bihar, India',
            'email' => 'contact@raushankumar.com',
            'phone' => '+91 620xxxxxxx',
            'university' => 'Dr C V Raman University, Vaishali (Bihar)',
            'degree' => 'B.Tech CSE',
            'education_period' => '2023 – 2027',
            'current_semester' => '6th Semester',
            'current_company' => 'DataAegis Software Private Limited',
            'current_role' => 'Software Developer Trainee',
            'profile_image' => 'images/profile.jpg',
            'about_image' => 'images/about.jpg',
            'resume_file' => 'resume.pdf',
            'github_url' => 'https://github.com',
            'linkedin_url' => 'https://linkedin.com',
            'twitter_url' => 'https://x.com',
        ]);

        // 3. Skills
        $skills = [
            ['name' => 'React', 'category' => 'frontend', 'image' => 'images/skills/react.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg', 'level' => 'Advanced', 'level_color' => 'text-cyan-400 bg-cyan-950/60 border-cyan-800/60', 'description' => 'Component architecture, state management (Hooks/Context), and interactive SPAs.', 'sort_order' => 1, 'is_active' => true],
            ['name' => 'JavaScript', 'category' => 'frontend', 'image' => 'images/skills/javascript.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg', 'level' => 'Advanced', 'level_color' => 'text-amber-400 bg-amber-950/60 border-amber-800/60', 'description' => 'DOM manipulation, asynchronous logic (Promises/Async-Await), and modern ES6+ features.', 'sort_order' => 2, 'is_active' => true],
            ['name' => 'Tailwind CSS', 'category' => 'frontend', 'image' => 'images/skills/tailwind.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg', 'level' => 'Expert', 'level_color' => 'text-sky-400 bg-sky-950/60 border-sky-800/60', 'description' => 'Utility-first styling, glassmorphism, responsive systems, and micro-interactions.', 'sort_order' => 3, 'is_active' => true],
            ['name' => 'HTML', 'category' => 'frontend', 'image' => 'images/skills/html.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg', 'level' => 'Expert', 'level_color' => 'text-orange-400 bg-orange-950/60 border-orange-800/60', 'description' => 'Semantic structure, web standards, accessibility (a11y), and SEO-friendly layouts.', 'sort_order' => 4, 'is_active' => true],
            ['name' => 'CSS', 'category' => 'frontend', 'image' => 'images/skills/css.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg', 'level' => 'Advanced', 'level_color' => 'text-blue-400 bg-blue-950/60 border-blue-800/60', 'description' => 'Flexbox, CSS Grid layouts, keyframe animations, and custom media queries.', 'sort_order' => 5, 'is_active' => true],
            ['name' => 'Laravel', 'category' => 'backend', 'image' => 'images/skills/laravel.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg', 'level' => 'Advanced', 'level_color' => 'text-rose-400 bg-rose-950/60 border-rose-800/60', 'description' => 'MVC architecture, Eloquent ORM, Blade, Routing, Middleware, and Auth.', 'sort_order' => 6, 'is_active' => true],
            ['name' => 'PHP', 'category' => 'backend', 'image' => 'images/skills/php.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg', 'level' => 'Advanced', 'level_color' => 'text-indigo-400 bg-indigo-950/60 border-indigo-800/60', 'description' => 'Object-Oriented Programming (OOP), RESTful endpoints, and server scripting.', 'sort_order' => 7, 'is_active' => true],
            ['name' => 'Node.js', 'category' => 'backend', 'image' => 'images/skills/nodejs.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nodejs/nodejs-original.svg', 'level' => 'Intermediate', 'level_color' => 'text-emerald-400 bg-emerald-950/60 border-emerald-800/60', 'description' => 'Event-driven runtime, asynchronous server handling, and npm module ecosystem.', 'sort_order' => 8, 'is_active' => true],
            ['name' => 'MySQL', 'category' => 'database', 'image' => 'images/skills/mysql.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg', 'level' => 'Advanced', 'level_color' => 'text-blue-400 bg-blue-950/60 border-blue-800/60', 'description' => 'Relational database design, indexing, foreign keys, migrations, and query tuning.', 'sort_order' => 9, 'is_active' => true],
            ['name' => 'Git', 'category' => 'tools', 'image' => 'images/skills/git.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg', 'level' => 'Advanced', 'level_color' => 'text-orange-400 bg-orange-950/60 border-orange-800/60', 'description' => 'Branching models, pull requests, cherry-picking, and merge conflict resolution.', 'sort_order' => 10, 'is_active' => true],
            ['name' => 'GitHub', 'category' => 'tools', 'image' => 'images/skills/github.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg', 'level' => 'Advanced', 'level_color' => 'text-slate-300 bg-slate-800/60 border-slate-700/60', 'description' => 'Open source collaboration, repository hosting, issue tracking, and actions.', 'sort_order' => 11, 'is_active' => true],
            ['name' => 'Postman', 'category' => 'tools', 'image' => 'images/skills/postman.png', 'cdn_fallback' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postman/postman-original.svg', 'level' => 'Advanced', 'level_color' => 'text-amber-400 bg-amber-950/60 border-amber-800/60', 'description' => 'API testing, request payload validation, auth token headers, and automated tests.', 'sort_order' => 12, 'is_active' => true],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }

        // 4. Projects
        $projects = [
            [
                'title' => 'Grocify',
                'subtitle' => 'Grocery E-Commerce Platform',
                'category' => 'react',
                'category_name' => 'React / Frontend',
                'icon' => 'images/projects/grocify.png',
                'icon_bg' => 'bg-emerald-500/15 border-emerald-500/30 text-emerald-400',
                'fallback_icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>',
                'description' => 'A fast, responsive online grocery store with real-time cart calculation, product category filters, and modern checkout experience.',
                'features' => [
                    'Dynamic shopping cart state management',
                    'Instant keyword search and filter by category',
                    'Mobile-first responsive UI with micro-animations'
                ],
                'tags' => [
                    ['name' => 'React', 'color' => 'text-emerald-400 bg-emerald-950/60 border-emerald-800/50'],
                    ['name' => 'Tailwind CSS', 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/50'],
                    ['name' => 'JavaScript', 'color' => 'text-yellow-400 bg-yellow-950/60 border-yellow-800/50'],
                ],
                'live_url' => '#',
                'github_url' => 'https://github.com',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'VisitIndia',
                'subtitle' => 'Cultural Tourism Guide',
                'category' => 'react',
                'category_name' => 'React / Frontend',
                'icon' => 'images/projects/visitindia.png',
                'icon_bg' => 'bg-amber-500/15 border-amber-500/30 text-amber-400',
                'fallback_icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A48.24 48.24 0 0012 9.75c-2.551 0-5.056.2-7.5.583V21" /></svg>',
                'description' => 'An interactive travel web application exploring Indian heritage, state-by-state tourist attractions, local traditions, and monuments.',
                'features' => [
                    'State-wise interactive cultural discovery',
                    'Curated travel itineraries and local attractions',
                    'Optimized asset bundling with Parcel & React'
                ],
                'tags' => [
                    ['name' => 'React', 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/50'],
                    ['name' => 'Parcel', 'color' => 'text-purple-400 bg-purple-950/60 border-purple-800/50'],
                    ['name' => 'JavaScript', 'color' => 'text-amber-400 bg-amber-950/60 border-amber-800/50'],
                ],
                'live_url' => '#',
                'github_url' => 'https://github.com',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Merchant System (epay)',
                'subtitle' => 'Enterprise Onboarding & KYC',
                'category' => 'laravel',
                'category_name' => 'Laravel / Full Stack',
                'icon' => 'images/projects/merchant.png',
                'icon_bg' => 'bg-indigo-500/15 border-indigo-500/30 text-indigo-400',
                'fallback_icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3" /></svg>',
                'description' => 'A robust merchant onboarding and KYC document verification pipeline built for DataAegis Software fintech operations.',
                'features' => [
                    'Multi-step merchant registration & document verification',
                    'Secured REST APIs with token validation & middleware',
                    'Relational MySQL schema design with indexing & transactions'
                ],
                'tags' => [
                    ['name' => 'Laravel', 'color' => 'text-rose-400 bg-rose-950/60 border-rose-800/50'],
                    ['name' => 'PHP', 'color' => 'text-indigo-400 bg-indigo-950/60 border-indigo-800/50'],
                    ['name' => 'MySQL', 'color' => 'text-blue-400 bg-blue-950/60 border-blue-800/50'],
                    ['name' => 'Tailwind', 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/50'],
                ],
                'live_url' => '#',
                'github_url' => 'https://github.com',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'E-commerce Platform',
                'subtitle' => 'Full-Stack Multi-Panel Web App',
                'category' => 'fullstack',
                'category_name' => 'Full Stack (Laravel + React)',
                'icon' => 'images/projects/ecommerce.png',
                'icon_bg' => 'bg-sky-500/15 border-sky-500/30 text-sky-400',
                'fallback_icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>',
                'description' => 'A complete end-to-end e-commerce store with authenticated customer ordering, seller catalog control, and comprehensive admin dashboard metrics.',
                'features' => [
                    'Multi-role authentication (Customer, Seller, Admin)',
                    'Product catalog management and order lifecycle tracking',
                    'Decoupled architecture with Laravel API & React frontend'
                ],
                'tags' => [
                    ['name' => 'Laravel', 'color' => 'text-rose-400 bg-rose-950/60 border-rose-800/50'],
                    ['name' => 'React', 'color' => 'text-cyan-400 bg-cyan-950/60 border-cyan-800/50'],
                    ['name' => 'MySQL', 'color' => 'text-blue-400 bg-blue-950/60 border-blue-800/50'],
                ],
                'live_url' => '#',
                'github_url' => 'https://github.com',
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(['title' => $project['title']], $project);
        }

        // 5. Experiences
        $experiences = [
            [
                'role' => 'Software Developer Trainee',
                'company' => 'DataAegis Software Private Limited',
                'period' => '2024 – Present',
                'type' => 'Full-time / Trainee',
                'location' => 'Bihar, India',
                'logo' => 'images/experience/dataaegis.png',
                'is_current' => true,
                'summary' => 'Actively contributing to enterprise fintech and digital merchant services, focusing on robust backend architecture, KYC verification workflows, and seamless frontend integrations.',
                'deliverables' => [
                    ['title' => 'epay Merchant & KYC Architecture', 'desc' => 'Engineered multi-step merchant registration and digital KYC document verification pipelines ensuring data compliance and secure processing.'],
                    ['title' => 'RESTful API Endpoint Development', 'desc' => 'Built high-performance, token-secured RESTful APIs using Laravel and PHP for merchant profiles, status callbacks, and transaction data.'],
                    ['title' => 'Database Modeling & Query Optimization', 'desc' => 'Designed relational MySQL database schemas, indexing strategies, Eloquent ORM relationships, and transaction safeguards.'],
                    ['title' => 'Collaborative Git & Agile Workflow', 'desc' => 'Followed strict version control branching strategies, conducted pull request code reviews, and tested all API contracts via Postman suites.']
                ],
                'responsibilities' => [
                    'Working on epay project (Merchant/KYC flow).',
                    'Built features using Laravel, PHP, MySQL and JavaScript.',
                    'Collaborating with frontend team and following Git workflow.'
                ],
                'tags' => [
                    ['name' => 'Laravel', 'color' => 'text-rose-400 bg-rose-950/60 border-rose-800/60'],
                    ['name' => 'PHP', 'color' => 'text-indigo-400 bg-indigo-950/60 border-indigo-800/60'],
                    ['name' => 'MySQL', 'color' => 'text-blue-400 bg-blue-950/60 border-blue-800/60'],
                    ['name' => 'JavaScript', 'color' => 'text-amber-400 bg-amber-950/60 border-amber-800/60'],
                    ['name' => 'Tailwind CSS', 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/60'],
                ],
                'sort_order' => 1
            ],
            [
                'role' => 'Full-Stack Project Lead & Developer',
                'company' => 'Dr C V Raman University (Academic)',
                'period' => '2023 – 2024',
                'type' => 'Academic & Project Work',
                'location' => 'Vaishali, Bihar',
                'logo' => 'images/experience/dataaegis.png',
                'is_current' => false,
                'summary' => 'Led the design, development, and presentation of full-stack web applications and interactive frontend platforms as part of B.Tech CSE coursework.',
                'deliverables' => [
                    ['title' => 'Full-Stack E-Commerce & Grocery Platforms', 'desc' => 'Designed and implemented Grocify and multi-vendor shopping systems with React, Laravel, and MySQL.'],
                    ['title' => 'Interactive UI/UX & Responsive Engineering', 'desc' => 'Created tourism guide VisitIndia using modular React components, state management, and modern Tailwind CSS design tokens.']
                ],
                'responsibilities' => [
                    'Led development of Grocify and VisitIndia applications.',
                    'Engineered responsive layouts and API integrations.',
                    'Conducted code reviews for student engineering group.'
                ],
                'tags' => [
                    ['name' => 'React', 'color' => 'text-cyan-400 bg-cyan-950/60 border-cyan-800/60'],
                    ['name' => 'JavaScript', 'color' => 'text-amber-400 bg-amber-950/60 border-amber-800/60'],
                    ['name' => 'PHP', 'color' => 'text-indigo-400 bg-indigo-950/60 border-indigo-800/60'],
                    ['name' => 'MySQL', 'color' => 'text-blue-400 bg-blue-950/60 border-blue-800/60'],
                ],
                'sort_order' => 2
            ]
        ];

        foreach ($experiences as $exp) {
            Experience::firstOrCreate(['company' => $exp['company'], 'role' => $exp['role']], $exp);
        }

        // 6. Education
        $educations = [
            [
                'degree' => 'Bachelor of Technology (B.Tech)',
                'field' => 'Computer Science & Engineering (CSE)',
                'institution' => 'Dr C V Raman University',
                'location' => 'Vaishali, Bihar, India',
                'period' => '2023 – 2027',
                'status' => 'Currently in 6th Semester',
                'icon_bg' => 'bg-indigo-500/15 border-indigo-500/30 text-indigo-400',
                'is_current' => true,
                'summary' => 'Undergoing a comprehensive 4-year engineering curriculum focused on theoretical computer science, software architecture, algorithm design, and modern full-stack web engineering.',
                'description' => 'Specializing in core computer science, software architecture, relational databases, data structures & algorithms, and modern full-stack web technologies.',
                'highlights' => [
                    'Data Structures & Algorithms (DSA)',
                    'Database Management Systems (DBMS)',
                    'Object-Oriented Programming (OOP)',
                    'Full-Stack Web Engineering (PHP/Laravel/React)'
                ],
                'courses' => [
                    ['name' => 'Data Structures & Algorithms (DSA)', 'desc' => 'Arrays, Linked Lists, Trees, Graphs, Sorting, Dynamic Programming & Complexity Analysis.'],
                    ['name' => 'Database Management Systems (DBMS)', 'desc' => 'Relational schemas, SQL queries, normalization (1NF to BCNF), indexing, and ACID transactions.'],
                    ['name' => 'Object-Oriented Programming (OOP)', 'desc' => 'Polymorphism, Inheritance, Encapsulation, Abstraction, and SOLID design principles.'],
                    ['name' => 'Web Technologies & Internet Computing', 'desc' => 'Full-stack development, MVC architectures, HTTP protocols, and RESTful API engineering.'],
                ],
                'tags' => [
                    ['name' => 'Computer Science', 'color' => 'text-sky-400 bg-sky-950/60 border-sky-800/60'],
                    ['name' => 'Software Engineering', 'color' => 'text-indigo-400 bg-indigo-950/60 border-indigo-800/60'],
                ],
                'sort_order' => 1
            ],
            [
                'degree' => 'Higher Secondary (Class XII)',
                'field' => 'Science (Physics, Chemistry, Mathematics - PCM)',
                'institution' => 'Senior Secondary Schooling',
                'location' => 'Bihar, India',
                'period' => 'Completed',
                'status' => 'Science Stream',
                'icon_bg' => 'bg-sky-500/15 border-sky-500/30 text-sky-400',
                'is_current' => false,
                'summary' => 'Completed senior secondary education with primary focus on Higher Mathematics, Physics, Chemistry, and analytical problem-solving foundation.',
                'description' => 'Built strong analytical and problem-solving fundamentals in Higher Mathematics, Physics, and Chemistry.',
                'highlights' => [
                    'Higher Mathematics & Calculus',
                    'Analytical Physics & Chemistry',
                    'Logical Problem Solving'
                ],
                'courses' => [
                    ['name' => 'Higher Mathematics', 'desc' => 'Calculus, Linear Algebra, Coordinate Geometry, Trigonometry, and Probability.'],
                    ['name' => 'Physics & Chemistry', 'desc' => 'Mechanics, Electromagnetism, Modern Physics, and Organic & Inorganic Chemistry.']
                ],
                'tags' => [
                    ['name' => 'Mathematics', 'color' => 'text-blue-400 bg-blue-950/60 border-blue-800/60'],
                    ['name' => 'Physics', 'color' => 'text-purple-400 bg-purple-950/60 border-purple-800/60'],
                ],
                'sort_order' => 2
            ]
        ];

        foreach ($educations as $edu) {
            Education::firstOrCreate(['degree' => $edu['degree'], 'institution' => $edu['institution']], $edu);
        }
    }
}
