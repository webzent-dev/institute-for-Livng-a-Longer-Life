@extends('front.layouts.app')
@section('content')
@php
    // CMS sections (App\Models\PageContent, page_key "faq"), keyed by section_key. Every value
    // falls back to the original hard-coded copy, so the page still renders if a section has not
    // been seeded or an admin deactivates one.
    $sections = $sections ?? collect();
    $hero     = $sections['hero'] ?? null;
    $cta      = $sections['cta']  ?? null;
    $ctaMeta  = $cta->meta ?? [];
@endphp
<div class="min-h-screen flex flex-col">
    <main class="flex-1">
        @if($hero || !$sections->count())
        <section class="gradient-subtle py-10">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-6">
                    <i data-lucide="help-circle" class="w-8 h-8" ></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $hero->heading ?? 'Frequently Asked Questions' }}</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    {{ $hero->body ?? 'Find answers to common questions about our membership, products, and services.' }}
                </p>
            </div>
        </section>
        @endif
 
        <section class="py-5 bg-background">
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
        @if($cta || !$sections->count())
        <x-ui.cta-section
            icon="mail"
            align="center"
            {{-- Bound with ":" so the value is escaped once by the component; "title=..." would double-escape apostrophes. --}}
            :title="$cta->heading ?? 'Still Have Questions?'"
            :subtitle="$cta->subheading ?? 'Can\'t find the answer you\'re looking for? Our support team is here to help.'"
            cardClass="hover:border-gray-200"
            :buttons="[
                ['route' => 'contact',   'label' => $ctaMeta['contact_label'] ?? 'Contact Support', 'variant' => 'outline',  ],
                ['href' => '/help-center', 'label' => $ctaMeta['help_label'] ?? 'Visit Help Center', 'variant' => 'outline',  ],
            ]"
        />
        @endif
    </main>
</div>
@endsection