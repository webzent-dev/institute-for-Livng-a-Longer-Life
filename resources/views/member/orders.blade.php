
@extends('member.member')

@section('member-content')

<!-- Orders Page -->
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Main Title -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
      <p class="text-gray-600 mt-2">Track and manage your product orders</p>
    </div>

    <!-- Order History Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900">Order History</h2>
      </div>
      <p class="text-gray-600 mb-6">View all your past and current orders</p>
      
      <!-- Orders Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2025-001</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dec 15, 2025</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">VitalBoost Supplement</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$99.99</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Delivered</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-green-600 hover:text-green-500">View</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2025-002</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dec 10, 2025</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Organic MultiVitamin</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$45.00</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Shipped</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-green-600 hover:text-green-500">View</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2025-003</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dec 5, 2025</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Essential Oils Meditation Guide</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$125.50</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Processing</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-green-600 hover:text-green-500">View</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2024-050</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Nov 20, 2024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Immunity Booster Pack</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$67.00</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Delivered</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-green-600 hover:text-green-500">View</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
        <div class="text-3xl font-bold text-green-600">4</div>
        <div class="text-sm text-gray-600">Total Orders</div>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
        <div class="text-3xl font-bold text-green-600">2</div>
        <div class="text-sm text-gray-600">Delivered</div>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
        <div class="text-3xl font-bold text-green-600">2</div>
        <div class="text-sm text-gray-600">In Progress</div>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
        <div class="text-sm text-gray-600">Plans</div>
      </div>
    </div>
  </div>
</div>
@endsection
 