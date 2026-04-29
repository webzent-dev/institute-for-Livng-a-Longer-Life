@extends('admin.email-management.layout')

@section('title', 'Email Logs')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Email Logs</h1>
        <p class="text-gray-500">View and filter email sending history</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="filterDate" class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="filterDate">
                    <option value="today">Today</option>
                    <option value="week">Last 7 Days</option>
                    <option value="month">Last 30 Days</option>
                    <option value="all">All Time</option>
                </select>
            </div>
            
            <div>
                <label for="filterStatus" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="filterStatus">
                    <option value="all">All Status</option>
                    <option value="sent">Sent</option>
                    <option value="failed">Failed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            
            <div>
                <label for="filterType" class="block text-sm font-medium text-gray-700 mb-2">Email Type</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="filterType">
                    <option value="all">All Types</option>
                    <option value="collaborator_active">Collaborator Active</option>
                    <option value="collaborator_login">Collaborator Login</option>
                    <option value="member_signup">Member Signup</option>
                    <option value="order_confirmation">Order Confirmation</option>
                    <option value="custom">Custom</option>
                </select>
            </div>
            
            <div>
                <label for="searchEmail" class="block text-sm font-medium text-gray-700 mb-2">Search Email</label>
                <div class="relative">
                    <input type="text" class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           id="searchEmail" placeholder="Search by email...">
                    <i data-lucide="search" class="absolute left-3 top-3 w-4 h-4 text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-4 space-x-3">
            <button type="button" onclick="refreshLogs()" 
                    class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                Refresh
            </button>
            <button type="button" onclick="exportLogs()" 
                    class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Export
            </button>
        </div>
    </div>

    <!-- Email Logs Table -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="emailLogsTable">
                    @if(isset($emailLogs) && $emailLogs->count() > 0)
                        @foreach($emailLogs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->recipient_email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate">{{ $log->subject }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->email_type_label }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{!! $log->status_badge !!}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->sent_at ? $log->sent_at->format('M j, Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <button type="button" onclick="viewEmailDetails({{ $log->id }})" 
                                        class="text-blue-600 hover:text-blue-900 font-medium">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="inbox" class="w-12 h-12 text-gray-300 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No email logs found</h3>
                                    <p class="text-gray-500">Start sending emails to see logs here</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if(isset($emailLogs))
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200 mt-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $emailLogs->firstItem() }} to {{ $emailLogs->lastItem() }} of {{ $emailLogs->total() }} entries
                </div>
                <div class="flex space-x-2">
                    @if($emailLogs->onFirstPage())
                        <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $emailLogs->previousPageUrl() }}" 
                           class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200">
                            Previous
                        </a>
                    @endif
                    
                    @if($emailLogs->hasMorePages())
                        <a href="{{ $emailLogs->nextPageUrl() }}" 
                           class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200">
                            Next
                        </a>
                    @else
                        <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Email Details Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="emailDetailsModal">
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[80vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Email Details</h3>
                <button type="button" onclick="closeEmailDetails()" 
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6" id="emailDetailsContent">
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end p-6 border-t border-gray-200 space-x-3">
                <button type="button" onclick="closeEmailDetails()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                    Close
                </button>
                <button type="button" id="resendEmailBtn" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                    <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                    Resend Email
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterElements = ['filterDate', 'filterStatus', 'filterType', 'searchEmail'];
    
    filterElements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('change', function() {
                applyFilters();
            });
        }
    });
    
    // Search on enter key
    const searchEmail = document.getElementById('searchEmail');
    if (searchEmail) {
        searchEmail.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
    }
});

function applyFilters() {
    const dateFilter = document.getElementById('filterDate').value;
    const statusFilter = document.getElementById('filterStatus').value;
    const typeFilter = document.getElementById('filterType').value;
    const searchEmail = document.getElementById('searchEmail').value;
    
    const params = new URLSearchParams();
    if (dateFilter !== 'all') params.append('date_filter', dateFilter);
    if (statusFilter !== 'all') params.append('status', statusFilter);
    if (typeFilter !== 'all') params.append('email_type', typeFilter);
    if (searchEmail) params.append('search_email', searchEmail);
    
    const url = window.location.pathname + '?' + params.toString();
    window.location.href = url;
}

function refreshLogs() {
    window.location.reload();
}

function exportLogs() {
    // Get current filters
    const dateFilter = document.getElementById('filterDate').value;
    const statusFilter = document.getElementById('filterStatus').value;
    const typeFilter = document.getElementById('filterType').value;
    
    const params = new URLSearchParams();
    if (dateFilter !== 'all') params.append('date_filter', dateFilter);
    if (statusFilter !== 'all') params.append('status', statusFilter);
    if (typeFilter !== 'all') params.append('email_type', typeFilter);
    params.append('export', 'true');
    
    const url = window.location.pathname + '?' + params.toString();
    window.open(url, '_blank');
}

function viewEmailDetails(id) {
    const modal = document.getElementById('emailDetailsModal');
    const content = document.getElementById('emailDetailsContent');
    
    // Show loading state
    modal.classList.remove('hidden');
    content.innerHTML = `
        <div class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        </div>
    `;
    
    // Fetch email details via AJAX
    fetch(`/admin/email/logs/details/${id}`)
        .then(response => response.json())
        .then(data => {
            content.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Basic Information</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">ID:</span>
                                    <span class="text-sm text-gray-900">${data.id}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Type:</span>
                                    <span class="text-sm text-gray-900">${data.email_type_label}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Status:</span>
                                    <span>${data.status_badge}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Timestamps</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Created:</span>
                                    <span class="text-sm text-gray-900">${data.created_at}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Sent At:</span>
                                    <span class="text-sm text-gray-900">${data.sent_at || 'Not sent'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Email Details</h4>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-500">From:</span>
                                <span class="text-sm text-gray-900">admin@example.com</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">To:</span>
                                <span class="text-sm text-gray-900">${data.recipient_email}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Subject:</span>
                                <span class="text-sm text-gray-900">${data.subject}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Message:</span>
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm text-gray-700 max-h-32 overflow-y-auto">
                                    ${data.message}
                                </div>
                            </div>
                            ${data.error_message ? `
                            <div>
                                <span class="text-sm font-medium text-gray-500">Error:</span>
                                <div class="mt-2 p-3 bg-red-50 rounded-lg text-sm text-red-700">
                                    ${data.error_message}
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
            
            // Set resend button
            document.getElementById('resendEmailBtn').onclick = function() {
                resendEmail(data.id, data.email_type, 'user');
            };
        })
        .catch(error => {
            content.innerHTML = `
                <div class="text-center py-8">
                    <i data-lucide="alert-circle" class="w-12 h-12 text-red-300 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-red-900 mb-2">Error Loading Details</h3>
                    <p class="text-red-500">Failed to load email details. Please try again.</p>
                </div>
            `;
        });
}

function closeEmailDetails() {
    const modal = document.getElementById('emailDetailsModal');
    modal.classList.add('hidden');
}

function resendEmail(id, type, recipientType) {
    if (!confirm('Are you sure you want to resend this email?')) {
        return;
    }
    
    fetch('/admin/email/resend', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            email_type: type,
            recipient_id: id,
            recipient_type: recipientType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Email resent successfully!');
            closeEmailDetails();
            refreshLogs();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        alert('Network error: ' + error.message);
    });
}
</script>
@endpush
