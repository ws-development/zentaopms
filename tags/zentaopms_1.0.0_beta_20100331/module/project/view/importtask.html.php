<?php
/**
 * The importtask view file of project module of ZenTaoMS.
 *
 * ZenTaoMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * ZenTaoMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ZenTaoMS.  If not, see <http://www.gnu.org/licenses/>.  
 *
 * @copyright   Copyright 2009-2010 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     project
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<div class='yui-d0'>
  <form method='post' target='hiddenwin'>
  <table class='table-1 fixed tablesorter'>
    <thead>
    <tr class='colhead'>
      <th class='w-p15'><?php echo $lang->task->project;?></th>
      <th><?php echo $lang->task->id;?></th>
      <th><?php echo $lang->task->pri;?></th>
      <th class='w-p20'><?php echo $lang->task->name;?></th>
      <th><?php echo $lang->task->owner;?></th>
      <th><?php echo $lang->task->left;?></th>
      <th><?php echo $lang->task->type;?></th>
      <th><?php echo $lang->task->deadline;?></th>
      <th><?php echo $lang->task->status;?></th>
      <th class='w-p20'><?php echo $lang->task->story;?></th>
      <th class='w-50px'><?php echo $lang->project->import;?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($tasks2Imported as $task):?>
    <?php $class = $task->owner == $app->user->account ? 'style=color:red' : '';?>
    <tr class='a-center'>
      <td><?php echo $projects[$task->project];?></td>
      <td><?php if(!common::printLink('task', 'view', "task=$task->id", sprintf('%03d', $task->id))) printf('%03d', $task->id);?></td>
      <td><?php echo $task->pri;?></td>
      <td class='a-left nobr'><?php if(!common::printLink('task', 'view', "task=$task->id", $task->name)) echo $task->name;?></td>
      <td <?php echo $class;?>><?php echo $task->ownerRealName;?></td>
      <td><?php echo $task->left;?></td>
      <td><?php echo $lang->task->typeList[$task->type];?></td>
      <td class=<?php if(isset($task->delay)) echo 'delayed';?>><?php if(substr($task->deadline, 0, 4) > 0) echo $task->deadline;?></td>
      <td class=<?php echo $task->status;?> ><?php echo $lang->task->statusList[$task->status];?></td>
      <td class='a-left nobr'>
        <?php 
        if($task->storyID)
        {
            if(common::hasPriv('story', 'view')) echo html::a($this->createLink('story', 'view', "storyid=$task->storyID"), $task->storyTitle);
            else echo $task->storyTitle;
        }
        ?>
      </td>
      <td><input type='checkbox' name='tasks[]' value='<?php echo $task->id;?>' /></td>
    </tr>
    <?php endforeach;?>
    </tbody>
  </table>
  <div class='a-right'><?php echo html::submitButton($lang->project->importTask);?></div>
  </form>
</div>  
<?php include '../../common/view/footer.html.php';?>
