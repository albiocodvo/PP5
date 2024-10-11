<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<!-- component -->
<div class="bg-white">
  <header class="absolute inset-x-0 top-0 z-50">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
      <div class="flex lg:flex-1">
        <a href="landing_page.php" class="-m-1.5 p-1.5 transition duration-200 hover:text-indigo-600">
          <span class="text-xl font-bold text-gray-900">The Virtual Aid Co.</span>
        </a>
      </div>
      <div class="flex lg:hidden">
        <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
          <span class="sr-only">Open main menu</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
        <a href="services.php" class="text-sm font-semibold leading-6 text-gray-900">Services</a>
        <a href="pricing.php" class="text-sm font-semibold leading-6 text-gray-900">Pricing</a>

        <?php if (isset($_SESSION['role'])): ?>
          <!-- Employer specific links -->
          <?php if ($_SESSION['role'] === 'employer'): ?>
            <a href="employer_dashboard.php" class="text-sm font-semibold leading-6 text-gray-900">Post A Job</a>
          <?php endif; ?>

          <!-- Job seeker specific links -->
          <?php if ($_SESSION['role'] === 'job_seeker'): ?>
            <a href="job_seeker_dashboard.php" class="text-sm font-semibold leading-6 text-gray-900">Find Jobs</a>
          <?php endif; ?>
        <?php else: ?>
          <a href="login.php" class="text-sm font-semibold leading-6 text-gray-900">What Are You Looking For?</a>
        <?php endif; ?>

        <a href="contact_form.php" class="text-sm font-semibold leading-6 text-gray-900">Contact Us</a>
      </div>
      <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        <?php if (isset($_SESSION['role'])): ?>
          <form action="logout.php" method="POST">
            <button type="submit" class="text-sm font-semibold leading-6 text-gray-900">Log out</button>
          </form>
        <?php else: ?>
          <a href="login.php" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
        <?php endif; ?>
      </div>
    </nav>

    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true">
      <!-- Background backdrop, show/hide based on slide-over state. -->
      <div class="fixed inset-0 z-50"></div>
      <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <div class="flex items-center justify-between">
          <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">Your Company</span>
            <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="">
          </a>
          <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Close menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="mt-6 flow-root">
          <div class="-my-6 divide-y divide-gray-500/10">
            <div class="space-y-2 py-6">
              <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Services</a>
              <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Pricing</a>

              <?php if (isset($_SESSION['role'])): ?>
                <!-- Employer specific links -->
                <?php if ($_SESSION['role'] === 'employer'): ?>
                  <a href="post_job.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Post A Job</a>
                <?php endif; ?>

                <!-- Job seeker specific links -->
                <?php if ($_SESSION['role'] === 'job_seeker'): ?>
                  <a href="find_jobs.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Find Jobs</a>
                <?php endif; ?>
              <?php endif; ?>
            </div>
            <div class="py-6">
              <?php if (isset($_SESSION['role'])): ?>
                <form action="logout.php" method="POST">
                  <button type="submit" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log out</button>
                </form>
              <?php else: ?>
                <a href="login.php" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</div>
