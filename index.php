var mysql = require('mysql');
<?php
  $username = $_POST['username'];
  $email = $_POST['email'];
  $pw= $_POST['pw'];

  $con = new mysqli("localhost", "root", "", "project");
  if($con->connect_error){
    die("Failed to connect : ".$con->connect_error);
  } else {
    $stmt = $con->prepare("select * from users where username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0) {
      $data = $stmt_result->fetch_assoc();
      if($data['pw'] === $pw) {
        echo "<h2>Login Successfully!</h2>";
      } else {
      echo "<h2>Invalid Username or Password</h2>";
      }
    } else {
      echo "<h2>Invalid Username or Password</h2>";
    }
  }

?>

<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>Dashboard</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>
 <head>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   .dropdown:hover .dropdown-menu {
    display: block;
   }
   .selected {
    border: 2px solid black;
   }
  </style>
  <script>
   function showAddUserForm() {
    document.getElementById('addUserForm').classList.remove('hidden');
   }

   function hideAddUserForm() {
    document.getElementById('addUserForm').classList.add('hidden');
   }

   function showRemoveUserForm() {
    const rows = document.querySelectorAll('#userTableBody tr');
    // rows.forEach(row => {
    //   const checkbox = document.createElement('input');
    //   checkbox.type = 'checkbox'; 
    //   checkbox.classList.add('remove-checkbox', 'form-checkbox', 'h-5', 'w-5', 'text-red-600');
    //   row.insertCell(3).appendChild(checkbox);
    // });
    document.getElementById('removeUserForm').classList.remove('hidden');
   }

   function hideRemoveUserForm() {
    const checkboxes = document.querySelectorAll('.remove-checkbox');
    checkboxes.forEach(checkbox => {
     checkbox.parentElement.remove();
    });
    document.getElementById('removeUserForm').classList.add('hidden');
   }

   function removeUsers() {
    const checkboxes = document.querySelectorAll('.remove-checkbox:checked');
    checkboxes.foreach(checkbox => {
     checkbox.closest('tr').remove();
    });
    hideRemoveUserForm();
   }

   function showEditUserForm() {
    const rows = document.querySelectorAll('#userTableBody tr');
    rows.forEach(row => {
     const radio = document.createElement('input');
     radio.type = 'radio';
     radio.name = 'edit-radio';
     radio.classList.add('edit-radio', 'form-radio', 'h-5', 'w-5', 'text-blue-600',);
     row.insertCell(3).appendChild(radio);
    });
    document.getElementById('editUserForm').classList.remove('hidden');
   }

   function hideEditUserForm() {
    const radios = document.querySelectorAll('.edit-radio');
    radios.forEach(radio => {
     radio.parentElement.remove();
    });
    document.getElementById('editUserForm').classList.add('hidden');
   }

   function editUser() {
    const selectedRadio = document.querySelector('.edit-radio:checked');
    if (selectedRadio) {
     const row = selectedRadio.closest('tr');
     const username = prompt("Enter Full Name", row.cells[2].innerText);
     const email = prompt("Enter Email", row.cells[3].innerText);
     const branch = prompt("Enter Branch", row.cells[4].innerText);
     const role = prompt("Enter Role", row.cells[5].innerText);
     const createdOn = prompt("Enter Created On", row.cells[6].innerText);
     const createdBy = prompt("Enter Created By", row.cells[7].innerText);

     if (username && email && branch && role && createdOn && createdBy) {
      row.cells[2].innerText = username;
      row.cells[3].innerText = email;
      row.cells[4].innerText = branch;
      row.cells[5].innerText = role;
      row.cells[6].innerText = createdOn;
      row.cells[7].innerText = createdBy;

      hideEditUserForm();
     }
    }
   }

   function showGrantPrivilegeForm() {
    const rows = document.querySelectorAll('#userTableBody tr');
    rows.forEach(row => {
     const checkbox = document.createElement('input');
     checkbox.type = 'checkbox';
     checkbox.classList.add('grant-checkbox', 'form-checkbox', 'h-5', 'w-5', 'text-green-600');
     row.insertCell(0).appendChild(checkbox);
    });
    document.getElementById('grantPrivilegeForm').classList.remove('hidden');
   }

   function hideGrantPrivilegeForm() {
    const checkboxes = document.querySelectorAll('.grant-checkbox');
    checkboxes.forEach(checkbox => {
     checkbox.parentElement.remove();
    });
    document.getElementById('grantPrivilegeForm').classList.add('hidden');
   }

   function grantPrivileges() {
    const checkboxes = document.querySelectorAll('.grant-checkbox:checked');
    checkboxes.forEach(checkbox => {
     const row = checkbox.closest('tr');
     if (!row.cells[row.cells.length - 1].innerHTML.includes('<i class="fas fa-star text-yellow-500"></i>')) {
      row.cells[row.cells.length - 1].innerHTML += ' <i class="fas fa-star text-yellow-500"></i>';
     }
    });
    hideGrantPrivilegeForm();
   }

   function showRevokePrivilegeForm() {
    const rows = document.querySelectorAll('#userTableBody tr');
    rows.forEach(row => {
     if (row.cells[row.cells.length - 1].innerHTML.includes('<i class="fas fa-star text-yellow-500"></i>')) {
      const checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.classList.add('revoke-checkbox', 'form-checkbox', 'h-5', 'w-5', 'text-red-600');
      row.insertCell(0).appendChild(checkbox);
     }
    });
    document.getElementById('revokePrivilegeForm').classList.remove('hidden');
   }

   function hideRevokePrivilegeForm() {
    const checkboxes = document.querySelectorAll('.revoke-checkbox');
    checkboxes.forEach(checkbox => {
     checkbox.parentElement.remove();
    });
    document.getElementById('revokePrivilegeForm').classList.add('hidden');
   }

   function revokePrivileges() {
    const checkboxes = document.querySelectorAll('.revoke-checkbox:checked');
    checkboxes.forEach(checkbox => {
     const row = checkbox.closest('tr');
     row.cells[row.cells.length - 1].innerHTML = row.cells[row.cells.length - 1].innerHTML.replace(' <i class="fas fa-star text-yellow-500"></i>', '');
    });
    hideRevokePrivilegeForm();
   }

   function showMedCatalog() {
    document.getElementById('userPage').classList.add('hidden');
    document.getElementById('medCatalogPage').classList.remove('hidden');
    document.getElementById('inventoryPage').classList.add('hidden');
    // document.getElementById('transactionsPage').classList.add('hidden');
    document.getElementById('usersButton').classList.remove('selected');
    document.getElementById('medCatalogButton').classList.add('selected');
    document.getElementById('inventoryButton').classList.remove('selected');
    document.getElementById('transactionsButton').classList.remove('selected');
   }

   function showUsers() {
    document.getElementById('medCatalogPage').classList.add('hidden');
    document.getElementById('userPage').classList.remove('hidden');
    document.getElementById('inventoryPage').classList.add('hidden');
    // document.getElementById('transactionsPage').classList.add('hidden');
    document.getElementById('usersButton').classList.add('selected');
    document.getElementById('medCatalogButton').classList.remove('selected');
    document.getElementById('inventoryButton').classList.remove('selected');
    document.getElementById('transactionsButton').classList.remove('selected');
   }

   function showInventory() {
    document.getElementById('userPage').classList.add('hidden');
    document.getElementById('medCatalogPage').classList.add('hidden');
    document.getElementById('inventoryPage').classList.remove('hidden');
    // document.getElementById('transactionsPage').classList.add('hidden');
    document.getElementById('usersButton').classList.remove('selected');
    document.getElementById('medCatalogButton').classList.remove('selected');
    document.getElementById('inventoryButton').classList.add('selected');
    document.getElementById('transactionsButton').classList.remove('selected');
   }

   function showTransactions() {
    document.getElementById('userPage').classList.add('hidden');
    document.getElementById('medCatalogPage').classList.add('hidden');
    document.getElementById('inventoryPage').classList.add('hidden');
    // document.getElementById('transactionsPage').classList.remove('hidden');
    document.getElementById('usersButton').classList.remove('selected');
    document.getElementById('medCatalogButton').classList.remove('selected');
    document.getElementById('inventoryButton').classList.remove('selected');
    document.getElementById('transactionsButton').classList.add('selected');
   }
  </script>
 </head>

 <body class="bg-gray-100">
  <div class="flex items-center justify-between p-4 bg-white shadow">
   <div class="flex items-center">
    <img alt="User profile picture" class="rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/sxf1h605GKQ1fUWkSLeB31Sbzc3f4wOgdl9seHX7keCXrEA6E.jpg" width="40"/>
    <span class="ml-2">
    <strong><?php echo $_SESSION['username']; ?></strong>    </span>
    <i class="fas fa-caret-down ml-2">
    </i>
   </div>
   <div class="flex space-x-4">
    <button class="px-4 py-2 selected" id="usersButton" onclick="showUsers()">
     Users
    </button>
    <button class="px-4 py-2" id="medCatalogButton" onclick="showMedCatalog()">
     Med Catalog
    </button>
    <button class="px-4 py-2" id="inventoryButton" onclick="showInventory()">
     Inventory
    </button>
    <!-- <button class="px-4 py-2" id="transactionsButton" onclick="showTransactions()">
     Transactions
    </button> -->
   </div>
   <div>
    <input class="px-4 py-2 border rounded" placeholder="search" type="text"/>
   </div>
  </div>

