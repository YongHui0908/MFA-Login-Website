<?php
require 'config.php';

try {
    // Fetch course-wise user count, excluding 'admin' role
    $stmt = $pdo->prepare("
        SELECT 
            user_details.course AS course_name,
            COUNT(users.id) AS user_count
        FROM 
            users
        JOIN 
            user_details ON users.id = user_details.user_id
        WHERE 
            users.role != 'admin'
        GROUP BY 
            user_details.course
        ORDER BY 
            user_count DESC;
    ");
    $stmt->execute();
    $courseData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Simulated course data from backend (replace this with dynamic PHP rendering)
  const courseData = <?php echo json_encode($courseData); ?>;

  // Prepare data for the chart
  const labels = courseData.map(item => item.course_name); // Course names
  const data = courseData.map(item => item.user_count);    // User counts

  // Chart colors (automatically assigned or customized)
  const colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];

  // Initialize the chart
  const chart = echarts.init(document.querySelector("#courseChart"));
  chart.setOption({
    tooltip: {
      trigger: 'item',
      formatter: '{a} <br/>{b}: {c} ({d}%)' // Show course name, user count, and percentage
    },
    legend: {
      orient: 'vertical',
      left: 'left',
      // top: '10%',
      data: labels // List courses in the legend
    },
    series: [{
      name: 'Courses',
      type: 'pie',
      top: '20%',
      radius: ['40%', '70%'],
      avoidLabelOverlap: false,
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: true,
          fontSize: '14',
          fontWeight: 'bold',
          formatter: '{b}\n{c} Users' // Highlighted label on hover
        }
      },
      labelLine: {
        show: false
      },
      data: labels.map((label, index) => ({
        value: data[index],
        name: label,
        itemStyle: { color: colors[index % colors.length] } // Assign color to each slice
      }))
    }]
  });
});
</script>