<?php include 'connect.php'; ?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="style.css">
    <!-- Boxiocns CDN Link -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  
   </head>
	
<body>
  <div class="sidebar close">
    <?php include "sidebar.php"; ?>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Orders</span>
    </div>
	  
	  <div class="empMainCon">
		  <div style="text-align: right; margin-bottom: 10px">
		  	<button id="popupButton" onclick="openPopup(1)" class="save-button">+Add Order</button>
		  </div>
		  
		   	<div class="controls-container">
		  		<div class="records-per-page">
					<span>Records per page:</span>
					<select id="recordsPerPage" onchange="changeRecordsPerPage()" class="custom-select">
					  <option value="5">5</option>
					  <option value="10">10</option>
					  <option value="50">50</option>
					</select>
				  </div>
		  	<div class="search-bar">
				<span>Search:</span>
				<input type="text" id="searchInput" onkeyup="fetchData()" placeholder="Search for names..">
		  	</div>
		  </div>

    <div class="table-container">
	  <table id="myTable">
		<thead>
		  <tr>
			<th onclick="sortTable(0)">Order ID# <span class="sort-indicator" id="indicator0"></span></th>
			<th onclick="sortTable(1)">Name <span class="sort-indicator" id="indicator1"></span></th>
			<th onclick="sortTable(2)">Contact Number <span class="sort-indicator" id="indicator2"></span></th>
			<th onclick="sortTable(3)">Order Date <span class="sort-indicator" id="indicator3"></span></th>
			<th onclick="sortTable(4)">Payment Type <span class="sort-indicator" id="indicator3"></span></th>
			<th onclick="sortTable(5)">Status <span class="sort-indicator" id="indicator4"></span></th>
			<th onclick="sortTable(6)">Action <span class="sort-indicator" id="indicator5"></span></th>

		  </tr>
		</thead>
		<tbody id="tableBody">
		  <!-- Table content goes here -->
		</tbody>
	  </table>
	</div>


    <div class="pagination-summary">
      <span id="tableSummary"></span>
      <div class="pagination">
		  
      </div>
    </div>
	  </div>
	  
      <div id="popupWindow" class="popup">
    <div class="popup-content">
        <div class="xclose">
            <span class="close" onclick="closePopup()">&times;</span>
        </div>
        
        <form action="action/infoOrder.php" method="POST" class="myform" name="myForm" id="myForm">
			<input type="hidden" id="storeid" name="storeid" value="<?php echo $_SESSION['store'] ?>">
			<div class="myform-row">
				<div id="divalert" class="divalert" name="divalert"></div>
			</div>
				
			<div class="myform-row">
				<div class="label">
					<label for="ordDate" class="myform-label">ORDER DATE#</label>
				</div>
				<div class="input">
					<span><?php echo date("Y-m-d"); ?></span>
				</div>
			</div>
			
			<div class="myform-row">
				<div class="label">
					<label for="ordNum" class="myform-label">CONTACT NUMBER</label>
				</div>
				<div class="input">
					<input type="text" id="ordNum" name="ordNum" class="myform-input" onKeyUp="fetchCustName()">
				</div>
			</div>

			<div class="myform-row">
				<div class="label">
					<label for="ordName" class="myform-label">CLIENT NAME</label>
				</div>
				<div class="input">
					<input type="text" id="ordName" name="ordName" class="myform-input">
					<input type="hidden" id="ordUID" name="ordUID">
					<input type="hidden" id="ordOID" name="ordOID">
				</div>
			</div>
				
			<div style="width: 100%; text-align: center; border: 1px solid #000">
				<table id="itemTable" style="border: none; width: 95%; margin: 0 auto;">
					<tr style="text-align: left">
						<th>Product</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total Price</th>
					</tr>
					<tbody id="proSelected">
						<!-- Table rows will be dynamically added here -->
					</tbody>
					<tr>
						<td colspan="3" style="text-align: right; border-top: : 1px solid #000">Total Amount:</td>
						<td>
							<span id="txtTotal">0.00</span>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: center; border: none">
							<input type="button" id="btnSelect" class="button" onClick="showProductInfoPopup()" value="Select">
						</td>
					</tr>
				</table>
			</div>
				
			<div class="myform-row">
				<div class="label">
					<label for="ordDate" class="myform-label">Payment Type</label>
				</div>
				<div class="input">
					<select id="ordType" name="ordType" class="custom-select" required>
						<option value="1" value="1">COD</option>
						<option value="2" value="2">Monthly Statement</option>
					</select>
				</div>
			</div>
            <div class="myform-row">
                <div class="label">
					<label for="ordDate" class="myform-label">Status : </label>
				</div>
                <div class="input">
                    <span name="orderStatus" class="myform-text"></span>
                </div>
			</div>
           
				<div style="text-align: center;">
					<input type="button" id="addOrder" class="button" value="Add Order" onClick="infoOrder('add', this.form)">
					<!-- <input type="button" id="editOrder" class="button" value="Save Change" style="background-color: lightgreen;" onClick="orderInfo('edit', this.form)"> -->
					<input type="button" id="delOrder" class="button" value="Delete Order" style="background-color: lightcoral;" onClick="confirmDeleteOrder(this.form)">
				</div>
    </form>
        <!-- Your existing form content -->
        <form action="action/infoOrder.php" method="POST" class="myform" name="myForm" id="myForm">
            <!-- Rest of your form content -->
        </form>
    </div>
