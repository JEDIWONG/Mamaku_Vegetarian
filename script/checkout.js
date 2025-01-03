document.addEventListener("DOMContentLoaded", () => {
    const checkoutCashlessContainer = document.querySelector(".checkout-cashless-container");
    const paymentMethods = document.querySelectorAll(".checkout-method .method");
    const cashlessMethods = document.querySelectorAll(".checkout-cashless-list .method");
    const nextButton = document.querySelector(".checkout-price-bar button");

    // Variables to track selected methods
    let selectedPaymentMethod = null;
    let selectedCashlessMethod = null;

    // Initially hide the cashless container
    checkoutCashlessContainer.style.display = "none";

    // Add event listeners to payment methods
    paymentMethods.forEach((method) => {
        method.addEventListener("click", () => {
            const methodName = method.querySelector("p").textContent.trim();
            selectedPaymentMethod = methodName;

            // Reset background color for all methods
            paymentMethods.forEach((m) => {
                m.style.backgroundColor = ""; // Reset background color
            });

            cashlessMethods.forEach((m) => {
                m.style.backgroundColor = ""; // Reset background color
            });

            // Set background color for the selected method
            method.style.backgroundColor = "#e0ffe0"; // Light green for selected

            if (methodName === "Cashless") {
                // Show the cashless container with flex display
                checkoutCashlessContainer.style.display = "flex";
                checkoutCashlessContainer.style.flexDirection = "column";
            } else {
                // Hide the cashless container for other methods
                checkoutCashlessContainer.style.display = "none";
                selectedCashlessMethod = null; // Reset cashless method if cash is selected
            }
        });
    });

    // Add event listeners to cashless methods
    cashlessMethods.forEach((method) => {
        method.addEventListener("click", () => {
            const methodName = method.querySelector("p").textContent.trim();
            selectedCashlessMethod = methodName;

            // Reset background color for all cashless methods
            cashlessMethods.forEach((m) => {
                m.style.backgroundColor = ""; // Reset background color
            });

            // Set background color for the selected method
            method.style.backgroundColor = "#e0ffe0"; // Light green for selected
        });
    });

    nextButton.addEventListener("click", () => {
        if (!selectedPaymentMethod) {
            alert("Please select a payment method.");
            return;
        }

        if (selectedPaymentMethod === "Cashless" && !selectedCashlessMethod) {
            alert("Please select a cashless payment method.");
            return;
        }

        // Proceed to the backend for checkout
        proceedToCheckout(selectedPaymentMethod, selectedCashlessMethod || null);
    });

    async function proceedToCheckout(paymentMethod, cashlessMethod) {
        try {
            const response = await fetch("../controller/checkout.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    payment_method: paymentMethod,
                    cashless_method: cashlessMethod, // Null if "Cash" is selected
                }),
            });

            const result = await response.json();
            if (result.status === "success") {
                alert("Checkout successful!");
                if (paymentMethod === "Cash") {
                    window.location.href = "../view/cash_result.php";
                } else {
                    window.location.href = "../view/result.php";
                }
            } else {
                alert(result.message || "Checkout failed. Please try again.");
            }
        } catch (error) {
            console.error("Error during checkout:", error);
            alert("An error occurred. Please try again.");
        }
    }
});
