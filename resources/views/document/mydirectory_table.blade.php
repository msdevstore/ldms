<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$ldms_general_setting_data->site_title}}</title>
    <link rel="stylesheet" href="<?php echo asset('/public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('/public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('/public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('/public/css/jquery-ui.min.css')?>" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="<?php echo asset('/public/css/main.css')?>" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/public/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/public/css/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/public/css/dataTables.checkboxes.css') ?>">
</head>
<body>
@include('partials.topMenu')

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if($errors->has('title'))
 <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>{{ $errors->first('title') }}</strong></div>

@endif

<?php 
$path = $real_path;
$dirs = [];
$files = [];
$unit = array('Byte', 'KB', 'MB', 'GB');
foreach (new DirectoryIterator($path) as $fileInfo) {
    if (!$fileInfo->isDot()) {
        if ($fileInfo->isDir()) { 
            $dirs[] = array(
                'name' => $fileInfo->getFilename(),
                'type' => 'Folder',
                'size' => '',
                'date' => date("Y-m-d h-m-s", $fileInfo->getATime()),
                'path' => $fileInfo->getPathname(),
            );
        }
        else {
            $size = $fileInfo->getSize();
            $cnt = 0;
            while($size > 1024) {
                $size /= 1024;
                $size = round($size, 2);
                $cnt++;
            }
            $files[] = array(
                'name' => $fileInfo->getFilename(),
                'type' => strtoupper(pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION)),
                'size' => $size.$unit[$cnt],
                'date' => date("Y-m-d h-m-s", $fileInfo->getATime()),
                'path' => $fileInfo->getPathname(),
            );
        }
    }
}
?>

  <div class="col-md-12">     
    <!--Document List Start-->
    <div class="col-md-9 panel">
        <?php 
        if($role == 'admin') {
            $title = str_replace('./public/priv', 'Super Admin', $real_path);
        } else {
            $title = str_replace('./public/priv/'.Auth::user()->email, 'My Directory', $real_path);
        }
        $id = 0;
        ?>
        <h1>{{$title}}</h1>
        <div class="container-fluid">
            <div class="col-md-4">
                <a href="#" data-toggle="modal" data-target="#createFolder" class="btn btn-primary"><i class="fa fa-file"></i> Create Folder</a>
            </div>
            <div class="col-md-7">
            </div>
            <div class="col-md-1" style="display: flex; justify-content: right;">
                <a href="#" onclick="history.back()" data-toggle="modal" class="btn btn-primary"> Return</a>
            </div>
        </div>
       
        <div class="col-md-12"> 
            <table id="document-table" class="table table-bordered table-striped">
              <thead>
                <th>#</th>
                <th>Name</th>
                <th>Date modified</th>
                <th>Type</th>
                <th>Size</th>
                <th class="text-center hidden-print not-exported">{{trans('file.Option')}}</th>
              </thead>
              <tbody>
                @foreach($dirs as $item)
                <?php 
                $temp_path = ltrim($item['path'], './');
                $temp_path1 = str_replace('\\', '*', $temp_path);
                $path = str_replace('/', '*', $temp_path1);
                ?>
                <tr>
                    <td>{{++$id}}</td>
                    <td><a href="{{URL::to('document/mydirectory_table/'.$path)}}" class="open-folder" style="color: orange;"><i class="fa fa-folder"></i> {{ $item['name'] }}</td>
                    <td>{{ $item['date'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>{{ $item['size'] }}</td>
                    <td class="text-center hidden-print">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">{{trans('file.Action')}}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                <li><a title = "View" href="{{URL::to('document/mydirectory_table/'.$path)}}"><i class="fa fa-eye" aria-hidden="true"></i> {{trans('file.View')}}/{{trans('file.Edit')}}</a></li>
                                <li class="divider"></li>
                                <li><a title = "Delete" href="#" class="del-btn" path="{{$item['path']}}"><i class="fa fa-trash" aria-hidden="true"></i> {{trans('file.Delete')}}</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
                @foreach($files as $item)
                <?php 
                $temp_path = ltrim($item['path'], './');
                $path = str_replace('\\', '/', $temp_path);
                ?>
                <tr>
                    <td>{{++$id}}</td>
                    <td><a href="{{asset($path)}}" target="_blank"><i class="fa fa-file"></i> {{ $item['name'] }}</td>
                    <td>{{ $item['date'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>{{ $item['size'] }}</td>
                    <td class="text-center hidden-print">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">{{trans('file.Action')}}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                <li><a title = "View" href="{{asset($path)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> {{trans('file.View')}}</a></li>
                                <li class="divider"></li>
                                <li><a title = "Edit" id="edit-btn" path="{{$item['path']}}"><i class="fa fa-eye" aria-hidden="true"></i> {{trans('file.Edit')}}</a></li>
                                <li class="divider"></li>
                                <li><a title = "Download" href="{{asset($path)}}" target="_blank" download><i class="fa fa-download" aria-hidden="true"></i> {{trans('file.Download')}}</a></li>
                                <li class="divider"></li>
                                <li><a title = "Delete" href="#" class="del-btn" path="{{$item['path']}}"><i class="fa fa-trash" aria-hidden="true"></i> {{trans('file.Delete')}}</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
         <!--Document Create End-->
    </div> 
    <div class="col-md-3">
        <div class="col-md-12 panel">
            <h3>{{trans('file.Upload New Document')}}</h3> 
                <!--Document Create Start-->
            <div>
                <div class="col-md-12">
                    {!! csrf_field() !!}
                    <div class="form-group">
                         <label for="ldms_documentTitle">{{trans('file.Document Title')}} *</label>
                         <div class="form-group-inner">
                             <div class="field-outer">
                                 <input required class="form-control" type="text" name="title" id="ldms_documentTitle" placeholder="{{trans('file.Trade License')}}">
                             </div>
                         </div>
                    </div> 
                    <div class="form-group">

                        <label >{{trans('file.Category')}}</label>
                        <div class="form-group-inner">
                             <div class="field-outer">
                               <select name="category_id" class="form-control" id="category_id">
                                    <option>Choose Category</option>
                                   @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>                                   
                                   @endforeach
                               </select>
                             </div>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="ldms_experiedDate">{{trans('file.Expiry Date')}} *</label>
                        <div class="form-group-inner">
                             <div class="field-outer">
                               <input id="ldms_experiedDate" name="ldms_experiedDate" class="form-control" type="text" name="date" value="<?php echo date('d-m-Y', strtotime('+2 day')); ?>">
                             </div>
                        </div>
                    </div>
                    <div class="form-group">
                         <label for="ldms_email">{{trans('file.Notification Email')}} *</label>
                         <div class="form-group-inner">
                             <div class="field-outer">
                                <input required class="form-control" type="email" name="ldms_email" id="ldms_email" placeholder=
                                "abc@gmail.com">
                             </div>
                         </div>
                    </div>
                    <div class="form-group">
                         <label for="mobile">{{trans('file.Notification Mobile')}}</label>
                         <div class="form-group-inner">
                             <div class="field-outer">
                                <input class="form-control" type="text" name="mobile" placeholder=
                                "+8801*********" id="mobile">
                             </div>
                         </div>
                    </div>
                    <div class="form-group">
                        <label for="ldms_tags_for_search">Tags for Search</label>
                        <div class="form-group-inner">
                            <div class="field-outer">
                               <input class="form-control" type="text" name="tags_for_search" placeholder=
                               "Driving, NID" id="tags_for_search">
                            </div>
                        </div>
                   </div>
                    <div class="form-group">
                         <label for="ldms_documentFile">{{trans('file.Document')}}</label>
                         <div class="form-group-inner">
                             <div class="field-outer">
                                 <input  type="file" name="ldms_documentFile" id="ldms_documentFile" accept=".pdf">
                                 <label class="btn btn-default" for="ldms_documentFile"><i class="fa fa-upload"></i> {{trans('file.Upload File')}}</label>
                                 <span id="ldms_document_file_name"></span>
                             </div>
                         </div>
                    </div>                                   
                </div>
                <div class="form-group submit text-right">
                    <label for="submit"></label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input type="submit" name="submit" value="{{trans('file.Submit')}}" class="btn btn-primary" id="import-document-ok">
                         </div>
                    </div>
                </div>                
             </div>
             <!--Document Create End-->
        </div> 
  </div>
  <button type="button" style="display: none;" id="edit-modal-btn" class="btn btn-info btn-lg" data-toggle="modal" data-target="#editDocument">Open Modal</button>
  <div class="modal fade" id="editDocument" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Document</h4>
        </div>
        <div class="modal-body">
          <div class="col-md-12">
                {!! csrf_field() !!}
                <div class="form-group">
                     <label for="ldms_documentTitle">{{trans('file.Document Title')}} *</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input required class="form-control" type="text" name="title" id="document-title" placeholder="{{trans('file.Trade License')}}">
                         </div>
                     </div>
                </div> 
                <div class="form-group">
                    <label >{{trans('file.Category')}}</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <select name="category_id" class="form-control" id="document-category">
                                <option>Choose Category</option>
                               @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>                                   
                               @endforeach
                           </select>
                         </div>
                    </div>
                </div>  
                <div class="form-group">
                    <label for="ldms_experiedDate">{{trans('file.Expiry Date')}} *</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="document-expdate" name="ldms_experiedDate" class="form-control" type="text" name="date" value="<?php echo date('d-m-Y', strtotime('+2 day')); ?>">
                         </div>
                    </div>
                </div>
                <div class="form-group">
                     <label for="ldms_email">{{trans('file.Notification Email')}} *</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input required class="form-control" type="email" name="ldms_email" id="document-email" placeholder=
                            "abc@gmail.com">
                         </div>
                     </div>
                </div>
                <div class="form-group">
                     <label for="mobile">{{trans('file.Notification Mobile')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="text" name="mobile" placeholder=
                            "+8801*********" id="document-mobile">
                         </div>
                     </div>
                </div>
                <div class="form-group">
                    <label for="ldms_tags_for_search">Tags for Search</label>
                    <div class="form-group-inner">
                        <div class="field-outer">
                           <input class="form-control" type="text" name="tags_for_search" placeholder=
                           "Driving, NID" id="document-tags">
                        </div>
                    </div>
               </div>           
                <input class="form-control" id="document-id" style="display: none">                      
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="edit-document-ok" class="btn btn-default" data-dismiss="modal">OK</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
            
  <button type="button" style="display: none;" id="delete-modal-btn" class="btn btn-info btn-lg" data-toggle="modal" data-target="#deleteOne">Open Modal</button>
  <div class="modal fade" id="createFolder" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Note</h4>
        </div>
        <div class="modal-body">
          <h4>Do you want to create New folder?</h4>
          <input class="form-control" id="folder-name" placeholder="Name">
        </div>
        <div class="modal-footer">
          <button type="button" id="create-folder-ok" class="btn btn-default" data-dismiss="modal">OK</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="deleteOne" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Note</h4>
        </div>
        <div class="modal-body">
          <h4>Do you really want to delete this?</h4>
          <input type="hidden" id="delete_path">
        </div>
        <div class="modal-footer">
          <button type="button" id="delete-one-ok" class="btn btn-default" data-dismiss="modal">OK</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<div id="importProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['route' => 'document.import', 'method' => 'post', 'files' => true]) !!}
        <div class="modal-header">
          <span style="font-weight: 850;">Import Document</span>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <i><small>{{trans('file.All field labels are required input fields.')}}</small></i><br><br>
           <p>{{trans('file.The correct column order is')}} (title, expiredDate(d-m-Y), email, mobile, tags for search, fileName) {{trans('file.and you must follow this.')}} {{trans('file.Make sure expiredDate column is in text format.')}} {{trans('file.Files must be located in')}} public/document {{trans('file.directory')}}.</p>
           <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.Upload File')}} *</strong></label>
                        {{Form::file('file', array('class' => 'form-control','required'))}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong> {{trans('file.Sample File')}}</strong></label>
                        <a href="../public/sample/sample-doc.csv" class="btn btn-info btn-block btn-md"><i class="fa fa-download"></i>  {{trans('file.Download')}}</a>
                    </div>
                </div>
           </div>           
            <div class="form-group" id="operation_value"></div>
            <input type="submit" name="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
        </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

 <script type="text/javascript" src="<?php echo asset('/public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('/public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('/public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('/public/js/bootstrap-datepicker.min.js')?>"></script>

 <script type="text/javascript" src="<?php echo asset('/public/js/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/dataTables.bootstrap4.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/buttons.bootstrap4.min.js') ?>">"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/buttons.print.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/buttons.colVis.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/sum().js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/dataTables.select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('/public/js/dataTables.checkboxes.min.js') ?>"></script>
 
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    var table = $('#document-table').DataTable( {
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
                'targets': [0, 1]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
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
        ]
    } );

    var ldms_experiedDate = $('#ldms_experiedDate');
    ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
    });

    var ldms_document_file = $("#ldms_documentFile");
    ldms_document_file.change(function(){
        var  ldms_document_file_name = $("#ldms_document_file_name");
        ldms_document_file_name.html($(":file").val());
     });


    @if(count($document_list)!=0)
        var ldms_tags_email = [ @foreach($ldms_documents_all as $document)
            <?php
                $emailArray[] = $document->email;
            ?>
            @endforeach
                <?php
                echo  '"'.implode('","', $emailArray).'"';
                ?> ];
        var ldms_email = $('#ldms_email');
        ldms_email.autocomplete({
        source: function( request, response ) {
                var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                response( $.grep( ldms_tags_email, function( item ){
                    return matcher.test( item );
                }) );
            }
        });
        
        function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
        }

        var tooltip = $('[data-toggle="tooltip"]');
        tooltip.tooltip({container: 'body'});
    @endif

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
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        end_date.datepicker('setStartDate', minDate);
    });

    end_date.datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        start_date.datepicker('setEndDate', minDate);
    });

    var searchParams = new URLSearchParams(window.location.search);
    if (searchParams != '') {
        var f_start_date = searchParams.get('filter_start_date').split("-");
        start_date.datepicker( 'setDate', new Date(f_start_date[2], f_start_date[1] - 1, f_start_date[0]) );  
        var f_end_date = searchParams.get('filter_end_date').split("-");
        end_date.datepicker( 'setDate', new Date(f_end_date[2], f_end_date[1] - 1, f_end_date[0]) );    
    }


    $('#filter_form').on('submit',function (e) {
        e.preventDefault();
        var filter_start_date = $('#start_date').val();
        var filter_end_date = $('#end_date').val();
        if (filter_start_date != '' && filter_end_date != '') { 
            document.location.href = "{{ route('document.create') }}?filter_start_date="+filter_start_date+"&filter_end_date="+filter_end_date;           
        }
        else {
            alert('Please select start and end date');
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#create-folder-ok').click(function () {
            let name = $('#folder-name').val();
            if(!name) alert("Please enter folder name!");
            else {
                $.ajax({
                    url: "{{URL::to('document/folder_create')}}",
                    type: "POST",
                    data: {
                        name: name,
                        path: "{{$real_path}}"
                    },
                    success: function(res) {
                        console.log(res);
                        if(res == 'exist') {
                            alert(name + ' folder is aleady exist!');
                        } else if (res == 'done') {
                            alert(name + ' folder is created successfully!');
                            location.reload();
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            }
               
        });
        $('#import-document-ok').click(function() {
            var ldms_documentTitle = $('#ldms_documentTitle').val();
            var category_id = $('#category_id').val();
            var ldms_experiedDate = $('#ldms_experiedDate').val();
            var ldms_email = $('#ldms_email').val();
            var mobile = $('#mobile').val();
            var tags_for_search = $('#tags_for_search').val();
            var ldms_documentFile = $('#ldms_documentFile').val();
            if(!ldms_documentTitle || !category_id || !ldms_email) {
                alert("You didn't input all date!");
            }else {
                if(!ldms_documentFile) {
                    alert("You didn't select the file!");
                } else {
                    var formData = new FormData();
                    formData.append('title', ldms_documentTitle);
                    formData.append('category_id', category_id);
                    formData.append('ldms_experiedDate', ldms_experiedDate);
                    formData.append('ldms_email', ldms_email);
                    formData.append('mobile', mobile);
                    formData.append('tags_for_search', tags_for_search);
                    formData.append('path', "{{$real_path}}");
                    formData.append('file', $('#ldms_documentFile')[0].files[0]);
                    $.ajax({
                        url: "{{ URL::to('/document/file_upload') }}",
                        type: 'post',
                        enctype: 'multipart/form-data',
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(data) {
                            console.log(data);
                            if(data == 1) {
                                alert('File uploaded successfully!');
                                location.reload();
                            } else if(data == 2) {
                                alert('Expired date must be 2 days from now!');
                            } else {
                                alert('File upload failed!');
                            }
                        },
                        error:function(err) {
                            console.log(err);
                        }
                    })
                }
            }
        });

        $('.del-btn').click(function() {
            $('#delete_path').val($(this).attr('path'));
            $('#delete-modal-btn').click();
        });
        
        $('#edit-btn').click(function() {
            var path = $(this).attr('path');
            $.ajax({
                url: "{{URL::to('/document/get_document_info')}}",
                type: "POST",
                data: {
                    path: path
                },
                success: function(res) {
                    console.log(res);
                    $('#document-id').val(res.id);
                    $('#document-title').val(res.title);
                    $('#document-category').val(res.category_id).change();
                    $('#document-expdate').val(res.expired_date);
                    $('#document-email').val(res.email);
                    $('#document-mobile').val(res.mobile);
                    $('#document-tags').val(res.tags_for_search);
                    $('#edit-modal-btn').click();
                },
                error: function(err) {
                    console.log(err);
                }
            })
        });
        
        $('#edit-document-ok').click(function() {
            var id = $('#document-id').val();
            var title = $('#document-title').val();
            var category_id = $('#document-category').val();
            var expired_date = $('#document-expdate').val();
            var email = $('#document-email').val();
            var mobile = $('#document-mobile').val();
            var tags_for_search = $('#document-tags').val();
            if(!title || !category_id || !expired_date) {
                alert("You didn't input all data!");
            }else {
                $.ajax({
                    url: "{{URL::to('/document/update_document')}}",
                    type: "POST",
                    data: {
                        title: title,
                        id: id,
                        category_id: category_id,
                        expired_date: expired_date,
                        email: email,
                        mobile: mobile,
                        tags_for_search: tags_for_search
                    },
                    success:function(res) {
                        if(res) {
                            alert("Success!");
                            location.reload();
                        }
                    },
                    error:function(err) {
                        console.log(err);
                    }
                })
            }
        });
        $('#delete-one-ok').click(function() {
            console.log($('#delete_path').val());
            $.ajax({
                url: "{{ URL::to('/document/delete_one') }}",
                type: "post",
                data: {
                    path: $('#delete_path').val()
                },
                success: function(data) {
                    console.log(data);
                    if(data == 1) {
                        alert('Success!');
                        location.reload();
                    } else {
                        alert('Failed!');
                    }
                },
                error: function(err) {
                    alert('Failed!');
                }
            })
        })
    })
</script>
</body>
</html>
