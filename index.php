<?php
	session_start();
	
	$user = "infostudent";
	$pswd = 'p@$$w0rd';
	$servername = "localhost";
	$databname = "bugmedatabase";
	$ad = "admin@bugme.com";
	
	if(isset($_SESSION['user'])){
		$loggedin ="";
		if($_SESSION['user'] == $ad){
			$addu = true;
		}else{
			$addu = false;
		}	
	}else{
		$loggedin = "disabled";
		$addu = true;
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if($_POST['status'] == 'login'){
			loginUser($user,$pswd,$servername,$databname,$_POST['username'],$_POST['password'],$ad);
		}else if($_POST['status'] == 'logout'){
			unset($_SESSION['user']);
			$loggedin = "";
			$loggedin = "";
		}else if($_POST['status'] == 'addissue'){
			addIssue($user,$pswd,$servername,$databname,$_POST['title'],$_POST['description'],$_POST['assigned'],$_POST['priority'],$_POST['typed']);
		}else if($_POST['status'] == 'adduser'){
			addUser($user,$pswd,$servername,$databname,$_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['password']);
		}else if($_POST['status'] == 'setupdate'){
			updateIssue($user,$pswd,$servername,$databname,$_POST['id'],$_POST['mark']);
		}
	}else if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['user']) && isset($_GET['status']) ){
		 if($_GET['status'] == 'getusers'){
			getUsers($user,$pswd,$servername,$databname);
		}else if($_GET['status'] == 'getissues'){
			getIssues($user,$pswd,$servername,$databname);
		}else if($_GET['status'] == 'getiss'){
			getIssue($user,$pswd,$servername,$databname,$_GET['id']);
		}else if($_GET['status'] == 'getuserid'){
			echo $_SESSION['user_id'];
		}
	}else{
?>

<html>
<head>
	<title>BugMe</title>
	<link href="styles/style.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<header class="navcustom">
	  <a href="#"><i class="fa fa-bug mr-3 cwhite" aria-hidden="true"></i><b class="cwhite">BugMe Issue Tracker</b></a>
	</header>
	<div class="row">
	  <div class="col-3">
		<div class="nav flex-column nav-pills sidenav" id="v-pills-tab" role="tablist" aria-orientation="vertical">
		  <a class="nav-link side" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-home" aria-hidden="true"></i><b> Home</b></a>
		  <a class="nav-link side <?php echo $loggedin;?> <?php if($addu){echo 'activeshow2';}else{echo 'inactivehide2'; }?>" id="v-pills-adduser-tab" data-toggle="pill" href="#v-pills-adduser" role="tab" aria-controls="v-pills-adduser" aria-selected="false"><i class="fa fa-user-plus fa-flip-horizontal"></i><b> Add User</b></a>
		  <a class="nav-link side <?php echo $loggedin;?>" id="v-pills-newissues-tab" data-toggle="pill" href="#v-pills-newissues" role="tab" aria-controls="v-pills-newissues" aria-selected="false"><i class="fa fa-plus-circle"></i><b> New Issue</b></a>
		  <a class="nav-link side <?php echo $loggedin;?>" id="v-pills-logoff-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false"><i class="fa fa-power-off"></i><b> Logout</b></a>
		</div>
	  </div>
	  <div class="col-9 content">
	  <div class="tab-content" id="pills-tabContent">
		  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
			<div id="login" class="<?php if($loggedin!=""){echo 'activeshow';}else{echo 'inactivehide'; }?>">
			<form>
			  <h1>Login</h1>
			  <div class="form-group">
				<label for="email">Username</label>
				<input type="email" class="form-control" id="email" placeholder="">
				<p class="invalid" >Invalid Email</p>
			  </div>
			  <div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" placeholder="">
				<p class="invalid" >Invalid Password</p>
			  </div>
			  <button type="button" id="loginbtn" class="btn btn-primary">Login</button>
			</form>
		  </div>
		  <div id="home" class="<?php if($loggedin==""){echo 'activeshow';}else{echo 'inactivehide'; }?>">
			<span><h1 class="float-left">New User</h1><button type="button" class="btn btn-success float-right mt-2" data-toggle="pill" href="#v-pills-newissues" role="tab" aria-controls="v-pills-newissues" aria-selected="false">Add New Issue</button></span>
			<br><br><br><br>
			<div class="pb-8"><h5 class="float-left">Filter By:</h5>
			<button onclick="filter(this,'a')" type="button" class="filters btn btn-primary float-left ml-5" id="displayall"><b>ALL</b></button>
			<button onclick="filter(this,'o')" type="button" class="filters btn custombtnlink float-left ml-5"><b>OPEN</b></button>
			<button onclick="filter(this,'m')" type="button" class="filters btn custombtnlink float-left ml-5"><b>MY TICKETS</b></button>
			</div>
			<br><br>
			<table class="table">
				  <thead>
					<tr>
					  <th scope="col">Title</th>
					  <th scope="col">Type</th>
					  <th scope="col">Status</th>
					  <th scope="col">Assigned To</th>
					  <th scope="col">Created</th>
					</tr>
				  </thead>
				  <tbody id="table_data">
					<?php 
						if(isset($_SESSION['user'])){
							getIssues($user,$pswd,$servername,$databname); 
						}
					?>
				  </tbody>
			</table>
		  </div>
		  </div>
		  <div class="tab-pane fade" id="v-pills-adduser" role="tabpanel" aria-labelledby="v-pills-adduser-tab">
			<form>
			  <h1>New User</h1>
			  <div class="form-group">
				<label for="firstname">FirstName</label>
				<input type="text" class="form-control" id="firstname" placeholder="">
			  </div>
			   <div class="form-group">
				<label for="lastname">LastName</label>
				<input type="text" class="form-control" id="lastname" placeholder="">
			  </div>
			  <div class="form-group">
				<label for="setpassword">Password</label>
				<input type="password" class="form-control" id="setpassword" placeholder="">
			  </div>
			  <div class="form-group">
				<label for="setemail">Email</label>
				<input type="email" class="form-control" id="setemail" placeholder="">
			  </div>
			  <button type="button" id="submituserbtn" class="btn btn-primary pr-5 pl-5 ">Submit</button>
			</form>
		  </div>
		  <div class="tab-pane fade" id="v-pills-newissues" role="tabpanel" aria-labelledby="v-pills-newissues-tab">
				<h1>Add Issue</h1>
				<form>
				  <div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" placeholder="">
				  </div>
				  <div class="form-group">
					<label for="description">Description</label>
					<textarea class="form-control" id="description" rows="3"></textarea>
				  </div>
				  <div class="form-group">
					<label for="assigned">Assigned to</label>
					<select class="form-control" id="assigned">
					</select>
				  </div>
				  <div class="form-group">
					<label for="typed">Type</label>
					<select class="form-control" id="typed">
					  <option value="Bug">Bug</option>
					  <option value="Proposal">Proposal</option>
					  <option value="Task">Task</option>
					</select>
				  </div>
				  <div class="form-group">
					<label for="priority">Priority</label>
					<select class="form-control" id="priority">
					  <option value="Minor" >Minor</option>
					  <option value="Major" >Major</option>
					  <option value="Critical" >Critical</option>
					</select>
				  </div>
				  <button type="button" id="submitissuebtn" class="btn btn-primary pr-5 pl-5 ">Submit</button>
				  <br><br>
				</form>
		  </div>
		  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel">
				 
		  </div>
		  </div>
		</div>
	  </div>
	</div>
		

	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="scripts/script.js" type="text/javascript" ></script>
</body>
</html>
<?php 
	}
				
	function loginUser($user,$pswd,$servername,$databname,$e,$p,$ad){
		try {
				$conn = new PDO("mysql:host=$servername;dbname=$databname", $user, $pswd);
				$stmt = $conn->prepare("SELECT id,email,password FROM Users WHERE email='$e';");
				$stmt->execute();
				
				
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if($data['password'] == ""){
					echo "Invalid Email";
				}else if($data['password'] == md5($p)){
					echo $e;
					echo "|";
					echo $ad;
					$loggedin = "";
					$_SESSION['user'] = $e;
					$_SESSION['user_id'] = $data['id'];
				}else{
					echo "Invalid Password";
                }
				
			}
		catch(PDOException $e)
			{
			echo "Connection failed: " . $e->getMessage();
			}
	}
	function getUsers($user,$pswd,$servername,$databname){
		try {
				$conn = new PDO("mysql:host=$servername;dbname=$databname", $user, $pswd);
				$stmt = $conn->prepare("SELECT id,firstname,lastname FROM Users;");
				$stmt->execute();
				
				
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach($data as $row){
					echo '<option value='.$row['id'].'>'.$row['firstname'].' '.$row['lastname'].'</option>';
				}
			}
		catch(PDOException $e)
			{
			echo "Connection failed: " . $e->getMessage();
			}
	}
	
	function getIssues($user,$pswd,$servername,$databname){
		try {
				$conn = new PDO("mysql:host=$servername;dbname=$databname", $user, $pswd);
				$stmt = $conn->prepare("SELECT Issues.id,Issues.title,Issues.type,Issues.status,Issues.created,Issues.created_by,Users.firstname,users.lastname FROM Issues join Users on Issues.assigned_to = Users.id;");
				$stmt->execute();
				
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach($data as $row){
					echo '
					 <tr>
					  <th scope="row">#'.$row['id'].' <a onclick="getprofile('."'".$row['id']."'".')" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">'.$row['title'].'</a></th>
					  <td>'.$row['type'].'</td>';
			
					  if($row['status']=="open"){
						  echo '<td><button type="button" class="btn btn-success" disabled>'.$row['status'].'</button><input type="hidden" value="'.$row['created_by'].'" ></td>';
					  }else if($row['status']=="closed"){
						   echo '<td><button type="button" class="btn btn-danger" disabled>'.$row['status'].'</button><input type="hidden" value="'.$row['created_by'].'" ></td>';
					  }else{
						   echo '<td><button type="button" class="btn btn-warning" disabled>'.$row['status'].'</button><input type="hidden" value="'.$row['created_by'].'" ></td>';
					  }
					 
					echo 
					 '<td>'.$row['firstname'].' '.$row['lastname'].'</td>
					  <td>'.$row['created'].'</td>
					</tr>';
				}
			}
		catch(PDOException $e)
			{
			echo "Connection failed: " . $e->getMessage();
			}
	}
	
	function addIssue($user,$pswd,$servername,$databname,$t,$d,$a,$p,$tp){
		try {
				$conn = new PDO("mysql:host=$servername;dbname=$databname", $user, $pswd);
				$stmt = $conn->prepare("INSERT INTO Issues (title,description,type,priority,status,assigned_to,created_by,created,updated) VALUES ('$t','$d','$tp','$p','OPEN',$a,".$_SESSION['user_id'].",CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP());");
				
				$stmt->execute();
				echo "200 OK";
			}
		catch(PDOException $e)
			{
			echo "Connection failed: " . $e->getMessage();
			}
	}
	
	function getIssue($user,$pswd,$servername,$databname,$i){
		try {
				$conn = new PDO("mysql:host=$servername;dbname=$databname", $user, $pswd);
				#echo '<script>alert("'.$i.'")</script>';
				$stmt = $conn->prepare("SELECT Issues.id,Issues.description,Issues.title,Issues.type,Issues.status,Issues.priority,Issues.created,Issues.updated,Users.firstname,users.lastname FROM Issues join Users on Issues.assigned_to = Users.id WHERE Issues.id=$i;");
				
				$stmt->execute();
				$stmt2 = $conn->prepare("SELECT Users.firstname,users.lastname FROM Issues join Users on Issues.created_by = Users.id WHERE Issues.id=$i;");
				
				$stmt2->execute();
				
				$data2 = $stmt2->fetch(PDO::FETCH_ASSOC);
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				echo '
				<h1>'.$data['title'].'</h1>
				 <h5>Issue #'.$data['id'].'</h5>
				 <div class="float-left" style="width:65%;">
				 <p>'.$data['description'].'
					<p>
				 <span style="color:lightgray"><i class="fa fa-angle-right" aria-hidden="true"></i><em class="secondary">Issue created on  '.$data['created'].' by '.$data2['firstname'].' '.$data2['lastname'].'</em></span>
				 <br>
				 <span style="color:lightgray"><i class="fa fa-angle-right" aria-hidden="true"></i><em class="secondary">Last Updated on '.$data['updated'].'</em></span>
				 </div>
				 <div class="float-right" style="width:30%">
					 <div class="p-3" style="width:100%;background:rgb(240,240,240);border:1px solid black">
					 <p><b>Assigned To</b><br>'.$data['firstname'].' '.$data['lastname'].'</p>
					 <p><b>Type</b><br>'.$data['type'].'</p>
					 <p><b>Priority</b><br>'.$data['priority'].'</p>
					 <p><b>Status</b><br>'.$data['status'].'</p>
					 </div>
					  <br>
					 <button data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false" onclick="markissue('."'c'".','.$data['id'].')" type="button" class="btn btn-primary mb-3" style="width:100%;">Mark as Closed</button>
					 <button data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" onclick="markissue('."'p'".','.$data['id'].')" type="button" class="btn btn-success mb-3" style="width:100%;">Mark in Progress</button>
				 </div>';
			}
		catch(PDOException $e)
			{
			echo "Connection failed: " . $e->getMessage();
			}
	}
	
	function addUser($user,$pswd,$servername,$databname,$f,$l,$e,$p){
		try {
				$conn = new PDO("mysql:host=$servername;dbname=$databname", $user, $pswd);
				$stmt = $conn->prepare("INSERT INTO Users (firstname,lastname,password,email,date_joined) VALUES ('$f','$l',MD5('$p'),'$e',CURRENT_TIMESTAMP());");
				
				$stmt->execute();
				echo "200 OK";
			}
		catch(PDOException $e)
			{
			echo "Connection failed: " . $e->getMessage();
			}
	}
	
	function updateIssue($user,$pswd,$servername,$databname,$i,$m){
		try {
				$conn = new PDO("mysql:host=$servername;dbname=$databname", $user, $pswd);
				$stmt = $conn->prepare("UPDATE Issues SET status = '$m', updated=CURRENT_TIMESTAMP() WHERE id = $i;");

				$stmt->execute();
				echo "200 OK";
			}
		catch(PDOException $e)
			{
			echo "Connection failed: " . $e->getMessage();
			}
	}
	
	
?>