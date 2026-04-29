@extends('admin.dashboard.dashboard')

@section('title', 'Database Migration')

@section('content')
<div class="space-y-6 flex-1 p-8 bg-gradient-subtle">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Database Migration</h1>
        <p class="text-gray-500">Manage database migrations for email management system</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Email Logs Table Status</h2>
            
            @if($tableExists)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                        <div>
                            <h3 class="text-green-800 font-semibold">Table Exists</h3>
                            <p class="text-green-600">The email_logs table is already created and ready to use.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mr-3"></i>
                        <div>
                            <h3 class="text-yellow-800 font-semibold">Table Not Found</h3>
                            <p class="text-yellow-600">The email_logs table needs to be created for the email management system to work.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex space-x-4">
            @if(!$tableExists)
                <button type="button" id="createTableBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-database mr-2"></i>
                    Create Email Logs Table
                </button>
            @endif
            
            @if($tableExists)
                <button type="button" id="dropTableBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-trash mr-2"></i>
                    Drop Email Logs Table
                </button>
            @endif
            
            <a href="{{ route('admin.email.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200 inline-block">
                <i class="fas fa-envelope mr-2"></i>
                Go to Email Management
            </a>
        </div>

        <div id="migrationResult" class="mt-6 hidden">
            <!-- Result will be shown here -->
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Migration Information</h2>
        <div class="space-y-3">
            <div class="border-l-4 border-blue-500 pl-4">
                <h3 class="font-semibold">Table: email_logs</h3>
                <p class="text-gray-600">Stores all email sending history and logs</p>
            </div>
            <div class="border-l-4 border-green-500 pl-4">
                <h3 class="font-semibold">Purpose</h3>
                <p class="text-gray-600">Track email deliveries, failures, and provide email management functionality</p>
            </div>
            <div class="border-l-4 border-yellow-500 pl-4">
                <h3 class="font-semibold">Required for</h3>
                <p class="text-gray-600">Email Management System - Dashboard, Templates, Compose, and Logs features</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#createTableBtn').click(function() {
        var btn = $(this);
        var originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Creating table...');
        
        $.ajax({
            url: '{{ route("admin.migration.run") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#migrationResult').removeClass('hidden').html(`
                    <div class="bg-${response.success ? 'green' : 'red'}-50 border border-${response.success ? 'green' : 'red'}-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-${response.success ? 'check-circle' : 'exclamation-circle'} text-${response.success ? 'green' : 'red'}-500 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-${response.success ? 'green' : 'red'}-800 font-semibold">${response.success ? 'Success' : 'Error'}</h3>
                                <p class="text-${response.success ? 'green' : 'red'}-600">${response.message}</p>
                            </div>
                        </div>
                    </div>
                `);
                
                if (response.success) {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                $('#migrationResult').removeClass('hidden').html(`
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-red-800 font-semibold">Network Error</h3>
                                <p class="text-red-600">Failed to connect to server. Please try again.</p>
                            </div>
                        </div>
                    </div>
                `);
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    $('#dropTableBtn').click(function() {
        if (!confirm('Are you sure you want to drop the email_logs table? This will delete all email history and cannot be undone.')) {
            return;
        }
        
        var btn = $(this);
        var originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Dropping table...');
        
        $.ajax({
            url: '{{ route("admin.migration.rollback") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#migrationResult').removeClass('hidden').html(`
                    <div class="bg-${response.success ? 'green' : 'red'}-50 border border-${response.success ? 'green' : 'red'}-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-${response.success ? 'check-circle' : 'exclamation-circle'} text-${response.success ? 'green' : 'red'}-500 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-${response.success ? 'green' : 'red'}-800 font-semibold">${response.success ? 'Success' : 'Error'}</h3>
                                <p class="text-${response.success ? 'green' : 'red'}-600">${response.message}</p>
                            </div>
                        </div>
                    </div>
                `);
                
                if (response.success) {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                $('#migrationResult').removeClass('hidden').html(`
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-red-800 font-semibold">Network Error</h3>
                                <p class="text-red-600">Failed to connect to server. Please try again.</p>
                            </div>
                        </div>
                    </div>
                `);
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
@endpush
