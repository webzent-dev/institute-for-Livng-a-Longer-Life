@extends('admin.dashboard.dashboard')
 

@section('content')

<section class=" section-base -mt-6">
       
                            
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
                        
</section>

@endsection