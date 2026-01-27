@php
    $logo = DB::table('web_settings')->where('id', 1)->first();
@endphp
<footer class=" bg-foreground text-background relative overflow-hidden text-white" style="background:#2B3B36; font-family:'Plus Jakarta Sans', sans-serif !important;">
  <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-8 pt-12">
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-8 pb-8">
      <!-- Brand -->
      <div class="col-span-1 md:col-span-2 text-left">
          <div class="mb-4 flex justify-start">
              <img
                  src="{{ asset('storage/'.$logo->logo) }}"
                  alt="Institute for Living Longer"
                  class="h-16 w-auto"
              />
          </div>

          <p class="text-background/80 text-sm max-w-md mb-4 ">
              Your personalized journey to wellness. Join our community for a longer, healthier life through
              evidence-based practices and expert guidance.
          </p>

          <div class="flex space-x-4 justify-start">
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
        <h3 class="font-semibold text-background mb-4 text-sm">Quick Links</h3>
        <ul class="space-y-2">
          @foreach ($quickLinks as $link)
            <li>
              <a href="{{ $link['href'] }}" class="text-background/80 hover:text-primary transition-colors text-sm">
                {{ $link['title'] }}
              </a>
            </li>
          @endforeach

        </ul>
      </div>

      <!-- Contact -->
      <div class=" ">
        <h3 class="  font-semibold text-background mb-4 text-sm">Contact</h3>
            <ul class="space-y-3">
            <li class="flex items-start gap-2">
                    <div class="iconbg ">
                    <i data-lucide="mail" class="h-5 w-5   "></i>
                    </div>
                    <a href="mailto:info@instituteforlivinglonger.com" class=" flex items-start text-background/80 hover:text-primary transition-colors text-sm mt-2 text-wrap">info@instituteforlivinglonger.com</a>
            </li>

                <li class="flex items-start text-background/80 text-sm gap-2 ">

                        <div class="iconbg">
                        <i data-lucide="map-pin" class="h-6 w-6   "></i>
                        </div>

                        <div class="space-y-1">
                            <div>    <h3 class=" font-semibold text-background mb-4 text-sm ">Locations</h3> </div>

                                            <a href="https://maps.app.goo.gl/1cXGaXLE86aCyT2p7" target="_blank" rel="noopener noreferrer" class="">
                                            <p class="hover:text-green-600 flex items-start text-background/80 hover:text-primary transition-colors text-sm mt-2 ">
                                                580 Park Avenue Suite 1E<br>
                                                New York, NY 10065
                                            </p>
                                            </a>
                                            <a href="https://maps.app.goo.gl/BtRX2FRtfRZTyxdY6" target="_blank" rel="noopener noreferrer" class=" ">
                                            <p class="hover:text-green-600 flex items-start text-background/80 hover:text-primary transition-colors text-sm mt-2 ">
                                                3103 Route 28<br>
                                                Shokan, NY 12481
                                            </p>
                                            </a>
                        </div>

                </li>

            </ul>
      </div>
    </div>

    <div class="border-t text-background/80  py-8  text-center  text-sm">
      <p>&copy; <span id="year"></span> Institute for Living Longer. Designed by <a href="https://www.webzent.com" class=" hover:text-primary transition-colors text-accent font-semibold">Webzent Technologies Pvt. Ltd.</a></p>
    </div>
  </div>

</footer>




<script>

  (function () {
    const el = document.getElementById('year');
    if (el) el.textContent = new Date().getFullYear();
  })();
</script>

