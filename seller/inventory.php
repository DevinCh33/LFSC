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
      <span class="text">Products</span>
    </div>
	  
	  <div class="empMainCon">		  
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
			<th onclick="sortTable(0)">Product Code <span class="sort-indicator" id="indicator0"></span></th>
			<th onclick="sortTable(1)">Image <span class="sort-indicator" id="indicator1"></span></th>
			<th onclick="sortTable(2)">Product Name <span class="sort-indicator" id="indicator2"></span></th>
			<th onclick="sortTable(3)">Unit Sold <span class="sort-indicator" id="indicator3"></span></th>
			<th onclick="sortTable(4)">Available Stock <span class="sort-indicator" id="indicator4"></span></th>
			<th onclick="sortTable(5)">Availability <span class="sort-indicator" id="indicator5"></span></th>
			<th onclick="sortTable(7)">Reorder Recommendation <span class="sort-indicator" id="indicator7"></span></th>
			<th onclick="sortTable(8)">Action <span class="sort-indicator" id="indicator8"></span></th>

		  </tr>
		</thead>
		<tbody id="tableBody">
		  <!-- Table content goes here -->
		</tbody>
	  </table>
	</div>


    <div class="pagination-summary">
      <span id="tableSummary">Showing 1-10 of 100 Records</span>
      <div class="pagination">
		  
      </div>
    </div>
	  </div>
	  
	  
    <div id="popupWindow" class="popup">
		
      <div class="popup-content">
		  <div class="xclose">
		  	<span class="close" onclick="closePopup()">&times;</span>
		  </div>
        	
			<form action="" method="POST" class="myform" name="myForm" id="myForm">
			<input type="hidden" value="<?php echo $_SESSION['store']; ?>" id="storeID" name="storeID">
			<div class="myform-row">
				<div id="divalert" class="divalert" name="divalert"></div>
			</div>
				
			<div class="myform-row">
				<div class="label">
					<label for="productCode" class="myform-label">Current Stock#</label>
				</div>
				<div class="input">
					<input type="text" id="productCode" name="productCode" class="myform-input" required>
				</div>
			</div>
				
			<div class="myform-row">
				<div class="label">
					<label for="productCode" class="myform-label">New Stock#</label>
				</div>
				<div class="input">
					<input type="text" id="productStock" name="productStock" class="myform-input" required>
				</div>
			</div>
				
				<input type="hidden" name="proID" id="proID">
				<input type="button" id="editProduct" class="button" value="Save Change" style="background-color: lightgreen;" onClick="productInfo('edit', this.form)">
				
    </form>
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
	
function productInfo(action, form) {
    var productCode = $('#productCode').val();
	var proStock = $('#proStock').val();
	var productID = $("#proID").val();
    var store = $('#storeID').val();

   
	
    if (productCode === "" || productName === "" || weightValues.length === 0 || priceValues.length === 0 || proQuan === "" && action != "del") {
        $('#divalert').css('background-color', 'red');
        $('#divalert').text('Product Code, Name, Weight, and Price must not be empty');
        $('#divalert').show();
        setTimeout(function () {
            $('#divalert').hide();
        }, 3000);
    } else {
		var text = "";
        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: {act: action, data: $("#myForm").serialize(), proID: productID},
            success: function (response) {
				if(action == "edit")
					text = "Information Updated Successfully!";
                $('#divalert').css('background-color', 'green');
				$('#divalert').text(text);
				$('#divalert').show();
				setTimeout(function() {
					$('#divalert').hide();
				}, 3000);
				if(action == 'del'){
					closePopup();
					fetchData();
				}
				
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
}
	
var recordsPerPage = parseInt(document.getElementById('recordsPerPage').value);
var currentPage = 1;

function updateTableAndPagination(data) {
    // Calculate the start and end indices based on the current page and records per page
    var startIndex = (currentPage - 1) * recordsPerPage;
    var endIndex = startIndex + recordsPerPage;

    // Clear existing table rows
    var tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';
    // Populate the table with the data for the current page
    for (var i = startIndex; i < endIndex && i < data.length; i++) {
        var rowData = data[i];
        var newRow = document.createElement('tr');
        newRow.innerHTML = '<td>' + rowData.productCode + '</td>' +
            '<td style="padding: 0px;">' + rowData.productImage + '</td>' +
            '<td>' + rowData.productName + '</td>' +
            '<td>' + rowData.descr + '</td>' +
            '<td>' + rowData.quantity + '</td>' +
			'<td>' + rowData.productName + '</td>' +
            `<td style="color: ${(rowData.status === '1') ? 'green' : 'red'};">${(rowData.status === '1') ? 'Active' : 'Inactive'}</td>`+
			'<td><i class="icon fa fa-eye" id="btnView'+i+'" name="'+rowData.productID+'" onclick="viewRec('+i+')"></i><i class="icon fa fa-edit" id="btnEdit'+i+'" name="'+rowData.productID+'" onclick="editRec('+i+')"></i><i class="icon fa fa-trash"id="btnDel'+i+'" name="'+rowData.productID+'" onclick="delRec('+i+')"></i></td>';
        tableBody.appendChild(newRow);
    }
    // Update the table summary
    var totalRecords = data.length;
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
        url: 'action/fetchInventory.php',
        type: 'GET',
        dataType: 'json',
		data: {search:  search},
        success: function(response) {
			console.log(response);
            updateTableAndPagination(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
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
        url: 'action/fetchProduct.php',
        type: 'GET',
        dataType: 'json',
        data: {name: name},
        success: function(response) {
            openPopup(windowType);
            // Set product details
            $('#productCode').val(response[0].productCode).prop('readonly', windowType === 2);
            $('#proName').val(response[0].productName).prop('readonly', windowType === 2);
            $('#proDescr').val(response[0].descr).prop('readonly', windowType === 2);
			$('#proID').val(response[0].productID);

            // Clear existing price rows except the first two (header and initial row)
            var priceTable = document.getElementById("priceTable");
            var rowCount = priceTable.rows.length;
            for (var i = rowCount - 2; i > 0; i--) {
                priceTable.deleteRow(i);
            }

            // Populate price table
            response[0].prices.forEach(function(item) {
                addPriceRowWithData(item.proWeight, item.proPrice, item.priceNo);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
	
function openPopup(type) {
    document.getElementById("popupWindow").style.display = "block";
	
	if(type == 1){
		document.getElementById('addProduct').style.display = "block";
		document.getElementById('editProduct').style.display = "none";
		document.getElementById('delProduct').style.display = "none";
	}
	else if(type == 2){
		document.getElementById('addImageFile').style.display = "none";
		document.getElementById('addProduct').style.display = "none";
		document.getElementById('editProduct').style.display = "none";
		document.getElementById('delProduct').style.display = "none";
	}		
	else if(type == 3){
		document.getElementById('addProduct').style.display = "none";
		document.getElementById('editProduct').style.display = "block";
		document.getElementById('delProduct').style.display = "none";
	}
		
	else if(type == 4){
		document.getElementById('addProduct').style.display = "none";
		document.getElementById('editProduct').style.display = "none";
		document.getElementById('delProduct').style.display = "block";
	}
		
}
	



</script>
