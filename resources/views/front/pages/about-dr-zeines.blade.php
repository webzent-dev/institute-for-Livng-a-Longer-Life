@extends('front.layouts.app')
@section('content')
    @if($aboutPageContent && $aboutPageContent->page_content)
        {!! $aboutPageContent->page_content !!}
    @else


    <main class="flex-1">
        <section class="gradient-subtle py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <h1 class="text-4xl lg:text-6xl font-bold text-foreground text-left">Meet Dr. Victor Zeines</h1>
                        <p class="text-xl text-muted-foreground">
                            Founder of the Institute for Living Longer
                        </p>
                        <div class="h-1 w-24 gradient-primary rounded-full"></div>
                    </div>
                    <div class="relative">
                        <div class="aspect-square rounded-2xl overflow-hidden shadow-strong">
                        <img src="{{ env('APP_URL') . '/assets/dr-zeines.webp' }}" alt="Dr. Victor Zeines"
                            class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-background bg-white">
            <div class="max-w-7xl mx-auto grid md:grid-cols-2 lg:grid-cols-4 gap-8 px-4">
                <x-card class="equal-height">
                    <x-card-content class="space-y-4">
                        <div class="iconbg w-14 h-14">
                            <i data-lucide="graduation-cap" class="w-7 h-7 text-primary-foreground"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-foreground">Education & Training</h3>
                        <p class="text-muted-foreground text-[16px]">Doctorate in Dental Medicine with specialized training in holistic health and longevity medicine</p>
                    </x-card-content>
                </x-card>
                <x-card class="equal-height">
                    <x-card-content class="space-y-4">
                        <div class="iconbg w-14 h-14">
                            <i data-lucide="award" class="w-7 h-7 text-primary-foreground"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-foreground">40+ Years Experience</h3>
                        <p class="text-muted-foreground text-[16px]">Pioneering holistic approaches to health, wellness, and biological age reversal</p>
                    </x-card-content>
                </x-card>
                <x-card class="equal-height">
                    <x-card-content class="space-y-4">
                        <div class="iconbg w-14 h-14">
                            <i data-lucide="book-open" class="w-7 h-7 text-primary-foreground"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-foreground">Published Author</h3>
                        <p class="text-muted-foreground text-[16px]">Multiple publications on integrative health and evidence-based wellness practices</p>
                    </x-card-content>
                </x-card>
                <x-card class="equal-height">
                    <x-card-content class="space-y-4">
                        <div class="iconbg w-14 h-14">
                            <i data-lucide="heart" class="w-7 h-7 text-primary-foreground"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-foreground">Wellness Philosophy</h3>
                        <p class="text-muted-foreground text-[16px]">Dedicated to empowering individuals to take control of their health through education and community support</p>
                    </x-card-content>
                </x-card>
            </div>
        </section>
        <section class="py-20 gradient-subtle">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg border bg-card text-card-foreground   shadow-sm">
                    <div class="p-8 lg:p-12 space-y-6 ">
                        <h2 class="text-3xl font-bold text-foreground mb-6 text-left">A Lifetime Dedicated to Health & Wellness</h2>
                        <div class="prose prose-lg max-w-none text-muted-foreground space-y-4 text-[16px]">
                            <p class="text-[16px]">
                                Dr. Victor Zeines has dedicated over four decades to understanding
                                and teaching the principles of holistic health and longevity. As a
                                pioneering voice in integrative medicine, he has helped thousands of
                                individuals transform their lives through evidence-based wellness
                                practices.
                            </p>
                            <p class="text-[16px]">
                                His unique approach combines traditional medical knowledge with
                                cutting-edge research in nutrition, exercise science, stress
                                management, and biological age reversal. Dr. Zeines believes that
                                true health is not merely the absence of disease, but a state of
                                complete physical, mental, and social well-being.
                            </p>
                            <p class="text-[16px]">
                                Through the Institute for Living Longer, Dr. Zeines has created a
                                comprehensive educational platform that makes advanced wellness
                                knowledge accessible to everyone. His teaching style is warm,
                                engaging, and deeply rooted in scientific evidence, making complex
                                health concepts easy to understand and implement.
                            </p>
                            <p class="text-[16px]">
                                Beyond his individual practice, Dr. Zeines has assembled a network
                                of world-class collaborators — expert physicians and health
                                practitioners who share his vision of empowering individuals to
                                take charge of their health destiny. Together, they offer a
                                comprehensive approach to wellness that addresses every aspect of
                                healthy living.
                            </p>
                        </div>
                        <div class="mt-8 p-6 bg-secondary rounded-xl">
                            <p class="text-lg font-semibold text-foreground mb-2 text-[18px]">
                                "My mission is simple: to empower you with the knowledge and tools
                                you need to live a longer, healthier, and more vibrant life."
                            </p>
                            <p class="text-muted-foreground text-[16px]">- Dr. Victor Zeines</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-background">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-5xl font-bold text-foreground mb-4">Dr. Zeines' Wellness Philosophy</h2>
                    <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                        Five core principles for lasting health and vitality
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <x-card class="equal-height">
                        <x-card-content>
                            <div class="text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4">01</div>
                            <h3 class="text-xl font-semibold text-foreground mb-2 text-[20px]">Prevention First</h3>
                            <p class="text-muted-foreground text-[16px]">Focus on preventing disease rather than just treating symptoms</p>
                        </x-card-content>
                    </x-card>
                    <x-card class="equal-height">
                        <x-card-content>
                            <div class="text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4">02</div>
                            <h3 class="text-xl font-semibold text-foreground mb-2 text-[20px]">Whole Person Care</h3>
                            <p class="text-muted-foreground text-[16px]">Address physical, mental, emotional, and spiritual health</p>
                        </x-card-content>
                    </x-card>
                    <x-card class="equal-height">
                        <x-card-content>
                            <div class="text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4">03</div>
                            <h3 class="text-xl font-semibold text-foreground mb-2 text-[20px]">Evidence-Based</h3>
                            <p class="text-muted-foreground text-[16px]">Combine traditional wisdom with scientific research</p>
                        </x-card-content>
                    </x-card>
                    <x-card class="equal-height">
                        <x-card-content>
                            <div class="text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4">04</div>
                            <h3 class="text-xl font-semibold text-foreground mb-2 text-[20px]">Personalized Approach</h3>
                            <p class="text-muted-foreground text-[16px]">Recognize that each person’s path to wellness is unique</p>
                        </x-card-content>
                    </x-card>
                    <x-card class="equal-height">
                        <x-card-content>
                            <div class="text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4">05</div>
                            <h3 class="text-xl font-semibold text-foreground mb-2 text-[20px]">Sustainable Habits</h3>
                            <p class="text-muted-foreground text-[16px]">Build lasting lifestyle changes, not quick fixes</p>
                        </x-card-content>
                    </x-card>
                    <x-card class="equal-height">
                        <x-card-content>
                            <div class="text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4">06</div>
                            <h3 class="text-xl font-semibold text-foreground mb-2 text-[20px]">Community Support</h3>
                            <p class="text-muted-foreground text-[16px]">Harness the power of community for lasting transformation</p>
                        </x-card-content>
                    </x-card>
                </div>
            </div>
        </section>
    </main>
     @endif
@endsection