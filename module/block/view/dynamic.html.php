<div class='panel-body'>
  <ul class="timeline timeline-tag-left">
    <?php 
    $i = 0;
    foreach($actions as $action)
    {
        $user = isset($users[$action->actor]) ? $users[$action->actor] : $action->actor;
        if($action->action == 'login' or $action->action == 'logout' or empty($action->objectLink)) $action->objectName = $action->objectLabel = '';
        $class = $i % 3 == 0 ? "class='active'" : '';
        echo "<li $class><div>";
        printf($lang->block->dynamicInfo, $action->date, $user, $action->actionLabel, $action->objectLabel, $action->objectLink, $action->objectName);
        echo "</div></li>";
        $i++;
    }
    ?>
  </ul>
</div>
