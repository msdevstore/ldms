<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo e($ldms_general_setting_data->site_title); ?></title>
    <link rel="stylesheet" href="<?php echo asset('/public/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/public/css/bootstrap-datepicker.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/public/css/font-awesome.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('/public/css/jquery-ui.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="<?php echo asset('/public/css/main.css') ?>" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/public/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/public/css/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/public/css/dataTables.checkboxes.css') ?>">
</head>

<body>
    <?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div>
    <?php endif; ?>
    <?php if(session()->has('message1')): ?>
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div>
    <?php endif; ?>
    <?php if($errors->has('title')): ?>
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><?php echo e($errors->first('title')); ?></strong></div>

    <?php endif; ?>

    <div class="col-md-12">
        <!--Document List Start-->
        <div class="col-md-12 panel">
            <div class="row">
                <div class="col-md-12">
                    <h1> <?php echo e(trans(" Document Type")); ?>  <br>
                    <span style="font-size: 14px;" > <?php echo e(trans("Please choose suitable options that you want to upload document.")); ?> </span></h1>
                    <?php if($role == 'admin'): ?>
                    <a href="<?php echo e(route('document.mydirectory_table', ['path' => 'public*priv'])); ?>" class="btn btn-info" style="margin-left: 50px;"> <i class="fa fa-folder fa-2x"></i> My Directory Table</a>
                    <?php else: ?>
                    <a href="<?php echo e(route('document.mydirectory_table', ['path' => 'public*priv*'.Auth::user()->email])); ?>" class="btn btn-info" style="margin-left: 50px;"> <i class="fa fa-folder fa-2x"></i> My Directory Table</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!--Document List End-->
    </div>

    <script type="text/javascript" src="<?php echo asset('/public/js/jquery-3.2.0.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/jquery-ui.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/bootstrap-datepicker.min.js') ?>"></script>

    <script type="text/javascript" src="<?php echo asset('/public/js/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/dataTables.buttons.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/buttons.bootstrap4.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/buttons.print.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/pdfmake.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/vfs_fonts.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/buttons.html5.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/buttons.colVis.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/sum().js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/dataTables.select.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/public/js/dataTables.checkboxes.min.js') ?>"></script>

    <script type="text/javascript">
        var table = $('#document-table').DataTable({
            "order": [],
            'language': {
                'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
                "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
                "search": '<?php echo e(trans("file.Search")); ?>',
                'paginate': {
                    'previous': '<?php echo e(trans("file.Previous")); ?>',
                    'next': '<?php echo e(trans("file.Next")); ?>'
                }
            },
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 6]
                },
                {
                    'checkboxes': {
                        'selectRow': true
                    },
                    'targets': 0
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: 'Blfrtip',
            buttons: [{
                    extend: 'pdf',
                    text: '<?php echo e(trans("file.PDF")); ?>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        modifier: {
                            page: 'current'
                        }
                    },
                    footer: true
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
                    footer: true
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
                    footer: true
                },
                {
                    extend: 'colvis',
                    text: '<?php echo e(trans("file.Column visibility")); ?>',
                    columns: ':gt(0)'
                },
            ]
        });

        var ldms_experiedDate = $('#ldms_experiedDate');
        ldms_experiedDate.datepicker({
            format: "dd-mm-yyyy",
            startDate: "<?php echo date('d-m-Y'); ?>",
            autoclose: true,
            todayHighlight: true
        });

        var ldms_document_file = $("#ldms_documentFile");
        ldms_document_file.change(function() {
            var ldms_document_file_name = $("#ldms_document_file_name");
            ldms_document_file_name.html($(":file").val());
        });


        <?php if(count($document_list) != 0): ?>
        var ldms_tags_email = [<?php $__currentLoopData = $ldms_documents_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $emailArray[] = $document->email;
            ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php
            echo  '"' . implode('","', $emailArray) . '"';
            ?>
        ];
        var ldms_email = $('#ldms_email');
        ldms_email.autocomplete({
            source: function(request, response) {
                var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(ldms_tags_email, function(item) {
                    return matcher.test(item);
                }));
            }
        });

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        var tooltip = $('[data-toggle="tooltip"]');
        tooltip.tooltip({
            container: 'body'
        });
        <?php endif; ?>

        var searchParams = new URLSearchParams(window.location.search);
        if (searchParams != '') {
            var f_start_date = searchParams.get('filter_start_date').split("-");
            var f = new Date(f_start_date[2], f_start_date[1] - 1, f_start_date[0]);
        }


        var start_date = $('#start_date');
        var end_date = $('#end_date');
        start_date.datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            end_date.datepicker('setStartDate', minDate);
        });

        end_date.datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            start_date.datepicker('setEndDate', minDate);
        });

        var searchParams = new URLSearchParams(window.location.search);
        if (searchParams != '') {
            var f_start_date = searchParams.get('filter_start_date').split("-");
            start_date.datepicker('setDate', new Date(f_start_date[2], f_start_date[1] - 1, f_start_date[0]));
            var f_end_date = searchParams.get('filter_end_date').split("-");
            end_date.datepicker('setDate', new Date(f_end_date[2], f_end_date[1] - 1, f_end_date[0]));
        }


        $('#filter_form').on('submit', function(e) {
            e.preventDefault();
            var filter_start_date = $('#start_date').val();
            var filter_end_date = $('#end_date').val();
            if (filter_start_date != '' && filter_end_date != '') {
                document.location.href = "<?php echo e(route('document.create')); ?>?filter_start_date=" + filter_start_date + "&filter_end_date=" + filter_end_date;
            } else {
                alert('Please select start and end date');
            }
        });
    </script>
</body>

</html>