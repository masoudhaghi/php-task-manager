<?php
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Access Denied');
}

$tasks = mysql_query("SELECT * FROM `tasks` ORDER BY `id` DESC LIMIT {$page['start']},{$page['limit']}");
$count_tasks = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS `count` FROM `tasks`"));
// tasks count
$tasks_count = $count_tasks['count'];
// pagination
$pagination['total'] = ceil($tasks_count / $page['limit']);
$pagination['start'] = $page['current'] <= 3 ? 1 : $page['current'] - 3;
$pagination['end'] = $page['current'] + 3 >= $pagination['total'] ? $pagination['total'] : $page['current'] + 3;
?>
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
                        <h4 class="card-title">Tasks</h4><br />
                        <div class="card-text">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
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
                            <td colspan=\"5\"><div class=\"alert alert-info\"><strong>Info!</strong> Cannot find any task in the system, but you can <a href=\"index.php?page=new-task\" class=\"alert-link\" title=\"New Task\">create a new task</a> now.</div></td>
                        </tr>\n";
                    }
                ?>
                <nav>
                    <ul class="pagination">
                    <?php
                        if ($page['current'] > 1) {
                            echo "<li class=\"page-item\">
                                <a class=\"page-link\" href=\"index.php?page=home&amp;pagenum={$page['previous']}\" aria-label=\"Previous\">
                                <span aria-hidden=\"true\">&raquo;</span>
                                <span class=\"sr-only\">Previous</span>
                                </a>
                            </li>\n";
                        }
                        if ($pagination['total'] < 10) {
                            // the pages are less than 10, print them all
                            for ($i = 1; $i <= $pagination['total']; $i++) {
                                $cur = $page['current'] == $i ? "active" : "";
                                echo "<li class=\"page-item $cur\"><a class=\"page-link\" href=\"index.php?page=home&amp;pagenum={$i}\" title=\"Tasks - Page {$i}\">{$i}</a></li>\n";
                            }
                        } else {
                            // the pages are more than 10, so we use custom logic
                            if ($page['current'] > 6) {
                                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=home&amp;pagenum=1\" title=\"Tasks - Page 1\">1</a></li>\n";
                                echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" title=\"\">...</a></li>\n";
                            }
                            for ($i = $pagination['start']; $i <= $pagination['end']; $i++) {
                                $cur = $page['current'] == $i ? "active" : "";
                                echo "<li class=\"page-item $cur\"><a class=\"page-link\" href=\"index.php?page=home&amp;pagenum={$i}\" title=\"Tasks - Page {$i}\">{$i}</a></li>\n";
                            }
                            if ($page['current'] + 5 < $pagination['total']) {
                                echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" title=\"\">...</a></li>\n";
                                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=home&amp;pagenum={$pagination['total']}\" title=\"Tasks - Page {$pagination['total']}\">{$pagination['total']}</a></li>\n";
                            }
                        }
                        if ($page['current'] < $pagination['total']) {
                        echo "<li class=\"page-item\">
                            <a class=\"page-link\" href=\"index.php?page=home&amp;pagenum={$page['next']}\" aria-label=\"Next\">
                            <span aria-hidden=\"true\">&laquo;</span>
                            <span class=\"sr-only\">Next</span>
                            </a>
                        </li>\n";
                        }
                    ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>