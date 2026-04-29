@props(['title'])

<section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>

    {{ $slot }}
</section>

{{-- Usage Example --}}

{{-- <x-dashboard.report-section title="Monthly Summary">
    <p>Report details here...</p>
</x-dashboard.report-section> --}}



{{-- <x-dashboard.report-section title="Monthly Reports">
    <p>This section contains the monthly reports data and visualizations.</p>    
</x-dashboard.report-section> --}}

{{-- <x-dashboard.report-section title="User Analytics">
    <p>Here you can find insights and analytics about user behavior.</p>
</x-dashboard.report-section> --}}  
{{-- <x-dashboard.report-section title="Sales Data">
    <p>This section provides detailed sales data and trends.</p>
</x-dashboard.report-section> --}}