<!-- USERS -->
  
  <div class="p-4" id="userPage">
   <div class="bg-white shadow rounded-lg p-4">
    <div class="dropdown relative mb-4">
     <i class="fas fa-ellipsis-v cursor-pointer">
     </i>
     <div class="dropdown-menu absolute hidden text-gray-700 pt-1">
      <table class="bg-white shadow rounded-lg">
       <tr>
        <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer" onclick="showAddUserForm()">
         Add User
        </td>
       </tr>
       <!-- <tr>
        <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer" onclick="showGrantPrivilegeForm()">
         Grant User Privilege
        </td>R
       </tr> -->
       <!-- <tr>
        <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer" onclick="showRevokePrivilegeForm()">
         Revoke User Privilege
        </td>
       </tr> -->
      </table>
     </div>
    </div>
    <table class="w-full text-left">
     <thead>
      <tr>
       <th class="py-2">ID</th>
       <th class="py-2">Full Name</th>
       <th class="py-2">Email</th>
       <th class="py-2" colspan="2">Operations</th>
      </tr>
     </thead>
     <tbody id="userTableBody">
      <!-- <tr class="border-t">
       <td class="py-2">
        <img alt="User profile picture" class="rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/sxf1h605GKQ1fUWkSLeB31Sbzc3f4wOgdl9seHX7keCXrEA6E.jpg" width="40"/>
       </td>
       <td class="py-2">
        Christian Paolo Reyes
       </td>
       <td class="py-2">
        cpaolo852@gmail.com
       </td>
       <td class="py-2">
        Fairview
       </td>
       <td class="py-2">
        Manager
       </td>
       <td class="py-2">
        May 10, 2024
       </td>
       <td class="py-2">
        Paolo Jules Acuna
       </td>
      </tr> -->

      <!-- Display the Admins' info -->
        <?php
        $connect = mysqli_connect('localhost', 'root', '', 'project');
         
        $query = 'SELECT * FROM users';
        $result = mysqli_query( $connect, $query );
        $total = mysqli_num_rows($result);
        ?>
        <!-- // echo mysqli_num_rows( $result ); //shows the rows of users in the db -->
        <?php
        if($total!=0)
        {
          while( $record =  $result->fetch_assoc())
          {
              // echo '<tr class="border-t"><th class="py-2">'.$record['id'].'</th>';
              // echo '<th class="py-2">'.$record['username'].'</th>';
              // echo '<th class="py-2">'.$record['email'].'</th>';
              // echo "<td><a href = 'delete.php?rn=$record[id]'>Delete</td>";
              // echo '</tr>';
              // echo '</thead>';

              echo "
              <tr>
              <th>".$record['id']."</th>
              <th>".$record['username']."</th>
              <th>".$record['email']."</th>
              <td><a href = 'delete.php?rn=$record[id]'>Delete</td>
              <td><a href = 'edit.php?id=$record[id]&un=$record[username]&em=$record[email]&pw=$record[pw]'>Update</td>
              </tr>
              ";
          }
        }
        ?>
     </tbody>
    </table>
    <!-- Add user Function -->
  <form method="POST" action="process-form.php">
    <div class="hidden" id="addUserForm">
     <div class="mt-4">
      <label for="username" class="block" id="username" name="username">
       Full Name:
       <input class="border rounded w-full py-2 px-3 mt-1" id="username" name="username" type="text" placeholder="Username" required/>
      </label>
     </div>
     <div class="mt-4">
      <label for="email" class="block" id="email" name="email">
       Email:
       <input class="border rounded w-full py-2 px-3 mt-1" id="email" name="email" type="email" placeholder="Email" required/>
      </label>
     </div>
     <div class="mt-4">
      <label for="pw" class="block" id="pw" name="pw">
       Password:
       <input class="border rounded w-full py-2 px-3 mt-1" id="pw" name="pw" type="password" placeholder="Password" required/>
      </label>
     </div>
     <div class="mt-4 flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
       Submit
      </button>
      <button type="cancel" class="px-4 py-2 bg-red-500 text-white rounded" onclick="hideAddUserForm()">
       Cancel
      </button>
     </div>
    </div>
  </form>

  <!-- Delete User Function -->
  <form method="POST" action="delete.php">
    <div class="hidden" id="removeUserForm">
     <div class="mt-4 flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">
       Delete
      </button>
      <button type="cancel" class="px-4 py-2 bg-gray-500 text-white rounded" onclick="hideRemoveUserForm()">
       Cancel
      </button>
     </div>
    </div>
  </form>
    <!-- Edit User Function -->
    <div class="hidden" id="editUserForm">
     <div class="mt-4 flex space-x-4">
      <button class="px-4 py-2 bg-blue-500 text-white rounded" onclick="editUser()">
       Edit
      </button>
      <button class="px-4 py-2 bg-gray-500 text-white rounded" onclick="hideEditUserForm()">
       Cancel
      </button>
     </div>
    </div>
    <div class="hidden" id="grantPrivilegeForm">
     <div class="mt-4 flex space-x-4">
      <button class="px-4 py-2 bg-green-500 text-white rounded" onclick="grantPrivileges()">
       Grant
      </button>
      <button class="px-4 py-2 bg-gray-500 text-white rounded" onclick="hideGrantPrivilegeForm()">
       Cancel
      </button>
     </div>
    </div>
    <div class="hidden" id="revokePrivilegeForm">
     <div class="mt-4 flex space-x-4">
      <button class="px-4 py-2 bg-red-500 text-white rounded" onclick="revokePrivileges()">
       Revoke
      </button>
      <button class="px-4 py-2 bg-gray-500 text-white rounded" onclick="hideRevokePrivilegeForm()">
       Cancel
      </button>
     </div>
    </div>
   </div>
  </div>
  
