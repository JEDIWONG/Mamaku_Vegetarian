
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link type="image/svg" rel="icon" href="../../assets/images/Logo.svg">
        <link rel="stylesheet" href="../../style/admin/header.css">
        <link rel="stylesheet" href="../../style/admin/footer.css">
        <link rel="stylesheet" type="text/css" href="../../style/admin/dashboard.css">
        <script src="../../script/function.js"></script>
        <title>Admin Dashboard</title>
    </head>
    <body>

    <?php include "../../include/admin/sidebar.php"; ?>



        <!--content of dashboard -->
        <div class="dashboard-content">
            <div class="top-dashboard">
                <h5>Dashboard</h5>
            </div>
        
        

            <section class="admin-dashboard">
                <h1>Monthly Sales Trends</h1>
                <canvas id="salesTrendChart" width="400" height="200"></canvas>
            </section>
            
            <script>
                // Fetch and render Sales Trends chart
                fetch('../../controller/get_sales_trends.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const labels = data.data.map(item => item.month_name);
                            const sales = data.data.map(item => item.total_sales);

                            const ctx = document.getElementById('salesTrendChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Total Sales',
                                        data: sales,
                                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: { position: 'top' }
                                    }
                                }
                            });
                        }
                    })
                    .catch(err => console.error('Error fetching Sales Trends data:', err));
            </script>

        </div>

        

    </body>
</html>
