<!-- Payments Page -->

@extends('member.member')

@section('member-content')


<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Main Title -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Payment History</h1>
      <p class="text-gray-600 mt-2">Manage your payment methods and view transaction history</p>
    </div>

    <!-- Saved Payment Methods Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Saved Payment Methods</h2>
        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">+ Add Card</button>
      </div>
      <p class="text-gray-600 mb-6">Manage your credit and debit cards</p>
      
      <!-- Cards List -->
      <div class="space-y-4">
        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-md">
          <div>
            <div class="text-sm font-medium text-gray-900">Visa ****4242</div>
            <div class="text-xs text-gray-500">Expires 12/26</div>
          </div>
          <span class="text-sm text-green-600 font-medium">Default</span>
        </div>
        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-md">
          <div>
            <div class="text-sm font-medium text-gray-900">Mastercard ****8888</div>
            <div class="text-xs text-gray-500">Expires 03/29</div>
          </div>
          <button class="text-green-600 hover:text-green-500 text-sm font-medium">Set Default</button>
        </div>
      </div>
    </div>

    <!-- Transaction History Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900">Transaction History</h2>
      </div>
      <p class="text-gray-600 mb-6">All membership payment transactions</p>
      
      <!-- Transactions Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PAY-2025-01</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 1, 2025</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Premium Membership - Annual</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Visa ****4242</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$87.00</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-green-600 hover:text-green-500">↓</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PAY-2024-02</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 1, 2024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Standard Membership - Annual</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Visa ****4242</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$18.00</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-green-600 hover:text-green-500">↓</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PAY-2023-01</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 1, 2023</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Standard Membership - Annual</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Mastercard ****8888</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$18.00</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-green-600 hover:text-green-500">↓</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
        <div class="text-3xl font-bold text-green-600">$753.00</div>
        <div class="text-sm text-gray-600">Total Spent on Memberships</div>
      </div>
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
        <div class="text-3xl font-bold text-green-600">3</div>
        <div class="text-sm text-gray-600">Years as Member</div>
      </div>
    </div>
  </div>
</div>
@endsection