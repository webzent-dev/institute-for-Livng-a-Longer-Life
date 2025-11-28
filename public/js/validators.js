window.validators = {

    sanitize: {
        name: value => value.replace(/[^A-Za-z\s'-]/g, "").slice(0, 40),
    },

    rules: {
        firstName(value) {
            if (!value) return "First name is required";
            if (value.trim().length < 3) return "Minimum 3 characters";
            if (!/^[A-Za-z\s'-]{3,40}$/.test(value)) return "Only letters allowed";
            return true;
        },
        lastName(value) {
            if (!value) return "Last name is required";
            if (value.trim().length < 3) return "Minimum 3 characters";
            if (!/^[A-Za-z\s'-]{3,40}$/.test(value)) return "Only letters allowed";
            return true;
        },
        email(value) {
            if (!value) return "Email is required";
            const re = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
            return re.test(value.trim()) ? true : "Invalid email";
        },
        phone(value) {
            if (!value) return "Phone is required";
            if ((value.match(/\d/g) || []).length < 10) return "Invalid phone";
            return true;
        },
        password(value) {
            if (!value) return "Password required";
            const re = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/;
            return re.test(value) ? true : "Weak password";
        },
        confirmPassword(value, form) {
            if (!value) return "Confirm password";
            return value === form.password ? true : "Passwords do not match";
        },
        subject(value) {
            if (!value) return "Subject is required";
            if (value.trim().length < 5) return "Minimum 5 characters";
            return true;
        },

        description(value) {
            if (!value) return "Message is required";
            if (value.trim().length < 5) return "Minimum 5 characters";
            return true;
        },

    }
};
