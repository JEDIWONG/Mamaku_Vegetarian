document.addEventListener("DOMContentLoaded", () => {
    const quantityIndicator = document.querySelector(".amt-indicator");
    const addToCartBtn = document.querySelector(".add-cart-btn");
    const totalPriceLabel = document.querySelector(".order-price");
    const productInfo = document.querySelector(".product-info-container");

    let quantity = 1; // Initial quantity
    const basePrice = parseFloat(productInfo.getAttribute("data-product-price")); // Base product price

    // Update the total price
    const updateTotalPrice = () => {
        const selectedOptionPrice = 0; // Option pricing can be added here if necessary
        const selectedAddons = Array.from(
            document.querySelectorAll("input[name='product_addon[]']:checked")
        ).map(addon => parseFloat(addon.getAttribute("data-addon-price")));

        const addonsTotal = selectedAddons.reduce((total, price) => total + price, 0);
        const totalPrice = (basePrice + addonsTotal + selectedOptionPrice) * quantity;

        totalPriceLabel.textContent = `RM ${totalPrice.toFixed(2)}`;
        return totalPrice.toFixed(2); // Return the computed total price
    };

    // Event listeners for quantity changes
    document.querySelector(".amt-add")?.addEventListener("click", () => {
        quantity++;
        quantityIndicator.textContent = quantity;
        updateTotalPrice();
    });

    document.querySelector(".amt-decrease")?.addEventListener("click", () => {
        if (quantity > 1) {
            quantity--;
            quantityIndicator.textContent = quantity;
            updateTotalPrice();
        }
    });

    // Event listener for add-ons selection
    document.querySelectorAll("input[name='product_addon[]']").forEach(addon => {
        addon.addEventListener("change", updateTotalPrice);
    });

    // Event listener for adding to cart
    addToCartBtn.addEventListener("click", async () => {
        const selectedOption = document.querySelector("input[name='product_option']:checked");
        const selectedAddons = Array.from(
            document.querySelectorAll("input[name='product_addon[]']:checked")
        ).map(addon => addon.value);

        const specialInstruction = document.querySelector(".order-instruction-field")?.value || "";
        const totalPrice = updateTotalPrice(); // Get the computed total price

        if (!selectedOption) {
            alert("Please select an option.");
            return;
        }

        try {
            // Prepare the data to send as JSON
            const data = {
                product_id: productInfo.getAttribute("data-product-id"),
                quantity: quantity,
                option: selectedOption.value,
                addons: selectedAddons.join(","), // Convert addons array to comma-separated string
                instruction: specialInstruction,
                price: totalPrice,
            };

            const response = await fetch("../controller/add_to_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data), // Send data as JSON string
            });

            const result = await response.json(); // Parse JSON response from the server
            if (result.status === "success") {
                alert("Item added to cart successfully!");
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error("Error adding to cart:", error);
            alert("An error occurred. Please try again.");
        }
    });

    updateTotalPrice();
});
