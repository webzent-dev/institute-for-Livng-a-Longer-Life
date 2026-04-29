<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/admin') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Setting | Institute for Living Longer - Your Journey to Wellness')</title>
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
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif

    <div id="toast" class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50"></div>
    <body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
        <div class="flex min-h-screen">
            <x-dashboard.sidebar.sidebar />
            <div class="flex-1 flex flex-col">
                <x-dashboard.sidebar.header />
                <main class="flex-1 p-8  bg-white ">
                    <div class="space-y-6">
                        <!-- Header -->
                        <div class="flex justify-between items-center ">
                            <div class="">
                                <h1 class="text-3xl font-bold text-left mb-0">Settings</h1>
                                <p class="text-muted-foreground text-lg">Manage site configuration and preferences</p>
                            </div>
                        </div>
                        <!-- General Settings -->
                        <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">General Settings</h3>
                            </div>
                            @if(isset($siteSettingData->id))
                                <form method="POST" action="{{ route('admin.settings.updategeneralsettings') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $siteSettingData->id }}">
                            @else
                                <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                                    @csrf
                            @endif
                                <input type="hidden" name="form_name" value="general_setting">
                                <x-form.input label="Site Name" type="text" name="site_name" placeholder="Enter Site Name*" value="{{isset($siteSettingData->site_name) ? $siteSettingData->site_name : old('site_name')}}" autocomplete="off" required />
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Site Description <span class="required" style="color: red;">*</span></label>
                                    <textarea name="site_description" rows="3" placeholder="Enter site description*" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>{{ isset($siteSettingData->site_description) ? $siteSettingData->site_description : old('site_description') }}</textarea>
                                </div>
                                <x-form.input label="Contact Email" type="email" name="contact_email" placeholder="admin@example.com" value="{{ isset($siteSettingData->contact_email) ? $siteSettingData->contact_email : old('contact_email') }}" autocomplete="off" required />
                                <div class="w-1/6 mt-3">
                                    <x-button-use label="Save Changes" type="submit" variant="primary" class="w-full"/>
                                </div>
                            </form>
                        </div>

                        <!-- Email Settings-->
                        <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Email Settings</h3>
                            </div>
                            @if(isset($siteSettingData->id))
                                <form method="POST" action="{{ route('admin.settings.updategeneralsettings') }}" class="space-y-3 overflow-y-auto scrollbar-custom  scroll-smooth px-5">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $siteSettingData->id }}">
                            @else
                                <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom  scroll-smooth px-5">
                                    @csrf
                            @endif

                                <input type="hidden" name="form_name" value="email_setting">
                                <x-form.input label="SMTP Host" type="text" name="smtp_host" value="{{ isset($siteSettingData->smtp_host) ? $siteSettingData->smtp_host : old('smtp_host') }}" placeholder="smtp.example.com" autocomplete="off" required />
                                <x-form.input label="SMTP Port" type="text" name="smtp_port" value="{{ isset($siteSettingData->smtp_port) ? $siteSettingData->smtp_port : old('smtp_port') }}" placeholder="587" autocomplete="off" required />
                                <div class="w-1/6 mt-3">
                                    <x-button-use label="Save Changes" type="submit" variant="primary"  class="w-full"/>
                                </div>
                            </form>
                        </div>

                        <!-- Stripe Settings-->
                        <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Stripe Settings</h3>
                            </div>
                            @if(isset($siteSettingData->id))
                                <form method="POST" action="{{ route('admin.settings.updategeneralsettings') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $siteSettingData->id }}">
                            @else
                                <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                                    @csrf
                            @endif
                                <input type="hidden" name="form_name" value="stripe_setting">
                                <x-form.input label="Stripe Sandbox Key" type="text" name="stripe_sandbox_key" placeholder="Enter Stripe Sandbox Key*" value="{{isset($siteSettingData->stripe_sandbox_key) ? $siteSettingData->stripe_sandbox_key : old('stripe_sandbox_key')}}" autocomplete="off" required />
                                <x-form.input label="Stripe Sandbox Secret" type="text" name="stripe_sandbox_secret" placeholder="Enter Stripe Sandbox Secret*" value="{{isset($siteSettingData->stripe_sandbox_secret) ? $siteSettingData->stripe_sandbox_secret : old('stripe_sandbox_secret')}}" autocomplete="off" required />
                                <x-form.input label="Stripe Production Key" type="text" name="stripe_production_key" placeholder="Enter Stripe Production Key*" value="{{isset($siteSettingData->stripe_production_key) ? $siteSettingData->stripe_production_key : old('stripe_production_key')}}" autocomplete="off" required />
                                <x-form.input label="Stripe Production Secret" type="text" name="stripe_production_secret" placeholder="Enter Stripe Production Secret*" value="{{isset($siteSettingData->stripe_production_secret) ? $siteSettingData->stripe_production_secret : old('stripe_production_secret')}}" autocomplete="off" required />
                                <x-form.select name="stripe_mode" label="Stripe Mode" :options="[
                                    ['value' => 'sandbox', 'label' => 'Sandbox'],
                                    ['value' => 'production', 'label' => 'Production'],
                                ]" :selected="isset($siteSettingData->stripe_mode) ? $siteSettingData->stripe_mode : old('stripe_mode')" required />
                                <div class="w-1/6 mt-3">
                                    <x-button-use label="Save Changes" type="submit" variant="primary" class="w-full"/>
                                </div>
                            </form>
                        </div>

                        <!-- Zoom Account Settings-->
                        <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Zoom Account Settings</h3>
                            </div>
                            @if(isset($siteSettingData->id))
                                <form method="POST" action="{{ route('admin.settings.updategeneralsettings') }}" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $siteSettingData->id }}">
                            @else
                                <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                                    @csrf
                            @endif
                                <input type="hidden" name="form_name" value="zoom_setting">
                                <x-form.input label="Zoom Client ID" type="text" name="zoom_client_id" placeholder="Enter Zoom Client ID*" value="{{isset($siteSettingData->zoom_client_id) ? $siteSettingData->zoom_client_id : old('zoom_client_id')}}" autocomplete="off" required />
                                <x-form.input label="Zoom Client Secret" type="text" name="zoom_client_secret" placeholder="Enter Zoom Client Secret*" value="{{isset($siteSettingData->zoom_client_secret) ? $siteSettingData->zoom_client_secret : old('zoom_client_secret')}}" autocomplete="off" required />
                                <x-form.input label="Zoom Account ID" type="text" name="zoom_account_id" placeholder="Enter Zoom Account ID*" value="{{isset($siteSettingData->zoom_account_id) ? $siteSettingData->zoom_account_id : old('zoom_account_id')}}" autocomplete="off" required />
                                <x-form.input label="Zoom API URL" type="text" name="zoom_api_url" placeholder="Enter Zoom API URL*" value="{{isset($siteSettingData->zoom_api_url) ? $siteSettingData->zoom_api_url : old('zoom_api_url')}}" autocomplete="off" required />
                                <div class="w-1/6 mt-3">
                                    <x-button-use label="Save Changes" type="submit" variant="primary" class="w-full"/>
                                </div>
                            </form>
                        </div>

                        <!-- Security Settings-->
                        <div class="py-4 rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Security Settings</h3>
                            </div>
                            @if(isset($siteSettingData->id))
                            <form method="POST" action="{{ route('admin.settings.updategeneralsettings') }}" class="space-y-3 overflow-y-auto scrollbar-custom  scroll-smooth px-5">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $siteSettingData->id }}">
                            @else
                            <form method="POST" class="space-y-3 overflow-y-auto scrollbar-custom scroll-smooth px-5">
                                @csrf
                            @endif
                                <x-form.input label="Session Timeout (minutes)" type="number" name="session_timeout" value="{{ isset($siteSettingData->session_timeout) ? $siteSettingData->session_timeout : old('session_timeout') }}" placeholder="60" autocomplete="off" required />
                                <div class=" w-1/6 mt-3">
                                    <x-button-use label="Save Changes" type="submit" variant="primary"  class="w-full"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
                @yield('content')
            </div>
        </div>
        <x-dashboard.sidebar.mobile-sidebar />
        <script>lucide.createIcons()</script>
        <script>
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
        </script>
    </body>
</html>