@extends('admin.dashboard.dashboard')
 

@section('content')

<section class=" section-base">
        <!-- User Table -->

    @php
            $sampleUsers = [
                [
                    'id' => '1',
                    'user_id' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
                    'role' => 'admin',
                    'created_at' => now()->subDays(30)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '2',
                    'user_id' => 'b2c3d4e5-f6a7-8901-bcde-f12345678901',
                    'role' => 'collaborator',
                    'created_at' => now()->subDays(25)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '3',
                    'user_id' => 'c3d4e5f6-a7b8-9012-cdef-123456789012',
                    'role' => 'moderator',
                    'created_at' => now()->subDays(20)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '4',
                    'user_id' => 'd4e5f6a7-b8c9-0123-def1-234567890123',
                    'role' => 'user',
                    'created_at' => now()->subDays(15)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '5',
                    'user_id' => 'e5f6a7b8-c9d0-1234-ef12-345678901234',
                    'role' => 'collaborator',
                    'created_at' => now()->subDays(10)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '6',
                    'user_id' => 'f6a7b8c9-d0e1-2345-f123-456789012345',
                    'role' => 'user',
                    'created_at' => now()->subDays(5)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '7',
                    'user_id' => 'a7b8c9d0-e1f2-3456-1234-567890123456',
                    'role' => 'user',
                    'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '8',
                    'user_id' => 'b8c9d0e1-f2a3-4567-2345-678901234567',
                    'role' => 'moderator',
                    'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
                ],
            ];
    @endphp

    <!-- Main Content -->
                        <main class="flex-1 -mt-7 px-4 md:px-6 overflow-y-auto scrollbar-custom ">
                            <!-- Welcome Card -->
                           
                            <div class="bg-white/100 rounded-2xl p-6  mb-6 shadow-md text-slate-800">
                                <div class="flex flex-col md:flex-row md:items-center justify-between">
                                    <div>
                                        <h2 class="text-2xl font-semibold mb-2 text-left">Welcome back, Dr. Zeines!</h2>
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
                                <x-ui.stats :items="
                                                    [
                                                        ['label' => 'Total Users', 'value' => 127, 'icon' => 'users','icon_color' => 'bg-green-50 text-green-600', 'percent_change' => '+8.5%', 'percent_change_bg' => 'bg-green-50 text-green-600'],
                                                        ['label' => 'collaborators', 'value' => '8', 'icon' => 'credit-card','iconbg' => 'bg-amber-50', 'icon_color' => 'bg-amber-50 text-amber-600', 'percent_change' => '+8.5%', 'percent_change_bg' => 'bg-amber-50 text-amber-600'],
                                                        ['label' => 'Orders', 'value' => 340, 'icon' => 'bar-chart-3', 'iconbg' => 'bg-blue-50', 'icon_color' => 'bg-blue-50 text-blue-600', 'percent_change' => '+8.5%', 'percent_change_bg' => 'bg-green-50 text-blue-600'],
                                                        ['label' => 'Visits', 'value' => '45k', 'icon' => 'eye',  'iconbg' => 	'bg-yellow-50', 	'icon_color' => 	'text-yellow-600', 	'percent_change' => '+8.5%', 	'percent_change_bg' => 	'text-yellow-600'],
                                                    ]" 
                                />
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
                            
                            
                        </main>

</div>
</section>



@endsection
{{-- @include('components.dashboard.sidebar.menu')    --}}