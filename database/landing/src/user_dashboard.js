document.addEventListener("DOMContentLoaded", () => {
    const reservationForm = document.querySelector("#reservationForm");

    reservationForm.addEventListener("submit", e => {
        e.preventDefault();

        const formData = new FormData(reservationForm);

        fetch('./src/make_reservation.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Reservation made successfully!");
                reservationForm.reset();
            } else {
                alert("Error making reservation: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An unexpected error occurred. Please try again later.");
        });
    });

    // Fetch hospitals to populate the form
    fetch('./src/get_hospitals.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const hospitalSelect = document.querySelector("#hospital");
            data.hospitals.forEach(hospital => {
                const option = document.createElement("option");
                option.value = hospital.hospital_id;
                option.textContent = hospital.name;
                hospitalSelect.appendChild(option);
            });
        } else {
            alert("Error fetching hospitals: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An unexpected error occurred. Please try again later.");
    });
});
