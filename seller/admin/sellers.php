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
	<input type="hidden" id="storeid" name="storeid" value="<?php echo $_SESSION['store']; ?>">
  <div class="sidebar close">
    <?php include "sidebar.php"; ?>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Sellers</span>
    </div>
	  
	  <div class="empMainCon">
		  <div style="text-align: right; margin-bottom: 10px">
		  	<button id="popupButton" onclick="openPopup()" class="save-button">+Add Seller</button>
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
			<th onclick="sortTable(0)">Shop ID# <span class="sort-indicator" id="indicator0"></span></th>
			<th onclick="sortTable(1)">Image <span class="sort-indicator" id="indicator1"></span></th>
			<th onclick="sortTable(2)">Title <span class="sort-indicator" id="indicator2"></span></th>
			<th onclick="sortTable(3)">Email <span class="sort-indicator" id="indicator3"></span></th>
			<th onclick="sortTable(4)">Phone Number <span class="sort-indicator" id="indicator4"></span></th>
			<th onclick="sortTable(5)">Status <span class="sort-indicator" id="indicator5"></span></th>
			<th onclick="sortTable(6)">Action <span class="sort-indicator" id="indicator6"></span></th>
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
		<div id="addSeller">
			<form action="action/createAdmin.php" method="POST" class="myform" name="myForm" id="myForm">
				
			<div class="myform-row">
				<div class="label">
					<label for="username" class="myform-label">Username</label>
				</div>
				<div class="input">
					<input type="text" id="username" name="username" class="myform-input" required>
					<span id="alertUsername" class="alertCSS"></span>
				</div>
			</div>

			<div class="myform-row">
				<div class="label">
					<label for="emoNum">Email</label>
				</div>
				<div class="input">
					<input type="email" id="custEmail" name="custEmail" class="myform-input" required>
					<span id="alertEmail" class="alertCSS"></span>
				</div>
			</div>
				
			<div>
				<input type="button" id="addEmployee" class="button" value="Add Seller" onClick="sellerInfo('add', this.form)">
			</div>
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
	fetchData();
});
	
function sellerInfo(action, form) {
    var username = $('#username').val();
    var custPass = $('#custPass').val();
    var custEmail = $('#custEmail').val();
	var error = 0;

	if(username == ""){
		$("#alertUsername").text("This field must not be empty!");
		error += 1;
	}else{
		$("#alertUsername").text("");
	}
	
	var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$";
	var randomNum = Math.floor(Math.random() * 5) + 4;
    var custPass = "";
	
    for (var i = 0; i < randomNum; i++) {
        var randomIndex = Math.floor(Math.random() * charset.length);
        custPass  += charset[randomIndex];
    }
	
	if(custEmail == ""){
		$("#alertEmail").text("This field must not be empty!");
		error += 1;
	}else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(custEmail.trim())) {
		$("#alertEmail").text("Please enter a valid email address in Malaysia format.");
		error += 1;
	}else{
		$("#alertEmail").text("");
	}
	
	if(error == 0){
		$.ajax({
            url: $(form).attr('action'), // The script to call to add data
            type: $(form).attr('method'),
            data: {
                act: action,
                username: username,
                custPass: custPass,
                custEmail: custEmail,
            },
            success: function (response) {
                if (action == "add")
                    alert(response);
                if (action == "edit")
                    alert("Information updated successfully!");
                if (action == "del")
                    alert("Seller deactivated successfully!");
            },
            error: function (xhr, status, error) {
                alert("Failed");
            }
        });
	}
}
	
var recordsPerPage = parseInt(document.getElementById('recordsPerPage').value);
var currentPage = 1;

function updateTableAndPagination(data) {
	if (data.data.length === 0) {
        document.getElementById('tableBody').innerHTML = '<tr><td colspan="8" style="text-align: center;">NO SELLERS RECORD</td></tr>';
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
			
        newRow.innerHTML = 
            '<td>' + rowData[0] + '</td>' +
            '<td><img style="width: 40vh; height: 40vh;" src="../Res_img/'+rowData[1]+'"></td>' +
            '<td>' + rowData[2] + '</td>' +
            '<td>' + rowData[3] + '</td>' +
            '<td>' + rowData[4] + '</td>' +
            `<td style="color: ${(rowData[5] == 0) ? 'black' : (rowData[5] == 1) ? 'green' : (rowData[5] == 2) ? 'red' : 'ice color'};">${(rowData[5] == 0) ? 'Unverify' : (rowData[5] == 1) ? 'Active' : (rowData[5] == 2) ? 'Inactive' : 'Frozen'}</td>` +
			'<td><i class="' + (rowData[5] == 1 ? 'fa fa-ban' : 'fas fa-plus') + '" id="btn' + (rowData[5] == 1 ? 'blk' : 'rec') + i + '" title="Ban the seller" name="' + rowData[0] + '" onclick="editRec(\'' + (rowData[5] == 1 ? 'blk' : 'rec') + '\',' + i + ')" style="margin-left: 5px; color: ' + (rowData[5] == 1 ? 'red' : 'green') + ';"></i></td>';
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
        url: 'action/fetchSeller.php',
        type: 'GET',
        dataType: 'json',
		data: {search:  search},
        success: function(response) {
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
	
function openPopup() {
    document.getElementById("popupWindow").style.display = "block";
	
}
	
function editRec(act, num){
	var shopID = document.getElementById("btn"+act+num).getAttribute("name");
	
	if (act == 'blk') {
		var confirmationMessage = "Are you sure you want to ban this user?";
	} else {
		var confirmationMessage = "Are you sure you want to recover this user?";
	}

	if (confirm(confirmationMessage)) {
		$.ajax({
			url: "action/changeShopStatus.php",
			type: "GET",
			data: {
				act: act,
				shopID: shopID
			},
			success: function(response) {
				alert(response);
				fetchData();
			},
			error: function(xhr, status, error) {
				console.log("Error occurred: Status: " + status + ", Error: " + error);
			}
		});
	}
}

function renameCategory() {
    var categoryId = document.getElementById('categoryDropdown').value;
    var newCategoryName = document.getElementById('newCategoryName').value;

    // Send AJAX request to update category name in the database
    $.ajax({
        url: 'rename_category.php', // PHP script to handle category renaming
        type: 'POST',
        dataType: 'json',
        data: { categoryId: categoryId, newCategoryName: newCategoryName },
        success: function(response) {
            if (response.success) {
                // Category renamed successfully
                // You can update the category name in the dropdown if needed
                alert('Category renamed successfully!');
            } else {
                // Error renaming category
                alert('Failed to rename category!');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error renaming category:', error);
        }
    });
}

function deleteCategory() {
    var categoryId = document.getElementById('categoryDropdown').value;

    // Send AJAX request to delete category from the database
    $.ajax({
        url: 'delete_category.php', // PHP script to handle category deletion
        type: 'POST',
        dataType: 'json',
        data: { categoryId: categoryId },
        success: function(response) {
            if (response.success) {
                // Category deleted successfully
                // You can remove the category from the dropdown if needed
                alert('Category deleted successfully!');
            } else {
                // Error deleting category
                alert('Failed to delete category!');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error deleting category:', error);
        }
    });
}
</script>