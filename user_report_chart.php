<?php
require 'config.php';

try {
    // Fetch user registration data
    $stmt = $pdo->prepare("
        SELECT 
            DATE(created_at) as registration_date,
            COUNT(*) as total_users
        FROM 
            users
        WHERE 
            users.role !='admin'
        GROUP BY 
            DATE(created_at)
        ORDER BY 
            registration_date ASC;
        
    ");
    $stmt->execute();
    $registrationData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
<script>
    const userRegistrationData = <?php echo json_encode($registrationData); ?>;
    document.addEventListener("DOMContentLoaded", () => {
        const categories = userRegistrationData.map(item => item.registration_date);
        const seriesData = userRegistrationData.map(item => parseInt(item.total_users));

        new ApexCharts(document.querySelector("#reportsChart"), {
            series: [{
                name: 'Registrations',
                data: seriesData
            }],
            chart: {
                height: 350,
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                type: 'datetime',
                categories: categories,
                title: {
                text: 'Date of Registrations'
              }
            },
            yaxis: {
            //   min: 0, // Ensures the y-axis starts from 0
              title: {
                text: 'Number of Registrations'
              }
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yyyy'
                }
            }
        }).render();
    });
</script>
