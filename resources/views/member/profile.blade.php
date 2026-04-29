@extends('member.member')
@section('member-content')
<div x-data="profileForm()" class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 text-left">Profile Settings</h1>
        <p class="text-gray-600">Manage your personal information</p>
    </div>

    <div class="bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.08)]">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Personal Information
            </h3>
            <p class="text-gray-600 mb-6">Update your profile details</p>
            <div class="space-y-6">
                <div class="flex items-center gap-6">
                    <!-- Image Preview Circle -->
                    <div class="relative">
                        @if(!empty($userInfo['profile_image']) && file_exists(public_path('user_images/'.$userInfo['profile_image'])))
                            <img id="profilePreview" src="{{ asset('user_images/'.$userInfo['profile_image']) }}" class="h-24 w-24 rounded-full object-cover bg-blue-100 border">
                        @else
                            <img id="profilePreview" src="{{ asset('user_images/avatar.jpg') }}" class="h-24 w-24 rounded-full object-cover bg-blue-100 border">

                        @endif
                    </div>

                    <!-- Hidden File Input -->
                    <input type="file" id="profileInput" name="profile_image" accept="image/*" class="hidden">

                    <!-- Button to Trigger File Upload -->
                    <button type="button" id="uploadBtn" class="border border-gray-300 rounded-lg px-4 py-2 text-sm hover:bg-gray-50 transition">
                        <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Change Photo
                    </button>
                </div>


                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name tt <span style="color:#ff0000">*</span></label>
                        <input type="text" id="firstName" x-model="formData.firstName"  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter First Name*" autocomplete="off" required>
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span style="color:#ff0000">*</span></label>
                        <input type="text" id="lastName" x-model="formData.lastName" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter Last Name*" autocomplete="off" required>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span style="color:#ff0000">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <input type="email" id="email" x-model="formData.email" class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" disabled>
                        </div>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone <span style="color:#ff0000">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <input type="tel" id="phone" x-model="formData.phone" class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary phone_number" placeholder="Enter Phone*" autocomplete="off" required>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address <span style="color:#ff0000">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <input type="text" id="address" x-model="formData.address" class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter Address*" autocomplete="off" required>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City <span style="color:#ff0000">*</span></label>
                        <input type="text" id="city" x-model="formData.city" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter City*" autocomplete="off" required>
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State <span style="color:#ff0000">*</span></label>
                        <input type="text" id="state" x-model="formData.state" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter State*" autocomplete="off" required>
                    </div>
                    <div>
                        <label for="zipCode" class="block text-sm font-medium text-gray-700 mb-1">Zip Code <span style="color:#ff0000">*</span></label>
                        <input type="text" id="zipCode" x-model="formData.zipCode" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter Zip Code*" autocomplete="off" required>
                    </div>
                </div>

                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio <span style="color:#ff0000">*</span></label>
                    <textarea id="bio" x-model="formData.bio" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter Bio*" autocomplete="off" required></textarea>
                </div>

                <button @click="saveProfile" id="save_changes" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-accent transition">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function profileForm() {
    let userDetail = @json($userDetail);
    let userAddressDetail = @json($userAddressDetail);
    //console.log(userDetail);
    //console.log(userAddressDetail);

    // Normalize userAddressDetail to a plain object with expected keys
    if (!userAddressDetail || typeof userAddressDetail !== 'object') {
        try {
            if (typeof userAddressDetail === 'string' && userAddressDetail.trim() !== '') {
                userAddressDetail = JSON.parse(userAddressDetail);
            } else {
                userAddressDetail = null;
            }
        } catch (e) {
            console.warn('Failed to parse userAddressDetail JSON', e);
            userAddressDetail = null;
        }
    }

    if (!userAddressDetail) {
        userAddressDetail = {
            address_line_1: '',
            address_line_2: '',
            city: '',
            state: '',
            zip_code: '',
            bio: ''
        };
    } else {
        // Accept several possible key variants and fall back to empty string
        userAddressDetail = {
            address_line_1: userAddressDetail.address_line_1 ?? '',
            address_line_2: userAddressDetail.address_line_2 ?? '',
            city: userAddressDetail.city ?? '',
            state: userAddressDetail.state ?? '',
            zip_code: userAddressDetail.zip_code ?? userAddressDetail.zipCode,
            bio: userAddressDetail.bio ?? ''
        };
    }

    return {
        formData: {
            firstName: userDetail.first_name,
            lastName: userDetail.last_name,
            email: userDetail.email,
            phone: userDetail.phone,
            address: userAddressDetail.address_line_1,
            city: userAddressDetail.city,
            state: userAddressDetail.state,
            zipCode: userAddressDetail.zip_code,
            bio: userAddressDetail.bio,
        },
        saveProfile() {
            let firstName = this.formData.firstName;
            let lastName = this.formData.lastName;
            let phone = this.formData.phone;
            let address = this.formData.address;
            let city = this.formData.city;
            let state = this.formData.state;
            let zipCode = this.formData.zipCode;
            let bio = this.formData.bio;

            if(firstName == '' || firstName == null) {
                toastr.error('Please enter first name.');
                $('#firstName').focus();
                return false;
            }

            if(lastName == '' || lastName == null) {
                toastr.error('Please enter last name.');
                $('#lastName').focus();
                return false;
            }

            if(phone == '' || phone == null) {
                toastr.error('Please enter phone number.');
                $('#phone').focus();
                return false;
            }

            if(address == '' || address == null) {
                toastr.error('Please enter address.');
                $('#address').focus();
                return false;
            }

            if(city == '' || city == null) {
                toastr.error('Please enter city.');
                $('#city').focus();
                return false;
            }

            if(state == '' || state == null) {
                toastr.error('Please enter state.');
                $('#state').focus();
                return false;
            }

            if(zipCode == '' || zipCode == null) {
                toastr.error('Please enter zip code.');
                $('#zipCode').focus();
                return false;
            }

            if(bio == '' || bio == null) {
                toastr.error('Please enter bio.');
                $('#bio').focus();
                return false;
            }

            //disable save chanegs button
            $('#save_changes').attr('disabled', true).text('Please wait...');

            // ================= CREATE FORMDATA =================
            let formData = new FormData();
            formData.append('firstName', firstName);
            formData.append('lastName', lastName);
            formData.append('phone', phone);
            formData.append('address', address);
            formData.append('city', city);
            formData.append('state', state);
            formData.append('zipCode', zipCode);
            formData.append('bio', bio);

            // Append Image
            let imageFile = document.getElementById('profileInput').files[0];
            if(imageFile){
                formData.append('profile_image', imageFile);
            }

            var baseurl = $('meta[name=base-url]').attr("content");

            // In a real application, you would send this to your Laravel backend
            fetch(baseurl+'/member/saveProfile', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                $('#save_changes').attr('disabled', false);
                $('#save_changes').text('Save Changes');
                // Show toast notification
                this.showToast('Profile Updated', 'Your profile information has been saved successfully.');
            })
            .catch(error => {
                console.error('Error:', error);
            });
        },
        showToast(title, message) {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg z-50';
            toast.innerHTML = `
                <div class="font-semibold">${title}</div>
                <div class="text-sm">${message}</div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    }
}

$(document).ready(function() {

    // Trigger file input when button clicked
    $("#uploadBtn").click(function() {
        $("#profileInput").click();
    });

    // Preview selected image
    $("#profileInput").change(function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                $("#profilePreview").attr("src", e.target.result);
                //$("#initials").hide(); // hide initials after image upload
            }

            reader.readAsDataURL(file);
        }
    });

});

//Add validation for phone number input to allow only digits and maximum lengeth of 10 characters
$('.phone_number').on('input', function() {
    let value = $(this).val();
    // Remove any non-digit characters
    value = value.replace(/[^0-9]/g, '');
    // Limit to 10 characters
    value = value.substring(0, 10);
    $(this).val(value);
});
</script>
@endsection
