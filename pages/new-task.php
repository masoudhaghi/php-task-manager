<?php
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Access Denied');
}

$id = isset($_GET['id']) && $_GET['id'] != null && is_numeric($_GET['id']) ? $_GET['id'] : null;
$parent;
if ($id != null) {
    $parent = mysql_fetch_array(mysql_query("SELECT * FROM `tasks` WHERE `id`='{$id}'"));
}
$tasks = mysql_query("SELECT * FROM `tasks` ORDER BY `id` DESC");
if (isset($_POST['posttask'])) {
    if ($_POST['title'] != "") {
		$t_title = $_POST['title'];
		$t_parentid = $_POST['parent'];
		$t_description = $_POST['description'];

        if (mysql_query("INSERT INTO `tasks` (`title`, `parent_id`, `description`) VALUES ('$t_title', '$t_parentid', '$t_description')")) {
            message("success", "Your task has been created successfully.");
        } else {
            message("error", mysql_error());
        }
    }
}
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <form id="newtask" action="index.php?page=new-task" method="post">
                    <div class="card">
						<div class="card-block">
							<h4 class="card-title">New Task Details</h4>
							<p class="card-text">
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<fieldset class="form-group">
											<label for="title">Task Title</label>
											<input type="text" class="form-control" id="title" name="title" placeholder="New task title" required />
										</fieldset>
										<fieldset class="form-group">
											<label for="parent">Parent Task</label>
                                            <?php
                                            if ($parent != null) {
                                                echo "<input type=\"hidden\" id=\"parent\" name=\"parent\" value=\"{$parent['id']}\" />
                                                <div class=\"alert bg-faded\">
                                                    Parent Task: {$parent['title']}
                                                    <a href=\"index.php?page=new-task\" title=\"New Task\" class=\"close\"><span aria-hidden=\"true\">&times;</span></a>
                                                </div>\n";
                                            } else {
                                            ?>
											<select class="c-select form-control" id="parent" name="parent">
                                                <option></option>
                                                <?php
                                                while ($t = mysql_fetch_array($tasks)) {
                                                    echo "<option value=\"{$t['id']}\">{$t['title']}</option>\n";
                                                } 
                                                ?>
                                            </select>
                                            <?php
                                            }
                                            ?>
										</fieldset>
										<fieldset class="form-group">
											<label for="description">Task Description</label>
											<textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the task..."></textarea>
										</fieldset>
                                        <button type="submit" id="posttask" name="posttask" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Save</button>
									</div>
								</div>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>