<!--CREATE TASKS--!>


<!DOCTYPE html>
<?php include("_header.php"); 
include("_sidebar_header.php");?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1" content="height=device-height, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/style.css" type="text/css">

    <title>Create Task</title>


</head>

<body>
        <!-- Start Page Content -->

<?php 				//check if we have session id, redirect to landing if we don't
if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){
	$id = $_SESSION["uid"];
	$task_id = $_SESSION["tid"];
}
else{
	echo "Please sign in to access this page";
	sleep(1);
	header("Location: landing.php");
	exit();
}
if($result = $db->query("select * from task where task_id = '$task_id'")){				//get all the task related information for a given task id from the task table
		while($obj = $result->fetch_object()){
			$name = htmlspecialchars($obj->name);
			$start_date = htmlspecialchars($obj->start_date);			//* means start date, end date, desc, project_id, id, task type etc.
			$end_date = htmlspecialchars($obj->end_date);
			$desc = htmlspecialchars($obj->desc);
			$project_id = htmlspecialchars($obj->project_id);
			$m_id = htmlspecialchars($obj->m_id);
			$task_type_id = htmlspecialchars($obj->task_type_id);
			if($result2 = $db->query("select * from project where project_id = '$project_id'")){
				while($obj2 = $result2->fetch_object()){
					$project_name = htmlspecialchars($obj2->name);
				}
			}
			if($result3 = $db->query("select * from milestones where m_id = '$m_id'")){
				while($obj3 = $result3->fetch_object()){
					$milestone = htmlspecialchars($obj3->name);
				}
			}
			if($result4 = $db->query("select * from task_type where task_type_id = '$task_type_id'")){
				while($obj4 = $result4->fetch_object()){
					$task_type = htmlspecialchars($obj4->name);
				}
			}
		}
		$result->close();
}
?>




<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
<div class="container" >
  <div class="row">
	  <div class="col-md-6">
		  <br>
		  <div class="panel panel-info">
		  <div class="panel-heading">
              <h3 class="panel-title">Create Task</h3>
            </div>
			<div class="panel-body">
		  <div class="container-fluid" >				<!--Check for a given task and identify it's id--!>
				  <form data-toggle="validator" role="form" autocomplete="off" action="submit_edit_task.php" method="post">
					  <div class="form-group col-sm-6">
						  <label for="name" class="control-label">Task Name</label>
						  <?php echo "<input name='name' type='text' class='form-control' id='name' value='" . $name . "'>"; ?>
					  </div>
					  
					  <div class="form-group col-sm-6">
						  <label for="task_type" class="control-label">Task Type</label><br>
						  
							<?php
								$result = $db ->query("SELECT * FROM `task_type`");
								$option1.="<select name='task_type'>";
								while($obj = $result->fetch_object()){
									if($obj->task_type_id == $task_type_id){
										$option1.="<option value=" . $obj->task_type_id . " selected>" . $obj->name . "</option> ";
									}
									else{
										$option1.="<option value=" . $obj->task_type_id . ">" . $obj->name . "</option> ";
									}
								}
								$option1.="</select>"; 
								echo $option1;
							?>
						  
					  </div><br><br><br><br>
					  <div class="form-group col-sm-6">
						  <label for="project" class="control-label">Project</label><br>
						  
							<?php		//get the project id
								if($result2 = $db ->query("SELECT project_id, name FROM `project`")){
								
									$option2.="<select name='project'>";
									while($obj2 = $result2->fetch_object()){
										if($obj2->project_id == $project_id){
											$option2.="<option value=" . $obj2->project_id . " selected>" . $obj2->name . "</option> ";
										}
										else{
											$option2.="<option value=" . $obj2->project_id . ">" . $obj2->name . "</option> ";
										}
									}
									$option2.="</select>"; 
									echo $option2;
								}
								else
									echo "project error";
							?>
						  
					  </div>
					  
					  <div class="form-group col-sm-6">
						  <label for="milestone" class="control-label">Milestone</label><br>
						  
							<?php			//check if it's part of a milestone and display 
								if($result3 = $db ->query("SELECT * FROM `milestones`")){
								
									$option3.="<select name='milestone'>";
									while($obj3 = $result3->fetch_object()){
										if($obj3->m_id == $m_id){
											$option3.="<option value=" . $obj3->m_id . " selected>" . $obj3->name . "</option> ";
										}
										else{
											$option3.="<option value=" . $obj3->m_id . ">" . $obj3->name . "</option> ";
										}
									}
									$option3.="</select>"; 
									echo $option3;
								}
								else
									echo "milestone error";
							?>
						  
					  </div><br><br>
					  


					<!--display start, end, description--!>
					  <div class="form-group col-sm-6" align="left">
						  <label for="start_date" class="control-label">Start Date</label>
						  <?php echo "<input name='start_date' type='date' class='form-control' id='start_date' value=" . $start_date . ">"; ?>
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="end_date" class="control-label">End Date</label>
						  <?php echo "<input name='end_date' type='date' class='form-control' id='end_date' value=" . $end_date . ">"; ?>
					  </div><br>
					  <div class="form-group col-sm-12">
						  <label for="description" class="control-label">Description</label>
						  <textarea name="description" type="text" class="form-control" rows="3" placeholder="" required><?php echo $desc; ?></textarea>
					  </div><br>
					  
					  <div class="form-group" align= "right">
						  <button type="submit" class="btn btn-primary">Submit</button>
					  </div>
			  </form>
		  </div>
		  </div>
		  </div>
	  </div>
</div>	
</div>
</div>
</div>

	    <!-- End Page Content -->
		
</body>
<?php include("_sidebar_footer.php");?>
