<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<style>
.container {max-width: 800px;margin: 20px auto;}
table {margin-left:150px;width: 1000px;border-collapse: collapse;margin-top: 0px;box-shadow: 0 10px 10px 0 rgba(0, 0, 0, 0.1);}
thead {background-color: #333;color: white;}
th, td {padding: 12px;text-align: left;border-bottom: 1px solid #ddd;}
tr:nth-child(even) {background-color: #f9f9f9;}
tr:hover {background-color: #f1f1f1;}
.float-right {float: right;margin-top: 10px;margin-right:50px;border:none;}
.float-right a {display: block; padding: 10px 15px;background-color:blue;color: white;text-decoration: none;border-radius: 5px;}
.float-right a:hover {background-color: green;}
.search{background-color:blue;border:none;padding:5px 15px;color:white;border-radius:5px;}
.insert{background-color:blue;border:none;padding:8px 10px;color:white;border-radius:5px;}
.pagination {display: flex;list-style: none;padding: 0;justify-content: center;margin-left:150px;}
.pagination a {display: inline-block;padding: 10px;margin: 5px;background-color: #ddd;text-decoration: none;color: black;border-radius: 5px;}
.pagination a:hover {background-color: #ccc;}
.pagination a:active {background-color: blue;color: white;}
strong{margin-left:150px;}
span{color:red;margin-left:300px;}
</style>
<?php include 'index.php'?>
<div class="container-fluid position-relative">
    <h1 class="text-center">Records</h1>
    <div class="container">
    <div class="row">
        <div class="options ml-auto"> 
            <input type="text" id="searchInput" placeholder="Search">
            <button class="search">Search</button>
            <a href="party.php" class="insert" >Insert</a>
        </div>
    </div>
</div>
<div class="float-left">
<table>
         <thead class=thead-dark>
            <th class="text-center">S.No</th>
            <th class="text-center">Party Name</th>
            <th class="text-center">Phone</th>
            <th class="text-center">City</th>
            <th class="text-center">State</th>
            <th class="text-center">Address</th>
            <th class="text-center">Action</th>
            
         </thead>
         <tbody>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "test";
        
        
        $conn = new mysqli($servername, $username, $password, $database);
//Pagination
$page_no ="";
$total_no_of_pages=""; 
        if(isset($_POST['input']))
        {
           $input=$_POST['input'];
        }
        if(!empty($input))
          {
            $search = mysqli_real_escape_string($conn, $_POST['input']);
            $query = "SELECT * FROM party WHERE name  LIKE '{$input}%' ";
          }
        else
        {
            $query = "SELECT * FROM party ";
        }
            
        $result= mysqli_query($conn,$query);
            if(mysqli_num_rows($result)>0)
            {
              if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                  $page_no = $_GET['page_no'];
                  } else {
                      $page_no = 1;
                      }
                        
            $total_records_per_page = 5; 
            $offset = ($page_no-1) * $total_records_per_page;
            $previous_page = $page_no - 1;
            $next_page = $page_no + 1;
            $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `party`");
            $total_records = mysqli_fetch_array($result_count);
            $total_records = $total_records['total_records'];
            $total_no_of_pages = ceil($total_records / $total_records_per_page);
            $second_last = $total_no_of_pages - 1; 
                  
            $result = mysqli_query($conn,"SELECT * FROM `party` LIMIT $offset, $total_records_per_page");  
            }
            
        // $sql="SELECT * FROM party";
        // $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){
            ?>
              
                        <td class="text-center"><?php echo $row['id']; ?> </td>
                        <td class="text-center"><?php echo $row['name']; ?> </td>
                        <td class="text-center"><?php echo $row['phone']; ?> </td>
                        <td class="text-center"><?php echo $row['city']; ?> </td>
                        <td class="text-center"><?php echo $row['state']; ?> </td>
                        <td class="text-center"><?php echo $row['address']; ?> </td>
                        <td class="text-center"><button class="btn btn-primary"><a href="party.php?id=<?php echo $row['id']; ?>" class="text-light">Update</a></button> 
                        <button class="btn btn-danger"><a href="partydelete.php?id=<?php echo $row['id']; ?>" class="text-light">Delete</a></button> </td>
                  </tr>
              <?php 
        }
    
        ?>
        </tbody>           
        </table>
    <span id="noResult">No result found</span>

<ul class="pagination">
  <?php


if ($total_no_of_pages <= 20)
{   
    if ($page_no > 1) {
    echo "<li><a href='?page_no=".($page_no-1)."' class='button'>Previous</a></li>"; 
    }
    for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
    if ($counter == $page_no) {
    echo "<li class='active'><a>$counter</a></li>"; 
            }else{
        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                }
        }

        if ($page_no < $total_no_of_pages){
        echo "<li><a href='?page_no=".($page_no+1)."' class='button'>Next</a></li>";
        }
    
    }

            
    
?>
</ul> 
<div class="text-center">  
<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
    <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
   </div>
</div>
</div>      
</div>
</div>
</div>
<!-- Search filter -->
<script>
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            var searchText = $(this).val().toLowerCase();
            var found = false;

            $("tbody tr").filter(function () {
                var name = $(this).find("td:eq(1)").text().toLowerCase();
                var city = $(this).find("td:eq(3)").text();

                var matchname = name.includes(searchText);
                var matchcity = city.includes(searchText);

                var match = matchname || matchcity;
                $(this).toggle(match);

                if (match) {
                    found = true;
                }
            });

            if (!found) {
                $("#noResult").show();
            
            } else {
                $("#noResult").hide();
            }
        });
    });
</script>
</body>
</html>