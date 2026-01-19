
@extends('member.member')

@section('member-content')


<!-- Security Settings Page -->
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Main Title -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Security Settings</h1>
      <p class="text-gray-600 mt-2">Manage your account security and privacy</p>
    </div>

    <!-- Change Password Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900">Change Password</h2>
      </div>
      <p class="text-gray-600 mb-6">Update your password to keep your account secure</p>
      
      <form class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
          <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
          <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
          <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium">Update Password</button>
      </form>
    </div>

    <!-- Security Options Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-6">Security Options</h2>
      
      <div class="space-y-4">
        <div class="flex items-start">
          <label class="flex items-center">
            <input type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
            <span class="ml-3 text-sm text-gray-900">Configure additional security features</span>
          </label>
          <p class="ml-7 text-xs text-gray-500 mt-1">Add extra layer of security to your account</p>
        </div>
        <div class="flex items-start">
          <label class="flex items-center">
            <input type="checkbox" checked class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
            <span class="ml-3 text-sm text-gray-900">Email notifications for login</span>
          </label>
          <p class="ml-7 text-xs text-gray-500 mt-1">Get notified when someone logs into your account</p>
        </div>
      </div>
    </div>

    <!-- Recent Login Activity Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900">Recent Login Activity</h2>
      </div>
      <p class="text-gray-600 mb-6">Monitor recent login to your account</p>
      
      <!-- Login Activity List -->
      <div class="space-y-4">
        <div class="flex justify-between items-center p-4 border border-gray-200 rounded-md">
          <div>
            <div class="text-sm font-medium text-gray-900">Chrome on Windows</div>
            <div class="text-xs text-gray-500">New York, NY</div>
          </div>
          <div class="text-right">
            <div class="text-xs text-gray-500">Dec 17, 2025</div>
            <div class="text-xs text-gray-900">10:30 AM</div>
          </div>
        </div>
        <div class="flex justify-between items-center p-4 border border-gray-200 rounded-md">
          <div>
            <div class="text-sm font-medium text-gray-900">Safari on iPhone</div>
            <div class="text-xs text-gray-500">New York, NY</div>
          </div>
          <div class="text-right">
            <div class="text-xs text-gray-500">Dec 16, 2025</div>
            <div class="text-xs text-gray-900">3:45 PM</div>
          </div>
        </div>
        <div class="flex justify-between items-center p-4 border border-gray-200 rounded-md">
          <div>
            <div class="text-sm font-medium text-gray-900">Chrome on MacOS</div>
            <div class="text-xs text-gray-500">Brooklyn, NY</div>
          </div>
          <div class="text-right">
            <div class="text-xs text-gray-500">Dec 15, 2025</div>
            <div class="text-xs text-gray-900">9:00 AM</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection