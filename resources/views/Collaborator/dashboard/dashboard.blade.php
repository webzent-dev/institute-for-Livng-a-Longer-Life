<!DOCTYPE html>
{{-- <html lang="en"> --}}
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

<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">


<div class="flex min-h-screen">

   
    <x-dashboard.sidebar.sidebar />

    <div class="flex-1 flex flex-col">

       
        <x-dashboard.sidebar.header />

        <main class="flex-1 p-4 md:p-6 overflow-y-auto">

               @if (request()->is('admin/dashboard')) 
   
            
                            <!-- Main Content -->
                        <main class="flex-1 p-4 md:p-6 overflow-y-auto scrollbar-custom ">
                            <!-- Welcome Card -->
                           
                            <div class="bg-white/100 rounded-2xl p-6   mb-6 shadow-md text-slate-800">
                                <div class="flex flex-col md:flex-row md:items-center justify-between">
                                    <div>
                                        <h2 class="text-2xl font-semibold mb-2 text-left">Welcome back, {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}!</h2>
                                        <p class=" mb-4 max-w-2xl">Your team's performance is up by 24% this month. Keep up the great work!</p>
                                        <button class="bg-white text-green-600 font-medium px-5 py-2.5 rounded-xl hover:bg-gray-100 transition-all shadow-md">
                                            View Reports
                                        </button>
                                    </div>
                                    <div class="mt-6 md:mt-0">
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-green-100 hover:bg-green-200 flex items-center justify-center mx-auto">
                                            <i data-lucide="trending-up" class="w-10 h-10 text-green-500"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-10">
                                 <!-- Cards Section -->
                            <x-ui.stats :items="[
     ['label' => 'Total Users', 'value' => 127, 'icon' => 'users','icon_color' => 'bg-green-50 text-green-600', 'percent_change' => '+8.5%', 'percent_change_bg' => 'bg-green-50 text-green-600'],
    ['label' => 'collaborators', 'value' => '8', 'icon' => 'credit-card','iconbg' => 'bg-amber-50', 'icon_color' => 'bg-amber-50 text-amber-600', 'percent_change' => '+8.5%', 'percent_change_bg' => 'bg-amber-50 text-amber-600'],
    ['label' => 'Orders', 'value' => 340, 'icon' => 'bar-chart-3', 'iconbg' => 'bg-blue-50', 'icon_color' => 'bg-blue-50 text-blue-600', 'percent_change' => '+8.5%', 'percent_change_bg' => 'bg-green-50 text-blue-600'],
    ['label' => 'Visits', 'value' => '45k', 'icon' => 'eye',  'iconbg' => 	'bg-yellow-50', 	'icon_color' => 	'text-yellow-600', 	'percent_change' => '+8.5%', 	'percent_change_bg' => 	'text-yellow-600'],
]" />
                            </div>
                         

                            
                           
                            <!-- Stats Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                                <!-- Stat Card 1 -->
                                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="p-3 rounded-xl bg-blue-50 text-green-600">
                                            <i data-lucide="users" class="w-6 h-6"></i>
                                        </div>
                                        <span class="text-sm text-green-600 font-medium bg-green-50 px-2.5 py-1 rounded-full">+12.5%</span>
                                    </div>
                                    <h3 class="text-2xl font-semibold text-slate-800 mb-1">4,823</h3>
                                    <p class="text-slate-500 text-sm">Total Users</p>
                                </div>
                                
                                <!-- Stat Card 2 -->
                                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600">
                                            <i data-lucide="credit-card" class="w-6 h-6"></i>
                                        </div>
                                        <span class="text-sm text-green-600 font-medium bg-green-50 px-2.5 py-1 rounded-full">+8.2%</span>
                                    </div>
                                    <h3 class="text-2xl font-semibold text-slate-800 mb-1">$42,580</h3>
                                    <p class="text-slate-500 text-sm">Monthly Revenue</p>
                                </div>
                                
                                <!-- Stat Card 3 -->
                                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="p-3 rounded-xl bg-amber-50 text-amber-600">
                                            <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                                        </div>
                                        <span class="text-sm text-red-600 font-medium bg-red-50 px-2.5 py-1 rounded-full">-3.1%</span>
                                    </div>
                                    <h3 class="text-2xl font-semibold text-slate-800 mb-1">1,247</h3>
                                    <p class="text-slate-500 text-sm">Sessions</p>
                                </div>
                                
                                <!-- Stat Card 4 -->
                                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="p-3 rounded-xl bg-violet-50 text-violet-600">
                                            <i data-lucide="target" class="w-6 h-6"></i>
                                        </div>
                                        <span class="text-sm text-green-600 font-medium bg-green-50 px-2.5 py-1 rounded-full">+24.7%</span>
                                    </div>
                                    <h3 class="text-2xl font-semibold text-slate-800 mb-1">86%</h3>
                                    <p class="text-slate-500 text-sm">Conversion Rate</p>
                                </div>
                            </div>
                            
                            <!-- Charts and Activity Section -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                                <!-- Chart Placeholder -->
                                <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-slate-800">Revenue Overview</h3>
                                        <div class="flex space-x-2">
                                            <button class="text-sm px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 font-medium">Monthly</button>
                                            <button class="text-sm px-3 py-1.5 rounded-lg hover:bg-slate-100 text-slate-600 font-medium">Quarterly</button>
                                            <button class="text-sm px-3 py-1.5 rounded-lg hover:bg-slate-100 text-slate-600 font-medium">Yearly</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Chart Placeholder -->
                                    <div class="h-64 flex items-center justify-center bg-slate-50 rounded-xl border border-slate-200">
                                        <div class="text-center">
                                            <div class="w-12 h-12 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center mx-auto mb-3">
                                                <i data-lucide="bar-chart" class="w-6 h-6 text-amber-500"></i>
                                            </div>
                                            <p class="text-slate-500">Revenue chart visualization</p>
                                            <p class="text-sm text-slate-400">Interactive chart would appear here</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Recent Activity -->
                                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                                    <h3 class="text-lg font-semibold text-slate-800 mb-6">Recent Activity</h3>
                                    
                                    <div class="space-y-5">
                                        <!-- Activity Item 1 -->
                                        <div class="flex items-start">
                                            <div class="mr-4 mt-1">
                                                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                                                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-slate-800">New user registered</p>
                                                <p class="text-sm text-slate-500">John Doe joined the platform</p>
                                                <p class="text-xs text-slate-400 mt-1">2 hours ago</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Activity Item 2 -->
                                        <div class="flex items-start">
                                            <div class="mr-4 mt-1">
                                                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-slate-800">Payment processed</p>
                                                <p class="text-sm text-slate-500">Subscription payment from Acme Inc.</p>
                                                <p class="text-xs text-slate-400 mt-1">4 hours ago</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Activity Item 3 -->
                                        <div class="flex items-start">
                                            <div class="mr-4 mt-1">
                                                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                                                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-slate-800">Pending orders</p>
                                                <p class="text-sm text-slate-500">New order from John Doe</p>
                                                <p class="text-xs text-slate-400 mt-1">6 hours ago</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Activity Item 4 -->
                                        <div class="flex items-start">
                                            <div class="mr-4 mt-1">
                                                <div class="w-10 h-10 rounded-full bg-violet-50 flex items-center justify-center text-violet-600">
                                                    <i data-lucide="upload" class="w-5 h-5"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-slate-800">Report generated</p>
                                                <p class="text-sm text-slate-500">Q3 financial report is ready</p>
                                                <p class="text-xs text-slate-400 mt-1">1 day ago</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button class="w-full mt-6 py-3 text-center text-green-600 font-medium rounded-xl border border-slate-200 hover:bg-slate-50">
                                        View All Activity
                                    </button>
                                </div>
                            </div>
                            
                            <!-- User Table -->
                            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                                <div class="px-6 py-5 border-b border-slate-100">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                                        <h3 class="text-lg font-semibold text-slate-800">Recent Users</h3>
                                        <div class="flex space-x-3 mt-3 md:mt-0">
                                            <button class="text-sm px-4 py-2 rounded-lg border border-slate-200 hover:bg-slate-50 font-medium">
                                                Export
                                            </button>
                                            <button class="text-sm px-4 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-amber-700">
                                                Add User
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Table -->
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-slate-50 border-b border-slate-100">
                                            <tr>
                                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">User</th>
                                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">Role</th>
                                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">Status</th>
                                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">Last Active</th>
                                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <!-- User 1 -->
                                            <tr class="hover:bg-slate-50">
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center">
                                                        <div class="w-9 h-9 rounded-full bg-gradient-to-r from-green-500 to-amber-500 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                                            DR.
                                                        </div>
                                                        <div>
                                                            <p class="font-medium text-green-800">Dr. Zeines</p>
                                                            <p class="text-sm text-slate-500">info@instituteforlivinglonger.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6">
                                                    <span class="px-3 py-1 text-xs font-medium bg-blue-50 text-amber-700 rounded-full">Admin</span>
                                                </td>
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center">
                                                        <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                                        <span class="text-sm text-slate-700">Active</span>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-sm text-slate-600">2 hours ago</td>
                                                <td class="py-4 px-6">
                                                    <div class="flex space-x-2">
                                                        <button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500">
                                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                                        </button>
                                                        <button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!-- User 2 -->
                                            <tr class="hover:bg-slate-50">
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center">
                                                        <div class="w-9 h-9 rounded-full bg-gradient-to-r from-emerald-500 to-green-500 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                                            SC
                                                        </div>
                                                        <div>
                                                            <p class="font-medium text-slate-800">Sarah Chen</p>
                                                            <p class="text-sm text-slate-500">sarah@example.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6">
                                                    <span class="px-3 py-1 text-xs font-medium bg-emerald-50 text-emerald-700 rounded-full">Editor</span>
                                                </td>
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center">
                                                        <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                                        <span class="text-sm text-slate-700">Active</span>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-sm text-slate-600">1 day ago</td>
                                                <td class="py-4 px-6">
                                                    <div class="flex space-x-2">
                                                        <button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500">
                                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                                        </button>
                                                        <button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!-- User 3 -->
                                            <tr class="hover:bg-slate-50">
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center">
                                                        <div class="w-9 h-9 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                                            RK
                                                        </div>
                                                        <div>
                                                            <p class="font-medium text-slate-800">Robert Kim</p>
                                                            <p class="text-sm text-slate-500">robert@example.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6">
                                                    <span class="px-3 py-1 text-xs font-medium bg-amber-50 text-amber-700 rounded-full">Viewer</span>
                                                </td>
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center">
                                                        <div class="w-2 h-2 rounded-full bg-slate-400 mr-2"></div>
                                                        <span class="text-sm text-slate-700">Inactive</span>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-sm text-slate-600">3 days ago</td>
                                                <td class="py-4 px-6">
                                                    <div class="flex space-x-2">
                                                        <button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500">
                                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                                        </button>
                                                        <button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Table Footer -->
                                <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between">
                                    <p class="text-sm text-slate-500 mb-4 sm:mb-0">Showing 3 of 128 users</p>
                                    <div class="flex space-x-2">
                                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-sm font-medium">
                                            Previous
                                        </button>
                                        <button class="px-3 py-1.5 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-amber-700">
                                            1
                                        </button>
                                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-sm font-medium">
                                            2
                                        </button>
                                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-sm font-medium">
                                            3
                                        </button>
                                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-sm font-medium">
                                            Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </main>

               
             @endif   

            @yield('content')
            
        </main>
    </div>
</div>

 
<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>
</html>
