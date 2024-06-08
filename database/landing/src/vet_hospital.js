document.addEventListener("DOMContentLoaded", () => {
    fetch('./src/get_reservations.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const reservationsTable = document.querySelector("#reservationsTable tbody");
            data.reservations.forEach(reservation => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${reservation.pet_owner}</td>
                    <td>${reservation.diagnosis}</td>
                    <td>${reservation.reservation_date}</td>
                    <td>${reservation.reservation_time}</td>
                `;
                reservationsTable.appendChild(row);
            });
        } else {
            alert("Error fetching reservations: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An unexpected error occurred. Please try again later.");
    });
});
