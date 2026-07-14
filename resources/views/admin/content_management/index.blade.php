<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Content Management | Institute for Living Longer - Your Journey to Wellness')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
</head>
@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif

<div id="toast" class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"></div>
<body x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
    <x-dashboard.sidebar.header />
    <main class="flex-1 p-8  bg-white ">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center  ">
                <div class="">
                    <h1 class="text-3xl font-bold text-left mb-0">Content Management</h1>
                    <p class="text-muted-foreground text-lg">Manage all content across the public website</p>
                </div>
                <!-- <div class="flex gap-2">
                    <x-button-use href=""  label="Save Draft" variant="outline" icon="save" class=" "/>
                    <x-button-use href=""  label="Publish Changes" variant="primary" icon="globe" class=" "/>
                </div> -->
            </div>
            
            <!-- Tabs -->
            <div dir="ltr" data-orientation="horizontal" class="mt-6">
                <div role="tablist" aria-orientation="horizontal" class="grid h-10 w-full grid-cols-3 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground" tabindex="0">
                    <button role="tab" aria-selected="true" data-state="active" data-tab="content" aria-controls="content" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">Page Content</button>
                    <button role="tab" aria-selected="false" data-state="inactive" data-tab="site_settings" aria-controls="site_settings" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Site Settings</button>
                    <button role="tab" aria-selected="false" data-state="inactive" data-tab="seo_and_meta" aria-controls="seo_and_meta" type="button" class="inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">SEO & Meta</button>
                </div>
            </div>

            <!-- Page Content Start Here -->
            <div id="content" class="tab-content mt-2">
                <div class="rounded-lg border bg-card shadow-sm">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <!-- <div class="flex gap-2">
                            <x-button-use href=""  label="Save Draft" variant="outline" icon="save" class=" "/>
                            <x-button-use href=""  label="Publish Changes" variant="primary" icon="globe" class=" "/>
                        </div> -->
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Page Content Editor</h3>
                            <p class="text-sm text-muted-foreground">Edit content sections for each page of the website</p>
                        </div>

                        <!-- Content -->
                        <div class="p-6 pt-0">
                            <div class="w-full" data-orientation="vertical">
                                <div id="accordion" class="">
                                    {{-- Home Page --}}
                                    <div class="">
                                        <h3 class="accordion-item flex">
                                            <button type="button" aria-controls="radix-:rl:" aria-expanded="false" id="radix-:rk:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                                                        <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                    </svg>
                                                    <span>Home Page</span>
                                                    <!-- <span class="text-sm text-muted-foreground">(5 sections)</span> -->
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rl:" hidden role="region" aria-labelledby="radix-:rk:" class="overflow-hidden text-sm transition-all"></div>

                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                {{-- Edited section by section (hero, feature blocks, membership heading,
                                                     community, newsletter, call to action) on its own screen. --}}
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="p-6 flex items-center justify-between gap-4">
                                                        <div>
                                                            <p class="text-base font-medium">Home Page Sections</p>
                                                            <p class="text-sm text-muted-foreground mt-1">
                                                                Edit the hero, feature blocks, membership heading, community section, newsletter panel and call to action individually.
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('admin.content.page', 'home') }}" class="btn btn-primary whitespace-nowrap">Edit Sections</a>
                                                    </div>
                                                </div>

                                                <!-- About Preview -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">About Preview</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Dr. Victor Zeines has dedicated his career to helping people achieve optimal health through holistic approaches.
                                                        </textarea>
                                                    </div>
                                                </div> -->

                                                <!-- Features Section -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Features Section</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Expert guidance, community support, and personalized wellness plans.
                                                        </textarea>
                                                    </div>
                                                </div> -->

                                                <!-- Testimonials Preview -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Testimonials Preview</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                        See what our members are saying about their transformation.</textarea>
                                                    </div>
                                                </div> -->

                                                <!-- Call to Action -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Call to Action</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                        Start your journey to better health today. Join our community of wellness enthusiasts.</textarea>
                                                    </div>
                                                </div> -->
                                                <!-- Call to Action -->

                                                <!-- <div class="flex items-center justify-end space-x-2">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    {{-- about --}}
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="M12 16v-4"></path>
                                                        <path d="M12 8h.01"></path>
                                                    </svg>
                                                    <span>About Dr. Zeines</span>
                                                    <!-- <span class="text-sm text-muted-foreground">(4 sections)</span> -->
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                {{-- Edited section by section (hero, highlight cards, biography, philosophy) on its own screen. --}}
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="p-6 flex items-center justify-between gap-4">
                                                        <div>
                                                            <p class="text-base font-medium">About Us Page Sections</p>
                                                            <p class="text-sm text-muted-foreground mt-1">
                                                                Edit the hero, highlight cards, biography and wellness philosophy individually.
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('admin.content.page', 'about') }}" class="btn btn-primary whitespace-nowrap">Edit Sections</a>
                                                    </div>
                                                </div>

                                                <!-- Credentials & Awards -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Credentials & Awards</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Board Certified Holistic Practitioner, Author of 'Healthy Mouth, Healthy Body'...
                                                        </textarea>
                                                    </div>
                                                </div> -->

                                                <!--Health Philosophy -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Health Philosophy</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Dr. Zeines believes in treating the whole person, not just symptoms...
                                                        </textarea>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Collaborators Page --}}
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="users" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>Collaborators Pages</span>
                                                    <!-- <span class="text-sm text-muted-foreground">(4 sections)</span> -->
                                                </div>  
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                {{-- Edited section by section (intro, call to action) on its own screen. --}}
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="p-6 flex items-center justify-between gap-4">
                                                        <div>
                                                            <p class="text-base font-medium">Collaborators Page Sections</p>
                                                            <p class="text-sm text-muted-foreground mt-1">
                                                                Edit the intro above the collaborator list and the "join our network" call to action.
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('admin.content.page', 'collaborators') }}" class="btn btn-primary whitespace-nowrap">Edit Sections</a>
                                                    </div>
                                                </div>

                                                <!-- Credentials & Awards -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Credentials & Awards</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Board Certified Holistic Practitioner, Author of 'Healthy Mouth, Healthy Body'...
                                                        </textarea>
                                                    </div>
                                                </div> -->

                                                <!-- Health Philosophy -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Health Philosophy</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Dr. Zeines believes in treating the whole person, not just symptoms...
                                                        </textarea>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Vital Boost --}}
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="users" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>Vital Boost Page</span>
                                                    <!-- <span class="text-sm text-muted-foreground">(4 sections)</span> -->
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                {{-- The Vital Boost page is edited section by section (hero, benefits,
                                                     ingredients, routine, CTA) on its own screen. --}}
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="p-6 flex items-center justify-between gap-4">
                                                        <div>
                                                            <p class="text-base font-medium">Vital Boost Page Sections</p>
                                                            <p class="text-sm text-muted-foreground mt-1">
                                                                Edit the hero, benefit cards, ingredients, daily routine and call to action individually.
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('admin.content.vital-boost') }}" class="btn btn-primary whitespace-nowrap">Edit Sections</a>
                                                    </div>
                                                </div>

                                                <!-- Credentials & Awards -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Credentials & Awards</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Board Certified Holistic Practitioner, Author of 'Healthy Mouth, Healthy Body'...
                                                        </textarea>
                                                    </div>
                                                </div> -->

                                                <!-- Health Philosophy -->
                                                <!-- <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Health Philosophy</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Dr. Zeines believes in treating the whole person, not just symptoms...
                                                        </textarea>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Testimonial Page --}}
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="shopping-bag" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>Testimonial Page</span>
                                                    <!-- <span class="text-sm text-muted-foreground">(3 sections)</span> -->
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                {{-- Edited section by section (intro, video testimonials, call to action) on its own screen. --}}
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="p-6 flex items-center justify-between gap-4">
                                                        <div>
                                                            <p class="text-base font-medium">Testimonials Page Sections</p>
                                                            <p class="text-sm text-muted-foreground mt-1">
                                                                Edit the intro, the video testimonials heading and the closing call to action.
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('admin.content.page', 'testimonials') }}" class="btn btn-primary whitespace-nowrap">Edit Sections</a>
                                                    </div>
                                                </div>

                                                <?php /*
                                                <!-- Credentials & Awards -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Credentials & Awards</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Board Certified Holistic Practitioner, Author of 'Healthy Mouth, Healthy Body'...
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <!-- Health Philosophy -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Health Philosophy</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Dr. Zeines believes in treating the whole person, not just symptoms...
                                                        </textarea>
                                                    </div>
                                                </div>
                                                */?>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FAQs Page --}}
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="shopping-bag" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>FAQ Page</span>
                                                    <!-- <span class="text-sm text-muted-foreground">(3 sections)</span> -->
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                {{-- Edited section by section (hero, call to action) on its own screen.
                                                     The questions themselves live in the FAQs module. --}}
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="p-6 flex items-center justify-between gap-4">
                                                        <div>
                                                            <p class="text-base font-medium">FAQ Page Sections</p>
                                                            <p class="text-sm text-muted-foreground mt-1">
                                                                Edit the FAQ heading and the support call to action.
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('admin.content.page', 'faq') }}" class="btn btn-primary whitespace-nowrap">Edit Sections</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach([
                                        ['key' => 'intro_videos', 'title' => 'Intro Videos Page', 'icon' => 'play-circle',
                                         'label' => 'Intro Videos Page Sections',
                                         'hint'  => 'Edit the heading above the sample videos and the membership call to action.'],
                                        ['key' => 'shop', 'title' => 'Store Page', 'icon' => 'shopping-bag',
                                         'label' => 'Store Page Sections',
                                         'hint'  => 'Edit the store heading and the member discount tiers shown below the products.'],
                                        ['key' => 'contact', 'title' => 'Contact Page', 'icon' => 'mail',
                                         'label' => 'Contact Page Sections',
                                         'hint'  => 'Edit the hero, form card copy, collaboration note and quick answers panel.'],
                                        ['key' => 'help_center', 'title' => 'Help Centre Page', 'icon' => 'life-buoy',
                                         'label' => 'Help Centre Page Sections',
                                         'hint'  => 'Edit the hero, the getting started steps and the support section.'],
                                    ] as $sectionPage)
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-expanded="false" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="{{ $sectionPage['icon'] }}" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>{{ $sectionPage['title'] }}</span>
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="p-6 flex items-center justify-between gap-4">
                                                        <div>
                                                            <p class="text-base font-medium">{{ $sectionPage['label'] }}</p>
                                                            <p class="text-sm text-muted-foreground mt-1">{{ $sectionPage['hint'] }}</p>
                                                        </div>
                                                        <a href="{{ route('admin.content.page', $sectionPage['key']) }}" class="btn btn-primary whitespace-nowrap">Edit Sections</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    {{-- Terms and Conditions Page --}}
                                    <div>
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="shopping-bag" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>Terms and Conditions Page</span>
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                @if(isset($termsandconditionsPageContent->id))
                                                <form method="post" action="{{ route('admin.content.management.updateSiteSettings')}}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id" value="{{ $termsandconditionsPageContent->id }}">
                                                @else
                                                <form method="post" action="{{ route('admin.content.management.store')}}">
                                                    @csrf    
                                                @endif
                                                    <input type="hidden" name="form_name" value="terms_and_conditions_page">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                    <!-- Testimonial Introduction-->
                                                    <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                        <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                            <div class="flex items-center justify-between">
                                                                <!-- <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Shop Introduction</label> -->
                                                                <div class="flex items-center gap-2">
                                                                    <div class="space-y-2">
                                                                        <!-- <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="p-6 pt-0">
                                                            <textarea name="page_content" id="terms_and_conditions_page_content" rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            {{isset($termsandconditionsPageContent->page_content) ? $termsandconditionsPageContent->page_content : ''}}
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Privacy Policy Page --}}
                                    <div>
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="shopping-bag" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>Privacy Policy Page</span>
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                @if(isset($privacypolicyPageContent->id))
                                                <form method="post" action="{{ route('admin.content.management.updateSiteSettings')}}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id" value="{{ $privacypolicyPageContent->id }}">
                                                @else
                                                <form method="post" action="{{ route('admin.content.management.store')}}">
                                                    @csrf    
                                                @endif
                                                    <input type="hidden" name="form_name" value="privacy_policy_page">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                    <!-- Privacy Policy Introduction-->
                                                    <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                        <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                            <div class="flex items-center justify-between">
                                                                <!-- <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Shop Introduction</label> -->
                                                                <div class="flex items-center gap-2">
                                                                    <div class="space-y-2">
                                                                        <!-- <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="p-6 pt-0">
                                                            <textarea name="page_content" id="privacy_policy_page_content" rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            {{isset($privacypolicyPageContent->page_content) ? $privacypolicyPageContent->page_content : ''}}
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <?php /*
                                    {{-- Contact Page --}}
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="mail" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>Contact Introduction</span>
                                                    <span class="text-sm text-muted-foreground">(3 sections)</span>
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                <!-- Membership Introduction -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Shop Introduction</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Join our exclusive community and unlock access to premium wellness content.
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <!-- Credentials & Awards -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Credentials & Awards</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Board Certified Holistic Practitioner, Author of 'Healthy Mouth, Healthy Body'...
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <!-- Health Philosophy -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Health Philosophy</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">Dr. Zeines believes in treating the whole person, not just symptoms...</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FAQs Page --}}
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="circle-question-mark" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>FAQ Page</span>
                                                    <span class="text-sm text-muted-foreground">(3 sections)</span>
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                <!-- Membership Introduction -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Shop Introduction</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Join our exclusive community and unlock access to premium wellness content.
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <!-- Credentials & Awards -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Credentials & Awards</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Board Certified Holistic Practitioner, Author of 'Healthy Mouth, Healthy Body'...
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <!-- Health Philosophy -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Health Philosophy</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Dr. Zeines believes in treating the whole person, not just symptoms...
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Legal Page --}}
                                    <div class="">
                                        <h3 class="accordion-item flex border-t">
                                            <button type="button" aria-controls="radix-:rn:" aria-expanded="false" id="radix-:rm:" class="flex flex-1 items-center justify-between py-4 font-medium transition-all hover:no-underline">
                                                <div class="flex items-center gap-3">
                                                    <i data-lucide="file-text" class="h-5 w-5 text-primary" aria-hidden="true"></i>
                                                    <span>Legal Pages</span>
                                                    <span class="text-sm text-muted-foreground">(3 sections)</span>
                                                </div>
                                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m6 9 6 6 6-6"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="radix-:rn:" hidden role="region" aria-labelledby="radix-:rm:" class="overflow-hidden text-sm transition-all"></div>
                                        {{-- accordion contents  --}}
                                        <div class="pb-4 pt-0">
                                            <div class="space-y-4 pt-4">
                                                <!-- Membership Introduction -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Shop Introduction</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Join our exclusive community and unlock access to premium wellness content.
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <!-- Credentials & Awards -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Credentials & Awards</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Board Certified Holistic Practitioner, Author of 'Healthy Mouth, Healthy Body'...
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <!-- Health Philosophy -->
                                                <div class="rounded-lg bg-card text-card-foreground shadow-sm border">
                                                    <div class="flex flex-col space-y-1.5 p-6 py-3">
                                                        <div class="flex items-center justify-between">
                                                            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-base font-medium">Health Philosophy</label>
                                                            <div class="flex items-center gap-2">
                                                                <div class="space-y-2">
                                                                    <x-form.switch name="is_published" label="Active" :checked="true" on-value="published" off-value="draft" on-label="Published" off-label="Draft" class="pt-8"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-6 pt-0">
                                                        <textarea rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none">
                                                            Dr. Zeines believes in treating the whole person, not just symptoms...
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    */?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page Content End Here -->

            <!-- Site Settings Start Here -->
            <div id="site_settings" class="tab-content mt-2 hidden">
                <!-- General Settings -->
                <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="text-2xl font-semibold leading-none tracking-tight">General Settings</h3>
                        <p class="text-muted-foreground text-lg">Configure basic site information</p>
                    </div>

                    <!-- FORM -->
                    @if(isset($webSettingData->id))
                        <form method="POST" action="{{ route('admin.content.management.updateSiteSettings') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $webSettingData->id }}">
                    @else
                    <form method="POST" action="{{ route('admin.content.management.store') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5" enctype="multipart/form-data">
                        @csrf
                    @endif
                        <input type="hidden" name="form_name" value="general_settings">
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            <div class="space-y-2">
                                <x-form.input label="Tagline" type="text" name="tagline" id="tagline" value="{{ isset($webSettingData->tagline) ? $webSettingData->tagline : old('tagline') }}" placeholder="Enter Tagline*" autocomplete="off" required  />
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Footer Text" type="text" name="footer_text" id="footer_text" value="{{ isset($webSettingData->footer_text) ? $webSettingData->footer_text : old('footer_text') }}" placeholder="Enter Footer Text*" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Logo Upload -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Logo <span class="text-red-500">*</span></label>
                                <div class="border-2 border-dashed rounded-lg p-4 text-center">
                                    <input type="file" name="logo" id="logo-upload" class="hidden" accept="image/*"/>
                                    <label for="logo-upload" class="cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload h-8 w-8 mx-auto text-muted-foreground mb-2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" x2="12" y1="3" y2="15"></line>
                                        </svg>
                                        <span class="text-sm text-muted-foreground">Upload Logo</span>
                                    </label>
                                </div>
                                <!--Show uploaded logo preview-->
                                <div id="logo-preview" class="mt-4">
                                    @if(!empty($webSettingData->logo) && file_exists(public_path('uploads/'.$webSettingData->logo)))
                                        <img src="{{ asset('uploads/'.$webSettingData->logo) }}" alt="Logo Preview" class="mx-auto h-20 object-contain" id="logo-preview-img"/>
                                    @else
                                        <img src="#" alt="Logo Preview" class="mx-auto h-20 object-contain hidden" id="logo-preview-img"/>
                                    @endif
                                </div>
                            </div>

                            <!-- Favicon Upload -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Favicon <span class="text-red-500">*</span></label>
                                <div class="border-2 border-dashed rounded-lg p-4 text-center">
                                    <input type="file" name="favicon" id="favicon-upload" class="hidden" accept="image/*"/>
                                    <label for="favicon-upload" class="cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload h-8 w-8 mx-auto text-muted-foreground mb-2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" x2="12" y1="3" y2="15"></line>
                                        </svg>
                                        <span class="text-sm text-muted-foreground">Upload Favicon</span>
                                    </label>
                                </div>
                                <!--Show uploaded favicon preview-->
                                <div id="favicon-preview" class="mt-4">
                                    @if(!empty($webSettingData->favicon) && file_exists(public_path('uploads/'.$webSettingData->favicon)))
                                        <img src="{{ asset('uploads/'.$webSettingData->favicon) }}" alt="Favicon Preview" class="mx-auto h-20 object-contain" id="favicon-preview-img"/>
                                    @else
                                        <img src="#" alt="Favicon Preview" class="mx-auto h-20 object-contain hidden" id="favicon-preview-img"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Social Media Links -->
                <div class="mt-4 py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="text-2xl font-semibold leading-none tracking-tight">Social Media Link</h3>
                        <p class="text-muted-foreground text-lg">Configure your social media presence</p>
                    </div>

                    <!-- FORM -->
                    @if(isset($webSettingData->id))
                        <form method="POST" action="{{ route('admin.content.management.updateSiteSettings') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $webSettingData->id }}">
                    @else
                    <form method="POST" action="{{ route('admin.content.management.store') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5" enctype="multipart/form-data">
                        @csrf
                    @endif
                        <input type="hidden" name="form_name" value="social_media_links">
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            <div class="space-y-2">
                                <x-form.input label="Facebook" type="url" name="facebook_url" id="facebook_url" value="{{ isset($webSettingData->facebook_url) ? $webSettingData->facebook_url : '' }}" placeholder="https://facebook.com/instituteforlivinglonger" autocomplete="off" required  />
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Instagram" type="url" name="instagram_url" id="instagram_url" value="{{ isset($webSettingData->instagram_url) ? $webSettingData->instagram_url : '' }}" placeholder="https://instagram.com/instituteforlivinglonger" autocomplete="off" required  />
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="YouTube" type="url" name="youtube_url" id="youtube_url" value="{{ isset($webSettingData->youtube_url) ? $webSettingData->youtube_url : '' }}" placeholder="https://youtube.com/instituteforlivinglonger" autocomplete="off" required  />
                            </div>
                            <div class="space-y-2">
                                <x-form.input label="Twitter/X" type="url" name="twitter_url" id="twitter_url" value="{{ isset($webSettingData->twitter_url) ? $webSettingData->twitter_url : '' }}" placeholder="https://twitter.com/ifll" autocomplete="off" required  />
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Site Settings End Here -->

            <!-- SEO & Meta Start Here -->
            <div id="seo_and_meta" class="tab-content mt-2 hidden">
                <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="text-2xl font-semibold leading-none tracking-tight">SEO & Meta Settings</h3>
                        <p class="text-muted-foreground text-lg">Configure default SEO settings for better search visibility</p>
                    </div>

                    <!-- FORM -->
                    <!-- <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5" enctype="multipart/form-data"> -->
                    @if(isset($webSettingData->id))
                        <form method="POST" action="{{ route('admin.content.management.updateSiteSettings') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $webSettingData->id }}">
                    @else
                    <form method="POST" action="{{ route('admin.content.management.store') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5" enctype="multipart/form-data">
                        @csrf
                    @endif
                        <input type="hidden" name="form_name" value="seo_meta_settings">
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            <div class="space-y-2">
                                <x-form.input label="Default Meta Title" type="text" name="meta_title" id="meta_title" value="{{ isset($webSettingData->meta_title) ? $webSettingData->meta_title : '' }}" placeholder="Enter Meta Title*" autocomplete="off" required/>
                                <!-- <p class="text-muted-foreground text-lg">57/60 characters recommended</p> -->
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Default Meta Description <span class="text-red-500">*</span></label>
                            <textarea name="meta_description" id="meta_description" rows="3" placeholder="Enter Meta Description*" autocomplete="off" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>
                                {{ isset($webSettingData->meta_description) ? $webSettingData->meta_description : '' }}
                            </textarea>
                            <!-- <p class="text-muted-foreground text-lg">122/160 characters recommended</p> -->
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Default OG Image <span class="text-red-500">*</span></label>
                            <div class="border-2 border-dashed rounded-lg p-6 text-center">
                                <input type="file" name="og_image" id="og-image-upload" class="hidden" accept="image/*"/>
                                <label for="og-image-upload" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload h-8 w-8 mx-auto text-muted-foreground mb-2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" x2="12" y1="3" y2="15"></line>
                                    </svg>
                                    <span class="text-sm text-muted-foreground block">Upload OG Image</span>
                                    <span class="text-xs text-muted-foreground">Recommended: 1200x630 pixels</span>
                                </label>
                            </div>
                        </div>
                        <!--Show uploaded favicon preview-->
                        <div id="og-image-preview" class="mt-4">
                            @if(!empty($webSettingData->og_image) && file_exists(public_path('uploads/'.$webSettingData->og_image)))
                                <img src="{{ asset('uploads/'.$webSettingData->og_image) }}" alt="OG Image Preview" class="mx-auto h-20 object-contain" id="og-image-preview-img"/>
                            @else
                                <img src="#" alt="OG Image Preview" class="mx-auto h-20 object-contain hidden" id="og-image-preview-img"/>
                            @endif
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- SEO & Meta End Here -->                        
        </div>
    </main>
    @yield('content')
    </div>
