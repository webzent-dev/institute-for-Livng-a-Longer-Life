function login() {
    return {
        showPass: false,
        form: {
            email: "",
            password: "",
        },
        errors: {},
        successMsg: "",
        generalError: "",
        async submitForm() {
            this.successMsg = "";
            this.generalError = "";
            this.errors = {};
            try {
                $("#loginBtn").attr('disabled',true);
                $("#loginBtn").text("Please wait...");
                const response = await fetch(baseurl + "/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify(this.form),
                });
                const data = await response.json();

                if (!response.ok) {

                    $("#loginBtn").attr('disabled',false);
                    $("#loginBtn").text("Sign In");

                    // Reset previous errors
                    this.errors = {};
                    this.generalError = "";

                    // Validation or authentication error (422 or 401)
                    if (response.status === 422 || response.status === 401) {

                        if (data.errors) {
                            this.errors = data.errors;
                
                            // If email error exists, also show as general error (optional)
                            if (data.errors.email) {
                                //this.generalError = data.errors.email[0];
                                toastr.error(data.errors.email[0]);
                            }
                        } else {
                            //this.generalError = data.message || "These credentials do not match our records.";
                            toastr.error("These credentials do not match our records.");
                        }

                    } else {
                        //this.generalError = data.message || "Something went wrong.";
                        toastr.error("Something went wrong.");
                    }

                    return;
                }

                // ✅ Success
                //this.successMsg = data.message || "Login successful!";
                toastr.success("Login successful!");

                // optional redirect
                setTimeout(() => {
                    //window.location.href = baseurl+"/member/dashboard";
                    window.location.href = baseurl;
                }, 800);
 
            } catch (e) {
                this.generalError = "Server error. Please try again.";
            }
        }
    }
}