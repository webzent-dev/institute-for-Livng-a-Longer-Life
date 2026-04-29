<!DOCTYPE html>
{{-- <html lang="en"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

@if (session('success'))
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50"
>
    {{ session('success') }}
</div>
@endif

<div id="toast"
     class="hidden fixed top-5 right-5 px-5 py-3 rounded-lg shadow-lg text-white z-50">
</div>
<body  x-data="{  sidebarOpen: true,  mobileSidebar: false  }"  class="bg-slate-50 antialiased">
<div class="flex min-h-screen">
    <x-dashboard.sidebar.sidebar />
    <div class="flex-1 flex flex-col">
     <x-dashboard.sidebar.header />

    <main class="flex-1 p-8  bg-white ">
        <div class="space-y-6">
                <!-- Header -->
            <div class="flex justify-between items-center  ">
                <div class="">
                    <h1 class="text-3xl font-bold text-left mb-0">Audit Logs</h1>
                    <p class="text-muted-foreground text-lg">
                    Track all administrative actions
                    </p>
                </div>
                <div class="right-3">
                <x-button-use label=" Add Course" variant="primary" icon="user-plus"
                    @click="$dispatch('open-modal', 'add-course-modal')" />
                </div>
            </div>
             {{-- Modal Form --}}
            <x-ui.modal name="add-course-modal" size="3xl" class="max-w-3xl sticky top-20">
                <h2 class="text-lg font-semibold leading-none tracking-tight mb-2 text-left">Schedule New Zoom Session</h2>


                    <!-- FORM -->
                <form @submit.prevent="submitForm" class="space-y-3 overflow-y-auto scrollbar-custom max-h-[60vh] scroll-smooth px-5 mb-6">

                    <x-form.input name="Session" type="number" placeholder="Monthly Wellness Session" label="Session Title"  />
                    <div class="space-y-2">
                                <label
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                >
                                    Description
                                </label>

                                <textarea
                                    rows="3"
                                    placeholder="Enter course description"
                                    class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                ></textarea>
                        </div>

                    <x-form.select label="Host" name="role"
                        :options="[
                                ['value' => 'Dr. Victor Zeines', 'label' => 'Dr. Victor Zeines'],
                                ['value' => 'Dr. Sarah Martinez', 'label' => 'Dr. Sarah Martinez'],
                                ['value' => 'Dr. Michael Chen', 'label' => 'Dr. Michael Chen'],
                                ['value' => 'Dr. Emily Thompson', 'label' => 'Dr. Emily Thompson'],
                            ]"
                            :selected="['Dr. Victor Zeines']"
                    />
                        <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="space-y-2">
                                    <x-form.date-picker
                                        name="session_date"
                                        label="Date"
                                        placeholder="dd-mm-yyyy"
                                    />

                                </div>
                                <div class="space-y-2">
                                    <x-form.time-picker
                                        name="session_time"
                                        label="Time"
                                        placeholder="02:15 PM"
                                    />
                                </div>
                        </div>


                    <x-form.select label="Duration" name="status" placeholder="Select duration"
                        :options="[
                                ['value' => '30 minutes', 'label' => '30 minutes'],
                                ['value' => '45 minutes', 'label' => '45 minutes'],
                                ['value' => '1 hour', 'label' => '1 hour'],
                                ['value' => '1.5 hours', 'label' => '1.5 hours'],
                                ['value' => '2 hours', 'label' => '2 hours'],
                            ]"
                    />

                    <x-form.input name="Zoom Meeting Link" type="text" placeholder="https://zoom.us/j/..." label="Zoom Meeting Link"  />


                    <x-button-use label="Schedule Session" variant="primary"  class="w-full" icon="calendar"/>

                </form>


            </x-ui.modal>


             <div class="p-6 pt-0">
    <div class="relative w-full overflow-auto">
      <table class="w-full caption-bottom text-sm">

        <thead class="[&_tr]:border-b">
          <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Action</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Resource Type</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Resource ID</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">User ID</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
          </tr>
        </thead>

        <tbody class="[&_tr:last-child]:border-0">

          <!-- Row 1 -->
          <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
            <td class="p-4 align-middle">
              <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-primary-foreground bg-green-500">
                create_product
              </div>
            </td>
            <td class="p-4 align-middle">product</td>
            <td class="p-4 align-middle font-mono text-sm">prod-123</td>
            <td class="p-4 align-middle font-mono text-sm">admin-1</td>
            <td class="p-4 align-middle">11/02/2026, 09:05:35</td>
            <td class=" justify-items-center ">
                                         <div class="flex gap-2">
                                            <x-button-use href="{{ route('admin.audit.logs.details') }}" label="View" variant="outline" icon="eye" class="pl-0 pr-0 w-24 h-10"/>

                                    </td>
          </tr>

          <!-- Row 2 -->
          <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
            <td class="p-4 align-middle">
              <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-primary-foreground bg-blue-500">
                update_user_role
              </div>
            </td>
            <td class="p-4 align-middle">user</td>
            <td class="p-4 align-middle font-mono text-sm">user-456</td>
            <td class="p-4 align-middle font-mono text-sm">admin-1</td>
            <td class="p-4 align-middle">11/02/2026, 08:05:35</td>
            <td class="p-4 align-middle">
              <button class="inline-flex items-center justify-center h-9 px-3 rounded-md border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground">
                <!-- Eye icon same as above -->
                View
              </button>
            </td>
          </tr>

          <!-- Row 3 -->
          <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
            <td class="p-4 align-middle">
              <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-primary-foreground bg-red-500">
                delete_course
              </div>
            </td>
            <td class="p-4 align-middle">course</td>
            <td class="p-4 align-middle font-mono text-sm">course-789</td>
            <td class="p-4 align-middle font-mono text-sm">admin-2</td>
            <td class="p-4 align-middle">11/02/2026, 07:05:35</td>
            <td class="p-4 align-middle">
              <button class="inline-flex items-center justify-center h-9 px-3 rounded-md border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground">
                View
              </button>
            </td>
          </tr>

          <!-- Row 4 -->
          <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
            <td class="p-4 align-middle">
              <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-primary-foreground bg-blue-500">
                update_settings
              </div>
            </td>
            <td class="p-4 align-middle">settings</td>
            <td class="p-4 align-middle font-mono text-sm">N/A</td>
            <td class="p-4 align-middle font-mono text-sm">admin-1</td>
            <td class="p-4 align-middle">11/02/2026, 06:05:35</td>
            <td class="p-4 align-middle">
                <button class="inline-flex items-center justify-center h-9 px-3 rounded-md border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground">
                  View
                </button>
            </td>
          </tr>

          <!-- Row 5 -->
          <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
            <td class="p-4 align-middle">
              <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-primary-foreground bg-green-500">
                create_collaborator
              </div>
            </td>
            <td class="p-4 align-middle">collaborator</td>
            <td class="p-4 align-middle font-mono text-sm">collab-321</td>
            <td class="p-4 align-middle font-mono text-sm">admin-2</td>
            <td class="p-4 align-middle">11/02/2026, 05:05:35</td>
            <td class="p-4 align-middle">
              <button class="inline-flex items-center justify-center h-9 px-3 rounded-md border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground">
                View
              </button>
            </td>
          </tr>

          <!-- Row 6 -->
          <tr class="border-b transition-colors data-[state=selected]:bg-muted hover:bg-muted/50">
            <td class="p-4 align-middle">
              <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-transparent text-primary-foreground bg-blue-500">
                update_order_status
              </div>
            </td>
            <td class="p-4 align-middle">order</td>
            <td class="p-4 align-middle font-mono text-sm">order-654</td>
            <td class="p-4 align-middle font-mono text-sm">admin-1</td>
            <td class="p-4 align-middle">11/02/2026, 04:05:35</td>
            <td class="p-4 align-middle">
              <button class="inline-flex items-center justify-center h-9 px-3 rounded-md border-2 border-primary bg-background text-primary hover:bg-primary hover:text-primary-foreground">
                View
              </button>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>




        </div>

    </main>



            @yield('content')

        </main>
    </div>
</div>


<x-dashboard.sidebar.mobile-sidebar />

<script>lucide.createIcons()</script>
</body>
<script>
  const tabs = document.querySelectorAll('[role="tab"]');
  const contents = document.querySelectorAll('.tab-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => {
        t.setAttribute('aria-selected', 'false');
        t.setAttribute('data-state', 'inactive');
        t.classList.remove('bg-background', 'shadow-sm');
      });

      contents.forEach(c => c.classList.add('hidden'));

      tab.setAttribute('aria-selected', 'true');
      tab.setAttribute('data-state', 'active');
      tab.classList.add('bg-background', 'shadow-sm');

      const activeContent = document.getElementById(tab.dataset.tab);
      if (activeContent) {
        activeContent.classList.remove('hidden');
      }
    });
  });
</script>
</html>
