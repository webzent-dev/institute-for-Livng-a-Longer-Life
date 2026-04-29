@extends('admin.email-management.layout')

@section('title', 'Compose Email')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Compose Email</h1>
            <p class="text-gray-500">Create and send email communications</p>
        </div>
    </div>

    <!-- Display Errors -->
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <h3 class="font-semibold text-red-800 mb-2">Validation Errors:</h3>
            <ul class="text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display Messages -->
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif
        <a href="{{ route('admin.email.index') }}" class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Back
        </a>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Email Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.email.send') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Recipient Type -->
                        <div>
                            <label for="recipient_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Recipient Type <span class="text-red-500">*</span>
                            </label>
                            <select id="recipient_type" name="recipient_type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Select Recipient Type</option>
                                <option value="user">Members</option>
                                <option value="collaborator">Collaborators</option>
                                <option value="custom">Custom Email</option>
                            </select>
                        </div>

                        <!-- Users Selection -->
                        <div id="usersSelection" class="hidden">
                            <label for="user_ids" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Users
                            </label>
                            <div id="userCheckboxList" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors max-h-40 overflow-y-auto">
                                <!-- Checkboxes will be dynamically added here -->
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Select users by checking the boxes</p>
                        </div>

                        <!-- Members Selection -->
                        <div id="membersSelection" class="hidden">
                            <label for="member_ids" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Members
                            </label>
                            <select id="member_ids" name="member_ids[]" multiple
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                    style="height: 150px;">
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }} ({{ $member->email }})</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple members</p>
                        </div>

                        <!-- Collaborators Selection -->
                        <div id="collaboratorsSelection" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Select Collaborators
                            </label>
                            <div id="collaboratorsCheckboxList" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors max-h-40 overflow-y-auto">
                                <!-- Checkboxes will be dynamically added here -->
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Select collaborators by checking the boxes</p>
                        </div>

                        <!-- Custom Email Selection -->
                        <div id="customEmailSelection" class="hidden">
                            <label for="recipient_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Recipient Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="recipient_email" name="recipient_email" 
                                   placeholder="Enter email address"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="subject" name="subject" 
                                   placeholder="Enter email subject" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" rows="10" 
                                      placeholder="Enter your message here..." required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-4">
                                                        <button type="submit" 
                                    class="flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                                Send Email
                            </button>
                            <button type="button" onclick="clearForm()"
                                    class="flex items-center px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                                Clear
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Email Templates -->
            <div class="bg-white rounded-xl shadow border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Email Templates</h3>
                    <div class="space-y-2">
                        <a href="#" class="template-item block p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200" 
                           data-template="welcome">
                            <h6 class="font-medium text-gray-900 mb-1">Welcome Email</h6>
                            <p class="text-sm text-gray-500">Welcome new users to the platform</p>
                        </a>
                        <a href="#" class="template-item block p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200" 
                           data-template="announcement">
                            <h6 class="font-medium text-gray-900 mb-1">Announcement</h6>
                            <p class="text-sm text-gray-500">Send general announcements</p>
                        </a>
                        <a href="#" class="template-item block p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200" 
                           data-template="reminder">
                            <h6 class="font-medium text-gray-900 mb-1">Reminder</h6>
                            <p class="text-sm text-gray-500">Send reminder emails</p>
                        </a>
                        <a href="#" class="template-item block p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200" 
                           data-template="promotion">
                            <h6 class="font-medium text-gray-900 mb-1">Promotion</h6>
                            <p class="text-sm text-gray-500">Send promotional emails</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $users->count() }}</div>
                            <div class="text-sm text-blue-700 mt-1">Total Users</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $members->count() }}</div>
                            <div class="text-sm text-green-700 mt-1">Total Members</div>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">{{ $collaborators->count() }}</div>
                            <div class="text-sm text-purple-700 mt-1">Total Collaborators</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