</div>



<div id="productInfo" class="popup">
    <div class="popup-content">
        <div class="xclose">
            <span class="close" onclick="hideProductInfoPopup()">&times;</span>
        </div>
        <div>
            <form method="GET" action="action/fetchProduct.php" id="proForm">
                <span>Search: <input type="text" id="searchProText" onkeyup="searchSpecific()"></span>
                <div id="showProduct" style="text-align: center; margin-top: 10px;"></div>
            </form>
        </div>
    </div>
</div>


	  
  </section>
  
</body>
</html>
<script src="scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function() {
	$('#divalert').hide();	
	fetchData();
	
	
});
	
function infoOrder(act, form) {
    if ($("#ordNum").val() == "" || $("#ordName").val() == "" || $("#ordDlvFee").val() == "" || $("#ordDep").val() == "" && act != "del") {
        $('#divalert').css('background-color', 'red');
        $('#divalert').text('All Text Fields Must Not Be Empty');
        $('#divalert').show();
        setTimeout(function() {
            $('#divalert').hide();
        }, 3000);
    } else if ($("#ordUID").val() == "" && act != "del") {
        $('#divalert').css('background-color', 'red');
        $('#divalert').text('Customer Not Found');
        $('#divalert').show();
        setTimeout(function() {
            $('#divalert').hide();
        }, 3000);
    } else if (selectedIds.length === 0 && act != "del") { // Check if no products are selected
        $('#divalert').css('background-color', 'red');
        $('#divalert').text('No Product Selected');
        $('#divalert').show();
        setTimeout(function() {
            $('#divalert').hide();
        }, 3000);
    } else {

        $.ajax({
            url: $(form).attr('action'), // The script to call to add data
            type: $(form).attr('method'),
            data: {
                act: act,
                data: $("#myForm").serialize()
            },
            success: function(response) {
                alert(response);
                fetchData();
                closePopup();
                $("#myForm")[0].reset();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + error);
            }
        })
    }
}

// Define a global variable to store selected item IDs
var selectedIds = [];
var quantities = [];

