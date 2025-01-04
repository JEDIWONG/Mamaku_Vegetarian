document.addEventListener("DOMContentLoaded", () => {
    const rows = document.querySelectorAll(".transaction-row tr");

    rows.forEach(row => {
        row.addEventListener("click", () => {
            const transactionId = row.dataset.transactionId; // Get the transaction ID from the row's data attribute

            if (transactionId) {
                // Send an AJAX request to set the session
                fetch("../controller/set_session.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ order_id: transactionId }) // Send transaction ID
                })
                .then(response => {
                    if (response.ok) {
                        // Redirect to the receipt page
                        window.location.href = "receipt.php"; // Redirect
                    } else {
                        alert("Failed to set session ID. Please try again.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
            }
        });
    });
});