</div>
<x-dashboard.sidebar.mobile-sidebar />
<script>lucide.createIcons()</script>
<style>
.accordion-content {
    transition: max-height 0.3s ease-out, opacity 0.2s ease;
    overflow: hidden;
    max-height: 0;
    opacity: 0;
}

.accordion-content.open {
    max-height: 2000px;
    opacity: 1;
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const accordionRoot = document.getElementById("accordion");
    if (!accordionRoot) return;
    const accordionItems = accordionRoot.querySelectorAll(":scope > div");
    function getItemParts(item) {
        const button = item.querySelector("h3 > button");
        const region = item.querySelector(':scope > div[role="region"]');
        const panel = region ? region.nextElementSibling : null;
        const chevron = button ? button.querySelector("svg.h-4.w-4") : null;
        return { button, region, panel, chevron };
    }

    function setAccordionState(item, expand) {
        const { button, region, panel, chevron } = getItemParts(item);
        if (!button) return;

        button.setAttribute("aria-expanded", expand ? "true" : "false");
        if (region) region.hidden = !expand;
        if (panel) panel.hidden = !expand;
        if (chevron) chevron.style.transform = expand ? "rotate(180deg)" : "rotate(0deg)";
    }

    function openOnly(targetItem) {
        accordionItems.forEach((item) => {
            setAccordionState(item, item === targetItem);
        });
    }

    function closeAll() {
        accordionItems.forEach((item) => setAccordionState(item, false));
    }

    closeAll();
    
    accordionItems.forEach((item) => {
        const { button } = getItemParts(item);
        if (!button) return;

        button.addEventListener("click", function (e) {
            e.preventDefault();
            const isExpanded =
                button.getAttribute("aria-expanded") === "true";

            if (isExpanded) {
                setAccordionState(item, false);
            } else {
                openOnly(item);
            }
        });
    });
});

