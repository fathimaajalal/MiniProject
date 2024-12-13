// SIDEBAR TOGGLE

let sidebarOpen = false;
const sidebar = document.getElementById('sidebar');

function openSidebar() {
  if (!sidebarOpen) {
    sidebar.classList.add('sidebar-responsive');
    sidebarOpen = true;
  }
}

function closeSidebar() {
  if (sidebarOpen) {
    sidebar.classList.remove('sidebar-responsive');
    sidebarOpen = false;
  }
}

// Toggle the search bar visibility
function toggleSearch() {
  const searchInput = document.getElementById('search-input');
  searchInput.style.display = (searchInput.style.display === 'block') ? 'none' : 'block';
}

// Perform a search when the user presses Enter
document.getElementById('search-input').addEventListener('keyup', function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
    searchResults(); // Call the function to fetch search results
  }
});

// Fetch search results from the server
function searchResults() {
  const query = document.getElementById('search-input').value.trim();
  if (query === "") {
    alert("Please enter a search query.");
    return;
  }

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "search.php", true); 
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Display search results in the search-results div
      const searchResultsDiv = document.getElementById('search-results');
      searchResultsDiv.innerHTML = xhr.responseText;
      searchResultsDiv.style.display = 'block';
    } else {
      console.error("Error fetching search results: " + xhr.status);
    }
  };

  xhr.send("query=" + query);
}


// SEARCH PRODUCTS
function searchProducts() {
  const searchInput = document.getElementById('search-input');
  const query = searchInput.value;

  // Make AJAX request to fetch products from database
  fetch('search_products.php?query=' + query)
    .then(response => response.json())
    .then(data => {
      // Update UI with search results
      console.log(data); // Replace with your UI update logic
    })
    .catch(error => {
      console.error('Error searching products:', error);
    });
}

// LOAD PRODUCT PAGE
function loadProductPage() {
  // Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Open a GET request to products.php
  xhr.open("GET", "products.php", true);

  // Set a callback function to handle the response
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Replace the content of the main container with the response
      document.querySelector(".main-container").innerHTML = xhr.responseText;
    } else {
      console.error("Error loading products page: " + xhr.status);
    }
  };

  // Send the request
  xhr.send();
}

// LOAD DONATION PAGE
function loadDonationPage() {
  // Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Open a GET request to products.php
  xhr.open("GET", "donations.php", true);

  // Set a callback function to handle the response
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Replace the content of the main container with the response
      document.querySelector(".main-container").innerHTML = xhr.responseText;
    } else {
      console.error("Error loading products page: " + xhr.status);
    }
  };

  // Send the request
  xhr.send();
}

// LOAD MANAGE USERS PAGE
function loadManageUsersPage() {
  // Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Open a GET request to manage_users.php
  xhr.open("GET", "manage_users.php", true);

  // Set a callback function to handle the response
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Replace the content of the main container with the response
      document.querySelector(".main-container").innerHTML = xhr.responseText;
      
      // After loading the users page, redefine the removeUser function to ensure it's in scope
      initializeRemoveUserHandler();
    } else {
      console.error("Error loading manage users page: " + xhr.status);
    }
  };

  // Send the request
  xhr.send();
}

// Define the removeUser function in script.js so it's globally available
function initializeRemoveUserHandler() {
  // Function to remove a user
  window.removeUser = function(regno) {
    if (confirm("Are you sure you want to remove this user?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "remove_user.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
      xhr.onload = function() {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            alert("User removed successfully!");
            loadManageUsersPage(); // Reload the users page
          } else {
            alert("Error removing user: " + response.message);
          }
        } else {
          alert("Error removing user. Please try again.");
        }
      };
  
      xhr.onerror = function() {
        console.error("Request failed: ", xhr.statusText);
      };
  
      // Log the regno value to check if it's being passed correctly
      console.log("Removing user with regno:", regno);
      xhr.send("regno=" + encodeURIComponent(regno));
    }
  };
  
}


// FETCH COUNTS ON PAGE LOAD
window.onload = function() {
  fetchProductCount();
  fetchDonationCount();
  fetchProductRequestCount();
  fetchDonationRequestCount();
  fetchPurchaseOrderCount();
  fetchSalesOrderCount();
  fetchOrderCount();  // Fetch order count
};

// FETCH ORDER COUNT
function fetchOrderCount() {
  fetch('fetch_order_count.php')
    .then(response => response.json())
    .then(data => {
      const orderCard = document.getElementById('order-count');
      orderCard.textContent = data.order_count;
    })
    .catch(error => {
      console.error('Error fetching order count:', error);
    });
}

// Function to display Orders page
function showOrders() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "orders.php", true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      document.querySelector(".main-container").innerHTML = xhr.responseText;
    } else {
      console.error("Error loading orders page: " + xhr.status);
    }
  };
  xhr.send();
}

// FETCH PRODUCT COUNT
function fetchProductCount() {
  fetch('fetch_product_count.php')
    .then(response => response.json())
    .then(data => {
      const productCard = document.getElementById('product-count');
      productCard.textContent = data.product_count;
    })
    .catch(error => {
      console.error('Error fetching product count:', error);
    });
}

