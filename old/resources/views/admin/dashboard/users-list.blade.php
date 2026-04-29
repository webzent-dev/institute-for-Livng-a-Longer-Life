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
<div class="p-6 space-y-4">

    {{-- SEARCH BOX --}}
    <input type="text" id="searchInput"
           placeholder="Search users..."
           class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:ring focus:ring-blue-200">

    {{-- TABLE --}}
    <x-ui.table>
        <x-ui.table-header>
            <x-ui.table-cell>Name</x-ui.table-cell>
            <x-ui.table-cell>Email</x-ui.table-cell>
            <x-ui.table-cell>Role</x-ui.table-cell>
            <x-ui.table-cell>Status</x-ui.table-cell>
            <x-ui.table-cell>Last Active</x-ui.table-cell>
        </x-ui.table-header>
        <tbody id="userTableBody"></tbody>
    </x-ui.table>

    {{-- PAGINATION --}}
    <div id="pagination" class="flex gap-2 mt-4"></div>
</div>

<script>
let currentPage = 1;
let lastPage = 1;
let searchTerm = "";

// ======= DUMMY DATA MODE (REMOVE WHEN BACKEND READY) =========
const dummyUsers = [
    {name:'John Doe', email:'john@example.com', role:'Admin', status:'Active', last_active:'Today'},
    {name:'Jane Smith', email:'jane@example.com', role:'Editor', status:'Active', last_active:'Yesterday'},
    {name:'Chris Brown', email:'cb@example.com', role:'Viewer', status:'Inactive', last_active:'3 days ago'},
    {name:'Kevin Lee', email:'kevin@example.com', role:'Admin', status:'Active', last_active:'1 hour ago'},
    {name:'Sarah Connor', email:'sc@example.com', role:'Viewer', status:'Inactive', last_active:'Last week'},
    {name:'Mike Ross', email:'mr@example.com', role:'Editor', status:'Active', last_active:'2 hours ago'},
    {name:'John Doe', email:'john@example.com', role:'Admin', status:'Active', last_active:'Today'},
    {name:'Jane Smith', email:'jane@example.com', role:'Editor', status:'Active', last_active:'Yesterday'},
    {name:'Chris Brown', email:'cb@example.com', role:'Viewer', status:'Inactive', last_active:'3 days ago'},
    {name:'Kevin Lee', email:'kevin@example.com', role:'Admin', status:'Active', last_active:'1 hour ago'},
    {name:'Sarah Connor', email:'sc@example.com', role:'Viewer', status:'Inactive', last_active:'Last week'},
    {name:'Mike Ross', email:'mr@example.com', role:'Editor', status:'Active', last_active:'2 hours ago'},
    {name:'John Doe', email:'john@example.com', role:'Admin', status:'Active', last_active:'Today'},
    {name:'Jane Smith', email:'jane@example.com', role:'Editor', status:'Active', last_active:'Yesterday'},
    {name:'Chris Brown', email:'cb@example.com', role:'Viewer', status:'Inactive', last_active:'3 days ago'},
    {name:'Kevin Lee', email:'kevin@example.com', role:'Admin', status:'Active', last_active:'1 hour ago'},
    {name:'Sarah Connor', email:'sc@example.com', role:'Viewer', status:'Inactive', last_active:'Last week'},
    {name:'Mike Ross', email:'mr@example.com', role:'Editor', status:'Active', last_active:'2 hours ago'},
    {name:'John Doe', email:'john@example.com', role:'Admin', status:'Active', last_active:'Today'},
    {name:'Jane Smith', email:'jane@example.com', role:'Editor', status:'Active', last_active:'Yesterday'},
    {name:'Chris Brown', email:'cb@example.com', role:'Viewer', status:'Inactive', last_active:'3 days ago'},
    {name:'Kevin Lee', email:'kevin@example.com', role:'Admin', status:'Active', last_active:'1 hour ago'},
    {name:'Sarah Connor', email:'sc@example.com', role:'Viewer', status:'Inactive', last_active:'Last week'},
    {name:'Mike Ross', email:'mr@example.com', role:'Editor', status:'Active', last_active:'2 hours ago'},
    {name:'John Doe', email:'john@example.com', role:'Admin', status:'Active', last_active:'Today'},
    {name:'Jane Smith', email:'jane@example.com', role:'Editor', status:'Active', last_active:'Yesterday'},
    {name:'Chris Brown', email:'cb@example.com', role:'Viewer', status:'Inactive', last_active:'3 days ago'},
    {name:'Kevin Lee', email:'kevin@example.com', role:'Admin', status:'Active', last_active:'1 hour ago'},
    {name:'Sarah Connor', email:'sc@example.com', role:'Viewer', status:'Inactive', last_active:'Last week'},
    {name:'Mike Ross', email:'mr@example.com', role:'Editor', status:'Active', last_active:'2 hours ago'},
    {name:'John Doe', email:'john@example.com', role:'Admin', status:'Active', last_active:'Today'},
    {name:'Jane Smith', email:'jane@example.com', role:'Editor', status:'Active', last_active:'Yesterday'},
    {name:'Chris Brown', email:'cb@example.com', role:'Viewer', status:'Inactive', last_active:'3 days ago'},
    {name:'Kevin Lee', email:'kevin@example.com', role:'Admin', status:'Active', last_active:'1 hour ago'},
    {name:'Sarah Connor', email:'sc@example.com', role:'Viewer', status:'Inactive', last_active:'Last week'},
    {name:'Mike Ross', email:'mr@example.com', role:'Editor', status:'Active', last_active:'2 hours ago'},
    {name:'John Doe', email:'john@example.com', role:'Admin', status:'Active', last_active:'Today'},
    {name:'Jane Smith', email:'jane@example.com', role:'Editor', status:'Active', last_active:'Yesterday'},
    {name:'Chris Brown', email:'cb@example.com', role:'Viewer', status:'Inactive', last_active:'3 days ago'},
    {name:'Kevin Lee', email:'kevin@example.com', role:'Admin', status:'Active', last_active:'1 hour ago'},
    {name:'Sarah Connor', email:'sc@example.com', role:'Viewer', status:'Inactive', last_active:'Last week'},
    {name:'Mike Ross', email:'mr@example.com', role:'Editor', status:'Active', last_active:'2 hours ago'},
    {name:'John Doe', email:'john@example.com', role:'Admin', status:'Active', last_active:'Today'},
    {name:'Jane Smith', email:'jane@example.com', role:'Editor', status:'Active', last_active:'Yesterday'},
    {name:'Chris Brown', email:'cb@example.com', role:'Viewer', status:'Inactive', last_active:'3 days ago'},
    {name:'Kevin Lee', email:'kevin@example.com', role:'Admin', status:'Active', last_active:'1 hour ago'},
    {name:'Sarah Connor', email:'sc@example.com', role:'Viewer', status:'Inactive', last_active:'Last week'},
    {name:'Mike Ross', email:'mr@example.com', role:'Editor', status:'Active', last_active:'2 hours ago'},
    
];
let dummyMode = true; // <-- make false when backend ready
// =============================================================

