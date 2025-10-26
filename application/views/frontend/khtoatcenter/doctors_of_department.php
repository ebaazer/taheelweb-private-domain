<?php if (count($doctors) <= 0) { 
    if (isset($department)) {
        $value = $this->lang->line('no_doctor_found_under').' '. $department->name.' '.$this->lang->line('department');
    } else {
        $value = $this->lang->line('select_a_department_first');
    }    
?>
    <input type="text" class="form-control input-lg"
        value="<?php echo $value;?>" disabled>
<?php } else { ?>
    <select class="form-control" name="doctor_id">
        <?php foreach ($doctors as $row) { ?>
            <option value="<?php echo $row['doctor_id'];?>">
                <?php echo $row['name'];?>
            </option>
        <?php } ?>
    </select>
<?php } ?>