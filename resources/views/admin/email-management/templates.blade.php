@extends('admin.email-management.layout')

@section('title', 'Email Templates')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.email.index') }}" 
           class="flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Back
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Email Templates</h1>
            <p class="text-gray-500">Manage and configure email templates</p>
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($emailTypes as $key => $emailType)
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $emailType['name'] }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $emailType['description'] }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer email-toggle" 
                               data-email-type="{{ $key }}" 
                               {{ $emailType['enabled'] ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <span class="text-sm {{ $emailType['enabled'] ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $emailType['enabled'] ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <button type="button" onclick="editTemplate('{{ $key }}')"
                        class="w-full flex items-center justify-center px-3 py-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded-lg transition-colors duration-200">
                    <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                    Edit
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Floating Action Button -->
    <div class="fixed top-20 right-6 z-50">
        <a href="{{ route('admin.email.compose') }}" 
           class="flex items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg transition-colors duration-200">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Compose Email
        </a>
    </div>
</div>


@endsection

@push('scripts')
<script>
function editTemplate(templateKey) {
    console.log('Edit template clicked:', templateKey);
    // Load the template content for editing
    toastr.info('Loading template editor...');
    
    $.ajax({
        url: '{{ route("admin.email.edit") }}',
        method: 'GET',
        data: {
            email_type: templateKey,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                // Create and show edit modal
                createEditModal(templateKey, response.content);
            } else {
                toastr.error('Failed to load template for editing');
            }
        },
        error: function(xhr) {
            var error = xhr.responseJSON ? xhr.responseJSON.error : 'Failed to load template';
            toastr.error(error);
        }
    });
}

$(document).ready(function() {
    console.log('Email templates page loaded');
    console.log('jQuery version:', $.fn.jquery);
    
    // Toggle email template status
    $('.email-toggle').change(function() {
        var emailType = $(this).data('email-type');
        var enabled = $(this).is(':checked');
        console.log('Toggle clicked:', emailType, enabled);
        
        $.ajax({
            url: '{{ route("admin.email.toggle") }}',
            method: 'POST',
            data: {
                email_type: emailType,
                enabled: enabled ? 1 : 0,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success(response.success);
            },
            error: function(xhr) {
                console.log('Toggle error response:', xhr);
                var errorMessage = 'Failed to update email template status';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    console.log('Validation errors:', xhr.responseJSON.errors);
                    errorMessage = xhr.responseJSON.message || errorMessage;
                }
                toastr.error(errorMessage);
                // Revert the toggle
                $('.email-toggle[data-email-type="' + emailType + '"]').prop('checked', !enabled);
            }
        });
    });
});


