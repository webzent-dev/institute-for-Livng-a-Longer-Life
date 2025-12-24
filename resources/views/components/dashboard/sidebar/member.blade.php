@extends('components.dashboard.member')
@section('content')

<!-- Member Store Page -->
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Main Title -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Member Store</h1>
      <p class="text-gray-600 mt-2">Exclusive products and free resources for members only</p>
    </div>

    <!-- Tabs -->
    <div class="flex border-b border-gray-200 mb-8">
      <button class="px-4 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Products</button>
      <button class="px-4 py-2 text-sm font-medium text-green-600 border-b-2 border-green-600">Free Guides</button>
      <button class="px-4 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Free Books</button>
    </div>

    <!-- Free Downloads Section -->
    <div class="bg-green-50 rounded-lg p-6 mb-8">
      <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900">Free Downloads</h2>
      </div>
      <p class="text-gray-600 mb-6">All guides are free for members to download</p>
    </div>

    <!-- Guides Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">PDF</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Complete Guide to Holistic Dentistry</h3>
        <p class="text-sm text-gray-600 mb-1">Dr. Victor Zines</p>
        <p class="text-sm text-gray-500 mb-4">45 pages</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">Download Free</button>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">PDF</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Natural Remedies for Gum Health</h3>
        <p class="text-sm text-gray-600 mb-1">Dr. Victor Zines</p>
        <p class="text-sm text-gray-500 mb-4">28 pages</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">Download Free</button>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">PDF</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Mercury-Free Living Handbook</h3>
        <p class="text-sm text-gray-600 mb-1">Dr. Victor Zines</p>
        <p class="text-sm text-gray-500 mb-4">36 pages</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">Download Free</button>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">PDF</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Anti-Inflammatory Diet Recipes</h3>
        <p class="text-sm text-gray-600 mb-1">Institute Team</p>
        <p class="text-sm text-gray-500 mb-4">52 pages</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">Download Free</button>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">PDF</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Stress Management Workbook</h3>
        <p class="text-sm text-gray-600 mb-1">Institute Team</p>
        <p class="text-sm text-gray-500 mb-4">32 pages</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">Download Free</button>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">PDF</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Sleep Optimization Guide</h3>
        <p class="text-sm text-gray-600 mb-1">Institute Team</p>
        <p class="text-sm text-gray-500 mb-4">24 pages</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium">Download Free</button>
      </div>
    </div>
  </div>
</div>
@endsection