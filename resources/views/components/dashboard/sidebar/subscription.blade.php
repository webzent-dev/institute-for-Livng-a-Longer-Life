
@extends('components.dashboard.member')
@section('content')
<!-- Subscription Page -->
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Main Title -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">My Subscription</h1>
      <p class="text-gray-600 mt-2">Manage your membership plan and benefits</p>
    </div>

    <!-- Subscription Plan Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xl font-semibold text-gray-900">Premium Plan <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 ml-2">Active</span></h2>
          <p class="text-2xl font-bold text-green-600">$387/year Plan</p>
        </div>
        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Change Plan</button>
      </div>
      
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="text-sm">
          <label class="block text-xs text-gray-500 mb-1">Member Since</label>
          <div class="font-medium">January 1, 2025</div>
        </div>
        <div class="text-sm">
          <label class="block text-xs text-gray-500 mb-1">Next Billing</label>
          <div class="font-medium">January 1, 2026</div>
        </div>
        <div class="text-sm col-span-2 md:col-span-1">
          <label class="block text-xs text-gray-500 mb-1">Subscription Period</label>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
          </div>
          <div class="text-xs text-gray-500 mt-1">380 days remaining</div>
        </div>
      </div>
    </div>

    <!-- Benefits Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-6">Your Benefits</h2>
      <p class="text-gray-600 mb-6">Everything included in your Premium plan</p>
      
      <div class="grid grid-cols-2 gap-4">
        <ul class="space-y-2">
          <li class="flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm text-gray-900">20% discount on all video library</span>
          </li>
          <li class="flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm text-gray-900">Personal wellness consultations</span>
          </li>
        </ul>
        <ul class="space-y-2">
          <li class="flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm text-gray-900">Priority Zoom session booking</span>
          </li>
          <li class="flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm text-gray-900">Exclusive member events</span>
          </li>
          <li class="flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm text-gray-900">Access to collaborator content</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Auto-Renewal Notice -->
    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-8">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <p class="ml-3">
          <span class="text-sm text-orange-800">Auto-Renewal Enabled</span>
          <span class="block text-sm text-orange-700">Your subscription will automatically renew on January 1, 2026. You can cancel or modify at any time.</span>
        </p>
        <button class="ml-auto text-orange-700 hover:text-orange-600 text-sm font-medium">Manage Auto-Renewal Settings</button>
      </div>
    </div>
  </div>
</div>
@endsection