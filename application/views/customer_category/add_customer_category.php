<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    echo "<table>";
    echo form_open('customer_category/add_category');
    echo "<tr><td>";echo form_label($this->lang->line('cate_name'));echo "</td><td>";echo form_input('name',set_value('name'),'id=name');echo "</td></tr>";
    echo "<tr><td>";echo form_submit('save',$this->lang->line('save'));echo "</td><td>";echo form_submit('cancel',$this->lang->line('cancel'));echo "</td></tr>";
    echo form_close();
    echo "</table>";
    echo validation_errors();

?>
