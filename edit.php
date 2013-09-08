<?php require 'edit.init.php';?>
<?php require 'header.php';?>
                    
                    <ol class="breadcrumb">
                        <li><?php echo editLite::getNiceName(EL_DATABASE);?></li>
                        <li><a href="index.php?table=<?php echo $table;?>"><?php echo editLite::getNiceName($table);?></a></li>
                        <li class="active">Edit</li>
                    </ol>
                    
                    <div class="page-header">
                        
                        <h1>Edit Row</h1>
                        <?php if (isset($alert)) echo $alert;?>
                    </div><!--/page-header-->

                    <form method="post" action="" class="form-horizontal" role="form">
    
                        <?php foreach ($editLite->columns as $c) { ?>
                        
                            <div class="form-group">

                                <label for="<?php echo $c->Field;?>" class="col-lg-2 control-label"><?php echo EditLite::getNiceName($c->Field);?></label>
                                <div class="col-lg-10">
                                    <?php EditLite::getControl($c, $row);?>
                                </div>
                            </div>
                        
                        <?php } ?>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" name="save" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        
                    </form>

<?php require 'footer.php';?>