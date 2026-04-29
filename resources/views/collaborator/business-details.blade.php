<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/admin') }}">
    <title>@yield('title', 'Business Details | Institute for Living Longer - Your Journey to Wellness')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
    <script src="{{asset('js/toastr.min.js')}}"></script>
</head>
<body x-data="{ sidebarOpen: true, mobileSidebar: false }" class="bg-slate-100 antialiased">
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
    <div class="flex min-h-screen">
        <x-dashboard.sidebar.sidebar />
        <div class="flex-1 flex flex-col">
            <x-dashboard.sidebar.header />
            <!-- MAIN CONTENT -->
            <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-white">
            <div class="space-y-8 max-w-4xl ">
                <!-- Header -->
                <div>
                    <h1 class="text-3xl font-bold text-foreground mb-2 text-left">Business Details</h1>
                    <p class="text-muted-foreground">Update your business information for payments and verification</p>
                </div>
                <form action="{{ route('collaborator.business-details.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <!-- Card Header -->
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Business Information</h3>
                            <p class="text-sm text-muted-foreground">Provide your business details for verification</p>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="p-6 pt-0 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="business_name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Business Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="business_name" name="business_name" value="{{ $businessDetails->business_name ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="Enter your business name" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="business_type" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Business Type <span class="text-red-500">*</span>
                                    </label>
                                    <select id="business_type" name="business_type" 
                                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                            required>
                                        <option value="">Select Business Type</option>
                                        <option value="sole_proprietorship" {{ ($businessDetails->business_type ?? '') == 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                        <option value="partnership" {{ ($businessDetails->business_type ?? '') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                        <option value="llc" {{ ($businessDetails->business_type ?? '') == 'llc' ? 'selected' : '' }}>LLC</option>
                                        <option value="corporation" {{ ($businessDetails->business_type ?? '') == 'corporation' ? 'selected' : '' }}>Corporation</option>
                                        <option value="non_profit" {{ ($businessDetails->business_type ?? '') == 'non_profit' ? 'selected' : '' }}>Non-Profit</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="business_address" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Business Address <span class="text-red-500">*</span>
                                </label>
                                <textarea id="business_address" name="business_address" rows="3"
                                          class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                          placeholder="Enter your complete business address" required>{{ $businessDetails->business_address ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label for="business_city" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        City <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="business_city" name="business_city" value="{{ $businessDetails->business_city ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="City" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="business_state" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        State <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="business_state" name="business_state" value="{{ $businessDetails->business_state ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="State" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="business_zip_code" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        ZIP Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="business_zip_code" name="business_zip_code" value="{{ $businessDetails->business_zip_code ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="ZIP Code" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="business_country" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Country <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="business_country" name="business_country" value="{{ $businessDetails->business_country ?? 'United States' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="Country" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="business_phone" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Business Phone <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="business_phone" name="business_phone" value="{{ $businessDetails->business_phone ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="+1 (555) 123-4567" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="business_email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Business Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="business_email" name="business_email" value="{{ $businessDetails->business_email ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="business@example.com" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="business_website" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Business Website
                                    </label>
                                    <input type="url" id="business_website" name="business_website" value="{{ $businessDetails->business_website ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="https://www.example.com">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="business_description" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Business Description
                                </label>
                                <textarea id="business_description" name="business_description" rows="4"
                                          class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                          placeholder="Describe your business activities and services">{{ $businessDetails->business_description ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="tax_id" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        Tax ID
                                    </label>
                                    <input type="text" id="tax_id" name="tax_id" value="{{ $businessDetails->tax_id ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="Tax ID">
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="ein_number" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                        EIN Number
                                    </label>
                                    <input type="text" id="ein_number" name="ein_number" value="{{ $businessDetails->ein_number ?? '' }}" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                           placeholder="XX-XXXXXXX">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('collaborator.dashboard') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                            Save Business Details
                        </button>
                    </div>
                </form>
            </div>
            </main>
        </div>
    </div>
</body>
</html>