function searchSpecific() {
    var product = $("#searchProText").val();
    var form = $("#proForm");

    if (product == "") {

    } else {
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: { search: product },
            success: function (response) {
                var products = JSON.parse(response);
                var htmlContent = '<table style="text-align: center; margin: 0 auto; border: none;">';

                var counter = 0;
                products.forEach(function (product, index) {
                    if (counter % 3 == 0) {
                        htmlContent += '<tr>';
                    }
                    htmlContent += '<td style="padding: 10px;">';
                    htmlContent += '<table style="border: none;">';
                    htmlContent += '<tr><td rowspan="2" colspan="2">' + product.productImage + '</td>';
                    htmlContent += '<td>' + product.productCode + '</td></tr>';
                    htmlContent += '<tr><td>' + product.productName + '</td></tr>';
                    product.prices.forEach(function (priceWeight) {
                        htmlContent += '<tr>';
                        htmlContent += '<td><input type="checkbox" id="' + priceWeight.priceNo + '"';
                        // Check if the checkbox should be checked based on selectedIds
                        if (selectedIds.includes(priceWeight.priceNo)) {
                            htmlContent += ' checked';
                        }
                        htmlContent += ' onchange="updateSelectedIds(this)"'; // Add onchange event
                        htmlContent += '></td>';
                        htmlContent += '<td>' + priceWeight.proWeight + '</td>';
                        htmlContent += '<td>' + priceWeight.proPrice + '</td>';
                        htmlContent += '</tr>';
                    });
                    htmlContent += '</table>';
                    htmlContent += '</td>';

                    if ((counter + 1) % 3 == 0) {
                        htmlContent += '</tr>';
                    }
                    ++counter;
                });

                htmlContent += '</table>';
                htmlContent += '<div style="text-align: center;"><input type="button" id="btnProSelected" class="button" value="Finish selected"></div>';

                $('#showProduct').html(htmlContent);

                // Remove previous click event handler to avoid multiple bindings
                $('#btnProSelected').off('click').on('click', function () {
                    if (selectedIds.length > 0) {
                        fetchProductDetails(selectedIds);
                        document.getElementById('productInfo').style.display = "none";
                    } else {
                        $('#proSelected').html('');
                        document.getElementById('productInfo').style.display = "none";
                        $("#txtTotal").text("0.00");
                    }
                });
            },
            error: function (xhr, status, error) {

            }
        });
    }
}

// Function to update selectedIds array when checkbox state changes
function updateSelectedIds(checkbox) {
    var id = checkbox.id;
    if (checkbox.checked) {
        // Add id to selectedIds array if checked
        if (!selectedIds.includes(id)) {
            selectedIds.push(id);
        }
    } else {
        // Remove id from selectedIds array if unchecked
        var index = selectedIds.indexOf(id);
        if (index !== -1) {
            selectedIds.splice(index, 1);
        }
    }
}// Define a global variable to store selected item IDs
var selectedIds = [];
var quantities = [];

