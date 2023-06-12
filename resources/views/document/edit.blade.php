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

    <!--Document Update Start-->
    <form class="form-group" method="post" action="ldms_update/{!! $document->id !!}" files="true" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="col-md-6">
            @if($file_exist == 1) 
                @php 
                $fileExtension = $document['file_name'] ;
                $fileExtension = substr($fileExtension, strpos($fileExtension, ".") + 1);
                @endphp
                @if ($fileExtension=='pdf')
                <iframe style="width:100%;height:100vh;margin-top: 30px" scrolling="no" src='../../public/document/<?php echo $document["file_name"]; ?>' frameborder='0'></iframe>
                @else
                <img style="max-width: 100%" src="../../public/document/<?php echo $document["file_name"]; ?>"/>
                @endif
            @else
                <h2 class="text-center">No file found</h2>
            @endif
        </div>

        <div class="col-md-6 col-offset-md-6">
            <div class="col-md-12 panel">
                <h1>{{trans('file.Edit Document')}}</h1>
                <input type="hidden" name="id" value="{!! $document["id"] !!}">
                <div class="form-group col-md-12">
                     <label for="ldms_documentTitle">{{trans('file.Document Title')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input required class="form-control" type="text" name="title" id="ldms_documentTitle" value="{!! $document["title"] !!}">
                         </div>
                     </div>
                </div> 
                <div class="form-group col-md-12">
                    <label >{{trans('file.Category')}}</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <select name="category_id" class="form-control">
                                <option>Choose Category</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}" @if($document["category_id"] == $category->id) selected @endif>{{$category->name}}</option>                                   
                                @endforeach
                           </select>
                         </div>
                    </div>
                </div>                  
                <div class="form-group col-md-12">
                    <label for="ldms_experiedDate">{{trans('file.Expiry Date')}}</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="ldms_experiedDate" name="ldms_experiedDate" class="form-control" type="text" name="date" value="{!! $document["expired_date"] !!}">
                         </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                     <label for="ldms_email">{{trans('file.Notification Email')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input required class="form-control" type="email" name="ldms_email" id="ldms_email" value="{!! $document["email"] !!}">
                         </div>
                     </div>
                </div>
                <div class="form-group col-md-12">
                     <label>Tags for Search</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="text" name="tags_for_search" value="{!! $document["tags_for_search"] !!}">
                         </div>
                     </div>
                </div>
                <div class="form-group col-md-12">
                    <label>{{trans('file.Notification Mobile')}}</label>
                    <div class="form-group-inner">
                        <div class="field-outer">
                           <input class="form-control" type="text" name="mobile" value="{!! $document["mobile"] !!}">
                        </div>
                    </div>
               </div>
                <div class="form-group col-md-12">
                     <label> {{trans('file.Document')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input type="hidden" name="previousFileName" value="{!! $document["file_name"] !!}">
                            <input type="file" name="ldms_documentFile" id="ldms_documentFile">
                            <label class="btn btn-default" for="ldms_documentFile"><i class="fa fa-upload"></i> {{trans('file.Upload File')}}</label>
                            <span id="ldms_document_file_name"></span>
                         </div>
                     </div>
                </div>                                                
                <div class="form-group submit col-md-12 text-left">
                    <label for="submit"></label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input type="submit" name="submit" value="{{trans('file.Update')}}" class="btn btn-primary" id="editForm">
                         </div>
                    </div>
                </div> 
            </div>
        </div>               
    </form>
<!--Document Update End-->
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

 <script type="text/javascript">
 var ldms_experiedDate = $('#ldms_experiedDate');
 ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('+2 day')); ?>",
     autoclose: true,
     todayHighlight: true
     });
 var editForm = $('#editForm');
 editForm.on("click",function () {
        var ldms_documentTitle = $.trim($('#ldms_documentTitle').val());
        if (ldms_documentTitle == '') {
            alert("Document Title can not be empty.");
            $("#ldms_documentTitle").focus();
            return false;
        }
        var ldms_email = $.trim($('#ldms_email').val());
        if (ldms_email == '') {
            alert("Alarm Sending Email can not be empty.");
            $('#ldms_email').focus();
            return false;
        }
    });

  var  ldms_document_file = $("#ldms_documentFile");
  ldms_document_file.change(function(){
      var  ldms_document_file_name = $("#ldms_document_file_name");
      ldms_document_file_name.html($(":file").val());
   });

 </script>
 </body>
 </html>