function fetchUsers(page = 1, search = "") {
    if (dummyMode) {
        renderTable(dummyUsers);
        renderPagination(1, 1);
        return;
    }

    fetch(`{{ route('admin.users') }}?page=${page}&search=${search}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(res => {
        currentPage = res.current_page;
        lastPage = res.last_page;
        renderTable(res.data);
        renderPagination(currentPage, lastPage);
    });
}

function renderTable(data) {
    const tbody = document.getElementById("userTableBody");
    tbody.innerHTML = "";

    data.forEach(u => {
        const initials = u.name.substring(0, 2).toUpperCase();
        const roleColor = u.role === 'Admin'
            ? 'bg-blue-50 text-blue-700'
            : (u.role === 'Editor'
                ? 'bg-emerald-50 text-emerald-700'
                : 'bg-amber-50 text-amber-700');

        const statusColor = u.status === 'Active' ? 'bg-green-500' : 'bg-gray-400';

        tbody.innerHTML += `
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 border-b">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold">
                        ${initials}
                    </div>
                    <span class="text-gray-800 font-semibold">${u.name}</span>
                </div>
            </td>

            <td class="px-4 py-3 border-b text-sm text-gray-700">${u.email}</td>

            <td class="px-4 py-3 border-b">
                <span class="px-2 py-1 rounded-full text-xs font-medium ${roleColor}">
                    ${u.role}
                </span>
            </td>

            <td class="px-4 py-3 border-b">
                <span class="flex items-center gap-2 text-sm text-gray-700">
                    <span class="w-2 h-2 rounded-full ${statusColor}"></span>
                    ${u.status}
                </span>
            </td>

            <td class="px-4 py-3 border-b text-sm text-gray-700">
                ${u.last_active ?? 'Unknown'}
            </td>
        </tr>`;
    });
}

function renderPagination(current, last) {
    const container = document.getElementById("pagination");
    container.innerHTML = "";

    // Prev Button
    container.innerHTML += `
        <button ${current===1?'disabled':''}
            onclick="changePage(${current-1})"
            class="px-3 py-1 border rounded ${current===1?'opacity-50 cursor-not-allowed':''}">
            Prev
        </button>
    `;

    // Page Numbers
    for (let i = 1; i <= last; i++) {
        container.innerHTML += `
            <button onclick="changePage(${i})"
            class="px-3 py-1 border rounded ${i===current?'bg-blue-600 text-white border-blue-600':''}">
                ${i}
            </button>
        `;
    }

    // Next Button
    container.innerHTML += `
        <button ${current===last?'disabled':''}
            onclick="changePage(${current+1})"
            class="px-3 py-1 border rounded ${current===last?'opacity-50 cursor-not-allowed':''}">
            Next
        </button>
    `;
}

function changePage(page) {
    currentPage = page;
    fetchUsers(page, searchTerm);
}

// Live Search
document.getElementById("searchInput").addEventListener("keyup", function() {
    searchTerm = this.value;
    fetchUsers(1, searchTerm);
});

// First load
fetchUsers();
</script>
@endsection