function searchSpecific() {
    var product = $("#searchProText").val();
    var form = $("#proForm");

    if (product == "") {
        return;
    } else {
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: { search: product },
            success: function (response) {
                var products = JSON.parse(response);
                var htmlContent = '<table style="text-align: center; margin: 0 auto; border: none;">';

                var counter = 0;
                products.forEach(function (product, index) {
                    if (counter % 3 == 0) {
                        htmlContent += '<tr>';
                    }
                    htmlContent += '<td style="padding: 10px;">';
                    htmlContent += '<table style="border: none;">';
                    htmlContent += '<tr><td rowspan="2" colspan="2">' + product.productImage + '</td>';
                    htmlContent += '<td>' + product.productCode + '</td></tr>';
                    htmlContent += '<tr><td>' + product.productName + '</td></tr>';
                    product.prices.forEach(function (priceWeight) {
                        htmlContent += '<tr>';
                        htmlContent += '<td><input type="checkbox" id="' + priceWeight.priceNo + '"';
                        // Check if the checkbox should be checked based on selectedIds
                        if (selectedIds.includes(priceWeight.priceNo)) {
                            htmlContent += ' checked';
                        }
                        htmlContent += ' onchange="updateSelectedIds(this)"'; // Add onchange event
                        htmlContent += '></td>';
                        htmlContent += '<td>' + priceWeight.proWeight + '</td>';
                        htmlContent += '<td>' + priceWeight.proPrice + '</td>';
                        htmlContent += '</tr>';
                    });
                    htmlContent += '</table>';
                    htmlContent += '</td>';

                    if ((counter + 1) % 3 == 0) {
                        htmlContent += '</tr>';
                    }
                    ++counter;
                });

                htmlContent += '</table>';
                htmlContent += '<div style="text-align: center;"><input type="button" id="btnProSelected" class="button" value="Finish selected"></div>';

                $('#showProduct').html(htmlContent);

                // Remove previous click event handler to avoid multiple bindings
                $('#btnProSelected').off('click').on('click', function () {
                    if (selectedIds.length > 0) {
                        fetchProductDetails(selectedIds);
                        document.getElementById('productInfo').style.display = "none";
                    } else {
                        $('#proSelected').html('');
                        document.getElementById('productInfo').style.display = "none";
                        $("#txtTotal").text("0.00");
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
}

// Function to update selectedIds array when checkbox state changes
function updateSelectedIds(checkbox) {
    var id = checkbox.id;
    if (checkbox.checked) {
        // Add id to selectedIds array if checked
        if (!selectedIds.includes(id)) {
            selectedIds.push(id);
        }
    } else {
        // Remove id from selectedIds array if unchecked
        var index = selectedIds.indexOf(id);
        if (index !== -1) {
            selectedIds.splice(index, 1);
        }
    }

    // Update display
    displaySelectedIds();
}


// JavaScript function to send data to fetchSpecificProduct.php
function fetchProductDetails(priceId) {
    // Store current quantity values before fetching new products
    var quantities = {};
    $('.quantityInput').each(function() {
        var productId = $(this).closest('tr').find('.productName input').val();
        var quantity = $(this).val();
        quantities[productId] = quantity;
    });

    $.ajax({
        url: 'action/fetchSpecificProduct.php', // Replace with the actual URL
        type: 'POST', // You may use GET or POST based on your server-side code
        data: { priceId: priceId },
        success: function (response) {
            var firstTotal = 0.00;
            // Parse the JSON string to a JavaScript object
            var products = JSON.parse(response);
            $('#proSelected').empty();

            // Iterate over each product in the array and add it as a row in the "proSelected" table
            products.forEach(function (product) {
                // Extract product details
                var productId = product.priceID;
                var productName = product.productName;
                var productPrice = parseFloat(product.productPrice); // Parse the price as a float
                var totalPrice = 0;

                // Create a new table row for the product
                var newRowHtml = '<tr>' +
                    '<td class="productName"><input type="hidden" value="' + productId + '" name="proID[]">' + productName + '</td>' +
                    '<td class="productPrice"><input type="hidden" value="' + productPrice + '" name="proPrice[]">' + productPrice.toFixed(2) + '</td>' + // Display price with 2 decimal places
                    '<td><input type="number" class="quantityInput" data-product-price="' + productPrice + '" value="' + (quantities[productId] || 1) + '" name="quan[]"></td>' +
                    '<td class="totalPrice">' + (productPrice * (quantities[productId] || 1)).toFixed(2) + '</td>' + // Initial total price is the product of price and quantity
                    '</tr>';

                // Append the new row to the "proSelected" table
                $("#proSelected").append(newRowHtml);
                firstTotal += parseFloat((productPrice * (quantities[productId] || 1)).toFixed(2));
            });
            $('#txtTotal').text(parseFloat(firstTotal).toFixed(2));

            // Attach a change event listener to each quantity input
            $('.quantityInput').on('input', function () {
                // Calculate the total price based on the selected quantity
                var quantity = $(this).val();
                var productPrice = parseFloat($(this).closest('tr').find('.productPrice input').val()); // Get product price from hidden input
                var total = quantity * productPrice;
                $(this).closest('tr').find('.totalPrice').text(total.toFixed(2));

                // Update the total price in the corresponding row with 2 decimal places
                updateTotalPrice();
            });

        },
        error: function (xhr, status, error) {
            // Handle errors
        }
    });
}

// Function to update the total price based on the quantity changes and remove items with quantity less than 1
function updateTotalPrice() {
    var total = 0.00;
    $('.quantityInput').each(function () {
        var quantity = parseFloat($(this).val());
        var productId = $(this).closest('tr').find('.productName input').val();
        var productPrice = parseFloat($(this).closest('tr').find('.productPrice input').val()); // Get product price from hidden input
        if (quantity < 1) {
            // Remove the item from selectedIds array if quantity is less than 1
            var index = selectedIds.indexOf(productId);
            if (index !== -1) {
                selectedIds.splice(index, 1);
            }
            // Uncheck the checkbox
            $('#' + productId).prop('checked', false);
            // Remove the row from the table
            $(this).closest('tr').remove();
        } else {
            var subtotal = quantity * productPrice;
            $(this).closest('tr').find('.totalPrice').text(subtotal.toFixed(2));
            total += subtotal;
        }
    });
    $('#txtTotal').text(total.toFixed(2));
}
// Attach a change event listener to each quantity input
$('.quantityInput').on('input', function () {
    // Update the quantity in the selectedIds array
    var productId = $(this).closest('tr').find('.productName input').val();
    var newQuantity = parseFloat($(this).val());
    var index = selectedIds.indexOf(productId);
    if (index !== -1) {
        selectedIds[index] = newQuantity;
    }

    // Calculate the total price based on the selected quantity
    var quantity = parseFloat($(this).val());
    var productPrice = parseFloat($(this).closest('tr').find('.productPrice input').val()); // Get product price from hidden input
    var total = quantity * productPrice;
    $(this).closest('tr').find('.totalPrice').text(total.toFixed(2));

    // Update the total price in the corresponding row with 2 decimal places
    updateTotalPrice();
});



// JavaScript function to update the HTML table row with product details
function updateProductRow(productDetails) {
    
}



function showProductInfoPopup() {
    var vegetableInfoPopup = document.getElementById("productInfo");
    vegetableInfoPopup.style.display = "block"; // Show the popup
}

// Function to hide the vegetable information popup
function hideProductInfoPopup() {
  var vegetableInfoPopup = document.getElementById("productInfo");
  vegetableInfoPopup.style.display = "none"; // Hide the popup
}
	
var recordsPerPage = parseInt(document.getElementById('recordsPerPage').value);
var currentPage = 1;

function updateTableAndPagination(data) {
	if (data.data.length === 0) {
        document.getElementById('tableBody').innerHTML = '<tr><td colspan="7" style="text-align: center;">NO ORDERS RECORD</td></tr>';
        document.getElementById('tableSummary').textContent = 'Showing 0-0 of 0 Records';
        document.querySelector('.pagination').innerHTML = ''; // Clear pagination controls
        return; // Exit function since there are no records to display
    }
    // Calculate the start and end indices based on the current page and records per page
    var startIndex = (currentPage - 1) * recordsPerPage;
    var endIndex = startIndex + recordsPerPage;

    // Clear existing table rows
    var tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';
    // Populate the table with the data for the current page
    for (var i = startIndex; i < endIndex && i < data.data.length; i++) {
        var rowData = data.data[i];
        var newRow = document.createElement('tr');
        newRow.innerHTML = '<td>' + rowData[0] + '</td>' +
            '<td>' + rowData[1] + '</td>' +
            '<td>' + rowData[2] + '</td>' +
            '<td>' + rowData[3] + '</td>' +
			'<td>' + rowData[4] + '</td>' +
            `<td style="color: ${(rowData[5] === '1') ? 'green' : 'red'};">${(rowData[5] === '1') ? 'Active' : 'Inactive'}</td>`+
			'<td><i class="icon fa fa-eye" id="btnView'+i+'" title="View" name="'+rowData[0]+'" onclick="viewRec('+i+')"></i><i class="icon fa fa-trash"id="btnDel'+i+'" title="Delete" name="'+rowData[0]+'" onclick="delRec('+i+')"></i></td>';
			//  '<td><i class="icon fa fa-eye" id="btnView'+i+'" title="View" name="'+rowData[0]+'" onclick="viewRec('+i+')"></i><i class="icon fa fa-edit" id="btnEdit'+i+'" title="Edit" name="'+rowData[0]+'" onclick="editRec('+i+')"></i><i class="icon fa fa-trash"id="btnDel'+i+'" title="Delete" name="'+rowData[0]+'" onclick="delRec('+i+')"></i></td>';
			// '<td><i class="icon fa fa-eye" id="btnView'+i+'" title="View" name="'+rowData[0]+'" onclick="viewRec('+i+')"></i><i class="icon fa fa-trash"id="btnDel'+i+'" title="Delete" name="'+rowData[0]+'" onclick="delRec('+i+')"></i></td>';
			// '<td><i class="icon fa fa-trash"id="btnDel'+i+'" title="Delete" name="'+rowData[0]+'" onclick="delRec('+i+')"></i></td>';



        tableBody.appendChild(newRow);
    }
    // Update the table summary
    var totalRecords = data.data.length;
    var startRecord = Math.min(startIndex + 1, totalRecords);
    var endRecord = Math.min(endIndex, totalRecords);
    document.getElementById('tableSummary').textContent = 'Showing ' + startRecord + '-' + endRecord + ' of ' + totalRecords + ' Records';

    // Calculate the total number of pages based on the selected records per page
    var totalPages = Math.ceil(totalRecords / recordsPerPage);
	
    // Update the pagination controls
    var paginationControls = document.querySelector('.pagination');
    paginationControls.innerHTML = '';

    if (currentPage > 1) {
        paginationControls.innerHTML += '<button onclick="previousPage()" class="btnPrevious">Previous</button>';
    }

    for (var i = 1; i <= totalPages; i++) {
        paginationControls.innerHTML += '<span class="page-link" onclick="goToPage(' + i + ')">' + i + '</span>';
    }

    if (currentPage < totalPages) {
        paginationControls.innerHTML += '<button onclick="nextPage('+totalRecords+')" class="btnNext">Next</button>';
    }
}

// Function to handle the "change" event of the "recordsPerPage" dropdown
function changeRecordsPerPage() {
    recordsPerPage = parseInt(document.getElementById('recordsPerPage').value);
    currentPage = 1; // Reset to the first page when changing records per page
    // Call fetchData to get the updated data and update the table
    fetchData();
}

// Function to navigate to the previous page
function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        fetchData();
    }
}

// Function to navigate to the next page
function nextPage(num) {
    var totalRecords = num; // Replace yourDataArray with your actual data array
    var totalPages = Math.ceil(totalRecords / recordsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        fetchData();
    }
}

// Function to navigate to a specific page
function goToPage(page) {
    currentPage = page;
    fetchData();
}


// Function to fetch and update data
function fetchData() {
    // Perform an AJAX request to fetch your data
    var search = "";
    search = document.getElementById("searchInput").value;
    $.ajax({
        url: 'action/fetchOrder.php',
        type: 'GET',
        dataType: 'json',
        data: { search: search },
        success: function(response) {
            updateTableAndPagination(response);
            updateStatusText(response.data);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Function to update status text
function updateStatusText(data) {
    var statusSpan = document.getElementsByName("orderStatus")[0];

    // Assuming status is always at the last index
    var statusValue = parseInt(data[data.length - 1][5]);

    // Map status numbers to status text
    var statusText = {
        1: "Preparing",
        2: "Packing",
        3: "Delivering",
        4: "Reject"
    };

    // Set the text content of the status span to the corresponding status text
    statusSpan.textContent = statusText[statusValue];
}

	
let currentColumn = -1;
let isAscending = true;

function sortTable(columnIndex) {
  const table = document.getElementById("myTable");
  const tbody = document.getElementById("tableBody");
  const rows = Array.from(tbody.rows);

  if (currentColumn === columnIndex) {
    isAscending = !isAscending;
  } else {
    isAscending = true;
    if (currentColumn !== -1) {
      document.getElementById("indicator" + currentColumn).classList.remove("asc", "desc");
    }
    currentColumn = columnIndex;
    document.getElementById("indicator" + currentColumn).classList.add("asc");
  }

  rows.sort((a, b) => {
    const aValue = a.cells[columnIndex].textContent.trim();
    const bValue = b.cells[columnIndex].textContent.trim();

    if (isAscending) {
      return aValue.localeCompare(bValue);
    } else {
      return bValue.localeCompare(aValue);
    }
  });

  tbody.innerHTML = "";
  rows.forEach((row) => tbody.appendChild(row));

  if (!isAscending) {
    document.getElementById("indicator" + currentColumn).classList.remove("asc");
    document.getElementById("indicator" + currentColumn).classList.add("desc");
  }
}
	
function findRec(windowType, name){
	$.ajax({
        url: 'action/fetchSpecificOrder.php',
        type: 'GET',
        dataType: 'json',
		data: {search:  name},
        success: function(response) {
			console.log(response);
			openPopup(windowType);
			document.getElementById("ordOID").value = response.data[0][0];
			$('#ordName').val(response.data[0][1]).prop('readonly',  windowType === 2);
			$('#ordNum').val(response.data[0][2]).prop('readonly',  windowType === 2);
             // Clear the existing table rows
            $('#proSelected').empty();

            // Iterate through the fetched data and append rows to the table
            $.each(response.data, function(index, item) {
                var htmlRow = '<tr>' +
                                '<td>' + item[3] + '</td>' + // Product name
                                '<td>' + item[5] + '</td>' + // Price
                                '<td>' + item[4] + '</td>' + // Quantity
                                '<td>' + (parseFloat(item[5]) * parseInt(item[4])) + '</td>' + // Total price
                            '</tr>';
                $('#proSelected').append(htmlRow);
            });
            // Calculate and display the total amount
            var totalAmount = 0;
                $('#proSelected').find('tr').each(function() {
                    var totalPrice = parseFloat($(this).find('td:eq(3)').text());
                    if (!isNaN(totalPrice)) {
                        totalAmount += totalPrice;
                    }
                });
                $('#txtTotal').text(totalAmount.toFixed(2));

            
			// Get the select element by its ID
			// var selectElement = document.getElementById("ordJob");

			// Loop through the options and select the one that matches the data
			// for (var i = 0; i < selectElement.options.length; i++) {
			//   if (selectElement.options[i].value === response.data[0][4]) {
			// 	selectElement.options[i].selected = true;
			// 	break; // Exit the loop once a match is found
			//   }
			// }	
			// Get the select element by its ID
			// var selectElement = document.getElementById("ordStatus");

			// // Loop through the options and select the one that matches the data
			// for (var i = 0; i < selectElement.options.length; i++) {
			//   if (selectElement.options[i].value === response.data[0][5]) {
			// 	selectElement.options[i].selected = true;
			// 	break; // Exit the loop once a match is found
			//   }
			// }	
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
	
function viewRec(num){
	var button = document.getElementById("btnView"+num);
	var name = button.getAttribute("name");
	findRec(2, name);
	
    document.getElementById('btnSelect').style.display = 'none';
	
}
	
function editRec(num){
	var button = document.getElementById("btnView"+num);
	var name = button.getAttribute("name");
	findRec(3, name);

	// Unhide the select button
    document.getElementById('btnSelect').style.display = 'block';
}
	
function delRec(num){
	var button = document.getElementById("btnDel"+num);
	var name = button.getAttribute("name");
	findRec(4, name);
}	

function confirmDeleteOrder(form) {
    // Ask for the first confirmation
    if (confirm("Are you sure you want to delete this order?")) {
    	// If the user confirms the second time, proceed with deletion
        infoOrder('del', form);
 
    }
}
	
function openPopup(type) {
    document.getElementById("popupWindow").style.display = "block";
	
	if(type == 1){
		document.getElementById('addOrder').style.display = "block";
		//document.getElementById('editOrder').style.display = "none";
		document.getElementById('delOrder').style.display = "none";
		document.getElementById('btnSelect').style.display = 'block';
	}
	else if(type == 2){
		document.getElementById('addOrder').style.display = "none";
		//document.getElementById('editOrder').style.display = "none";
		document.getElementById('delOrder').style.display = "none";
	}		
	else if(type == 3){
		document.getElementById('addOrder').style.display = "none";
		//document.getElementById('editOrder').style.display = "block";
		document.getElementById('delOrder').style.display = "none";
	}
		
	else if(type == 4){
		document.getElementById('addOrder').style.display = "none";
		//document.getElementById('editOrder').style.display = "none";
		document.getElementById('delOrder').style.display = "block";
	}
		
}
	
function fetchCustName(){
	var num = document.getElementById('ordNum').value;
	$.ajax({
        url: 'action/fetchSelectedUser.php',
        type: 'GET',
        dataType: 'json',
		data: {search:  num},
        success: function(response) {
			$("#ordUID").val(response[1]);
            $("#ordName").val(response[0]);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


</script>