<!-- MED CATALOG -->

  <div class="p-4 hidden" id="medCatalogPage">
   <div class="bg-white shadow rounded-lg p-4">
    <div class="dropdown relative mb-4">
     <i class="fas fa-ellipsis-v cursor-pointer">
     </i>
     <div class="dropdown-menu absolute hidden text-gray-700 pt-1">
      <table class="bg-white shadow rounded-lg">
       <!-- <tr>
        <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
         Register Medicine
        </td>
       </tr>
       <tr>
        <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
         Edit Medicine
        </td>
       </tr>
       <tr>
        <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
         Delete Medicine
        </td>
       </tr> -->
       </table>
       </div>
       </div>
       <table class="w-full text-left">
        <thead>
         <tr>
          <th class="py-2">
           Photo
          </th>
          <th class="py-2">
           Generic Name
          </th>
          <th class="py-2">
           Brand Name
          </th>
          <th class="py-2">
           Quality
          </th>
          <th class="py-2">
           Expiry
          </th>
          <th class="py-2">
           Description
          </th>
         </tr>
        </thead>
        <tbody id="userTableBody">
            <tr class="border-t">
             <td class="py-2">
              <img alt="User profile picture" class="rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/sxf1h605GKQ1fUWkSLeB31Sbzc3f4wOgdl9seHX7keCXrEA6E.jpg" width="40"/>
             </td>
             <td class="py-2">
              Enervoon
             </td>
             <td class="py-2">
              Enervon
             </td>
             <td class="py-2">
              Good
             </td>
             <td class="py-2">
              9 Months
             </td>
             <td class="py-2">
              Use Responsibly
             </td>
            </tr>
        <tbody id="userTableBody">
            <tr class="border-t">
             <td class="py-2">
              <img alt="User profile picture" class="rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/sxf1h605GKQ1fUWkSLeB31Sbzc3f4wOgdl9seHX7keCXrEA6E.jpg" width="40"/>
             </td>
             <td class="py-2">
              Enervoon
             </td>
             <td class="py-2">
              Enervon
             </td>
             <td class="py-2">
              Good
             </td>
             <td class="py-2">
              9 Months
             </td>
             <td class="py-2">
              Use Responsibly
             </td>
            </tr>    
        <tbody id="userTableBody">
            <tr class="border-t">
             <td class="py-2">
              <img alt="User profile picture" class="rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/sxf1h605GKQ1fUWkSLeB31Sbzc3f4wOgdl9seHX7keCXrEA6E.jpg" width="40"/>
             </td>
             <td class="py-2">
              Enervoon
             </td>
             <td class="py-2">
              Enervon
             </td>
             <td class="py-2">
              Good
             </td>
             <td class="py-2">
              9 Months
             </td>
             <td class="py-2">
              Use Responsibly
             </td>
            </tr>
        </table>
       </div>
       </div>
       
