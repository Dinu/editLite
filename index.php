<?php require 'index.init.php';?>
<?php require 'header.php';?>
                    
                    <ol class="breadcrumb">
                        <li><?php echo editLite::getNiceName(EL_DATABASE);?></li>
                        <li class="active"><a href="index.php"><?php echo editLite::getNiceName($table);?></a></li>
                    </ol>
                    
                    <div class="page-header">
                       
                        <h1><?php echo editLite::getNiceName($table);?></h1>
                        <div class="btn-group pull-right">
                            <a href="index.php?table=<?php echo $table;?>&amp;download&amp;type=csv" class="btn btn-default"><i class="glyphicon glyphicon-download"></i> Download</a>
                        </div>
                        
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="actions"></th>
                                <?php foreach ($editLite->columns as $c) { ?>
                                    <th class="<?php echo ($editLite->pk == $c->Field) ? 'primary' : '';?>">
                                        <?php echo EditLite::getNiceName($c->Field);?>
                                    </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            $i = 0;
                            $pk = $editLite->pk;
                            foreach ($editLite->rows as $r) {?>
                            
                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="edit.php?table=<?php echo $table;?>&row=<?php echo ($pk != '') ? $r->$pk : $i;?>" title="Edit Row"><i class="glyphicon glyphicon-pencil"></i></a>
                                            <a class="btn btn-default" href="#" title="Delete Row"><i class="glyphicon glyphicon-trash"></i></a>
                                        </div>
                                    </td>
                                    <?php foreach ($editLite->columns as $c) { ?>
                                        <td class="<?php echo  ($editLite->pk == $c->Field) ? 'primary' : '';?>">
                                            <?php
                                            $field = $c->Field;
                                            echo (strlen($r->$field) < 100) ? $r->$field : substr($r->$field, 0, 100) . '...';
                                            ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>

<?php require 'footer.php';?>