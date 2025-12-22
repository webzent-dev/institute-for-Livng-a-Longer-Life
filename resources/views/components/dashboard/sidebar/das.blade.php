@extends('components.dashboard.member')
@section('content')

<!-- Dashboard Page -->
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Welcome Message -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
      <p class="text-gray-600 mt-2">Welcome back! Access your membership benefits below.</p>
    </div>

    <!-- Feature Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
          </div>
          <h2 class="text-lg font-semibold text-gray-900">Video Library</h2>
        </div>
        <p class="text-gray-600 mb-4">Access all educational videos and wellness content</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">View Videos</button>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <h2 class="text-lg font-semibold text-gray-900">Member Store</h2>
        </div>
        <p class="text-gray-600 mb-4">Browse products with exclusive member discounts</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">Browse Store</button>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
          <h2 class="text-lg font-semibold text-gray-900">Collaborators</h2>
        </div>
        <p class="text-gray-600 mb-4">Connect with wellness experts and specialists</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">View Collaborators</button>
      </div>
    </div>

    <!-- Zoom Sessions Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Zoom Sessions</h2>
        <div class="flex space-x-2">
          <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded">Upcoming sessions</span>
          <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded">Archives & Recordings</span>
        </div>
      </div>

      <!-- Sessions List -->
      <div class="space-y-4">
        <div class="border border-gray-200 rounded-md p-4">
          <div class="flex justify-between items-start mb-2">
            <h3 class="text-sm font-semibold text-gray-900">Q&A with Dr. Victor Zines</h3>
            <span class="text-xs text-gray-500">2 PM EST (60 min)</span>
          </div>
          <p class="text-sm text-gray-600 mb-2">Monthly live session covering your wellness questions and health insights</p>
          <div class="flex items-center justify-between">
            <span class="text-xs text-green-600">12 spots available</span>
            <div class="flex space-x-2">
              <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium">Join Session</button>
              <button class="border border-gray-300 text-gray-700 px-3 py-1 rounded text-xs font-medium">Add to Calendar</button>
            </div>
          </div>
        </div>
        <div class="border border-gray-200 rounded-md p-4">
          <div class="flex justify-between items-start mb-2">
            <h3 class="text-sm font-semibold text-gray-900">Functional Nutrition Deep Dive</h3>
            <span class="text-xs text-gray-500">6:00 PM EST (45 min)</span>
          </div>
          <p class="text-sm text-gray-600 mb-2">Weekly discussion on optimizing nutrition for longevity and metabolic health</p>
          <div class="flex items-center justify-between">
            <span class="text-xs text-green-600">8 spots available</span>
            <div class="flex space-x-2">
              <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium">Join Session</button>
              <button class="border border-gray-300 text-gray-700 px-3 py-1 rounded text-xs font-medium">Add to Calendar</button>
            </div>
          </div>
        </div>
        <div class="border border-gray-200 rounded-md p-4">
          <div class="flex justify-between items-start mb-2">
            <h3 class="text-sm font-semibold text-gray-900">Movement & Mobility Masterclass</h3>
            <span class="text-xs text-gray-500">10:00 AM EST (90 min)</span>
          </div>
          <p class="text-sm text-gray-600 mb-2">Weekly hands-on training for strength and flexibility at any age</p>
          <div class="flex items-center justify-between">
            <span class="text-xs text-green-600">5 spots available</span>
            <div class="flex space-x-2">
              <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium">Join Session</button>
              <button class="border border-gray-300 text-gray-700 px-3 py-1 rounded text-xs font-medium">Add to Calendar</button>
            </div>
          </div>
        </div>
        <div class="border border-gray-200 rounded-md p-4">
          <div class="flex justify-between items-start mb-2">
            <h3 class="text-sm font-semibold text-gray-900">Holistic Health Workshop</h3>
            <span class="text-xs text-gray-500">3:00 PM EST (75 min)</span>
          </div>
          <p class="text-sm text-gray-600 mb-2">Comprehensive approach to integrating wellness practices into daily life</p>
          <div class="flex items-center justify-between">
            <span class="text-xs text-green-600">15 spots available</span>
            <div class="flex space-x-2">
              <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium">Join Session</button>
              <button class="border border-gray-300 text-gray-700 px-3 py-1 rounded text-xs font-medium">Add to Calendar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Getting Started Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900">Getting Started</h2>
      </div>
      <p class="text-gray-600 mb-6">Quick guide to maximize your membership</p>
      
      <ol class="space-y-4 text-sm text-gray-700">
        <li class="flex items-center">
          <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
            <span class="text-xs font-semibold text-green-600">1</span>
          </div>
          <span>Watch the welcome videos to understand all your benefits</span>
        </li>
        <li class="flex items-center">
          <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
            <span class="text-xs font-semibold text-green-600">2</span>
          </div>
          <span>Explore the Product Store with your exclusive member discount</span>
        </li>
        <li class="flex items-center">
          <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
            <span class="text-xs font-semibold text-green-600">3</span>
          </div>
          <span>Browse wellness products with your exclusive member discount</span>
        </li>
        <li class="flex items-center">
          <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
            <span class="text-xs font-semibold text-green-600">Connect with experts</span>
          </div>
          <span>Learn from our network of wellness collaborators and specialists</span>
        </li>
      </ol>
    </div>
  </div>
</div>
</div>
@endsection
