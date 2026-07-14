<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Vital Boost Page | Institute for Living Longer')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
    <script src="{{asset('js/toastr.min.js')}}"></script>
</head>
@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition class="fixed top-5 right-5 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif
<body x-data="{ sidebarOpen: true, mobileSidebar: false }" class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
    <x-dashboard.sidebar.header />
    <main class="flex-1 p-8 bg-white">
        @php
            $hero     = $sections['hero']     ?? null;
            $benefits = $sections['benefits'] ?? null;
            $booster  = $sections['booster']  ?? null;
            $usage    = $sections['usage']    ?? null;
            $cta      = $sections['cta']      ?? null;
        @endphp

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Vital Boost Page</h1>
                <p class="text-muted-foreground text-sm mt-1">Edit each section of the public Vital Boost page.</p>
            </div>
            <a href="{{ url('/vital-boost') }}" target="_blank" class="inline-flex items-center gap-2 border-2 border-primary text-primary rounded-md px-4 py-2 text-sm font-medium hover:bg-primary hover:text-white transition">
                View Page
            </a>
        </div>

        @if($errors->any())
        <div class="mb-6 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="post" action="{{ route('admin.content.vital-boost.update') }}" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- ── Hero ───────────────────────────────────────────── --}}
            <section class="rounded-lg border bg-card shadow-sm">
                <div class="border-b p-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Hero Section</h2>
                    <select name="sections[hero][status]" class="rounded-md border border-input px-3 py-1.5 text-sm">
                        <option value="active" @selected(($hero->status ?? 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(($hero->status ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="p-6 grid gap-4">
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Badge Text</span>
                        <input type="text" name="sections[hero][meta][badge_text]" value="{{ $hero->meta['badge_text'] ?? 'Premium Wellness Formula' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Title</span>
                        <input type="text" name="sections[hero][heading]" value="{{ $hero->heading ?? 'Vital Boost' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Subtitle</span>
                        <input type="text" name="sections[hero][subheading]" value="{{ $hero->subheading ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Description</span>
                        <textarea name="sections[hero][body]" rows="3" class="rounded-md border border-input px-3 py-2 text-sm">{{ $hero->body ?? '' }}</textarea>
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Highlighted Note</span>
                        <textarea name="sections[hero][meta][note]" rows="3" class="rounded-md border border-input px-3 py-2 text-sm">{{ $hero->meta['note'] ?? '' }}</textarea>
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Button Label</span>
                        <input type="text" name="sections[hero][meta][cta_label]" value="{{ $hero->meta['cta_label'] ?? 'Order Now' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <p class="text-xs text-muted-foreground">The hero image and price come from the Vital Boost product, not from this form.</p>
                </div>
            </section>

            {{-- ── Benefits ───────────────────────────────────────── --}}
            <section class="rounded-lg border bg-card shadow-sm">
                <div class="border-b p-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">What Makes Vital Boost Different</h2>
                    <select name="sections[benefits][status]" class="rounded-md border border-input px-3 py-1.5 text-sm">
                        <option value="active" @selected(($benefits->status ?? 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(($benefits->status ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="p-6 grid gap-4">
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Heading</span>
                        <input type="text" name="sections[benefits][heading]" value="{{ $benefits->heading ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Intro Paragraph</span>
                        <textarea name="sections[benefits][body]" rows="4" class="rounded-md border border-input px-3 py-2 text-sm">{{ $benefits->body ?? '' }}</textarea>
                    </label>

                    <div class="grid gap-1.5">
                        <span class="text-sm font-medium">Benefit Cards</span>
                        <div data-repeater="benefit-cards" class="space-y-3">
                            @foreach(($benefits->items ?? []) as $i => $card)
                            <div data-row class="grid md:grid-cols-[8rem_1fr_2fr_auto] gap-2 items-start rounded-md border p-3 bg-slate-50">
                                <input type="text" name="sections[benefits][items][cards][{{ $i }}][icon]" value="{{ $card['icon'] ?? '' }}" placeholder="icon (lucide)" class="rounded-md border border-input px-3 py-2 text-sm">
                                <input type="text" name="sections[benefits][items][cards][{{ $i }}][title]" value="{{ $card['title'] ?? '' }}" placeholder="Title" class="rounded-md border border-input px-3 py-2 text-sm">
                                <textarea name="sections[benefits][items][cards][{{ $i }}][description]" rows="2" placeholder="Description" class="rounded-md border border-input px-3 py-2 text-sm">{{ $card['description'] ?? '' }}</textarea>
                                <button type="button" data-remove class="text-red-600 text-sm px-2 py-2 hover:underline">Remove</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" data-add="benefit-cards" class="justify-self-start text-sm text-primary font-medium hover:underline">+ Add Benefit Card</button>
                        <p class="text-xs text-muted-foreground">Icon names come from Lucide (e.g. heart, brain, shield, trending-up, zap, users).</p>
                    </div>
                </div>
            </section>

            {{-- ── Immune System Booster ──────────────────────────── --}}
            <section class="rounded-lg border bg-card shadow-sm">
                <div class="border-b p-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Immune System Booster &amp; Ingredients</h2>
                    <select name="sections[booster][status]" class="rounded-md border border-input px-3 py-1.5 text-sm">
                        <option value="active" @selected(($booster->status ?? 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(($booster->status ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="p-6 grid gap-4">
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Heading</span>
                        <input type="text" name="sections[booster][heading]" value="{{ $booster->heading ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Intro Paragraph</span>
                        <textarea name="sections[booster][subheading]" rows="3" class="rounded-md border border-input px-3 py-2 text-sm">{{ $booster->subheading ?? '' }}</textarea>
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Body Paragraphs</span>
                        <textarea name="sections[booster][body]" rows="8" class="rounded-md border border-input px-3 py-2 text-sm">{{ $booster->body ?? '' }}</textarea>
                        <span class="text-xs text-muted-foreground">Separate paragraphs with a blank line. Each becomes its own paragraph on the page.</span>
                    </label>

                    <div class="grid gap-1.5">
                        <span class="text-sm font-medium">FACT Cards</span>
                        <div data-repeater="facts" class="space-y-2">
                            @foreach(($booster->items['facts'] ?? []) as $i => $fact)
                            <div data-row class="flex gap-2 items-start">
                                <textarea name="sections[booster][items][facts][{{ $i }}]" rows="2" class="flex-1 rounded-md border border-input px-3 py-2 text-sm">{{ $fact }}</textarea>
                                <button type="button" data-remove class="text-red-600 text-sm px-2 py-2 hover:underline">Remove</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" data-add="facts" class="justify-self-start text-sm text-primary font-medium hover:underline">+ Add Fact</button>
                    </div>

                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Ingredients Heading</span>
                        <input type="text" name="sections[booster][meta][ingredients_heading]" value="{{ $booster->meta['ingredients_heading'] ?? 'Premium Ingredients' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>

                    <div class="grid gap-1.5">
                        <span class="text-sm font-medium">Ingredients</span>
                        <div data-repeater="ingredients" class="grid md:grid-cols-2 gap-2">
                            @foreach(($booster->items['ingredients'] ?? []) as $i => $ingredient)
                            <div data-row class="flex gap-2 items-center">
                                <input type="text" name="sections[booster][items][ingredients][{{ $i }}]" value="{{ $ingredient }}" class="flex-1 rounded-md border border-input px-3 py-2 text-sm">
                                <button type="button" data-remove class="text-red-600 text-sm px-2 hover:underline">×</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" data-add="ingredients" class="justify-self-start text-sm text-primary font-medium hover:underline">+ Add Ingredient</button>
                    </div>
                </div>
            </section>

            {{-- ── Usage ──────────────────────────────────────────── --}}
            <section class="rounded-lg border bg-card shadow-sm">
                <div class="border-b p-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Your Daily Routine</h2>
                    <select name="sections[usage][status]" class="rounded-md border border-input px-3 py-1.5 text-sm">
                        <option value="active" @selected(($usage->status ?? 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(($usage->status ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="p-6 grid gap-4">
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Heading</span>
                        <input type="text" name="sections[usage][heading]" value="{{ $usage->heading ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>

                    <div class="grid gap-1.5">
                        <span class="text-sm font-medium">Stat Cards</span>
                        <div data-repeater="stats" class="space-y-2">
                            @foreach(($usage->items['stats'] ?? []) as $i => $stat)
                            <div data-row class="grid md:grid-cols-[1fr_1fr_1fr_auto] gap-2 items-center">
                                <input type="text" name="sections[usage][items][stats][{{ $i }}][value]" value="{{ $stat['value'] ?? '' }}" placeholder="Value (e.g. 1)" class="rounded-md border border-input px-3 py-2 text-sm">
                                <input type="text" name="sections[usage][items][stats][{{ $i }}][label]" value="{{ $stat['label'] ?? '' }}" placeholder="Label (e.g. Packet)" class="rounded-md border border-input px-3 py-2 text-sm">
                                <input type="text" name="sections[usage][items][stats][{{ $i }}][sub]" value="{{ $stat['sub'] ?? '' }}" placeholder="Sub (e.g. daily)" class="rounded-md border border-input px-3 py-2 text-sm">
                                <button type="button" data-remove class="text-red-600 text-sm px-2 hover:underline">Remove</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" data-add="stats" class="justify-self-start text-sm text-primary font-medium hover:underline">+ Add Stat</button>
                    </div>

                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Steps Heading</span>
                        <input type="text" name="sections[usage][meta][steps_heading]" value="{{ $usage->meta['steps_heading'] ?? 'Simple Steps to Follow:' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>

                    <div class="grid gap-1.5">
                        <span class="text-sm font-medium">Steps</span>
                        <div data-repeater="steps" class="space-y-2">
                            @foreach(($usage->items['steps'] ?? []) as $i => $step)
                            <div data-row class="flex gap-2 items-center">
                                <input type="text" name="sections[usage][items][steps][{{ $i }}]" value="{{ $step }}" class="flex-1 rounded-md border border-input px-3 py-2 text-sm">
                                <button type="button" data-remove class="text-red-600 text-sm px-2 hover:underline">×</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" data-add="steps" class="justify-self-start text-sm text-primary font-medium hover:underline">+ Add Step</button>
                    </div>

                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Powder Heading</span>
                        <input type="text" name="sections[usage][meta][powder_heading]" value="{{ $usage->meta['powder_heading'] ?? 'Why Powder Beats Pills?' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Powder Intro</span>
                        <textarea name="sections[usage][meta][powder_intro]" rows="2" class="rounded-md border border-input px-3 py-2 text-sm">{{ $usage->meta['powder_intro'] ?? '' }}</textarea>
                    </label>

                    <div class="grid gap-1.5">
                        <span class="text-sm font-medium">Powder Benefits</span>
                        <div data-repeater="powder_points" class="space-y-2">
                            @foreach(($usage->items['powder_points'] ?? []) as $i => $point)
                            <div data-row class="flex gap-2 items-center">
                                <input type="text" name="sections[usage][items][powder_points][{{ $i }}]" value="{{ $point }}" class="flex-1 rounded-md border border-input px-3 py-2 text-sm">
                                <button type="button" data-remove class="text-red-600 text-sm px-2 hover:underline">×</button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" data-add="powder_points" class="justify-self-start text-sm text-primary font-medium hover:underline">+ Add Point</button>
                    </div>
                </div>
            </section>

            {{-- ── Call To Action ─────────────────────────────────── --}}
            <section class="rounded-lg border bg-card shadow-sm">
                <div class="border-b p-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Call To Action</h2>
                    <select name="sections[cta][status]" class="rounded-md border border-input px-3 py-1.5 text-sm">
                        <option value="active" @selected(($cta->status ?? 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(($cta->status ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="p-6 grid md:grid-cols-2 gap-4">
                    <label class="grid gap-1.5 md:col-span-2">
                        <span class="text-sm font-medium">Heading</span>
                        <input type="text" name="sections[cta][heading]" value="{{ $cta->heading ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5 md:col-span-2">
                        <span class="text-sm font-medium">Subtitle</span>
                        <input type="text" name="sections[cta][subheading]" value="{{ $cta->subheading ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">One-time Price</span>
                        <input type="text" name="sections[cta][meta][price_one_time]" value="{{ $cta->meta['price_one_time'] ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">One-time Label</span>
                        <input type="text" name="sections[cta][meta][price_one_time_label]" value="{{ $cta->meta['price_one_time_label'] ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Subscription Price</span>
                        <input type="text" name="sections[cta][meta][price_subscription]" value="{{ $cta->meta['price_subscription'] ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Subscription Label</span>
                        <input type="text" name="sections[cta][meta][price_subscription_label]" value="{{ $cta->meta['price_subscription_label'] ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Button Label</span>
                        <input type="text" name="sections[cta][meta][cta_label]" value="{{ $cta->meta['cta_label'] ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1.5">
                        <span class="text-sm font-medium">Footer Note</span>
                        <input type="text" name="sections[cta][meta][footer_note]" value="{{ $cta->meta['footer_note'] ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                    </label>
                </div>
            </section>

            <div class="flex items-center justify-end gap-3 sticky bottom-0 bg-white/95 backdrop-blur py-4 border-t">
                <a href="{{ route('admin.content.management') }}" class="px-4 py-2 text-sm rounded-md border">Back to Content Management</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </main>
    </div>
</div>
<x-dashboard.sidebar.mobile-sidebar />

<script>
// Repeater rows. Each new row's field names are numbered from a counter that starts
// past the rows already on the page, so existing rows are never overwritten.
const repeaterTemplates = {
    'benefit-cards': i => `
        <div data-row class="grid md:grid-cols-[8rem_1fr_2fr_auto] gap-2 items-start rounded-md border p-3 bg-slate-50">
            <input type="text" name="sections[benefits][items][cards][${i}][icon]" placeholder="icon (lucide)" class="rounded-md border border-input px-3 py-2 text-sm">
            <input type="text" name="sections[benefits][items][cards][${i}][title]" placeholder="Title" class="rounded-md border border-input px-3 py-2 text-sm">
            <textarea name="sections[benefits][items][cards][${i}][description]" rows="2" placeholder="Description" class="rounded-md border border-input px-3 py-2 text-sm"></textarea>
            <button type="button" data-remove class="text-red-600 text-sm px-2 py-2 hover:underline">Remove</button>
        </div>`,
    'facts': i => `
        <div data-row class="flex gap-2 items-start">
            <textarea name="sections[booster][items][facts][${i}]" rows="2" class="flex-1 rounded-md border border-input px-3 py-2 text-sm"></textarea>
            <button type="button" data-remove class="text-red-600 text-sm px-2 py-2 hover:underline">Remove</button>
        </div>`,
    'ingredients': i => `
        <div data-row class="flex gap-2 items-center">
            <input type="text" name="sections[booster][items][ingredients][${i}]" class="flex-1 rounded-md border border-input px-3 py-2 text-sm">
            <button type="button" data-remove class="text-red-600 text-sm px-2 hover:underline">×</button>
        </div>`,
    'stats': i => `
        <div data-row class="grid md:grid-cols-[1fr_1fr_1fr_auto] gap-2 items-center">
            <input type="text" name="sections[usage][items][stats][${i}][value]" placeholder="Value" class="rounded-md border border-input px-3 py-2 text-sm">
            <input type="text" name="sections[usage][items][stats][${i}][label]" placeholder="Label" class="rounded-md border border-input px-3 py-2 text-sm">
            <input type="text" name="sections[usage][items][stats][${i}][sub]" placeholder="Sub" class="rounded-md border border-input px-3 py-2 text-sm">
            <button type="button" data-remove class="text-red-600 text-sm px-2 hover:underline">Remove</button>
        </div>`,
    'steps': i => `
        <div data-row class="flex gap-2 items-center">
            <input type="text" name="sections[usage][items][steps][${i}]" class="flex-1 rounded-md border border-input px-3 py-2 text-sm">
            <button type="button" data-remove class="text-red-600 text-sm px-2 hover:underline">×</button>
        </div>`,
    'powder_points': i => `
        <div data-row class="flex gap-2 items-center">
            <input type="text" name="sections[usage][items][powder_points][${i}]" class="flex-1 rounded-md border border-input px-3 py-2 text-sm">
            <button type="button" data-remove class="text-red-600 text-sm px-2 hover:underline">×</button>
        </div>`,
};

const repeaterCounters = {};
document.querySelectorAll('[data-repeater]').forEach(container => {
    repeaterCounters[container.dataset.repeater] = container.querySelectorAll('[data-row]').length;
});

document.querySelectorAll('[data-add]').forEach(btn => {
    btn.addEventListener('click', () => {
        const key = btn.dataset.add;
        const container = document.querySelector(`[data-repeater="${key}"]`);
        const index = repeaterCounters[key]++;
        container.insertAdjacentHTML('beforeend', repeaterTemplates[key](index));
    });
});

// Delegated so rows added after page load are removable too.
document.addEventListener('click', e => {
    if (e.target.matches('[data-remove]')) {
        e.target.closest('[data-row]').remove();
    }
});

lucide.createIcons();
</script>
</body>
</html>