<!-- INVENTORY -->

<div class="p-4 hidden" id="inventoryPage">
    <div class="bg-white shadow rounded-lg p-4">
     <div class="dropdown relative mb-4">
      <i class="fas fa-ellipsis-v cursor-pointer">
      </i>
      <div class="dropdown-menu absolute hidden text-gray-700 pt-1">
       <table class="bg-white shadow rounded-lg">
        <!-- <tr>
         <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
          Add Medicine
         </td>
        </tr>
        <tr>
         <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
          Edit Medicine
         </td>
        </tr>
        <tr>
         <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
          Delete Medicine
         </td>
        </tr> -->
        </table>
        </div>
        </div>
        <table class="w-full text-left">
         <thead>
          <tr>
           <th class="py-2">
            ID
           </th>
           <th class="py-2">
            Type of Medicine
           </th>
           <th class="py-2">
            Brand Name
           </th>
           <th class="py-2">
            Quantity
           </th>
           <th class="py-2">
            Expiration
           </th>
           <th class="py-2">
            Expires On
           </th>
          </tr>
         </thead>
         <tbody id="userTableBody">
            <tr class="border-t">
             <td class="py-2">
              2024123456
            </td>
             <td class="py-2">
              Vitamins
             </td>
             <td class="py-2">
              Enervon
             </td>
             <td class="py-2">
              Good
             </td>
             <td class="py-2">
              9 Months
             </td>
             <td class="py-2">
              Febuary 2026
             </td>
            </tr>
        </div>
        </div>
        