function waitForjQuery() {
    if (typeof jQuery !== 'undefined') {
       
        initEmailForm();
    } else {
        console.log('Waiting for jQuery...');
        setTimeout(waitForjQuery, 100);
    }
}

// Initialize email form functionality
function initEmailForm() {
    $(document).ready(function() {
        console.log('Document ready! -- Checking recipient_type element...');
        if ($('#recipient_type').length) {
            console.log('#recipient_type element found in DOM.');
        } else {
            console.log('#recipient_type element NOT found in DOM.');
        }
        
        // Handle recipient type change
        $('#recipient_type').on('change', function() {
            console.log('Dropdown changed!');
            var selectedType = $(this).val();
            console.log('Selected type:', selectedType);
            
            // Send value change to getAllUser route
            $.ajax({
                url: '{{ route("admin.email.all-users") }}',
                method: 'GET',
                data: { recipient_type: selectedType },
                success: function(response) {
                    console.log('Value sent to route successfully:', response);
                    
                    // Show the appropriate selection div first
                    if (selectedType === 'user') {
                        $('#usersSelection').removeClass('hidden');
                    } else if (selectedType === 'member') {
                        $('#membersSelection').removeClass('hidden');
                    } else if (selectedType === 'collaborator') {
                        $('#collaboratorsSelection').removeClass('hidden');
                    }
                    
                    // Handle different selection types - all as checkboxes now
                    if (response.users && response.users.length > 0) {
                        // Fix ID mapping for different types
                        var checkboxListId = selectedType + 'CheckboxList';
                        var hiddenInputId = selectedType + '_ids';
                        
                        // Special case for collaborators - the HTML ID has 's' at the end
                        if (selectedType === 'collaborator') {
                            checkboxListId = 'collaboratorsCheckboxList';
                        }
                        
                        console.log('Target checkbox list ID:', checkboxListId);
                        console.log('Target hidden input ID:', hiddenInputId);
                        
                        $('#' + checkboxListId).empty();
                        $('#' + hiddenInputId).val('');
                        
                        $.each(response.users, function(index, user) {
                            var displayName = user.first_name + ' ' + user.last_name;
                            var checkboxHtml = '<div class="flex items-center mb-2">' +
                                '<input type="checkbox" id="' + selectedType + '_' + user.id + '" value="' + user.id + '" class="mr-2 user-checkbox" data-type="' + selectedType + '">' +
                                '<label for="' + selectedType + '_' + user.id + '" class="text-sm text-gray-700">' + displayName + ' (' + user.email + ')</label>' +
                                '</div>';
                            $('#' + checkboxListId).append(checkboxHtml);
                            console.log('Added checkbox for:', displayName);
                        });
                        
                        // Add change event listener to update hidden input
                        $('.user-checkbox').on('change', function() {
                            updateSelectedUsers(selectedType);
                        });
                        
                        console.log(selectedType + ' loaded as checkboxes:', response.users);
                        console.log('Checkbox list content:', $('#' + checkboxListId).html());
                    } else {
                        console.log('No users found in response for type:', selectedType);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error sending value to route:', error);
                }
            });
            
            // Hide all selection divs
            $('#usersSelection, #membersSelection, #collaboratorsSelection, #customEmailSelection').addClass('hidden');
            
            // Show relevant selection based on type
            if (selectedType === 'user') {
                $('#usersSelection').removeClass('hidden');
                
                // Load users via AJAX
                $.get('{{ route("admin.email.users") }}', function(data) {
                    $('#user_ids').empty();
                    $.each(data, function(index, user) {
                        $('#user_ids').append('<option value="' + user.id + '">' + user.name + ' (' + user.email + ')</option>');
                    });
                    console.log('Users loaded:', data);
                });
                
                console.log('Showing users selection');
            } else if (selectedType === 'collaborator') {
                $('#collaboratorsSelection').removeClass('hidden');
                console.log('Showing collaborators selection');
            } else if (selectedType === 'custom') {
                $('#customEmailSelection').removeClass('hidden');
                console.log('Showing custom email selection');
            }
        });
    });

    // Handle form submission
    $('form').submit(function(e) {
        console.log('Form submitting...');
        var recipientType = $('#recipient_type').val();
        console.log('Recipient type:', recipientType);
        
        // Create hidden inputs for selected checkboxes before validation
        if (recipientType === 'user') {
            console.log('Calling updateSelectedUsers for user');
            updateSelectedUsers('user');
        } else if (recipientType === 'collaborator') {
        
            updateSelectedUsers('collaborator');
        }
        
        // Validation based on recipient type
        if (recipientType === 'user') {
            // Check if any member checkboxes are checked
            var checkedBoxes = $('.user-checkbox[data-type="user"]:checked');
            console.log('Checked member boxes count:', checkedBoxes.length);
            
            if (checkedBoxes.length === 0) {
                alert('Please select at least one member');
                e.preventDefault();
                return false;
            }
        } else if (recipientType === 'collaborator') {
            // Check if any collaborator checkboxes are checked
            var checkedBoxes = $('.user-checkbox[data-type="collaborator"]:checked');
            console.log('Checked collaborator boxes count:', checkedBoxes.length);
            
            if (checkedBoxes.length === 0) {
                alert('Please select at least one collaborator');
                e.preventDefault();
                return false;
            }
        } else if (recipientType === 'custom') {
            // Check if custom email is entered
            var customEmail = $('#recipient_email').val();
            console.log('Custom email:', customEmail);
            
            if (!customEmail) {
                alert('Please enter an email address');
                e.preventDefault();
                return false;
            }
        }
        
        // Add debug for all form data
        var formData = new FormData($('form')[0]);
        console.log('Form data:');
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    });

    // Handle template selection
    $('.template-item').click(function(e) {
        e.preventDefault();
        var templateType = $(this).data('template');
        
        var templates = {
            welcome: {
                subject: 'Welcome to Our Platform!',
                message: 'Dear User,\n\nWelcome to our platform! We are excited to have you on board.\n\nBest regards,\nThe Team'
            },
            announcement: {
                subject: 'Important Announcement',
                message: 'Dear User,\n\nWe have an important announcement to share with you.\n\n[Your announcement here]\n\nBest regards,\nThe Team'
            },
            reminder: {
                subject: 'Reminder',
                message: 'Dear User,\n\nThis is a reminder about [event/task].\n\nPlease take the necessary action.\n\nBest regards,\nThe Team'
            },
            promotion: {
                subject: 'Special Offer Just for You!',
                message: 'Dear User,\n\nWe have a special promotion just for you!\n\n[Promotion details here]\n\nDon\'t miss out on this amazing opportunity.\n\nBest regards,\nThe Team'
            }
        };
        
        var template = templates[templateType];
        if (template) {
            $('#subject').val(template.subject);
            $('#message').val(template.message);
        }
    });
}

function updateSelectedUsers(type) {
    var selectedIds = [];
    $('.user-checkbox[data-type="' + type + '"]:checked').each(function() {
        selectedIds.push($(this).val());
    });
    
    // Clear existing hidden inputs
    $('input[name="' + type + '_ids[]"]').remove();
    
    // Add hidden inputs for each selected ID to send as array
    $.each(selectedIds, function(index, id) {
        $('<input>').attr({
            type: 'hidden',
            name: type + '_ids[]',
            value: id
        }).appendTo('form');
    });
    
    console.log('Selected ' + type + ' IDs:', selectedIds);
}

function clearForm() {
    document.getElementById('recipient_type').value = '';
    $('#usersSelection, #membersSelection, #collaboratorsSelection, #customEmailSelection').addClass('hidden');
    document.getElementById('subject').value = '';
    document.getElementById('message').value = '';
    document.getElementById('recipient_email').value = '';
    
    // Clear all checkboxes
    $('.user-checkbox').prop('checked', false);
    $('.user-checkbox').trigger('change');
}

// Start waiting for jQuery
waitForjQuery();
</script>
@endpush
