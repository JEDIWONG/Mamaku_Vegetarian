document.addEventListener("DOMContentLoaded", () => {
    // Attach event listener to delete buttons
    document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.addEventListener("click", async (e) => {
            const cartItemId = btn.getAttribute("data-id"); // Get cart_item_id

            if (confirm("Are you sure you want to delete this item?")) {
                try {
                    const response = await fetch("../controller/delete_cart_item.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ cart_item_id: cartItemId }), // Send cart_item_id
                    });

                    const result = await response.json();
                    if (result.status === "success") {
                        alert("Item deleted successfully!");
                        location.reload(); // Reload page to reflect changes
                    } else {
                        alert(result.message || "Failed to delete item.");
                    }
                } catch (error) {
                    console.error("Error deleting item:", error);
                    alert("An error occurred. Please try again.");
                }
            }
        });
    });
});
