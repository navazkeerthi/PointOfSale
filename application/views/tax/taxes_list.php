<?php
echo $links; 
echo form_open('taxes_ci/manage_taxes');
echo "<table>";echo "<tr><td> Select </td><td> Value</td><td>Tax Type</td></tr>";
foreach ($row as $trow ){ ?>
<tr><td><input type="checkbox" name="mycheck[]" value="<?php echo $trow->id ?>" /></td><td><?php echo $trow->value ?>%</td><td><?php echo $trow->type ?></td>
    <td><a href="<?php echo base_url() ?>index.php/taxes_ci/inactive/<?php echo $trow->id ?>">Edit</a></td><td><a href="<?php echo base_url() ?>index.php/taxes_ci/delete_tax/<?php echo $trow->id ?>">Delete</a><td><?php if($trow->status==0){ ?><a href="<?php echo base_url() ?>index.php/taxes_ci/inactive/<?php echo $trow->id ?>">Inactive</a><?php }else{ ?><a href="<?php echo base_url() ?>index.php/taxes_ci/active/<?php echo $trow->id ?>">Active</a><?php  } ?></td></td></tr>
<?php }
echo "<tr><td>";echo form_submit('delete',$this->lang->line('delete'));echo "</td><td>";echo form_submit('add_tax',$this->lang->line('add'));echo "</td></tr>";
echo "</table>";
?>
