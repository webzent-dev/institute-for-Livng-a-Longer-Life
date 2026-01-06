@extends('front.dashboard.dashboard')
 

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

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-8">
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
    
    {{-- @endrole --}}

</div>
</section>



@endsection
{{-- @include('components.dashboard.sidebar.menu')    --}}