@extends('front.layouts.app')
@section('content')
<div class="min-h-screen flex flex-col">
    <main class="flex-1">
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-6">
                    <i data-lucide="help-circle" class="w-8 h-8" ></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Frequently Asked Questions</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Find answers to common questions about our membership, products, and <br>services.
                </p>
            </div>
        </section>
 
        <section class="py-20 bg-background">
            <div class="max-w-4xl mx-auto px-6 space-y-10">
                @foreach ($faqs as $section)
                    <div class="bg-white shadow-md rounded-xl border " >
                        <div class="px-6 py-4 border-b flex items-center">
                            <div class="w-2 h-8 gradient-primary rounded-full mr-3"></div>
                            <h3 class="text-xl font-bold">{{ $section['category'] }}</h3>
                        </div>
                        <div class="p-6">
                            <x-ui.accordion :items="$section['questions']" />
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- CTA SECTION --}}
        <x-ui.cta-section
            icon="mail"
            align="center"
            title="Still Have Questions?"
            subtitle="Can't find the answer you're looking for? Our support team is here to help."
            cardClass="hover:border-gray-200"
            :buttons="[
                ['route' => 'contact',   'label' => 'Contact Support', 'variant' => 'outline',  ],
                ['href' => '/help-center', 'label' => 'Visit Help Center', 'variant' => 'outline',  ],
            ]"
        />
    </main>
</div>
@endsection