// FETCH DONATION COUNT
function fetchDonationCount() {
  fetch('fetch_donation_count.php')
    .then(response => response.json())
    .then(data => {
      const donationCard = document.getElementById('donation-count');
      donationCard.textContent = data.donation_count;
    })
    .catch(error => {
      console.error('Error fetching donation count:', error);
    });
}

// FETCH PURCHASE ORDER COUNT
function fetchPurchaseOrderCount() {
  fetch('fetch_purchase_order_count.php')
    .then(response => response.json())
    .then(data => {
      const purchaseOrderCard = document.getElementById('purchase-order-count');
      purchaseOrderCard.textContent = data.purchase_order_count;
    })
    .catch(error => {
      console.error('Error fetching purchase order count:', error);
    });
}

// FETCH SALES ORDER COUNT
function fetchSalesOrderCount() {
  fetch('fetch_sales_order_count.php')
    .then(response => response.json())
    .then(data => {
      const salesOrderCard = document.getElementById('sales-order-count');
      salesOrderCard.textContent = data.sales_order_count;
    })
    .catch(error => {
      console.error('Error fetching sales order count:', error);
    });
}

// FETCH PRODUCT REQUEST COUNT
function fetchProductRequestCount() {
  fetch('fetch_product_request_count.php')
    .then(response => response.json())
    .then(data => {
      const productRequestCard = document.getElementById('product-request-count');
      productRequestCard.textContent = data.product_request_count;
    })
    .catch(error => {
      console.error('Error fetching product request count:', error);
    });
}

// FETCH DONATION REQUEST COUNT
function fetchDonationRequestCount() {
  fetch('fetch_donation_request_count.php')
    .then(response => response.json())
    .then(data => {
      const donationRequestCard = document.getElementById('donation-request-count');
      donationRequestCard.textContent = data.donation_request_count;
    })
    .catch(error => {
      console.error('Error fetching donation request count:', error);
    });
}

// SHOW PURCHASE ORDER PAGE
function showPurchaseOrder() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "purchase_orders.php", true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      document.querySelector(".main-container").innerHTML = xhr.responseText;
    } else {
      console.error("Error loading purchase orders page: " + xhr.status);
    }
  };
  xhr.send();
}

// SHOW PRODUCT REQUEST PAGE
function loadProductRequestPage() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "product_requests.php", true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      document.querySelector(".main-container").innerHTML = xhr.responseText;
    } else {
      console.error("Error loading product requests page: " + xhr.status);
    }
  };
  xhr.send();
}

// SHOW DONATION REQUEST PAGE
function loadDonationRequestPage() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "donation_requests.php", true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      document.querySelector(".main-container").innerHTML = xhr.responseText;
    } else {
      console.error("Error loading donation requests page: " + xhr.status);
    }
  };
  xhr.send();
}

// SHOW SALES ORDER PAGE
function showSalesOrder() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "sales_orders.php", true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      document.querySelector(".main-container").innerHTML = xhr.responseText;
    } else {
      console.error("Error loading sales orders page: " + xhr.status);
    }
  };
  xhr.send();
}
// ---------- CHARTS ----------

// ---------- CHARTS ----------
// ---------- CHARTS ----------

// Fetch Bar Chart Data
fetch('fetch_bar_chart_data.php')
  .then(response => response.json())
  .then(data => {
    const barChartOptions = {
      series: [
        {
          data: data.counts, // Use the fetched counts
        },
      ],
      chart: {
        type: 'bar',
        height: 350,
        toolbar: {
          show: false,
        },
      },
      colors: ['#246dec', '#cc3c43', '#367952', '#f5b74f', '#4f35a1'],
      plotOptions: {
        bar: {
          distributed: true,
          borderRadius: 4,
          horizontal: false,
          columnWidth: '40%',
        },
      },
      dataLabels: {
        enabled: false,
      },
      legend: {
        show: false,
      },
      xaxis: {
        categories: data.categories, // Use the fetched categories
      },
      yaxis: {
        title: {
          text: 'Count',
        },
      },
    };

    const barChart = new ApexCharts(
      document.querySelector('#bar-chart'),
      barChartOptions
    );
    barChart.render();
  })
  .catch(error => console.error('Error fetching bar chart data:', error));

// Fetch Area Chart Data
fetch('fetch_area_chart_data.php')
  .then(response => response.json())
  .then(data => {
    const areaChartOptions = {
      series: [
        {
          name: 'Orders',
          data: data.order_counts, // Using data from the orders table
        },
      ],
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false,
        },
      },
      colors: ['#4f35a1'],
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: 'smooth',
      },
      labels: data.labels, // Monthly labels
      markers: {
        size: 0,
      },
      yaxis: {
        title: {
          text: 'Orders',
        },
      },
      tooltip: {
        shared: true,
        intersect: false,
      },
    };

    const areaChart = new ApexCharts(
      document.querySelector('#area-chart'),
      areaChartOptions
    );
    areaChart.render();
  })
  .catch(error => console.error('Error fetching area chart data:', error));