const tabs = document.querySelectorAll('[role="tab"]');
const contents = document.querySelectorAll('.tab-content');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => {
            t.setAttribute('aria-selected', 'false');
            t.setAttribute('data-state', 'inactive');
            t.classList.remove('bg-background', 'shadow-sm');
        });

        contents.forEach(c => c.classList.add('hidden'));
        tab.setAttribute('aria-selected', 'true');
        tab.setAttribute('data-state', 'active');
        tab.classList.add('bg-background', 'shadow-sm');
        const activeContent = document.getElementById(tab.dataset.tab);
        if (activeContent) {
            activeContent.classList.remove('hidden');
        }
    });
});

document.getElementById('logo-upload').addEventListener('change', function(event) {
    //remove class hidden from logo preview img
    document.getElementById('logo-preview-img').classList.remove('hidden');

    const file = event.target.files[0];
    if (file) {
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert("File size must be less than 5MB.");
            event.target.value = "";
            return;
        }

        // Validate image type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert("Only JPG and PNG files are allowed.");
            event.target.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logo-preview-img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('favicon-upload').addEventListener('change', function(event) {
    //remove class hidden from favicon preview img
    document.getElementById('favicon-preview-img').classList.remove('hidden');

    const file = event.target.files[0];
    if (file) {
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert("File size must be less than 5MB.");
            event.target.value = "";
            return;
        }

        // Validate image type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert("Only JPG and PNG files are allowed.");
            event.target.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('favicon-preview-img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('og-image-upload').addEventListener('change', function(event) {
    //remove class hidden from og image preview img
    document.getElementById('og-image-preview-img').classList.remove('hidden');

    const file = event.target.files[0];
    if (file) {
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert("File size must be less than 5MB.");
            event.target.value = "";
            return;
        }

        // Validate image type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert("Only JPG and PNG files are allowed.");
            event.target.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('og-image-preview-img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    {{-- Home, Vital Boost, About, Collaborators, Testimonials, FAQ, Intro Videos, Store, Contact and
         Help Centre are edited section by section on their own screens, so they have no CKEditor here.
         Only the legal pages (terms, privacy) still use the raw HTML editor below. --}}

    CKEDITOR.replace('terms_and_conditions_page_content', {
        height: 400,
        extraAllowedContent: '*(*);*{*}',
        removePlugins: '',
        toolbar: [
            { name: 'document', items: [ 'Source', '-', 'Preview', 'Print' ] },
            { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
            { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote' ] },
            { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
            { name: 'links', items: [ 'Link', 'Unlink' ] }
        ]
    });

    CKEDITOR.replace('privacy_policy_page_content', {
        height: 400,
        extraAllowedContent: '*(*);*{*}',
        removePlugins: '',
        toolbar: [
            { name: 'document', items: [ 'Source', '-', 'Preview', 'Print' ] },
            { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
            { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote' ] },
            { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
            { name: 'links', items: [ 'Link', 'Unlink' ] }
        ]
    });

    // Update CKEditor instances before form submission
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        });
    });
});
</script>
</body>
</html>