<?php
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Access Denied');
}

$id = isset($_GET['id']) && $_GET['id'] != null && is_numeric($_GET['id']) ? $_GET['id'] : null;
if ($id == null) redirect("index.php");
$task = mysql_fetch_array(mysql_query("SELECT * FROM `tasks` WHERE `id`='{$id}' "));
$tasks = mysql_query("SELECT * FROM `tasks` WHERE `parent_id`='{$id}' ORDER BY `id` DESC");
if (isset($_POST['posttask'])) {
    if ($_POST['title'] != "") {
		$t_title = $_POST['title'];
		$t_parentid = $_POST['parent'];
		$t_description = $_POST['description'];

        if (mysql_query("INSERT INTO `tasks` (`title`, `parent_id`, `description`) VALUES ('$t_title', '$t_parentid', '$t_description')")) {
            message("success", "Your task has been successfully created.");
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
                <div class="card">
                    <div class="card-block">
                        <a href="index.php?page=edit-task&amp;id=<?php echo $id; ?>" title="Edit Task" class="btn btn-secondary pull-right"><i class="fa fa-edit"></i><span class="sr-only">Edit Task</span></a>
                        <h4 class="card-title">Task: <?php echo $task['title']; ?></h4><br />
                        <p class="card-text">
                            <?php echo $task['description']; ?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small><i class="fa fa-clock-o"></i>&nbsp; created <time datetime="<?php echo $task['createdAt']; ?>"><?php echo $task['createdAt']; ?></time>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?php
                    if (mysql_num_rows($tasks) > 0) {
                ?>
                <div class="card">
                    <div class="card-block">
                        <a href="index.php?page=new-task" title="New Task" class="btn btn-primary pull-right"><i class="fa fa-plus"></i><span class="sr-only">New Task</span></a>
                        <h4 class="card-title">Child Tasks</h4><br />
                        <div class="card-text">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th width="40%">Title</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-xs-right">Options</th>
                                    </tr>
                                </thead>
                                <?php
                                    while ($t = mysql_fetch_array($tasks)) {
                                        echo "<tr class=\"clickable\" data-href=\"index.php?page=view-task&amp;id={$t['id']}\">
                                            <td>{$t['id']}</td>
                                            <td>{$t['title']}</td>
                                            <td>". getStatus($t['status']) ."</td>
                                            <td><time datetime=\"{$t['createdAt']}\">{$t['createdAt']}</time></td>
                                            <td class=\"text-xs-right\">
                                                <a href=\"index.php?page=edit-task&amp;id={$t['id']}\" title=\"Edit Task\" class=\"btn btn-secondary btn-sm\"><i class=\"fa fa-edit\"></i><span class=\"sr-only\">Edit</span></a>\n";
                                                if ($t['status'] == 0) {
                                                    echo "<a href=\"index.php?page=complete-task&amp;id={$t['id']}\" title=\"Complete Task\" class=\"btn btn-success btn-sm\"><i class=\"fa fa-check-square\"></i><span class=\"sr-only\">Mark as Complete</span></a>\n";
                                                }
                                                echo "<a href=\"index.php?page=delete-task&amp;id={$t['id']}\" title=\"Delete Task\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-remove\"></i><span class=\"sr-only\">Delete</span></a>
                                            </td>
                                        </tr>\n";
                                    };
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                    } else {
                        echo "<tr>
                            <td colspan=\"5\"><div class=\"alert alert-info\"><strong>Info!</strong> There are no child tasks in here. But you can <a href=\"index.php?page=new-task&amp;id={$id}\" class=\"alert-link\" title=\"New Task\">create a new task</a> now.</div></td>
                        </tr>\n";
                    }
                ?>
            </div>
        </div>
    </div>
</section>