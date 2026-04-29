<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif
<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
        <x-dashboard.sidebar.header />
        @if(auth()->user()->isAdmin())
            <div class="space-y-6 flex-1 p-8 bg-gradient-subtle">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 text-left">Dashboard</h1>
                    <p class="text-gray-500">Overview of your platform</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Total Users --}}
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <i data-lucide="users" class="lucide-users text-blue-500"></i>
                        </div>
                        <p class="text-2xl font-bold text-black">{{$totalUsers}}</p>
                    </div>

                    {{-- Collaborators --}}
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-500">Collaborators</p>
                            <i data-lucide="user-check" class="lucide-user-check text-green-500"></i>
                        </div>
                        <p class="text-2xl font-bold text-black">{{$collaborators}}</p>
                    </div>

                    {{-- Products --}}
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-500">Products</p>
                            <i data-lucide="package" class="lucide-package text-purple-500"></i>
                        </div>
                        <p class="text-2xl font-bold text-black">{{$products}}</p>
                    </div>

                    {{-- Orders --}}
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-500">Orders</p>
                            <i data-lucide="shopping-cart" class="lucide-shopping-cart text-orange-500"></i>
                        </div>
                        <p class="text-2xl font-bold text-black">{{$orders}}</p>
                    </div>

                    {{-- Courses --}}
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-500">Courses</p>
                            <i data-lucide="graduation-cap" class="lucide-graduation-cap text-indigo-500"></i>
                        </div>
                        <p class="text-2xl font-bold text-black">{{$courses}}</p>
                    </div>

                    {{-- Revenue --}}
                    <div class="bg-white rounded-xl shadow p-5">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <i data-lucide="trending-up" class="lucide-trending-up text-emerald-500"></i>
                        </div>
                        <p class="text-2xl font-bold text-black">${{ number_format($adminRevenue, 2) }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold mb-2">Quick Actions</h2>
                    <p class="text-gray-500">
                        Use the sidebar to navigate to different sections of the admin portal.
                    </p>
                </div>
            </div>
        @endif

        @if(auth()->user()->isCollaborator())
            <div class="space-y-6 flex-1 p-8 bg-gradient-subtle">
                <div class="space-y-8">
                    <div>
                        <h1 class="text-left text-3xl font-bold text-foreground">Dashboard</h1>
                        <p class="mt-2 text-lg text-muted-foreground">Welcome back! Here's an overview of your performance.</p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-4 ">
                            <div class="flex items-center justify-between ">
                                <h3 class="text-sm font-medium tracking-tight">Total Revenue</h3>
                                <i data-lucide="dollar-sign" class="h-4 w-4 text-muted-foreground" aria-hidden="true"></i>
                            </div>
                            <div class="">
                                <div class="text-[2.2rem] font-bold leading-none">$0.00</div>
                                <p class="mt-2 text-sm text-muted-foreground">
                                    <i data-lucide="trending-up" class="mr-1 inline h-3 w-3" aria-hidden="true"></i>+12.5%
                                </p>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-4 ">
                            <div class="flex items-center justify-between ">
                                <h3 class="text-sm font-medium tracking-tight">Products</h3>
                                <i data-lucide="package" class="h-4 w-4 text-muted-foreground" aria-hidden="true"></i>
                            </div>
                            <div class="">
                                <div class="text-[2.2rem] font-bold leading-none">{{$products}}</div>
                                <p class="mt-2 text-sm text-muted-foreground">
                                    <i data-lucide="trending-up" class="mr-1 inline h-3 w-3" aria-hidden="true"></i>+2 new
                                </p>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-4 ">
                            <div class="flex items-center justify-between ">
                                <h3 class="text-sm font-medium tracking-tight">Total Orders</h3>
                                <i data-lucide="shopping-bag" class="h-4 w-4 text-muted-foreground" aria-hidden="true"></i>
                            </div>
                            <div class="">
                                <div class="text-[2.2rem] font-bold leading-none">{{$orders}}</div>
                                <p class="mt-2 text-sm text-muted-foreground">
                                    <i data-lucide="trending-up" class="mr-1 inline h-3 w-3" aria-hidden="true"></i>+8 this week
                                </p>
                            </div>
                        </div>
                        
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-4 ">
                            <div class="flex items-center justify-between ">
                                <h3 class="text-sm font-medium tracking-tight">Video Views</h3>
                                <i data-lucide="play" class="h-4 w-4 text-muted-foreground" aria-hidden="true"></i>
                            </div>
                            <div class="">
                                <div class="text-[2.2rem] font-bold leading-none">0</div>
                                <p class="mt-2 text-sm text-muted-foreground">
                                    <i data-lucide="trending-up" class="mr-1 inline h-3 w-3" aria-hidden="true"></i>+143 today
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm py-4 px-6">
                            <div class=" ">
                                <h2 class="text-[2rem] font-semibold leading-none tracking-tight text-left">Recent Activity</h2>
                            </div>
                            <div class=" ">
                                <p class=" text-muted-foreground">Your recent sales and course views will appear here.</p>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm py-4 px-6">
                            <div class="   ">
                                <h2 class="text-left text-[2rem] font-semibold leading-none tracking-tight">Quick Actions</h2>
                            </div>
                            <div class="  ">
                                <ul class="list-disc space-y-2 pl-5  text-muted-foreground">
                                    <li>Add new products to your store</li>
                                    <li>Create a new course</li>
                                    <li>Update your profile information
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </div>
</div>
<x-dashboard.sidebar.mobile-sidebar />
<script>lucide.createIcons()</script>
</body>
</html>