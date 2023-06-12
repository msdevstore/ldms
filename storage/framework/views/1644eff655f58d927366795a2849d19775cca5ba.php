<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($ldms_general_setting_data->site_title); ?></title>
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.checkboxes.css') ?>">
</head>
<body>
<?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message1')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
<?php if(count($categories)!=0): ?>
  <div class="col-md-9">     
    <!--Document List Start-->
    <div class="col-md-12 panel">
    
        <div class="col-md-12"> 
            <table id="document-table" class="table table-bordered table-striped">
                <thead>
                  <th class="not-exported"></th>
                  <th><?php echo e(trans('file.ID')); ?></th>
                  <th><?php echo e(trans('file.Category')); ?></th>
                  <th><?php echo e(trans('file.Parent Category')); ?></th>
                  <th class="text-center hidden-print not-exported"><?php echo e(trans('file.Option')); ?></th>
                </thead>
                
                <tbody>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <?php 
                            
                            $parent = $categories->where('id',$category->parent)->pluck('name')->implode('name');

                         ?>
                        <tr>
                            <td><?php echo e($key); ?></td>
                            <td><?php echo e($category->id); ?></td>
                            <td><?php echo e($category->name); ?></td>
                            <td><?php echo e($parent); ?></td>
                    
                            <td class="text-center hidden-print">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default"><?php echo e(trans('file.Action')); ?></button>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        <li><a class="edit-category" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo e($category->id); ?>" data-name="<?php echo e($category->name); ?>" data-parent="<?php echo e($category->parent); ?>"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo e(trans('file.Edit')); ?></a></li>
                                        <li class="divider"></li>
                                        <li>
                                            <a>
                                            <form method="post" action="<?php echo e(route('category.delete')); ?>">
                                            <?php echo csrf_field(); ?>

                                                <input type="hidden" name="category_id" value="<?php echo e($category->id); ?>">
                                                <button type="submit" style="display: block; background:none;border:none"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('file.Delete')); ?></button>
                                            </form>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--Document List End-->
  </div>

  <div class="col-md-3">
    <div class="col-md-12 panel">
        <h3><?php echo e(trans('file.Create Category')); ?></h3>
<?php else: ?>
  <div class="col-md-8 col-md-offset-2">
    <div class="col-md-12 panel">
    <h1 class="text-danger"><?php echo e(trans('file.No categories found')); ?></h1>
        <h3><?php echo e(trans('file.Create Category')); ?></h3>
<?php endif; ?>        
        <!--Document Create Start-->
        <form method="post" action="<?php echo e(route('category.store')); ?>" files="true" enctype="multipart/form-data">
            <div class="col-md-12">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                     <label><?php echo e(trans('file.Name')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="name" placeholder="Category name" required>
                         </div>
                     </div>
                </div>                   
                <div class="form-group">
                    <label ><?php echo e(trans('file.Parent Category')); ?></label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <select name="parent" class="form-control">
                               <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>                                   
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                  <input type="submit" name="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary" id="createForm">
                </div>                                 
            </div>              
         </form>
         <!--Document Create End-->
    </div> 
  </div>

  
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="<?php echo e(route('category.update')); ?>" files="true" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                        <label><?php echo e(trans('file.Name')); ?></label>
                        <div class="form-group-inner">
                            <div class="field-outer">
                                <input class="form-control" type="text" id="cat_name" name="name" placeholder="Category name" required>
                            </div>
                        </div>
                </div>                   
                <div class="form-group">
                    <label ><?php echo e(trans('file.Parent Category')); ?></label>
                    <div class="form-group-inner">
                        <div class="field-outer">
                            <select name="parent" class="form-control" id="cat_parent">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>                                   
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="hidden" id="cat_id" name="id">
                    <input type="submit" name="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary" id="createForm">
                </div>                                               
            </form>
        </div>
      </div>
    </div>
  </div>

 <script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

  <script type="text/javascript" src="<?php echo asset('public/js/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.bootstrap4.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.bootstrap4.min.js') ?>">"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.print.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.colVis.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/sum().js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.checkboxes.min.js') ?>"></script>

 <script type="text/javascript">
    $(document).on('click','.edit-category', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var parent = $(this).data('parent');

        $('#cat_id').val(id);
        $('#cat_name').val(name);
        $('#cat_parent').val(parent);
    })
  $('#document-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<?php echo e(trans("file.Previous")); ?>',
                    'next': '<?php echo e(trans("file.Next")); ?>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0,
                'checkboxes': {
                   'selectRow': true
                }
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                text: '<?php echo e(trans("file.PDF")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'csv',
                text: '<?php echo e(trans("file.CSV")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'print',
                text: '<?php echo e(trans("file.Print")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'colvis',
                text: '<?php echo e(trans("file.Column visibility")); ?>',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
</body>
</html>
