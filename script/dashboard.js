document.addEventListener("DOMContentLoaded", () => {
    const orderCount = document.querySelector(".order-count");
    const menuCards = document.querySelectorAll(".menu-card");

    // Initial data
    const dashboardData = {
        orders: {
            count: 6,
            period: "Last 7 Days"
        },
        menus: [
            {
                title: "Your Favourite Menu",
                name: "Fried Enoki Mushroom",
                lastUpdated: "4 minutes ago",
                imageUrl: "../assets/images/fried_enoki_mushroom.png"
            },
            {
                title: "Top Selling Menu",
                name: "Fried Enoki Mushroom",
                lastUpdated: "4 minutes ago",
                imageUrl: "../assets/images/fried_enoki_mushroom.png"
            }
        ]
    };

    function updateDashboard() {
        // Update order count
        orderCount.textContent = dashboardData.orders.count;

        // Update menu cards
        menuCards.forEach((card, index) => {
            const menuData = dashboardData.menus[index];
            if (menuData) {
                const menuImage = card.querySelector("img:not([src*='clock'])");
                const menuName = card.querySelector(".menu-name");
                const updateTime = card.querySelector(".update-info span");

                menuImage.src = menuData.imageUrl;
                menuImage.alt = menuData.name;
                menuName.textContent = menuData.name;
                updateTime.textContent = `updated ${menuData.lastUpdated}`;
            }
        });
    }

    // Initial update
    updateDashboard();
});