document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.querySelector("#login");
    const createAccountForm = document.querySelector("#createAccount");
    const accountTypeSelection = document.querySelector("#accountTypeSelection");
    const signupSuccessForm = document.querySelector("#signupSuccess");

    document.querySelector("#linkCreateAccount").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.add("form--hidden");
        accountTypeSelection.classList.remove("form--hidden");
    });

    document.querySelector("#linkLogin").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.remove("form--hidden");
        createAccountForm.classList.add("form--hidden");
        accountTypeSelection.classList.add("form--hidden");
        signupSuccessForm.classList.add("form--hidden");
    });

    document.querySelector("#linkLoginFromAccountType").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.remove("form--hidden");
        accountTypeSelection.classList.add("form--hidden");
    });

    document.querySelector("#successSignIn").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.remove("form--hidden");
        signupSuccessForm.classList.add("form--hidden");
    });

    document.querySelector("#petOwner").addEventListener("click", e => {
        e.preventDefault();
        showCreateAccountForm("pet_owner");
    });

    document.querySelector("#hospital").addEventListener("click", e => {
        e.preventDefault();
        showCreateAccountForm("hospital");
    });

    document.querySelector("#veterinarian").addEventListener("click", e => {
        e.preventDefault();
        showCreateAccountForm("hospital_employee");
    });

    function showCreateAccountForm(type) {
        createAccountForm.classList.remove("form--hidden");
        accountTypeSelection.classList.add("form--hidden");
        createAccountForm.dataset.accountType = type;
        document.querySelector("#accountType").value = type;

        // Show/hide specific fields based on account type
        if (type === "hospital") {
            document.querySelector("#hospitalFields").style.display = "block";
            document.querySelector("#employeeFields").style.display = "none";
        } else if (type === "hospital_employee") {
            document.querySelector("#hospitalFields").style.display = "none";
            document.querySelector("#employeeFields").style.display = "block";
        } else {
            document.querySelector("#hospitalFields").style.display = "none";
            document.querySelector("#employeeFields").style.display = "none";
        }

        console.log("Account Type:", type);
    }

    createAccountForm.addEventListener("submit", e => {
        e.preventDefault();

        const username = createAccountForm.querySelector('input[name="username"]').value;
        const email = createAccountForm.querySelector('input[name="email"]').value;
        const password = createAccountForm.querySelector('input[name="password"]').value;
        const confirmPassword = createAccountForm.querySelector('input[name="confirmPassword"]').value;
        const accountType = createAccountForm.dataset.accountType;

        console.log("Account Type:", accountType);

        if (username === "" || email === "" || password === "" || confirmPassword === "" || !accountType) {
            setFormMessage(createAccountForm, "error", "All fields are required.");
            return;
        }

        if (password !== confirmPassword) {
            setFormMessage(createAccountForm, "error", "Passwords do not match.");
            return;
        }

        const formData = new FormData(createAccountForm);
        formData.append('accountType', accountType);

        console.log("Submitting registration form...");

        fetch('./src/register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log("Response received: ", response);
            return response.json();
        })
        .then(data => {
            console.log("Response data: ", data);
            if (data.success) {
                createAccountForm.reset();
                createAccountForm.classList.add("form--hidden");
                signupSuccessForm.classList.remove("form--hidden");
            } else {
                setFormMessage(createAccountForm, "error", data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            setFormMessage(createAccountForm, "error", "An unexpected error occurred. Please try again later.");
        });
    });

    function setFormMessage(forElement, type, message) {
        const messageElement = forElement.querySelector(".form__message");
        messageElement.textContent = message;
        messageElement.classList.remove("form__message--success", "form__message--error");
        messageElement.classList.add(`form__message--${type}`);
    }
});
