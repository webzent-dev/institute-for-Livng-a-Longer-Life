
@props(['plan'])

                @php
                  $isPopular = isset($plan['popular']) && $plan['popular'] === true;
                @endphp
              <div class="relative">
                    <div class="flex flex-col {{ $isPopular ? 'border-primary border-4 shadow-strong md:scale-105 bg-card' : 'border-2 shadow-medium bg-card' }} rounded-2xl  ">
                      @if($isPopular)
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                            <span class="gradient-accent px-6 py-2 rounded-full text-sm font-semibold text-accent-foreground shadow-medium inline-flex items-center">
                            
                            <i data-lucide="star" class="w-4 h-4  flex-shrink-0 mr-2 "></i>
                            Most Popular
                            </span>
                        </div>
                        @endif

                        <div class="text-center pb-8 pt-12 px-6">
                        <h3 class="text-3xl font-bold text-foreground mb-2">{{ $plan['name'] }}</h3>
                        <p class="text-muted-foreground mb-6">{{ $plan['description'] }}</p>
                        <div class="flex items-baseline justify-center">
                            <span class="text-5xl font-bold text-foreground">{{ $plan['price'] }}</span>
                            <span class="text-muted-foreground ml-2">{{ $plan['period'] }}</span>
                        </div>
                        </div>

                        <div class="flex-1 flex flex-col px-6 pb-6">
                        <div class="space-y-6 flex-1">
                            <div>
                            <h4 class="font-semibold text-foreground mb-3">Features</h4>
                            <ul class="space-y-3">
                                @foreach($plan['features'] as $feature)
                                <li class="flex items-start">
                                    
                                    <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0 mr-2 "></i>
                                    <span class="text-muted-foreground text-sm">{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                            </div>
                            {{-- Benefits part --}}
                            @if(isset($plan['benefits']) && is_array($plan['benefits']))  

                            <div>
                            <h4 class="font-semibold text-foreground mb-3">Benefits</h4>
                            <ul class="space-y-2">
                                @foreach($plan['benefits'] as $benefit)
                                <li class="flex items-center">
                                    <div class="w-1.5 h-1.5 rounded-full bg-primary mr-2"></div>
                                    <span class="text-muted-foreground text-sm">{{ $benefit }}</span>
                                </li>
                                @endforeach
                            </ul>
                            </div>
                            @endif
                        </div>
                        
                        
                        {{-- <button
                            type="button"
                            onclick="openMembershipModal(@json(['name' => $plan['name'], 'price' => $plan['price'], 'period' => $plan['period']]))"
                            class="{{ $isPopular ? 'gradient-primary text-primary-foreground hover:opacity-90 shadow-medium font-semibold' : 'border-2 border-primary   text-primary hover:bg-primary hover:text-primary-foreground' }} h-11 rounded-md px-8 w-full mt-8">
                            Get Started
                        </button> --}}
                       

                          <x-button-use
                              :href="!empty($plan['url']) 
                                  // ? url('/membership/' . $plan['slug']) 
                                  ? url($plan['url'])
                                  : url('#')"
                              :isPopular="$isPopular"
                              label="Get Started"
                          /> 


                        </div>
                    </div>
              </div>

















 