<!-- TRANSACTIONS -->
<!-- 
<div class="p-4 hidden" id="transactionsPage">
    <div class="bg-white shadow rounded-lg p-4">
     <div class="dropdown relative mb-4">
      <i class="fas fa-ellipsis-v cursor-pointer">
      </i>
      <div class="dropdown-menu absolute hidden text-gray-700 pt-1">
       <table class="bg-white shadow rounded-lg">
        <tr>
         <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
          Add Medicine
         </td>
        </tr>
        <tr>
         <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
          Edit Medicine
         </td>
        </tr>
        <tr>
         <td class="px-4 py-2 hover:bg-gray-200 cursor-pointer">
          Delete Medicine
         </td>
        </tr>
        </table>
        </div>
        </div>
        <table class="w-full text-left">
         <thead>
          <tr>
           <th class="py-2">
            ID
           </th>
           <th class="py-2">
            Type of Medicine
           </th>
           <th class="py-2">
            Brand Name
           </th>
           <th class="py-2">
            Quantity
           </th>
           <th class="py-2">
            Expiration
           </th>
           <th class="py-2">
            Expires On
           </th>
          </tr>
         </thead>
         <tbody id="userTableBody">
            <tr class="border-t">
             <td class="py-2">
              <img alt="User profile picture" class="rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/sxf1h605GKQ1fUWkSLeB31Sbzc3f4wOgdl9seHX7keCXrEA6E.jpg" width="40"/>
             </td>
             <td class="py-2">
              Enervoon
             </td>
             <td class="py-2">
              Enervon
             </td>
             <td class="py-2">
              Good
             </td>
             <td class="py-2">
              9 Months
             </td>
             <td class="py-2">
              Febuary 2026
             </td>
            </tr>
        </div>
        </div>
        -->

</body>
</html>