<footer class=" bg-foreground text-background relative overflow-hidden text-white" style="background:#2B3B36; font-family:'Plus Jakarta Sans', sans-serif !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-8 pt-12">
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-8 pb-8">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-2 text-left">
                <div class="mb-4 flex justify-start">
                    @if(!empty($webSettingData->logo) && file_exists(public_path('uploads/'.$webSettingData->logo)))
                        <img src="{{ asset('uploads/'.$webSettingData->logo) }}" alt="{{$webSettingData->tagline}}" class="h-16 w-auto"/>
                    @else
                        <img src="{{ asset('assets/logo.png') }}" alt="Institute for Living Longer" class="h-16 w-auto"/>
                    @endif
                </div>
                <p class="text-background/80 text-sm max-w-md mb-4 leading-relaxed">
                    @if(!empty($webSettingData->footer_text))
                        {{ $webSettingData->footer_text }}
                    @else
                        Join our community for a longer, healthier life through evidence-based practices and expert guidance.
                    @endif
                </p>
                <div class="flex space-x-4 justify-start">
                    @if(!empty($webSettingData->facebook_url))
                        <a href="{{$webSettingData->facebook_url}}" target="_blank" class="iconbg hover:bg-emerald-600 transition-colors duration-300">
                            <!-- <i data-lucide="facebook" class="h-6 w-6 text-white"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook h-5 w-5"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                    @else
                        <a href="#" class="iconbg hover:bg-emerald-600 transition-colors duration-300">
                            <!-- <i data-lucide="facebook" class="h-6 w-6 text-white"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook h-5 w-5"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                    @endif

                    @if(!empty($webSettingData->instagram_url))
                        <a href="{{$webSettingData->instagram_url}}" target="_blank" class="iconbg hover:bg-emerald-600 transition-colors duration-300">
                            <!-- <i data-lucide="instagram" class="h-6 w-6"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram h-5 w-5"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                        </a>
                    @else
                        <a href="#" class="iconbg hover:bg-emerald-600 transition-colors duration-300">
                            <!-- <i data-lucide="instagram" class="h-6 w-6"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram h-5 w-5"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                        </a>
                    @endif
                    
                    @if(!empty($webSettingData->twitter_url))
                        <a href="{{$webSettingData->twitter_url}}" target="_blank" class="iconbg hover:bg-emerald-600 transition-colors duration-300">
                            <!-- <i data-lucide="twitter" class="h-6 w-6"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                            </svg>
                        </a>
                    @else
                        <a href="#" class="iconbg hover:bg-emerald-600 transition-colors duration-300">
                            <!-- <i data-lucide="twitter" class="h-6 w-6"></i> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                            </svg>
                        </a>
                    @endif

                    @if(!empty($webSettingData->youtube_url))
                        <a href="{{$webSettingData->youtube_url}}" target="_blank" class="iconbg hover:bg-emerald-600 transition-colors duration-300">
                            <!-- <i data-lucide="youtube" class="h-6 w-6"></i> -->
                            <svg xmlns="http://www.w3.org" width="24" height="24" viewBox="0 0 24 24" fill="#FF0000">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" fill="white"/>
                            </svg>
                        </a>
                    @else
                        <a href="#" class="iconbg hover:bg-emerald-600 transition-colors duration-300">
                            <!-- <i data-lucide="youtube" class="h-6 w-6"></i> -->
                            <svg xmlns="http://www.w3.org" width="24" height="24" viewBox="0 0 24 24" fill="#FF0000">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" fill="white"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
            <!-- Quick Links -->
            <div class="text-left" style="padding-top: 3.5rem;">
                <h3 class="font-semibold text-background mb-4 text-sm">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ url('/about-dr-zeines') }}" class="text-background/80 hover:text-primary transition-colors text-sm">About Dr. Zeines</a>
                    </li>
                    <li>
                        <a href="{{ url('/collaborators') }}" class="text-background/80 hover:text-primary transition-colors text-sm">Our Collaborators</a>
                    </li>
                    <li>
                        <a href="{{ url('/become-collaborator') }}" class="text-background/80 hover:text-primary transition-colors text-sm">Become a Collaborator</a>
                    </li>
                    <li>
                        <a href="{{ url('/membership') }}" class="text-background/80 hover:text-primary transition-colors text-sm">Membership Plans</a>
                    </li>
                    <li>
                        <a href="{{ url('/shop') }}" class="text-background/80 hover:text-primary transition-colors text-sm">Store</a>
                    </li>
                    <li>
                        <a href="{{ url('/collaborator') }}" class="text-background/80 hover:text-primary transition-colors text-sm">Collaborator Portal</a>
                    </li>
                </ul>
            </div>
            <!-- Contact -->
            <div class="text-left" style="padding-top: 3.5rem;">
                <h3 class="font-semibold text-background mb-4 text-sm">Contact</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <div class="iconbg flex-shrink-0">
                            <i data-lucide="mail" class="h-5 w-5"></i>
                        </div>
                        <div class="flex-1">
                            @if(!empty($siteSettingData->contact_email))
                                <a href="mailto:{{$siteSettingData->contact_email}}" class="text-background/80 hover:text-emerald-400 transition-colors text-sm leading-relaxed">{{$siteSettingData->contact_email}}</a>
                            @else
                                <a href="mailto:info@instituteforlivinglonger.com" class="text-background/80 hover:text-emerald-400 transition-colors text-sm leading-relaxed">info@instituteforlivinglonger.com</a>
                            @endif
                        </div>
                    </li>
                    @if(count($locations)>0)
                        <li>
                            <h4 class="font-semibold text-background text-sm mb-3">Our Locations</h4>
                            <div class="space-y-3">
                                @foreach($locations as $index => $location)
                                <div class="flex items-start gap-3">
                                    <div class="iconbg flex-shrink-0 mt-0.5">
                                        <i data-lucide="map-pin" class="h-5 w-5"></i>
                                    </div>
                                    <a href="https://maps.google.com/?q={{ $location->latitude }},{{ $location->longitude }}" target="_blank" rel="noopener noreferrer" class="flex-1 group">
                                        <div class="text-background/80 hover:text-emerald-400 transition-colors text-sm leading-relaxed">
                                            <div class="">{{ $location->address }}</div>
                                            <div class="text-background/70">{{ $location->city }}, {{ $location->state }} {{ $location->zip }}</div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="border-t text-background/80 py-8 text-center text-sm">
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