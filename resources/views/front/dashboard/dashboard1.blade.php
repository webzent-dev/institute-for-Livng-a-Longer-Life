<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>the INSTITUTE FOR LIVING A LONGER LIFE Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Smooth transitions and scroll behavior */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
        body {
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
        }
        /* Custom scrollbar */
        .scrollbar-custom::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-custom::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        .scrollbar-custom::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .scrollbar-custom::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-700">
    <!-- Main Layout -->
    <div class="flex min-h-screen">
        <!-- Sidebar - Hidden on mobile, visible on medium and up -->
        <aside class="hidden md:flex flex-col w-64 bg-white border-r border-slate-200 sticky top-0 h-screen">
            <!-- Logo -->
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <!-- Logo -->
                    
                    <div class="w-16 h-16    flex items-center justify-center">
                       <img src="{{ asset('assets/logo.png')}}" alt="">
                    </div>  

                    <span class="ml-2 heading-4 font-semibold text-slate-800">Welcome back <br>Dr. Zeines</span>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-primary-50 text-green-600">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="font-medium">Users</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50">
                    <i data-lucide="package-search" class="w-5 h-5"></i>
                    <span class="font-medium">All Products</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span class="font-medium">Orders</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    <span class="font-medium">Courses</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    <span class="font-medium">Analytics</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span class="font-medium">Reports</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span class="font-medium">Settings</span>
                </a>
            </nav>
            
            <!-- User Profile in Sidebar -->
            <div class="p-4 border-t border-slate-100">
                <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-50">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-500 to-amber-700 flex items-center justify-center text-white font-semibold">
                        DR.
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-slate-800 truncate">Dr. Zeines</p>
                        <p class="text-sm text-slate-500 truncate">info@instituteforlivinglonger.com</p>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Header -->
            <header class="sticky top-0 z-10 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 py-3 md:px-6">
                <div class="flex items-center justify-between">
                    <!-- Left: Mobile Menu Button & Page Title -->
                    <div class="flex items-center space-x-4">
                        <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-slate-100">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <div>
                            <h1 class="text-xl font-semibold text-slate-800">Dashboard</h1>
                            <p class="text-sm text-slate-500 hidden md:block">Welcome back, Dr. Zeines. A Pioneer in Holistic Dentistry with a Vision Beyond Teeth</p>
                        </div>
                    </div>
                    
                    <!-- Right: Search, Notifications, Profile -->
                    <div class="flex items-center space-x-3">
                        <!-- Search Bar -->
                        <div class="hidden md:flex items-center bg-slate-100 rounded-xl px-4 py-2">
                            <i data-lucide="search" class="w-4 h-4 text-slate-400 mr-2"></i>
                            <input type="text" placeholder="Search..." class="bg-transparent border-none focus:outline-none text-sm w-48">
                        </div>
                        
                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg hover:bg-slate-100">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- User Profile (Mobile) -->
                        <div class="md:hidden">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-r from-primary-500 to-primary-700 flex items-center justify-center text-white font-semibold text-sm">
                                AJ
                            </div>
                        </div>
                        
                        <!-- User Profile Dropdown (Desktop) -->
                        <div class="hidden md:flex items-center space-x-2 p-2 rounded-xl hover:bg-slate-100 cursor-pointer">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-r from-green-500 to-amber-700 flex items-center justify-center text-white font-semibold">
                                Dr.
                            </div>
                            <div class="hidden lg:block">
                                <p class="font-medium text-sm text-slate-800">Dr. Zeines</p>
                                <p class="text-xs text-slate-500">Administrator</p>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500 hidden lg:block"></i>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-6 overflow-y-auto scrollbar-custom ">
                <!-- Welcome Card -->
                <div class="bg-white/100 rounded-2xl p-6   mb-6 shadow-md text-slate-800">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold mb-2">Welcome back, Dr. Zeines!</h2>
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
        </div>
    </div>
    
    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
        
        // Simple mobile menu toggle (without JavaScript for actual toggling, this just shows the concept)
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            // In a real implementation, you would toggle a mobile menu
            alert("Mobile menu would open here. In a real implementation, JavaScript would toggle a sidebar.");
        });
    </script>
</body>
</html>


{{-- @extends('layouts.collaborator')

@section('content')
<h2 class="text-3xl font-bold mb-2">Dashboard</h2>
<p class="text-muted mb-8">
    Welcome back! Here's an overview of your performance.
</p> --}}

{{-- STATS --}}
{{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <x-ui.stats title="Total Revenue" value="$0.00" note="+12.5%" />
    <x-ui.stats title="Products" value="0" note="+2 new" />
    <x-ui.stats title="Total Orders" value="0" note="+8 this week" />
    <x-ui.stats title="Video Views" value="0" note="+143 today" />

</div> --}}

{{-- BOTTOM --}}
{{-- <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 bg-white border rounded-xl p-6">
        <h3 class="text-xl font-semibold mb-2">Recent Activity</h3>
        <p class="text-muted">
            Your recent sales and course views will appear here.
        </p>
    </div>

    <div class="bg-white border rounded-xl p-6">
        <h3 class="text-xl font-semibold mb-2">Quick Actions</h3>
        <ul class="text-sm space-y-2 text-muted">
            <li>• Add new products to your store</li>
            <li>• Create a new course</li>
            <li>• Update your profile information</li>
        </ul>
    </div>

</div> --}}
{{-- @endsection --}}









{{-- @extends('layouts.collaborator')
@section('title','Dashboard')

@section('content')
<div class="space-y-8">
    <h1 class="text-3xl font-bold">Dashboard</h1>

    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat-card title="Total Revenue" :value="$stats['revenue']"/>
        <x-stat-card title="Products" :value="$stats['products']"/>
        <x-stat-card title="Orders" :value="$stats['orders']"/>
        <x-stat-card title="Video Views" :value="$stats['views']"/>
    </div>
</div>
@endsection --}}

