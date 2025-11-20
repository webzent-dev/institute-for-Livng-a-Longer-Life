@extends('front.layouts.app')

@section('content')
 

    
        @php
        $credentials = [
            ['icon'=>'graduation-cap','title'=>'Education & Training','description'=>'Doctorate in Dental Medicine with specialized training in holistic health and longevity medicine'],
            ['icon'=>'award','title'=>'40+ Years Experience','description'=>'Pioneering holistic approaches to health, wellness, and biological age reversal'],
            ['icon'=>'book-open','title'=>'Published Author','description'=>'Multiple publications on integrative health and evidence-based wellness practices'],
            ['icon'=>'heart','title'=>'Wellness Philosophy','description'=>'Dedicated to empowering individuals to take control of their health through education and community support'],
        ];
        @endphp


    
<div class="min-h-screen flex flex-col font-jakarta">

        {{-- HERO --}}
        <section class=" py-20  bg-stone-50 ">
            <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-12 items-center">

                <div class="space-y-6">
                    <h1 class="text-4xl lg:text-6xl font-bold text-foreground text-teal-950">
                        Meet Dr. Victor Zeines
                    </h1>

                    <p class="text-xl text-muted-foreground text-neutral-500">
                        Founder of the Institute for Living Longer
                    </p>

                    <div class="h-1 w-24 gradient-primary rounded-full"></div>
                </div>

                <div class="relative">
                    <div class="aspect-square rounded-2xl overflow-hidden   w-4/5 mx-auto justify-self-end">
                        <img src="/assets/dr-zeines.webp" class="w-full h-full object-cover" />
                    </div>
                </div>

            </div>
        </section>

    
        <section class="py-20 bg-background bg-white ">
            <div class="max-w-7xl mx-auto grid md:grid-cols-2 lg:grid-cols-4 gap-8 px-4">

                @foreach($credentials as $c)
                    <x-card class="border-2 card-benefit  bg-white  transition-all duration-300 p-2 rounded-xl shadow hover:border-emerald-500 hover:border-[1px] equal-height">
                        <x-card-content class="space-y-4">

                            <div class="w-14 h-14 rounded-xl gradient-primary flex items-center justify-center mb-4 bg-emerald-500 ">
                                <i data-lucide="{{ $c['icon'] }}" class="w-7 h-7 text-primary-foreground"></i>
                            </div>

                            <h3 class="text-xl font-semibold text-foreground text-teal-950">
                                {{ $c['title'] }}
                            </h3>

                            <p class="text-muted-foreground text-neutral-500">
                                {{ $c['description'] }}
                            </p>

                        </x-card-content>
                    </x-card>
                @endforeach
               

            </div>
        </section>

        {{-- BIOGRAPHY SECTION (converted 1:1) --}}
        <section class="py-20 gradient-subtle bg-stone-50 ">
            <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-1 gap-4 item-center justify-center">
                <x-card class=" max-w-4xl mx-auto shadow-strong equal-height">
                    <x-card-content class="p-8 lg:p-12 space-y-6">

                        <h2 class="text-3xl font-bold text-foreground text-teal-950">
                            A Lifetime Dedicated to Health & Wellness
                        </h2>

                        <div class="prose prose-lg text-muted-foreground space-y-4 text-neutral-500">
                            Dr. Victor Zeines has dedicated over four decades to understanding and teaching the principles of holistic health and longevity. As a pioneering voice in integrative medicine, he has helped thousands of individuals transform their lives through evidence-based wellness practices.<br><br> 

                            His unique approach combines traditional medical knowledge with cutting-edge research in nutrition, exercise science, stress management, and biological age reversal. Dr. Zeines believes that true health is not merely the absence of disease, but a state of complete physical, mental, and social well-being.
                            <br><br>
                            Through the Institute for Living Longer, Dr. Zeines has created a comprehensive educational platform that makes advanced wellness knowledge accessible to everyone. His teaching style is warm, engaging, and deeply rooted in scientific evidence, making complex health concepts easy to understand and implement.
                            <br><br>
                            Beyond his individual practice, Dr. Zeines has assembled a network of world-class collaborators - expert physicians and health practitioners who share his vision of empowering individuals to take charge of their health destiny. Together, they offer a comprehensive approach to wellness that addresses every aspect of healthy living.
                        </div>

                        <div class="mt-8 p-6 bg-secondary rounded-xl bg-teal-50">
                            <p class="text-lg font-semibold text-foreground mb-2">
                                "My mission is simple: to empower you with the knowledge and tools you need to live a longer, healthier, and more vibrant life."
                            </p>
                            <p class="text-muted-foreground">- Dr. Victor Zeines</p>
                        </div>

                    </x-card-content>
                </x-card>
                
        </section>

        {{-- PHILOSOPHY (same UI) --}}
        <section class="py-20 bg-background">
            <div class="max-w-7xl mx-auto px-4">

                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">
                        Dr. Zeines' Wellness Philosophy
                    </h2>
                    <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                        Five core principles for lasting health and vitality
                    </p>
                </div>

                @php
                $principles = [
                    ['01','Prevention First','Focus on preventing disease rather than just treating symptoms'],
                    ['02','Whole Person Care','Address physical, mental, emotional, and spiritual health'],
                    ['03','Evidence-Based','Combine traditional wisdom with scientific research'],
                    ['04','Personalized Approach','Recognize that each person’s path to wellness is unique'],
                    ['05','Sustainable Habits','Build lasting lifestyle changes, not quick fixes'],
                    ['06','Community Support','Harness the power of community for lasting transformation'],
                ];
                @endphp

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">

                    @foreach($principles as $p)
                        <x-card class="border-2 shadow-md hover:shadow-medium hover:border-emerald-600 hover:border-[1px] transition ">
                            <x-card-content>
                                <div class="text-5xl font-bold   bg-emerald-500 text-transparent bg-clip-text  mb-4">
                                    {{ $p[0] }}
                                </div>

                                <h3 class="text-xl font-semibold text-foreground mb-2 text-teal-950">
                                    {{ $p[1] }}
                                </h3>

                                <p class="text-muted-foreground text-neutral-500">
                                    {{ $p[2] }}
                                </p>
                            </x-card-content>
                        </x-card>
                    @endforeach

                </div>

            </div>
        </section>

    </div>

   
@endsection
