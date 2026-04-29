<div class="overflow-x-auto rounded-xl border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        {{ $slot }}
    </table>
</div>



{{-- Usage Example --}}
{{-- <x-ui.table :headers="['Name','Email','Role','Joined']">
    <tr>
        <td>John Doe</td>
        <td>        </td>
        <td>Admin</td>
        <td>2024-01-12</td>
    </tr>
</x-ui.table> --}}