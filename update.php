<?php
    include_once('config.php');
    $upd_orderid=$_GET['id'];
?>

<head>
<?php
        echo "<script>";
        echo "ClassName = new Array();";
        echo "ClassNameCost = new Array();";
        echo "NowSeletClass = 0;";
        echo "NowOneCost = 0;";
        echo "var class_count = 0;";
        
        // set ClassName & ClassNameCost
        $stmt = mysqli_prepare($con,"SELECT DISTINCT `productClass` FROM `Product` ORDER BY  `Product`.`productClass` ASC");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_productClass);
        while(mysqli_stmt_fetch($stmt)) {
            $stmt2 = mysqli_prepare($con,"SELECT `productName`,`productCost` FROM `Product` WHERE productClass = ?");
            mysqli_stmt_bind_param($stmt2,'s',$res_productClass);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_store_result($stmt2);
            mysqli_stmt_bind_result($stmt2, $res_productName, $res_productCost);
            echo "ClassName[class_count] = new Array();";
            echo "ClassNameCost[class_count] = new Array();";
            while(mysqli_stmt_fetch($stmt2)) {
                echo "ClassName[class_count].push('".$res_productName."'); ";
                echo "ClassNameCost[class_count].push('".$res_productCost."'); ";
            }
            echo "class_count++; ";
        }
        
        // chose new productClass reset productName's list 
        echo "function ReNewName(index){";
        echo "  var obj = document.getElementById('newform'); ";
        echo "  for(var i=0 ; i<ClassName[index].length ; i++)";
        echo "      obj.productName.options[i] = new Option( ClassName[index][i], ClassName[index][i] );";
        echo "  obj.productName.length = ClassName[index].length;";
        echo "  NowSeletClass = index;";
        echo "  ReNewCost(0); ";
        echo "}";
        
        // chose new productName reset display Cost
        echo "function ReNewCost(index){";
        echo "  var obj = document.getElementById('cost'); ";
        echo "  obj.innerHTML = ClassNameCost[NowSeletClass][index] + ' NTD * ';";
        echo "  NowOneCost = ClassNameCost[NowSeletClass][index];";
        echo "  ReNewTotalCost();";
        echo "}";
        
        // reset display TotalCost
        echo "function ReNewTotalCost(){";
        echo "  var form = document.getElementById('newform'); ";
        echo "  var num = form.productNum.value;";
        echo "  var obj = document.getElementById('totalcost'); ";
        echo "  var totalcost = num*NowOneCost; ";
        echo "  obj.innerHTML = '= ' + totalcost + ' NTD';";
        echo "  if(totalcost == 0){";
        echo "      form.add.disabled = true; ";
        echo "  } ";
        echo "  else{ ";
        echo "      form.add.disabled = false;";
        echo "  }";
        echo "}";
        
        
        // add new form
        echo "var first=true;";
        echo "function add_new_data() { ";
        echo "  if(first) {";
        echo "      var obj = document.getElementById('newform'); ";
        echo "      new_element = document.createElement('select'); ";
        echo "      new_element.setAttribute('name','productClass'); ";
        echo "      new_element.setAttribute('onChange','ReNewName(this.selectedIndex);'); ";
        echo "      obj.appendChild(new_element); ";
        $stmt = mysqli_prepare($con,"SELECT DISTINCT `productClass` FROM `Product` ORDER BY  `Product`.`productClass` ASC");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_productClass);
        while(mysqli_stmt_fetch($stmt)) {
            echo "var new_option = new Option('".$res_productClass."','".$res_productClass."'); "; 
            echo "new_element.options.add(new_option); ";
        }
        echo "      new_element = document.createElement('select'); ";
        echo "      new_element.setAttribute('name','productName'); ";
        echo "      new_element.setAttribute('onChange','ReNewCost(this.selectedIndex);'); ";
        echo "      obj.appendChild(new_element); ";        
        echo "      new_element = document.createElement('lable'); ";
        echo "      new_element.setAttribute('id','cost'); ";
        echo "      new_element.innerHTML = '0 NTD * '; ";
        echo "      obj.appendChild(new_element); "; 
        echo "      new_element = document.createElement('input'); ";
        echo "      new_element.setAttribute('name','productNum'); ";
        echo "      new_element.setAttribute('type','number'); ";
        echo "      new_element.setAttribute('value','0'); ";
        echo "      new_element.setAttribute('onChange','ReNewTotalCost();'); ";
        echo "      new_element.setAttribute('onKeyup','ReNewTotalCost();'); ";
        echo "      new_element.setAttribute('onMouseup','ReNewTotalCost();'); ";
        echo "      obj.appendChild(new_element); ";     
        echo "      new_element = document.createElement('lable'); ";
        echo "      new_element.setAttribute('id','totalcost'); ";
        echo "      new_element.innerHTML = '= 0 NTD'; ";
        echo "      obj.appendChild(new_element); ";
        echo "      new_element = document.createElement('input');";
        echo "      new_element.setAttribute('name','orderid'); ";
        echo "      new_element.setAttribute('type','hidden');";
        echo "      new_element.setAttribute('value','".$upd_orderid."');";
        echo "      obj.appendChild(new_element);";
        echo "      new_element = document.createElement('input');";
        echo "      new_element.setAttribute('name','add'); ";
        echo "      new_element.setAttribute('type','submit');";
        echo "      new_element.setAttribute('disabled','false');";
        echo "      new_element.setAttribute('value','新增');";
        echo "      obj.appendChild(new_element);";
        echo "      first = false; ";
        echo "      ReNewName(0); ";
        echo "      ReNewCost(0); ";
        echo "  } ";
        echo "}";
        echo "</script> ";
