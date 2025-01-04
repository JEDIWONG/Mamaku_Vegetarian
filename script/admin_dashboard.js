// Fetch and render Sales Trends chart
fetch('../../controller/get_sales_trends.php') // Update to correct API endpoint
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const labels = data.data.map(item => item.month_name); // Extract month names
            const sales = data.data.map(item => item.total_sales); // Extract total sales

            const ctx = document.getElementById('salesTrendChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Sales (RM)',
                        data: sales,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Light green background
                        borderColor: 'rgba(75, 192, 192, 1)', // Dark green border
                        borderWidth: 2,
                        tension: 0.3, // Smooth curves
                        fill: true // Fill under the line
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales (RM)'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        } else {
            console.error('Error fetching data:', data.error);
        }
    })
    .catch(err => console.error('Error fetching Sales Trends data:', err));