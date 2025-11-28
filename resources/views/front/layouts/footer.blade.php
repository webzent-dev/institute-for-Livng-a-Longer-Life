
<footer class="bg-white border-t border-gray-200 font-jakarta">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8">
      <!-- Brand -->
      <div class="col-span-1 md:col-span-2 text-center md:text-left">
          <div class="mb-4 flex justify-center md:justify-start">
              <img 
                  src="{{ asset('assets/logo.png') }}" 
                  alt="Institute for Living Longer" 
                  class="h-16 w-auto" 
              />
          </div>

          <p class="max-w-md mb-4 mx-auto md:mx-0">
              Your personalized journey to wellness. Join our community for a longer, healthier life through 
              evidence-based practices and expert guidance.
          </p>

          <div class="flex space-x-4 justify-center md:justify-start">
              <a href="#" class="hover:text-green-600 transition-colors">
                  <i data-lucide="facebook" class="h-5 w-5"></i>
              </a>
              <a href="#" class="hover:text-pink-600 transition-colors">
                  <i data-lucide="instagram" class="h-5 w-5"></i>
              </a>
              <a href="#" class="hover:text-sky-500 transition-colors">
                  <i data-lucide="twitter" class="h-5 w-5"></i>
              </a>
          </div>
      </div>
           @php
          $quickLinks = [
            ['title' => 'About Dr. Zeines', 'href' => '/about-dr-zeines'],
            ['title' => 'Our Collaborators', 'href' => '/collaborators'],
            ['title' => 'Become a Collaborator', 'href' => '/become-collaborator'],
            ['title' => 'Membership Plans', 'href' => '/membership'],
            ['title' => 'Store', 'href' => '/shop'],
            ['title' => 'Collaborator Portal', 'href' => '/collaborator-portal'],
            ['title' => 'Admin Portal', 'href' => '/admin'],
          ];
          @endphp

      <!-- Quick Links -->
      <div>
        <h3 class="font-bold  text-gray-800 mb-4">Quick Links</h3>
        <ul class="space-y-2">
          @foreach ($quickLinks as $link)
            <li>
              <a href="{{ $link['href'] }}" class="hover:text-green-600 transition-colors">
                {{ $link['title'] }}
              </a>
            </li>
          @endforeach
        
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h3 class="font-semibold text-gray-800 mb-4">Contact</h3>
        <ul class="space-y-3">
          <li class="flex items-start ">
            <i data-lucide="mail" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0"></i>
            <a href="mailto:info@instituteforlivinglonger.com" class="hover:text-green-600 transition-colors">info@instituteforlivinglonger.com</a>
          </li>
          <li class="flex items-start ">
            <i data-lucide="phone" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0"></i>
            <div class="space-y-1">
              <div>580 Park Avenue Suite 1E</div>
              <div>New York, NY 10065</div>
              <div class="pt-2">3103 Route 28</div>
              <div>Shokan, NY 12481</div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="border-t border-gray-200  py-8  text-center  text-sm">
      <p>&copy; <span id="year"></span> Institute for Living Longer. Designed by <a href="https://www.webzent.com" class=" hover:text-green-600 transition-colors text-amber-500 font-semibold">Webzent Technologies Pvt. Ltd.</a></p>
    </div>
  </div>
</footer>

<script>
  // Set copyright year
  (function () {
    const el = document.getElementById('year');
    if (el) el.textContent = new Date().getFullYear();
  })();
</script>
 
