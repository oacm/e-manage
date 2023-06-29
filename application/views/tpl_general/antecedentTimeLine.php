<li>
    <a href="<?php echo base_url() . "$path/$file" . $extension . "?timestamp=" . rand(); ?>" target="_blank" class="selected">
        <span class="step_no">
            <i class="fa fa-file-pdf-o"></i>
        </span>
        <span class="step_descr">
            <?php echo "$code_out-$num_doc_out/$year_doc_out" === "-/" ? "$code-$num_document/$year_document" : "$code_out-$num_doc_out/$year_doc_out"; ?><br />
            <small><?php echo date("d / m / Y", strtotime($date_modification)); ?></small>
        </span>
    </a>
</li>