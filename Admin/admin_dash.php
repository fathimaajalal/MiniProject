<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    

  </head>
  <body>
    <div class="grid-container">

      <!-- Header -->
      <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>


        <div class="header-left">
          <span class="material-icons-outlined" onclick="toggleSearch()">search</span>
          <span class="material-icons-outlined"> <input type="text" id="search-input" placeholder="Search" style="display: none;"> </span>
        </div>

        <div class="header-right">
          <span class="material-icons-outlined">notifications</span>
          <span class="material-icons-outlined">email</span>
          <span class="material-icons-outlined">account_circle</span>
        </div>
      </header>
      <!-- End Header -->

      <!-- Sidebar -->

        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined">inventory</span> Connect @ Marian Inventory
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>
        
            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">dashboard</span> Dashboard
                    </a>
                </li>

                <li class="sidebar-list-item">
                  <a href="#" onclick="showOrders()">
                      <span class="material-icons-outlined">shopping_bag</span> Orders
                  </a>
              </li>

                <li class="sidebar-list-item">
                  <a href="#"   onclick="loadProductPage()">
                      <span class="material-icons-outlined">category</span> Products
                  </a>
              </li>

              <li class="sidebar-list-item">
                  <a href="#"   onclick="loadDonationPage()">
                      <span class="material-icons-outlined">volunteer_activism</span> Donations
                  </a>
              </li>

              <li class="sidebar-list-item">
                  <a href="#"   onclick="loadProductRequestPage()">
                      <span class="material-icons-outlined">request_quote</span> Product Requests
                  </a>
              </li>

              <li class="sidebar-list-item">
                  <a href="#" onclick="loadDonationRequestPage()">
                      <span class="material-icons-outlined">assignment</span> Donation Requests
                  </a>
              </li>


                <!-- <li class="sidebar-list-item">
                    <a href="#" onclick="showPurchaseOrder()">
                        <span class="material-icons-outlined">inventory_2</span> Purchase Orders
                    </a>
                </li>

                <li class="sidebar-list-item">
                    <a href="#" onclick="showSalesOrder()">
                        <span class="material-icons-outlined">inventory_2</span> Sales Orders
                    </a>
                </li> -->

                <li class="sidebar-list-item">
                  <a href="#" onclick="loadManageUsersPage()">
                      <span class="material-icons-outlined">manage_accounts</span> Manage Users
                  </a>
              </li>



            </ul>
        </aside>

      <!-- End Sidebar -->

      <!-- Main -->
      <main class="main-container">
        <div class="main-title">
          <p class="font-weight-bold">DASHBOARD</p>
        </div>

        <div class="main-cards">
        
          <div class="card">
            <div class="card-inner">
                <p class="text-primary">PRODUCTS</p>
                <span class="material-icons-outlined text-blue">inventory_2</span>   
            </div>
            <span class="text-primary font-weight-bold"   
                 id="product-count">249</span>
        </div>

        <!-- <div class="card">
          <div class="card-inner">
            <p class="text-primary">PURCHASE ORDERS</p>
            <span class="material-icons-outlined text-orange">add_shopping_cart</span>
          </div>
          <span class="text-primary font-weight-bold"   
                 id="purchase-order-count">83</span>
        </div>

        <div class="card">
          <div class="card-inner">
              <p class="text-primary">SALES ORDERS</p>
              <span class="material-icons-outlined text-green">shopping_cart</span>
          </div>
          <span class="text-primary font-weight-bold"   
                  id="sales-order-count">79</span>
      </div> -->



    <div class="card">
            <div class="card-inner">
                <p class="text-primary">DONATIONS</p>
                <span class="material-icons-outlined text-blue">inventory_2</span>   
            </div>
            <span class="text-primary font-weight-bold"   
                 id="donation-count">249</span>
        </div>

        <div class="card">
        <div class="card-inner">
            <p class="text-primary">PRODUCT REQUESTS</p>
            <span class="material-icons-outlined text-red">notification_important</span>
        </div>
        <span class="text-primary font-weight-bold"   
                  id="product-request-count"></span>
    </div>
    <div class="card">
        <div class="card-inner">
            <p class="text-primary">DONATION REQUESTS</p>
            <span class="material-icons-outlined text-red">notification_important</span>
        </div>
        <span class="text-primary font-weight-bold"   
                  id="donation-request-count"></span>

            <?php
           
            include 'connection.php';
    
            $sql = "SELECT COUNT(*) as count FROM donation_requests";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
    
            echo "<strong>" . $row['count'] . "</strong>";  
    
            $conn->close();
            ?>
        </span>
    </div>

    <div class="card">
            <div class="card-inner">
                <p class="text-primary">ORDERS</p>
                <span class="material-icons-outlined text-green">receipt</span>
            </div>
            <span class="text-primary font-weight-bold" id="order-count">0</span>
        </div>
    

        </div>

        <div class="charts">

          <div class="charts-card">
            <p class="chart-title">Top Categories</p>
            <div id="bar-chart"></div>
          </div>

          <div class="charts-card">
            <p class="chart-title">Orders</p>
            <div id="area-chart"></div>
          </div>

        </div>
      </main>
      
     <!-- End Main -->
 </div>

    <!-- Scripts -->

    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="scripts.js"></script>

</body>
</html>



