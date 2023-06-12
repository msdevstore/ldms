<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$ldms_general_setting_data->site_title}}</title>
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
@include('partials.topMenu')

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if(count($categories)!=0)
  <div class="col-md-9">     
    <!--Document List Start-->
    <div class="col-md-12 panel">
    
        <div class="col-md-12"> 
            <table id="document-table" class="table table-bordered table-striped">
                <thead>
                  <th class="not-exported"></th>
                  <th>{{trans('file.ID')}}</th>
                  <th>{{trans('file.Category')}}</th>
                  <th>{{trans('file.Parent Category')}}</th>
                  <th class="text-center hidden-print not-exported">{{trans('file.Option')}}</th>
                </thead>
                
                <tbody>
                  @foreach($categories as $key=>$category) 
                        @php
                            
                            $parent = $categories->where('id',$category->parent)->pluck('name')->implode('name');

                        @endphp
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $parent }}</td>
                    
                            <td class="text-center hidden-print">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">{{trans('file.Action')}}</button>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        <li><a class="edit-category" data-toggle="modal" data-target="#exampleModal" data-id="{{$category->id}}" data-name="{{$category->name}}" data-parent="{{$category->parent}}"><i class="fa fa-pencil" aria-hidden="true"></i> {{trans('file.Edit')}}</a></li>
                                        <li class="divider"></li>
                                        <li>
                                            <a>
                                            <form method="post" action="{{route('category.delete')}}">
                                            {!! csrf_field() !!}
                                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                                <button type="submit" style="display: block; background:none;border:none"><i class="fa fa-trash" aria-hidden="true"></i> {{trans('file.Delete')}}</button>
                                            </form>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--Document List End-->
  </div>

  <div class="col-md-3">
    <div class="col-md-12 panel">
        <h3>{{trans('file.Create Category')}}</h3>
@else
  <div class="col-md-8 col-md-offset-2">
    <div class="col-md-12 panel">
    <h1 class="text-danger">{{trans('file.No categories found')}}</h1>
        <h3>{{trans('file.Create Category')}}</h3>
@endif        
        <!--Document Create Start-->
        <form method="post" action="{{route('category.store')}}" files="true" enctype="multipart/form-data">
            <div class="col-md-12">
                {!! csrf_field() !!}
                <div class="form-group">
                     <label>{{trans('file.Name')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="name" placeholder="Category name" required>
                         </div>
                     </div>
                </div>                   
                <div class="form-group">
                    <label >{{trans('file.Parent Category')}}</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <select name="parent" class="form-control">
                               @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>                                   
                               @endforeach
                           </select>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                  <input type="submit" name="submit" value="{{trans('file.Submit')}}" class="btn btn-primary" id="createForm">
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
            <form method="post" action="{{route('category.update')}}" files="true" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="form-group">
                        <label>{{trans('file.Name')}}</label>
                        <div class="form-group-inner">
                            <div class="field-outer">
                                <input class="form-control" type="text" id="cat_name" name="name" placeholder="Category name" required>
                            </div>
                        </div>
                </div>                   
                <div class="form-group">
                    <label >{{trans('file.Parent Category')}}</label>
                    <div class="form-group-inner">
                        <div class="field-outer">
                            <select name="parent" class="form-control" id="cat_parent">
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>                                   
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="hidden" id="cat_id" name="id">
                    <input type="submit" name="submit" value="{{trans('file.Submit')}}" class="btn btn-primary" id="createForm">
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
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '{{trans("file.Previous")}}',
                    'next': '{{trans("file.Next")}}'
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
                text: '{{trans("file.PDF")}}',
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
                text: '{{trans("file.CSV")}}',
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
                text: '{{trans("file.Print")}}',
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
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
</body>
</html>
