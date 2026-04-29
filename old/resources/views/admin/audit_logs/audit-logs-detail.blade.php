<!DOCTYPE html>
{{-- <html lang="en"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

@if (session('success'))
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50"
>
    {{ session('success') }}
</div>
@endif

<div id="toast"
     class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50">
</div>
<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
     <x-dashboard.sidebar.header />


<main class="flex-1 p-8 bg-white ">
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-4">


        <x-button-use href="{{ route('admin.audit.logs') }}"   variant="outline" icon="arrow-left" class=" bg-white h-10 w-10 pl-1 pr-0"/>

        <div>
          <h1 class="text-3xl font-bold text-left mb-0">Audit Log Details</h1>
          <p class="text-muted-foreground text-lg">
           View detailed audit log information
          </p>
        </div>
      </div> 


    </div>

        <!-- Log Information -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold">Log Information</h3>
        </div>

        <div class="p-6 pt-0 space-y-4">
        <div class="grid grid-cols-2 gap-4">

            <div>
            <label class="text-sm font-medium text-muted-foreground">Log ID</label>
            <p class="font-mono text-sm">1</p>
            </div>

            <div>
            <label class="text-sm font-medium text-muted-foreground">Timestamp</label>
            <p>2024-03-15 10:30:45</p>
            </div>

            <div>
            <label class="text-sm font-medium text-muted-foreground">Action</label>
            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent bg-secondary text-secondary-foreground">
                update
            </div>
            </div>

            <div>
            <label class="text-sm font-medium text-muted-foreground">Resource Type</label>
            <p>product</p>
            </div>

            <div class="col-span-2">
            <label class="text-sm font-medium text-muted-foreground">Resource ID</label>
            <p class="font-mono text-sm">prod-456</p>
            </div>

        </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold">User Information</h3>
        </div>

        <div class="p-6 pt-0">
        <div class="grid grid-cols-2 gap-4">

            <div>
            <label class="text-sm font-medium text-muted-foreground">User ID</label>
            <p class="font-mono text-sm">user-123</p>
            </div>

            <div>
            <label class="text-sm font-medium text-muted-foreground">Email</label>
            <p>admin@example.com</p>
            </div>

            <div>
            <label class="text-sm font-medium text-muted-foreground">IP Address</label>
            <p class="font-mono text-sm">192.168.1.1</p>
            </div>

            <div class="col-span-2">
            <label class="text-sm font-medium text-muted-foreground">User Agent</label>
            <p class="text-sm break-all">
                Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36
            </p>
            </div>

        </div>
        </div>
    </div>

    <!-- Change Details -->
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold">Change Details</h3>
        </div>

        <div class="p-6 pt-0">
        <div class="space-y-4">

            <div>
            <label class="text-sm font-medium text-muted-foreground">Changed Fields</label>
            <div class="flex gap-2 mt-2">
                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-foreground">
                price
                </div>
                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-foreground">
                stock_quantity
                </div>
            </div>
            </div>

            <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="text-sm font-medium text-muted-foreground">Old Values</label>
                <pre class="mt-2 bg-muted p-3 rounded-md text-sm overflow-auto">
    {
    "price": 89.99,
    "stock_quantity": 45
    }
                </pre>
            </div>

            <div>
                <label class="text-sm font-medium text-muted-foreground">New Values</label>
                <pre class="mt-2 bg-muted p-3 rounded-md text-sm overflow-auto">
    {
    "price": 99.99,
    "stock_quantity": 50
    }
                </pre>
            </div>

            </div>
        </div>
        </div>
    </div>

  </div>
</main>




 </div>

    </main>



            @yield('content')

        </main>
    </div>
</div>


<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>

</html>
