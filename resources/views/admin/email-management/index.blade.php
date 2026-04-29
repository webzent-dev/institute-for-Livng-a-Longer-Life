@extends('admin.email-management.layout')

@section('title', 'Email Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Email Management</h1>
        <p class="text-gray-500">Manage all email communications and templates</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Emails -->
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Emails</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEmails }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i data-lucide="mail" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Sent Today -->
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Sent Today</p>
                    <p class="text-2xl font-bold text-green-600">{{ $sentToday }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i data-lucide="send" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingEmails }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>

        <!-- Failed -->
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Failed</p>
                    <p class="text-2xl font-bold text-red-600">{{ $failedEmails }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Quick Actions</h2>
                <p class="text-gray-500 text-sm">Manage email operations</p>
            </div>
            <div class="space-y-3">
                <a href="{{ route('admin.email.compose') }}" class="flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 group">
                    <div class="flex items-center">
                        <i data-lucide="edit" class="w-5 h-5 text-blue-600 mr-3"></i>
                        <span class="font-medium text-blue-900">Compose Email</span>
                    </div>
                    <i data-lucide="arrow-right" class="w-4 h-4 text-blue-600 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="{{ route('admin.email.templates') }}" class="flex items-center justify-between p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200 group">
                    <div class="flex items-center">
                        <i data-lucide="file-text" class="w-5 h-5 text-purple-600 mr-3"></i>
                        <span class="font-medium text-purple-900">Email Templates</span>
                    </div>
                    <i data-lucide="arrow-right" class="w-4 h-4 text-purple-600 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="{{ route('admin.email.logs') }}" class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200 group">
                    <div class="flex items-center">
                        <i data-lucide="history" class="w-5 h-5 text-gray-600 mr-3"></i>
                        <span class="font-medium text-gray-900">Email Logs</span>
                    </div>
                    <i data-lucide="arrow-right" class="w-4 h-4 text-gray-600 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Recent Email Activity</h2>
                <p class="text-gray-500 text-sm">Latest email communications</p>
            </div>
            <div class="space-y-3">
                @if($recentEmails->count() > 0)
                    @foreach($recentEmails as $email)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900 mb-1">{{ $email->subject }}</h3>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span>To: {{ $email->recipient_email }}</span>
                                    <span class="mx-2">•</span>
                                    {!! $email->status_badge !!}
                                </div>
                            </div>
                            <span class="text-xs text-gray-400">{{ $email->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <i data-lucide="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No recent activity</h3>
                        <p class="text-gray-500">Start sending emails to see activity here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
