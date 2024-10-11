<?php

include 'navbar.php';
?>

<div class="bg-white">
    <div class="mx-auto max-w-7xl grid grid-cols-1 lg:grid-cols-2 px-4 py-24 sm:px-6 sm:py-32">
        <div class="flex flex-col justify-between">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Our Services</h2>
                <p class="mt-4 text-gray-500">At The Virtual Aid Co., we are committed to connecting job seekers with opportunities that match their skills and ambitions. Our platform provides a range of services designed to streamline your job search and enhance your career prospects.</p>

                <dl class="mt-16 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 sm:gap-y-16 lg:gap-x-8">
                    <div class="border-t border-gray-200 pt-4">
                        <dt class="font-medium text-gray-900">Job Listings</dt>
                        <dd class="mt-2 text-sm text-gray-500">Access a wide range of job opportunities across various industries, tailored to your skill set.</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <dt class="font-medium text-gray-900">Resume Building</dt>
                        <dd class="mt-2 text-sm text-gray-500">Get expert tips and templates to craft a compelling resume that stands out to employers.</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <dt class="font-medium text-gray-900">Interview Preparation</dt>
                        <dd class="mt-2 text-sm text-gray-500">Utilize our resources to prepare for interviews, including common questions and best practices.</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <dt class="font-medium text-gray-900">Career Coaching</dt>
                        <dd class="mt-2 text-sm text-gray-500">Work with our coaches to develop your career strategy and achieve your professional goals.</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <dt class="font-medium text-gray-900">Networking Opportunities</dt>
                        <dd class="mt-2 text-sm text-gray-500">Connect with industry professionals and expand your professional network through our events.</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <dt class="font-medium text-gray-900">Job Alerts</dt>
                        <dd class="mt-2 text-sm text-gray-500">Stay informed with job alerts tailored to your preferences, ensuring you never miss an opportunity.</dd>
                    </div>
                </dl>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:gap-8 h-full">
            <img src="./assets/images/job_seeker.jpg" alt="Job seekers reviewing listings on a laptop." class="rounded-lg bg-gray-100 object-cover h-full">
            <img src="./assets/images/coach.jpg" alt="A professional coach guiding a job seeker." class="rounded-lg bg-gray-100 object-cover h-full">
            <img src="./assets/images/interview.jpg" alt="An interview preparation session." class="rounded-lg bg-gray-100 object-cover h-full">
            <img src="./assets/images/event.jpg" alt="Networking event for professionals." class="rounded-lg bg-gray-100 object-cover h-full">
        </div>
    </div>
</div>

<?php
// Include your footer and any necessary files
include 'footer.php';
?>
