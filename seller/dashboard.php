<?php
include 'connect.php';
session_start();


$isSellerSUPP = isset($_SESSION['adm_id']) && $_SESSION['adm_co'] === 'SUPP';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <!-- Boxicons CDN Link for icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet' />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
</head>
<body>
    <div class="sidebar close">
        <?php include "sidebar.php"; ?>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Dashboard</span>
            <?php if ($isSellerSUPP): ?>
                <form action="seller_bindtg.php" method="post" style="display: inline-block;">
                    <button type="submit" name="bindTelegram">Bind Telegram</button>
                </form>
            <?php endif; ?>
        </div>



        <div class="dashboard">
            <div class="card">
                    <h3>Monthly Income</h3>
                    <?php
                    $queryCurrentMonth = "SELECT SUM(total_amount) AS total_current_month FROM orders WHERE order_status = 3 AND order_date LIKE '" . date("Y-m-") . "%' AND orders.order_belong = '" . $_SESSION['store'] . "'";
                    $resultCurrentMonth = mysqli_query($db, $queryCurrentMonth);
                    $rowCurrentMonth = mysqli_fetch_assoc($resultCurrentMonth);
                    $totalCurrentMonth = ($rowCurrentMonth['total_current_month'] !== null) ? $rowCurrentMonth['total_current_month'] : 0;

                    ?>
                    <p>RM <?php echo $totalCurrentMonth; ?></p>
            </div>

            <div class="card">
                    <h3>Total Orders</h3>
                    <?php
                    // Query to get the total amount of orders for the current month
                    $queryCurrentMonth = "SELECT COUNT(order_id) AS total_current_month FROM orders WHERE order_date like '" . date("Y-m-") . "%' AND orders.order_belong = '" . $_SESSION['store'] . "'";
                    $resultCurrentMonth = mysqli_query($db, $queryCurrentMonth);
                    $rowCurrentMonth = mysqli_fetch_assoc($resultCurrentMonth);
                    $totalCurrentMonth = $rowCurrentMonth['total_current_month'];


                    ?>
                    <p><?php echo $totalCurrentMonth; ?></p>
            </div>

            <div class="card">
                <h3>Total Products</h3>
                <?php
                // Query to get the total amount of orders for the current month
                $queryCurrentMonth = "SELECT COUNT(product_id) AS total_current_month FROM product WHERE product_date like '" . date("Y-m-") . "%' AND product.owner = '" . $_SESSION['store'] . "'";
                $resultCurrentMonth = mysqli_query($db, $queryCurrentMonth);
                $rowCurrentMonth = mysqli_fetch_assoc($resultCurrentMonth);
                $totalCurrentMonth = $rowCurrentMonth['total_current_month'];


                ?>
                <p><?php echo $totalCurrentMonth; ?></p>
            </div>
            <div class='card'>
           		<h3>Employee Active</h3>
				<?php
                // Query to get the total amount of orders for the current month
                $queryEmployee = "SELECT COUNT(empNo) AS total_emp FROM tblemployee WHERE empstatus = '1' AND empstore = '" . $_SESSION['store'] . "'";
                $resultEmployee = mysqli_query($db, $queryEmployee);
                $rowEmployee = mysqli_fetch_assoc($resultEmployee);
                $totalEmployee = $rowEmployee['total_emp'];
                ?>
           		<p><?php echo $totalEmployee; ?></p>
           </div>


          
    <div class="sales-graph">
        <canvas id="salesChart"></canvas>
    </div>
    <?php
        // Perform the SQL query to get the total sales over time
        $sql_total_sales = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS order_month, SUM(p.proPrice * oi.quantity) AS total_sales
                            FROM order_item oi
                            INNER JOIN tblprice p ON oi.priceID = p.priceNo
                            INNER JOIN product pr ON p.productID = pr.product_id
                            INNER JOIN orders o ON oi.order_id = o.order_id
                            WHERE pr.owner = '".$_SESSION['store']."'
                            GROUP BY DATE_FORMAT(order_date, '%Y-%m') 
                            ORDER BY order_date";

        $result_total_sales = mysqli_query($db, $sql_total_sales);

        // Initialize an array to hold the sales data for each month
        $data_total_sales = array_fill_keys(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], 0);

        // Fetch total sales data into the array
        while ($row_sales = mysqli_fetch_assoc($result_total_sales)) {
            $month = date('F', strtotime($row_sales['order_month']));
            $data_total_sales[$month] = $row_sales['total_sales'];
        }
    ?>

            <div class="multiFunction">
                <div class="calendar">
                    <h3>Calendar</h3>
                    <h2 id="day"></h2>
                    <p id="month"></p>
                </div>

                <div class="rating">
					<h3>Store Rating</h3>
					
                    <?php
                // Query to get the total amount of orders for the current month
                $queryRating = "SELECT ROUND(AVG(rating), 1) AS average_rating FROM user_ratings WHERE res_id ='" . $_SESSION['store'] . "'";
                $resultRating = mysqli_query($db, $queryRating);
                $rowRating = mysqli_fetch_assoc($resultRating);
                $totalRating = $rowRating['average_rating'];
                ?>
           		<h1 style="text-align: center;"><?php echo $totalRating; ?></h1>
                
                <div class="rating-box" id="ratingBox">
						<!-- Stars will be dynamically added here -->
					</div>
				</div>


            </div>
        </div>


    </section>

    <script>
		$(document).ready(function() {
			createStars(4);
		});
		
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        let logoImage = document.getElementById("logo");
        let logoName = document.getElementById("logo_name");
        logoName.hidden = true;
        let initialSize = { width: 80, height: 80 };
        logoImage.width = initialSize.width;
        logoImage.height = initialSize.height;
        // Hide the logo name initially
        logoName.style.opacity = 0;

        // Function to show the logo name with a delay
        function showLogoName() {
            logoName.style.opacity = 1;
        }

        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            if (sidebar.classList.contains("close")) {
                // Sidebar is closed
                logoImage.width = initialSize.width;
                logoImage.height = initialSize.height;
                logoName.hidden = true;
            } else {
                // Sidebar is open
                // Adjust the logo size as needed
                logoImage.width = 120; // Increase the width to 120 when the sidebar is open
                logoImage.height = 120; // Increase the height to 120 when the sidebar is open
                logoName.hidden = false;
                setTimeout(showLogoName, 200);
            }
        });

        let currentDate = new Date();

        // // Array of month names for display
        const monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
        document.getElementById("day").textContent = currentDate.getDate();
        // // Update the content of the element with the ID "date" with the formatted date
        document.getElementById("month").textContent = monthNames[currentDate.getMonth()];



        // document.addEventListener('DOMContentLoaded', function () {
        //     var ctx = document.getElementById('salesChart').getContext('2d');
        //     var salesChart = new Chart(ctx, {
        //         type: 'bar',
        //         data: {
        //             labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        //             datasets: [{
        //                 label: 'Sales Amount (RM)',
        //                 data: [
        //                     <?php echo 1200; ?>,
        //                     <?php echo 1800; ?>,
        //                     <?php echo $data['March']; ?>,
        //                     <?php echo $data['April']; ?>,
        //                     <?php echo $data['May']; ?>,
        //                     <?php echo $data['June']; ?>,
        //                     <?php echo $data['July']; ?>,
        //                     <?php echo $data['August']; ?>,
        //                     <?php echo $data['September']; ?>,
        //                     <?php echo $data['October']; ?>,
        //                     <?php echo $data['November']; ?>,
        //                     <?php echo $data['December']; ?>
        //                 ],
        //                 backgroundColor: [
        //                     'rgba(255, 99, 132, 0.2)',
        //                     'rgba(54, 162, 235, 0.2)',
        //                     'rgba(255, 206, 86, 0.2)',
        //                     'rgba(75, 192, 192, 0.2)',
        //                     'rgba(153, 102, 255, 0.2)',
        //                     'rgba(255, 159, 64, 0.2)',
        //                     'rgba(255, 99, 132, 0.2)',
        //                     'rgba(54, 162, 235, 0.2)',
        //                     'rgba(255, 206, 86, 0.2)',
        //                     'rgba(75, 192, 192, 0.2)',
        //                     'rgba(153, 102, 255, 0.2)',
        //                     'rgba(255, 159, 64, 0.2)'
        //                 ],
        //                 borderColor: [
        //                     'rgba(255, 99, 132, 1)',
        //                     'rgba(54, 162, 235, 1)',
        //                     'rgba(255, 206, 86, 1)',
        //                     'rgba(75, 192, 192, 1)',
        //                     'rgba(153, 102, 255, 1)',
        //                     'rgba(255, 159, 64, 1)',
        //                     'rgba(255, 99, 132, 1)',
        //                     'rgba(54, 162, 235, 1)',
        //                     'rgba(255, 206, 86, 1)',
        //                     'rgba(75, 192, 192, 1)',
        //                     'rgba(153, 102, 255, 1)',
        //                     'rgba(255, 159, 64, 1)'
        //                 ],
        //                 borderWidth: 1
        //             }]
        //         },
        //         options: {
        //             plugins: {
        //                 datalabels: {
        //                     color: '#fff', // Color of data labels
        //                     anchor: 'end',
        //                     align: 'top',
        //                     formatter: function (value, context) {
        //                         return value + ' RM';
        //                     }
        //                 }
        //             },
        //             scales: {
        //                 y: {
        //                     beginAtZero: true
        //                 }
        //             }
        //         }
        //     });
        // });
		
        document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('salesChart').getContext('2d');

        // Retrieve the dynamic PHP data for sales
        var salesData = [
            <?php echo implode(',', $data_total_sales); ?>
        ];

        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Sales Amount (RM)',
                    data: salesData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#fff', // Color of data labels
                        anchor: 'end',
                        align: 'top',
                        formatter: function (value, context) {
                            return value + ' RM';
                        }
                    }
                },
                scales: {
                    x: {
                    type: 'category', 
                    display: true,
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Months',
                        color: 'black',
                        font: {
                            family: 'Comic Sans MS',
                            size: 20,
                            weight: 'bold',
                            lineHeight: 1.2,
                        },
                        padding: { top: 30, left: 0, right: 0, bottom: 50 }
                    }
                },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Total Sales',
                            color: 'black',
                            font: {
                                family: 'Comic Sans MS',
                                size: 20,
                                weight: 'bold',
                                lineHeight: 1.2,
                            },
                            padding: { top: 30, left: 0, right: 0, bottom: 50 }
                        }
                    }
                }
            }
        });
    });

		function createStars(rating) {
			const ratingBox = document.getElementById('ratingBox');
			ratingBox.innerHTML = ''; // Clear previous stars

			const roundedRating = Math.round(rating * 2) / 2; // Round rating to nearest 0.5
			const numFullStars = Math.floor(roundedRating);
			const hasHalfStar = roundedRating - numFullStars === 0.5;

			for (let i = 0; i < numFullStars; i++) {
				const star = document.createElement('div');
				star.className = 'star';
				ratingBox.appendChild(star);
			}

			if (hasHalfStar) {
				const halfStar = document.createElement('div');
				halfStar.className = 'star half-star';
				ratingBox.appendChild(halfStar);
			}
		}

		

    </script>
</body>
</html>