?>
</head>
<body>
<?php

    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['access']) && $_SESSION['access']==true) {

        $stmt = mysqli_prepare($con,"SELECT * FROM `Order` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$upd_orderid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_orderID ,$res_orderDate ,$res_shopID ,$res_totalCost);

        //list the order which been select
        echo "<table>";
        echo "<tr>";
        if($_SESSION['permission']=='admin') {
            echo "<th colspan=4>";
        }
        else{
            echo "<th colspan=3>";
        }
        echo "要修改的訂單:</th></tr>";
        echo "<tr>";
        echo "<td>訂單ID</td>";
        echo "<td>訂單日期</td>";
        if($_SESSION['permission']=='admin') {
            echo "<td>shopID</td>";
        }
        echo "<td>總金額</td>";
        echo "</tr>";
        while(mysqli_stmt_fetch($stmt)) {
            echo "<tr>";
            echo "<td>".$res_orderID."</td>";
            echo "<td>".$res_orderDate."</td>";
            if($_SESSION['permission']=='admin') {
                echo "<td>".$res_shopID."</td>";
            }
            echo "<td>".$res_totalCost."</td>";
            echo "</tr>";
        }      
        echo "</table><br>";
        //END list the order which been select 

        
        $stmt = mysqli_prepare($con,"SELECT * FROM `Subscribe` NATURAL JOIN `Product` WHERE `orderID` = ? ORDER BY  `Product`.`productClass` ASC ,  `Product`.`productName` ASC");
        mysqli_stmt_bind_param($stmt,'s',$upd_orderid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_productID, $res_subscribeID, $res_orderID, $res_pruductNum, $res_productClass, $res_productName, $res_productCost);

        // `Subscribe` should not have subscribeID in our design
        echo "<table id='updatetable'>";
        echo "<tr>";
        echo "<th>類別</th>"; 
        echo "<th>名稱</th>";
        echo "<th>單價</th>";
        echo "<th>數量</th>";
        echo "</tr>";
        echo "<tr>";
        while(mysqli_stmt_fetch($stmt)) {
            echo "<tr>";
            echo "<td>".$res_productClass."</td>";
            echo "<td>".$res_productName."</td>";
            echo "<td>".$res_productCost."</td>";
            echo "<td>
                    <form action='update-result.php' method='post'>
                        <input type='number' value=".$res_pruductNum." name='num'>
                        <input type='hidden' value=".$upd_orderid." name='oid'>
                        <input type='hidden' value=".$res_productID." name='pid'>
                        <input type='submit' value='修改'>
                    </form>
                 </td>";
            echo "<td>
                    <form action='del-sub-result.php' method='post'>
                        <input type='hidden' value=".$upd_orderid." name='oid'>
                        <input type='hidden' value=".$res_productID." name='pid'>
                        <input type='submit' value='刪除'>
                    </form>
                 </td>";
            echo "</tr>";
        }      
        echo "</table><br>";

        echo "<input type='submit' value='新增物品' onclick='add_new_data();'>";
        echo "<form id='newform' action='add-sub-result.php' method='post'>";
        echo "</form>";
        
        if($_SESSION['permission']=='admin') {
            echo "<a href='admin.php'>back to main page</a>";
        } else {
            echo "<a href='user.php'>back to main page</a>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);
    } else {
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 3; url=index.php');
    }
?>
</body>
