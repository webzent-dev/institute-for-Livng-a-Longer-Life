<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $schema['label'] . ' Page | Institute for Living Longer')</title>
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

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">{{ $schema['label'] }} Page</h1>
                <p class="text-muted-foreground text-sm mt-1">{{ $schema['description'] ?? 'Edit each section of this public page.' }}</p>
            </div>
            <a href="{{ url($schema['url']) }}" target="_blank" class="inline-flex items-center gap-2 border-2 border-primary text-primary rounded-md px-4 py-2 text-sm font-medium hover:bg-primary hover:text-white transition">
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

        <form method="post" action="{{ route('admin.content.page.update', $page) }}" class="space-y-8">
            @csrf
            @method('PUT')

            @foreach($schema['sections'] as $sectionKey => $section)
                @php $row = $sections[$sectionKey] ?? null; @endphp
                <section class="rounded-lg border bg-card shadow-sm">
                    <div class="border-b p-6 py-4 flex items-center justify-between">
                        <h2 class="text-xl font-semibold">{{ $section['label'] }}</h2>
                        <select name="sections[{{ $sectionKey }}][status]" class="rounded-md border border-input px-3 py-1.5 text-sm">
                            <option value="active" @selected(($row->status ?? 'active') === 'active')>Active</option>
                            <option value="inactive" @selected(($row->status ?? '') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="p-6 grid gap-4">

                        {{-- Column-backed fields: heading / subheading / body --}}
                        @foreach(($section['fields'] ?? []) as $fieldKey => $field)
                            <label class="grid gap-1.5">
                                <span class="text-sm font-medium">{{ $field['label'] }}</span>
                                @if(($field['type'] ?? 'text') === 'textarea')
                                    <textarea name="sections[{{ $sectionKey }}][{{ $fieldKey }}]" rows="{{ $field['rows'] ?? 3 }}" class="rounded-md border border-input px-3 py-2 text-sm">{{ $row->{$fieldKey} ?? '' }}</textarea>
                                @else
                                    <input type="text" name="sections[{{ $sectionKey }}][{{ $fieldKey }}]" value="{{ $row->{$fieldKey} ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                                @endif
                                @if(!empty($field['help']))
                                    <span class="text-xs text-muted-foreground">{{ $field['help'] }}</span>
                                @endif
                            </label>
                        @endforeach

                        {{-- Repeatable lists --}}
                        @foreach(($section['items'] ?? []) as $listKey => $list)
                            @php
                                $repeaterId = $sectionKey . '__' . $listKey;
                                $rows       = $row->items[$listKey] ?? [];
                                $columns    = empty($list['fields'])
                                    ? '1fr auto'
                                    : collect($list['fields'])->map(fn ($f) => $f['width'] ?? '1fr')->implode(' ') . ' auto';
                            @endphp
                            <div class="grid gap-1.5">
                                <span class="text-sm font-medium">{{ $list['label'] }}</span>
                                <div data-repeater="{{ $repeaterId }}" class="space-y-2">
                                    @foreach($rows as $i => $item)
                                        <div data-row class="grid gap-2 items-start rounded-md border p-3 bg-slate-50" style="grid-template-columns: {{ $columns }};">
                                            @if(empty($list['fields']))
                                                <input type="text" name="sections[{{ $sectionKey }}][items][{{ $listKey }}][{{ $i }}]" value="{{ $item }}" class="rounded-md border border-input px-3 py-2 text-sm">
                                            @else
                                                @foreach($list['fields'] as $fieldKey => $field)
                                                    @if(($field['type'] ?? 'text') === 'textarea')
                                                        <textarea name="sections[{{ $sectionKey }}][items][{{ $listKey }}][{{ $i }}][{{ $fieldKey }}]" rows="{{ $field['rows'] ?? 2 }}" placeholder="{{ $field['label'] }}" class="rounded-md border border-input px-3 py-2 text-sm">{{ $item[$fieldKey] ?? '' }}</textarea>
                                                    @else
                                                        <input type="text" name="sections[{{ $sectionKey }}][items][{{ $listKey }}][{{ $i }}][{{ $fieldKey }}]" value="{{ $item[$fieldKey] ?? '' }}" placeholder="{{ $field['label'] }}" class="rounded-md border border-input px-3 py-2 text-sm">
                                                    @endif
                                                @endforeach
                                            @endif
                                            <button type="button" data-remove class="text-red-600 text-sm px-2 py-2 hover:underline">Remove</button>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Blueprint for rows added after page load. __INDEX__ is replaced with a counter
                                     that starts past the rows already rendered, so existing rows are never overwritten. --}}
                                <template data-template="{{ $repeaterId }}">
                                    <div data-row class="grid gap-2 items-start rounded-md border p-3 bg-slate-50" style="grid-template-columns: {{ $columns }};">
                                        @if(empty($list['fields']))
                                            <input type="text" name="sections[{{ $sectionKey }}][items][{{ $listKey }}][__INDEX__]" class="rounded-md border border-input px-3 py-2 text-sm">
                                        @else
                                            @foreach($list['fields'] as $fieldKey => $field)
                                                @if(($field['type'] ?? 'text') === 'textarea')
                                                    <textarea name="sections[{{ $sectionKey }}][items][{{ $listKey }}][__INDEX__][{{ $fieldKey }}]" rows="{{ $field['rows'] ?? 2 }}" placeholder="{{ $field['label'] }}" class="rounded-md border border-input px-3 py-2 text-sm"></textarea>
                                                @else
                                                    <input type="text" name="sections[{{ $sectionKey }}][items][{{ $listKey }}][__INDEX__][{{ $fieldKey }}]" placeholder="{{ $field['label'] }}" class="rounded-md border border-input px-3 py-2 text-sm">
                                                @endif
                                            @endforeach
                                        @endif
                                        <button type="button" data-remove class="text-red-600 text-sm px-2 py-2 hover:underline">Remove</button>
                                    </div>
                                </template>

                                <button type="button" data-add="{{ $repeaterId }}" class="justify-self-start text-sm text-primary font-medium hover:underline">{{ $list['add_label'] ?? '+ Add Item' }}</button>
                                @if(!empty($list['help']))
                                    <p class="text-xs text-muted-foreground">{{ $list['help'] }}</p>
                                @endif
                            </div>
                        @endforeach

                        {{-- Free-form meta values --}}
                        @foreach(($section['meta'] ?? []) as $metaKey => $field)
                            <label class="grid gap-1.5">
                                <span class="text-sm font-medium">{{ $field['label'] }}</span>
                                @if(($field['type'] ?? 'text') === 'textarea')
                                    <textarea name="sections[{{ $sectionKey }}][meta][{{ $metaKey }}]" rows="{{ $field['rows'] ?? 3 }}" class="rounded-md border border-input px-3 py-2 text-sm">{{ $row->meta[$metaKey] ?? '' }}</textarea>
                                @else
                                    <input type="text" name="sections[{{ $sectionKey }}][meta][{{ $metaKey }}]" value="{{ $row->meta[$metaKey] ?? '' }}" class="rounded-md border border-input px-3 py-2 text-sm">
                                @endif
                                @if(!empty($field['help']))
                                    <span class="text-xs text-muted-foreground">{{ $field['help'] }}</span>
                                @endif
                            </label>
                        @endforeach

                        @if(!empty($section['note']))
                            <p class="text-xs text-muted-foreground">{{ $section['note'] }}</p>
                        @endif
                    </div>
                </section>
            @endforeach

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
const repeaterCounters = {};
document.querySelectorAll('[data-repeater]').forEach(container => {
    repeaterCounters[container.dataset.repeater] = container.querySelectorAll('[data-row]').length;
});

document.querySelectorAll('[data-add]').forEach(btn => {
    btn.addEventListener('click', () => {
        const key = btn.dataset.add;
        const container = document.querySelector(`[data-repeater="${key}"]`);
        const template = document.querySelector(`template[data-template="${key}"]`);
        const index = repeaterCounters[key]++;
        container.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', index));
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
