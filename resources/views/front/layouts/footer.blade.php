@php
    $logo = DB::table('web_settings')->where('id', 1)->first();
@endphp  
<footer class="bg-white border-t border-gray-200 font-jakarta">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-8 pb-8">
      <!-- Brand -->
      <div class="col-span-1 md:col-span-2 text-center md:text-left">
          <div class="mb-4 flex justify-center md:justify-start">
              <img 
                  src="{{ asset('storage/'.$logo->logo) }}" 
                  alt="Institute for Living Longer" 
                  class="h-16 w-auto" 
              />
          </div>

          <p class="max-w-md mb-4 mx-auto md:mx-0">
              Your personalized journey to wellness. Join our community for a longer, healthier life through 
              evidence-based practices and expert guidance.
          </p>

          <div class="flex space-x-4 justify-center md:justify-start">
              <a href="#" class="iconbg">
                  <i data-lucide="facebook" class="h-6 w-6 text-white"></i>
              </a>
              <a href="#" class="iconbg">
                  <i data-lucide="instagram" class="h-6 w-6"></i>
              </a>
              <a href="#" class="iconbg">
                  <i data-lucide="twitter" class="h-6 w-6"></i> 
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
        <h3 class="text-2xl font-bold  text-gray-800 mb-4">Quick Links</h3>
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
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Contact</h3>
        <ul class="space-y-3">
          <li class="flex items-start gap-2">
             <div class="iconbg ">
              <i data-lucide="mail" class="h-5 w-5   "></i>
            </div>
            <a href="mailto:info@instituteforlivinglonger.com" class="hover:text-green-600 transition-colors">info@instituteforlivinglonger.com</a>
          </li>
          <li class="flex items-start gap-2 ">
           
            <div class="iconbg">
              <i data-lucide="map-pin" class="h-6 w-6   "></i>
            </div>
            
            <div class="space-y-1">
              <div>    <h3 class="font-semibold text-foreground">Locations</h3>
                                    </div>
                                       
                                        <a href="https://maps.app.goo.gl/1cXGaXLE86aCyT2p7" target="_blank" rel="noopener noreferrer" class="  ">
                                        <p class="text-muted-foreground mb-3 hover:text-primary transition-colors block">
                                            580 Park Avenue Suite 1E<br>
                                            New York, NY 10065
                                        </p>
                                        </a>
                                         <a href="https://maps.app.goo.gl/BtRX2FRtfRZTyxdY6" target="_blank" rel="noopener noreferrer" class=" ">
                                        <p class="text-muted-foreground hover:text-primary transition-colors block">
                                            3103 Route 28<br>
                                            Shokan, NY 12481
                                        </p>
                                        </a>
                                    </div>
              
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
 