function createEditModal(templateKey, content) {
    // Remove existing edit modal if present
    $('#editModal').remove();
    
    // Create edit modal HTML
    var modalHtml = `
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex" x-data="{ open: true }" x-show="open" x-transition>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-xl shadow-xl max-w-6xl w-full h-[90vh] flex flex-col overflow-hidden">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">Edit Email Template: ${templateKey}</h3>
                        <div class="flex items-center space-x-2">
                            <button onclick="toggleEditorMode()" id="toggleModeBtn"
                                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm transition-colors duration-200">
                                <i data-lucide="code" class="w-4 h-4 inline mr-1"></i>
                                HTML Mode
                            </button>
                            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Modal Body -->
                    <form id="editTemplateForm" class="flex-1 flex flex-col overflow-hidden" style="max-height: 551px;">
                        <div class="flex-1 overflow-y-auto">
                            <div class="p-6">
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Template Content <span class="text-red-500">*</span>
                                        </label>
                                        <span class="text-xs text-gray-500" id="editorMode">Visual Mode</span>
                                    </div>
                                    <!-- Hidden textarea to store content -->
                                    <textarea name="content" id="templateContent" 
                                            style="display: none; width: 100%; min-height: 250px; font-family: 'Courier New', monospace; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; resize: vertical;"
                                            placeholder="Enter your HTML content here...">${content}</textarea>
                                    <!-- Rich text editor container -->
                                    <div id="rich-editor" contenteditable="true" 
                                         style="min-height: 250px; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; background: white;"
                                         class="focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                                <input type="hidden" name="email_type" value="${templateKey}">
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 p-6 pt-4 border-t border-gray-200 bg-white">
                            <button type="button" onclick="closeEditModal()"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                Save Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    $('body').append(modalHtml);
    
    // Reinitialize lucide icons
    lucide.createIcons();
    
    // Initialize simple rich text editor
    setTimeout(function() {
        var richEditor = $('#rich-editor');
        
        // Set initial content
        richEditor.html(content);
        
        // Add formatting toolbar
        var toolbarHtml = `
            <div class="border border-gray-300 border-b-0 rounded-t-lg bg-gray-50 p-2 flex flex-wrap gap-1">
                <button type="button" onclick="formatText('bold')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    <strong>B</strong>
                </button>
                <button type="button" onclick="formatText('italic')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    <em>I</em>
                </button>
                <button type="button" onclick="formatText('underline')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    <u>U</u>
                </button>
                <div class="border-l border-gray-300 mx-1"></div>
                <button type="button" onclick="formatText('justifyLeft')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    ≡
                </button>
                <button type="button" onclick="formatText('justifyCenter')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    ≡
                </button>
                <button type="button" onclick="formatText('justifyRight')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    ≡
                </button>
                <div class="border-l border-gray-300 mx-1"></div>
                <button type="button" onclick="formatText('insertUnorderedList')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    •
                </button>
                <button type="button" onclick="formatText('insertOrderedList')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    1.
                </button>
                <div class="border-l border-gray-300 mx-1"></div>
                <button type="button" onclick="insertLink()" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-sm">
                    🔗
                </button>
            </div>
        `;
        
        // Insert toolbar before the editor
        richEditor.before(toolbarHtml);
        
        // Update hidden textarea on content change
        richEditor.on('input keyup paste', function() {
            $('#templateContent').val(richEditor.html());
        });
        
        console.log('Rich text editor initialized successfully');
    }, 100);
    
    // Handle form submission
    $('#editTemplateForm').submit(function(e) {
        e.preventDefault();
        
        // Get content from rich editor before submission
        var editorContent = isHtmlMode ? $('#templateContent').val() : $('#rich-editor').html();
        $('#templateContent').val(editorContent);
        
        $.ajax({
            url: '{{ route("admin.email.update") }}',
            method: 'POST',
            data: $(this).serialize() + '&_token={{ csrf_token() }}',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    closeEditModal();
                } else {
                    toastr.error('Failed to update template');
                }
            },
            error: function(xhr) {
                var error = xhr.responseJSON ? xhr.responseJSON.error : 'Failed to update template';
                toastr.error(error);
            }
        });
    });
}

var isHtmlMode = false;

function formatText(command) {
    document.execCommand(command, false, null);
    $('#rich-editor').trigger('input');
}

function insertLink() {
    var url = prompt('Enter URL:');
    if (url) {
        document.execCommand('createLink', false, url);
        $('#rich-editor').trigger('input');
    }
}

function toggleEditorMode() {
    var richEditor = $('#rich-editor');
    var htmlEditor = $('#templateContent');
    var toggleBtn = $('#toggleModeBtn');
    var modeLabel = $('#editorMode');
    
    if (isHtmlMode) {
        // Switch to visual mode
        var htmlContent = htmlEditor.val();
        richEditor.html(htmlContent).show();
        htmlEditor.hide();
        richEditor.prev('.border-gray-300').show(); // Show toolbar
        
        toggleBtn.html('<i data-lucide="code" class="w-4 h-4 inline mr-1"></i>HTML Mode');
        modeLabel.text('Visual Mode');
        isHtmlMode = false;
    } else {
        // Switch to HTML mode
        var content = richEditor.html();
        htmlEditor.val(content).show();
        richEditor.hide();
        richEditor.prev('.border-gray-300').hide(); // Hide toolbar
        
        toggleBtn.html('<i data-lucide="eye" class="w-4 h-4 inline mr-1"></i>Visual Mode');
        modeLabel.text('HTML Mode');
        isHtmlMode = true;
    }
    
    // Reinitialize lucide icons
    lucide.createIcons();
}

function closeEditModal() {
    // Remove modal
    $('#editModal').remove();
    
    // Reset mode flag
    isHtmlMode = false;
}

</script>
@endpush
