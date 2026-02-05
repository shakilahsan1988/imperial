@extends('layouts.front')

@section('title', 'Executive, Corporate Sales, Marketing - Careers')

@section('content')

    <!-- Main Content Start -->
    <main class="font-sans text-imperial-text bg-white pb-20">
        
        <!-- Breadcrumbs (Navigation aid) -->
        <div class="bg-gray-50 border-b border-gray-200 py-3">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex text-sm text-gray-500">
                    <a href="{{ route('career') }}" class="hover:text-imperial-primary transition">Careers</a>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-900 font-medium truncate">Executive, Corporate Sales, Marketing</span>
                </nav>
            </div>
        </div>

        <!-- TOP SECTION: Sidebar (Left) + Video (Right) -->
        <section class="py-10 lg:py-16 border-b border-gray-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Grid: Sidebar (4 cols) | Video (8 cols) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                    
                    <!-- LEFT COLUMN: Job Info & Apply (Span 4) -->
                    <div class="lg:col-span-4 order-1 lg:order-1">
                        <div class="department-list bg-white">
                            <!-- Job Title -->
                            <div class="mb-title mb-6">
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                                    Executive, Corporate Sales, Marketing
                                </h1>
                            </div>

                            <!-- Job Meta List -->
                            <ul class="dp-list space-y-6 mb-8">
                                <!-- Department -->
                                <li class="dp-item border-l-4 border-imperial-primary pl-4">
                                    <h1 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Department</h1>
                                    <p class="text-lg font-medium text-gray-800">Marketing</p>
                                </li>
                                
                                <!-- Location -->
                                <li class="dp-item border-l-4 border-gray-200 pl-4">
                                    <h1 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Location</h1>
                                    <p class="text-gray-700">Imperial Health, Plot 9 Road No. 17, Dhaka 1212</p>
                                </li>
                                
                                <!-- Deadline -->
                                <li class="dp-item border-l-4 border-gray-200 pl-4">
                                    <h1 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Deadline</h1>
                                    <p class="text-gray-700">January 31, 2026</p>
                                </li>
                            </ul>

                            <!-- Job Footer: Apply Button & Short Desc -->
                            <div class="job-footer">
                                <a href="https://docs.google.com/forms/d/e/1FAIpQLSecn_HEcGnHkPp7FA8v9oKVx8eQyB3rLbVkKNUA6wpAXH2vtQ/viewform?usp=pp_url&entry.543597064=Executive,%20Corporate%20Sales&entry.994170229=JN00283" target="_blank" class="btn-link block w-full text-center bg-imperial-primary hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow transition-colors mb-4">
                                    Apply Job
                                </a>
                                
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 text-sm text-gray-600 italic leading-relaxed">
                                    We are looking for Dynamic, self-motivated individuals to join our corporate sales team to help create and implement sales strategies and meet the company set goals. The ideal candidate should have a proven track record of success in the corporate sales sector or related fields with aggressive sales drive to meet targets. 
                                    <a href="mailto:careers@imperialhealth.com" class="text-imperial-primary font-medium hover:underline">careers@imperialhealth.com</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Video (Span 8) -->
                    <div class="lg:col-span-8 order-2 lg:order-2">
                        <div class="video-block w-full">
                            <!-- Responsive YouTube Wrapper -->
                            <div class="aspect-video w-full bg-gray-900 rounded-xl overflow-hidden shadow-lg relative group">
                                <!-- Using standard iframe for functionality -->
                                <iframe 
                                    class="w-full h-full object-cover"
                                    src="https://www.youtube.com/embed/1e8IuFn60uY?start=10&end=30&modestbranding=2&rel=0" 
                                    title="Imperial Health Career Video" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- BOTTOM SECTION: Rich Text Content -->
        <section class="py-12 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="richtext-cont prose prose-lg max-w-none text-gray-700">
                        
                        <!-- Key Responsibility Areas -->
                        <div class="mb-8">
                            <p class="text-xl font-bold text-imperial-primary mb-4 border-b pb-2">Key Responsibility Areas:</p>
                            <ul class="list-disc list-outside ml-6 space-y-3">
                                <li>Identify and secure new organizations and companies as clients and establish strategic partnerships.</li>
                                <li>Responsible for building and maintaining strong, long-lasting relationships with corporate partners.</li>
                                <li>Serve as the primary point of contact for portfolio management, providing support for high-severity requests and handling issue escalations as needed.</li>
                                <li>Maintain regular communication with corporate partners, activating services such as compliance performance, promotional deals, and marketing packages to drive portfolio and revenue growth, while meeting or exceeding targets for revenue, account expansion, retention and development.</li>
                                <li>Continuously assess and revise partner operations to ensure a seamless flow of services across the entire delivery process.</li>
                                <li>Collaborate closely with Operations, IT, Medical Services and laboratory teams for lead management.</li>
                                <li>Log daily work activities and manage the business pipeline using account management tools (Pipedrive, ClickUp) for accurate tracking and projections.</li>
                            </ul>
                        </div>

                        <!-- Qualifications -->
                        <div class="mb-8">
                            <p class="text-xl font-bold text-imperial-primary mb-4 border-b pb-2">Qualifications:</p>
                            <ul class="list-disc list-outside ml-6 space-y-3">
                                <li>Bachelors in any discipline.</li>
                            </ul>
                        </div>

                        <!-- Experience -->
                        <div class="mb-8">
                            <p class="text-xl font-bold text-imperial-primary mb-4 border-b pb-2">Experience:</p>
                            <ul class="list-disc list-outside ml-6 space-y-3">
                                <li>At least 1-2 years of experience in corporate sales, including account planning and business development.</li>
                            </ul>
                        </div>

                        <!-- Technical Skills/Knowledge -->
                        <div class="mb-8">
                            <p class="text-xl font-bold text-imperial-primary mb-4">Technical Skills/Knowledge:</p>
                            
                            <div class="mb-4">
                                <p class="font-bold text-gray-900 text-lg mb-2">Business/Commercial Knowledge</p>
                                <ul class="list-disc list-outside ml-6 space-y-2">
                                    <li>Excellent written and verbal communication skills in English and Bangla.</li>
                                    <li>Knowledge of Sales pitching the right way to corporate POCs and decision-makers.</li>
                                    <li>Strong organizational skills and decision-making ability.</li>
                                    <li>Excellent critical thinking skills and ability to exercise good judgment and solve problems quickly and effectively.</li>
                                    <li>Ability to work independently to meet targets and deadlines.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Behavioral Competencies -->
                        <div class="mb-8">
                            <p class="text-xl font-bold text-imperial-primary mb-4 border-b pb-2">Behavioral Competencies:</p>
                            <ul class="list-disc list-outside ml-6 space-y-2">
                                <li>Honest</li>
                                <li>Service orientation</li>
                                <li>Attention to details</li>
                                <li>Teamwork</li>
                                <li>Resilience</li>
                                <li>Analytical and problem solving approach</li>
                                <li>Organized and attention to detail</li>
                                <li>Proactive in nature.</li>
                            </ul>
                        </div>

                        <!-- IT Skills -->
                        <div class="mb-8">
                            <p class="text-xl font-bold text-imperial-primary mb-4 border-b pb-2">IT Skills</p>
                            <ul class="list-disc list-outside ml-6 space-y-3">
                                <li>Good level PC skills particularly in MS Excel, Word and PowerPoint (knowledge of Windows XP and MS outlook is essential).</li>
                            </ul>
                        </div>

                        <!-- Interpersonal Skills -->
                        <div class="mb-8">
                            <p class="text-xl font-bold text-imperial-primary mb-4 border-b pb-2">Interpersonal Skills</p>
                            <ul class="list-disc list-outside ml-6 space-y-3">
                                <li>Outstanding negotiating skills.</li>
                                <li>Should be comfortable giving and receiving criticism, asking a lot of questions, and taking ownership.</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>
    <!-- Main Content End -->

@endsection