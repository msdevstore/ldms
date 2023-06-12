<?php
namespace App\Http\Controllers;

use App\Document;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Clickatell\Rest;
use Clickatell\ClickatellException;
use Carbon\Carbon;
use App\Categories;

class DocumentController extends Controller
{
    
    public function ldmsCreate(Request $request)
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        $categories = DB::table('categories')->get();
        if ($roleData->title == 'admin') {
            $ldms_documents_all = DB::table('documents')->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
            if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('expired_date', [$start_date, $end_date])->get();
                $ldms_total_documents_number = count($document_list);
            }
            else {
                $document_list = DB::table('documents')->get();
                $ldms_total_documents_number = count($document_list);
            }

            $categories = Categories::all();
            
            return view('document.create', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list','categories'));
        } 
        else {
            $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id', '=' ,$userData->role_id],
                                        ['expired_date', '<', $todayDate],
                                        ]
                                    )->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
            if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('expired_date', [$start_date, $end_date])->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            }
            else {
                $document_list = DB::table('documents')->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            }

    
            return view('document.create', compact('ldms_documents_all','categories', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        }
    }
    public function ldmsList(Request $request)
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        $categories = DB::table('categories')->get();
        $role = $roleData->title;
        if ($role == 'admin') {
            $ldms_documents_all = DB::table('documents')->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
            if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('expired_date', [$start_date, $end_date])->get();
                $ldms_total_documents_number = count($document_list);
            }
            else {
                $document_list = DB::table('documents')->get();
                $ldms_total_documents_number = count($document_list);
            }

            $categories = Categories::all();
            
            return view('document.list', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list','categories', 'role'));
        } 
        else {
            $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id', '=' ,$userData->role_id],
                                        ['expired_date', '<', $todayDate],
                                        ]
                                    )->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
            if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('expired_date', [$start_date, $end_date])->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            }
            else {
                $document_list = DB::table('documents')->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            }

    
            return view('document.list', compact('ldms_documents_all','categories', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list', 'role'));
        }
    }

    public function ldmsExpiredDocuments()
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        if ($roleData->title == 'admin') {
            $ldms_documents_all = Document::all();
            $todayDate = date('Y-m-d');
            $interval = date('Y-m-d', strtotime('+30 days'));

            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)
                                    ->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
            $ldms_total_documents_number = count($ldms_expired_documents_all);
            $document_list =  Document::where('expired_date', '<', $todayDate)->get();

            return view('document.expired_documents', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        } else {
            $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            $todayDate = date('Y-m-d');
            $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id',$userData->role_id],
                                        ['expired_date', '<', $todayDate]
                                        ]
                                    )->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id',$userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
            $ldms_total_documents_number = count($ldms_expired_documents_all);
            $document_list =  Document::where(
                                        [
                                        ['role_id',$userData->role_id],
                                        ['expired_date', '<', $todayDate]
                                        ]
                                    )->get();

            return view('document.expired_documents', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        }
    }

    public function ldmsCloseToBeExpiredDocuments()
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();

        if ($roleData->title == 'admin') {
            $ldms_expired_documents_all =  DB::table('documents')
                                ->where('expired_date', '<', $todayDate)
                                ->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                            ->where(
                                [
                                ['expired_date', '>=', $todayDate],
                                ['expired_date', '<' , $interval]
                                ]
                            )->get();
            $ldms_total_documents_number = count($ldms_close_expired_documents_all);
            $document_list = DB::table('documents')
                            ->where(
                                [
                                ['expired_date', '>=', $todayDate],
                                ['expired_date', '<' , $interval]
                                ]
                            )->get();

            return view('document.close_to_be_expired_documents', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        } else {
            $ldms_expired_documents_all =  DB::table('documents')
                                ->where(
                                    [
                                    ['role_id',$userData->role_id],
                                    ['expired_date', '<', $todayDate]
                                    ]
                                )
                                ->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                            ->where(
                                [
                                ['role_id', $userData->role_id],
                                ['expired_date', '>=', $todayDate],
                                ['expired_date', '<' , $interval]
                                ]
                            )->get();
            $ldms_total_documents_number = count($ldms_close_expired_documents_all);
            $document_list = DB::table('documents')
                            ->where(
                                [
                                ['role_id', $userData->role_id],
                                ['expired_date', '>=', $todayDate],
                                ['expired_date', '<' , $interval]
                                ]
                            )->get();

            return view('document.close_to_be_expired_documents', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        }
    }

    public function ldmsSearch()
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        if ($roleData->title == 'admin') {
            $ldms_documents_all = DB::table('documents')->get();
            
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();

            $ldms_total_documents_number = 1;
            $ldms_searched_title = $_GET['ldms_documentTitleSearch'];
            $document_list = DB::table('documents')
                            ->where('title', $ldms_searched_title)->get();

            if (count($document_list)==0) {
                return redirect()->back()->with('message1', 'Searched item not exists.');
            }

            return view('document.search', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        } else {
             $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id',$userData->role_id],
                                        ['expired_date', '<', $todayDate]
                                        ]
                                    )->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();

            $ldms_total_documents_number = 1;
            $ldms_searched_title = $_GET['ldms_documentTitleSearch'];
            $document_list = DB::table('documents')
                            ->where(
                                [
                                ['role_id',$userData->role_id],
                                ['title', $ldms_searched_title]
                                ]
                            )->get();

            if (count($document_list)==0) {
                return redirect()->back()->with('message1', 'Searched item not exists.');
            }

            return view('document.search', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        }
    }

    public function ldmsStore(Request $request)
    {
        $todayDate = strtotime(date('Y-m-d'));
        $expiredDate = strtotime($request->ldms_experiedDate);
        $dateDifference = ($expiredDate - $todayDate);
        $totalRemainingDays = floor($dateDifference / (60 * 60 * 24));
        if ($totalRemainingDays>1) {
            $ldms_objDocumentModel = new Document();
            $userData = DB::table('users')->where('id', Auth::id())->first();
            $ldms_objDocumentModel->role_id = $userData->role_id;
            $ldms_objDocumentModel->title = $request->title;
            $ldms_objDocumentModel->category_id = $request->category_id;
            $ldms_objDocumentModel->expired_date = date('Y-m-d', $expiredDate);
            $ldms_objDocumentModel->email = $request->ldms_email;
            $ldms_objDocumentModel->mobile = $request->mobile;
            $ldms_objDocumentModel->tags_for_search = $request->tags_for_search;
            if ($_FILES["ldms_documentFile"]["name"] != '') {            
                $ldms_objDocumentModel->file_name = strtotime(date('Y-m-d H:i:s')).$_FILES["ldms_documentFile"]["name"];
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/document/";
                $target_file = $target_dir . strtotime(date('Y-m-d H:i:s')).basename($_FILES["ldms_documentFile"]["name"]);
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                // exit;
                // Check file size
                if ($_FILES["ldms_documentFile"]["size"] > 10000000) {
                    return redirect("document/ldms_create")->with('message1', 'Sorry, your file is too large.Please upload a file less than 10 MB.');
                }
                // Allow certain file formats
                elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "pdf") {
                    return redirect("document/ldms_create")->with('message1', 'Sorry, only jpg, jpeg, png, pdf files are allowed.');
                }
                elseif (move_uploaded_file($_FILES["ldms_documentFile"]["tmp_name"], $target_file)) {
                } 
                else {
                    return redirect("document/ldms_create")->with('message1', 'Sorry, there was an error uploading your file.');
                }
            }

            if ($totalRemainingDays>30) {
                $alarmDate = array(date('Y-m-d', strtotime('-30 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-15 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
            } elseif ($totalRemainingDays>15) {
                $alarmDate = array(date('Y-m-d', strtotime('-15 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
            } elseif ($totalRemainingDays>7) {
                $alarmDate = array(date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
            } elseif ($totalRemainingDays>1) {
                $alarmDate = array(date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
            }
            $alarmDateList = implode(",", $alarmDate);
            $ldms_objDocumentModel->alarm = $alarmDateList;
            $status = $ldms_objDocumentModel->save();
            if ($status) {
                return redirect("document/ldms_create")->with('message', 'Document Inserted Successfully');
            } else {
                return redirect("document/ldms_create")->with('message1', 'Failed to save,try again.');
            }
        } else {
            return redirect("document/ldms_create")->with('message1', 'Expired date must be 2 days from now');
        }
    }

    public function import(Request $request)
    {
        //get file
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if($ext != 'csv')
            return redirect()->back()->with('message1', 'Please upload a CSV file');

        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through other columns
        while($columns=fgetcsv($file))
        {
            foreach ($columns as $key => $value) {
                if(($key == 0 || $key == 1 || $key == 2) && $value == '')
                    return redirect()->back()->with('message1', 'Column cant be empty!');
                if($key == 1){
                    $todayDate = strtotime(date('d-m-Y'));
                    $expiredDate = strtotime(date('d-m-Y', strtotime($value)));
                    $dateDifference = ($expiredDate - $todayDate);
                    $totalRemainingDays = floor($dateDifference / (60 * 60 * 24));
                    if($totalRemainingDays < 2)
                        return redirect()->back()->with('message1', 'Expired date must be 2 days from now');
                }
            }
            $data= array_combine($escapedHeader, $columns);
            if ($data['filename'] != '') {
                $old_name = "./public/document/".$data['filename'];
                if(file_exists($old_name)){
                    $new_name = "./public/document/".strtotime(date('Y-m-d H:i:s')).$data['filename'];
                    $data['filename'] = strtotime(date('Y-m-d H:i:s')).$data['filename'];
                    rename($old_name, $new_name);
                }
                else{
                    return redirect()->back()->with('message1', 'Files must be located in public/document directory');
                }
            }
            if ($totalRemainingDays>30) {
                $alarmDate = array(date('Y-m-d', strtotime('-30 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-15 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-7 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($data['expireddate']))));
            }
            elseif ($totalRemainingDays>15) {
                $alarmDate = array(date('Y-m-d', strtotime('-15 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-7 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($data['expireddate']))));
            }
            elseif ($totalRemainingDays>7) {
                $alarmDate = array(date('Y-m-d', strtotime('-7 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($data['expireddate']))));
            }
            elseif ($totalRemainingDays>1) {
                $alarmDate = array(date('Y-m-d', strtotime('-1 day', strtotime($data['expireddate']))));
            }

            $alarmDateList = implode(",", $alarmDate);
            $document = new Document();
            $document->role_id = Auth::user()->role_id;
            $document->title = $data['title'];
            $document->category_id = $data['category_id'];
            $document->file_name = $data['filename'];
            $document->expired_date = date('Y-m-d', strtotime($data['expireddate']));
            $document->email = $data['email'];
            $document->mobile = $data['mobile'];
            $document->tags_for_search = $data['tagsforsearch'];
            $document->alarm = $alarmDateList;
            $document->save();
        }
        return redirect()->back()->with('message', 'Documents imported successfully');
    }

    public function ldmsEdit($id)
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        $ldms_objDocumentModel = new Document();
        $document = $ldms_objDocumentModel->find($id);

        $file_path = public_path('document/'.$document->file_name);
        if ($document->file_name != '' && file_exists($file_path))
        {
            $file_exist = 1;
        }
        else {
            $file_exist = 0;
        }

        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        if ($roleData->title == 'admin') {
            $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
            $categories = Categories::all();
            return view('document.edit', compact('document', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all','file_exist','categories'));
        } else {
            $ldms_expired_documents_all = DB::table('documents')
                                ->where(
                                    [
                                    ['role_id',$userData->role_id],
                                    ['expired_date', '<', $todayDate]
                                    ]
                                )->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
            $categories = Categories::all();
            return view('document.edit', compact('document', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all','file_exist','categories'));
        }
    }

    public function ldmsUpdate(Request $request)
    {
        $ldms_objDocumentModel = new Document();
        $document = $ldms_objDocumentModel->find($request->id);

        if (!empty($_FILES["ldms_documentFile"]["name"])) {
            $target_dir = "public/document/";
            $target_file = $target_dir . strtotime(date('Y-m-d H:i:s')).basename($_FILES["ldms_documentFile"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            // Check file size
            if ($_FILES["ldms_documentFile"]["size"] > 10000000) {
                return redirect("document/ldms_create")->with('message1', 'Sorry, your file is too large.Please upload a file less than 10 MB.');
            }
            // Allow certain file formats
            elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "pdf") {
                return redirect("document/ldms_create")->with('message1', 'Sorry, only jpg, jpeg, png, pdf files are allowed.');
            }
            elseif (move_uploaded_file($_FILES["ldms_documentFile"]["tmp_name"], $target_file)) {
            } 
            else {
                return redirect("document/ldms_create")->with('message1', 'Sorry, there was an error uploading your file.');
            }
            if ($_POST["previousFileName"] != '') {
                unlink(public_path().'/document/'.$_POST["previousFileName"]);
            }
            $document->file_name = strtotime(date('Y-m-d H:i:s')).$_FILES["ldms_documentFile"]["name"];
        }

        $document->title = $request->title;
        $document->category_id = $request->category_id;
        $document->expired_date = date('Y-m-d', strtotime($request->ldms_experiedDate));
        $document->email = $request->ldms_email;
        $document->mobile = $request->mobile;
        $document->tags_for_search = $request->tags_for_search;
        $status = $document->update();

        if ($status) {
            return redirect("document/ldms_create")->with('message', 'Document Updated Successfully');
        } else {
            redirect("document/ldms_create")->with('message1', 'Failed to update,try again.');
        }
    }

    public function ldmsDelete($id, $fileName)
    {
        $ldms_objDocumentModel = new Document();
        $status = $ldms_objDocumentModel->find($id)->delete();
        if(file_exists(public_path().'/document/'.$fileName)){
            unlink(public_path().'/document/'.$fileName);
        }
        if ($status) {
            return redirect()->back()->with('message', 'Document Deleted Successfully');
        } else {
            return redirect()->back()->with('message1', 'Failed to delete,try again.');
        }
    }

    public function ldmsAlarmDate($id)
    {
        $ldms_objDocumentModel = new Document();
        $alarmDateList = $ldms_objDocumentModel->find($id);
        $todayDate = strtotime(date('Y-m-d'));
        $expiredDate = strtotime($alarmDateList['expired_date']);
        if ($expiredDate<$todayDate) {
            $document = $ldms_objDocumentModel->find($id);
            $alarmDateList = $document->alarm = "";
            DB::table('documents')
                ->where('id', $id)
                ->update(['alarm' => ""]);
            $alarmDateList = $ldms_objDocumentModel->find($id);
        }
        $todayDate = date('Y-m-d');
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)
                                ->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->whereRaw('expired_date > now() and expired_date < now()+INTERVAL 30 DAY')
                    ->get();
        return view('document.alarm_date', compact('alarmDateList', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
    }

    public function ldmsAlarmAdd()
    {
        $ldms_objDocumentModel = new Document();
        $id = $_POST["id"];
        $document = $ldms_objDocumentModel->find($id);
        $inputAlarm = strtotime($_POST["ldms_new_alarm"]);
        $newAlarm = date('Y-m-d',$inputAlarm);

        $previousAlarmDateList = $_POST["previousAlarmDateString"];
        if (strpos($previousAlarmDateList, $newAlarm) === false) {
            if (!empty($previousAlarmDateList)) {
                $alarmDateList = $previousAlarmDateList.",".$newAlarm;
            } else {
                $alarmDateList = $newAlarm;
            }
            $document->alarm = $alarmDateList;

            $status = $document->update();
            if ($status) {
                return redirect("document/ldms_alarm_date/$id")->with('message', 'Alarm Added Successfully');
            } else {
                return redirect("document/ldms_alarm_date/$id")->with('message1', 'Failed to add,try again.');
            }
        } else {
            return redirect("document/ldms_alarm_date/$id")->with('message1', 'Warning! duplicate alarm cannot be set.');
        }
    }

    public function ldmsAlarmDelete($alarmDate, $id, $alarmDateList)
    {
        $ldms_objDocumentModel = new Document();
        $alarmDateList = explode(",", $alarmDateList);
        $alarmDateList = (array_diff($alarmDateList, array($alarmDate)));
        $alarmDateList = implode(",", $alarmDateList);
        $document = $ldms_objDocumentModel->find($id);
        $document->alarm = $alarmDateList;
        $status = $document->update();
        if ($status) {
            return redirect("document/ldms_alarm_date/$id")->with('message', 'Alarm Deleted Successfully');
        } else {
            return redirect("document/ldms_alarm_date/$id")->with('message1', 'Failed to delete,try again.');
        }
    }

    public function ldmsUpdateProfile()
    {
        $userID =  Auth::user()->id;
        $userInformation = DB::table('users')->where('id', '=', $userID)->get();
        $todayDate = date('Y-m-d');
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)
                                ->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->whereRaw('expired_date > now() and expired_date < now()+INTERVAL 30 DAY')
                    ->get();
        return view('document.updateProfile', compact('userInformation', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
    }

    public function ldmsManageProfileUpdate()
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $userID = $_POST["id"];
        $status = DB::table('users')
                  ->where('id', $userID)
                ->update(
                    ['name' => $_POST["ldms_name"],
                    'email' => $_POST["ldms_email"]]
                );
        if (isset($status)) {
            return redirect("document/ldms_updateProfile")->with('message', 'Profile Updated Successfully');
        } else {
            redirect("document/ldms_updateProfile")->with('message1', 'Failed to Profile Update,try again.');
        }
    }

    public function ldmsChangePassword()
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        
        $userID = $_POST["id"];
        $oldPassword = $_POST['ldms_old_password'];
        $allData = DB::table('users')->where('id', $userID)->get();
        if (Hash::check($oldPassword, $allData[0]->password)) {
            if ($_POST['ldms_new_password']==$_POST['ldms_confirm_password']) {
                $status = DB::table('users')
                ->where('id', $userID)
                ->update(['password' => bcrypt($_POST["ldms_new_password"])]);
                if (isset($status)) {
                    return redirect("document/ldms_updateProfile")->with('message', 'Password Changed Successfully');
                }
            } else {
                return redirect("document/ldms_updateProfile")->with('message1', "New Password amd Confirm Password don't match");
            }
        } else {
            return redirect("document/ldms_updateProfile")->with('message1', "Current Password don't match");
        }
    }

    public function ldmsEmailSend()
    {
        $todayDate = date('Y-m-d');
        $ldms_alarm_sending_info = DB::table('documents')
                ->select('title', 'expired_date', 'email', 'mobile')
                ->where('alarm', 'like', '%'.$todayDate.'%')
                ->get();
        $ldms_general_setting_data = \App\GeneralSetting::latest()->first();

        foreach ($ldms_alarm_sending_info as $ldms_alarm_sending_info_single) {
            if($ldms_general_setting_data->notify_by == 'email') {
                $data['email'] = $ldms_alarm_sending_info_single->email;
                $data['document_name'] = $ldms_alarm_sending_info_single->title;
                $data['document_exp'] = $ldms_alarm_sending_info_single->expired_date;

                Mail::send( 'mail.expiration', $data, function( $message ) use ($data)
                {
                    $message->to( $data['email'] )->subject( 'Your ' .$data['document_name']. ' expired date ' .$data['document_exp'] );
                });
            }
            elseif($ldms_alarm_sending_info_single->mobile) {
                if( env('SMS_GATEWAY') == 'twilio') {
                    $account_sid = env('ACCOUNT_SID');
                    $auth_token = env('AUTH_TOKEN');
                    $twilio_phone_number = env('Twilio_Number');
                    try{
                        $client = new Client($account_sid, $auth_token);
                        $client->messages->create(
                            $ldms_alarm_sending_info_single->mobile,
                            array(
                                "from" => $twilio_phone_number,
                                "body" => 'Document Title : '.$ldms_alarm_sending_info_single->title.'. Expired Date : '.$ldms_alarm_sending_info_single->expired_date
                            )
                        );
                    }
                    catch(\Exception $e){
                        $message = 'User created successfully. Please setup your SMS Setting to send SMS';
                    }
                }
                elseif( env('SMS_GATEWAY') == 'clickatell') {
                    try {
                        $clickatell = new \Clickatell\Rest(env('CLICKATELL_API_KEY'));
                        $result = $clickatell->sendMessage(['to' => [$ldms_alarm_sending_info_single->mobile], 'content' => 'Document Title : '.$ldms_alarm_sending_info_single->title.'. Expired Date : '.$ldms_alarm_sending_info_single->expired_date]);
                    } 
                    catch (ClickatellException $e) {
                        $message = 'User created successfully. Please setup your SMS Setting to send SMS';
                    }
                }
            }
        }
    }

    public function mydirectory(Request $request)
    {
        $userData = Auth::user();
        if(!is_dir('./priv/')) {
            mkdir('./priv/');
        }
        if(!is_dir('./priv/'.$userData->email)) {
            mkdir('./priv/'.$userData->email);
        }
        if(!is_dir('./priv/'.$userData->email.'/Documents')) {
            mkdir('./priv/'.$userData->email.'/Documents');
        }

        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        $categories = DB::table('categories')->get();
        $role = $roleData->title;
        if ($role == 'admin') {
            $ldms_documents_all = DB::table('documents')->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
            if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('expired_date', [$start_date, $end_date])->get();
                $ldms_total_documents_number = count($document_list);
            }
            else {
                $document_list = DB::table('documents')->get();
                $ldms_total_documents_number = count($document_list);
            }

            $categories = Categories::all();
            
            return view('document.mydirectory', compact('role', 'ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list','categories'));
        } 
        else {
            $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id', '=' ,$userData->role_id],
                                        ['expired_date', '<', $todayDate],
                                        ]
                                    )->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
            if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('expired_date', [$start_date, $end_date])->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            }
            else {
                $document_list = DB::table('documents')->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            }
    
            return view('document.mydirectory', compact('role', 'ldms_documents_all','categories', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));

        }
    }

    public function fileUpload(Request $request)
    {
        if ($request->hasFile('file')) {
            $todayDate = strtotime(date('Y-m-d'));
            $expiredDate = strtotime($request->ldms_experiedDate);
            $dateDifference = ($expiredDate - $todayDate);
            $totalRemainingDays = floor($dateDifference / (60 * 60 * 24));
            if ($totalRemainingDays > 1) {

                $user = Auth::user();

                $file      = $request->file('file');
                // $filename  = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = $request->title.'.'.$file->getClientOriginalExtension();
                $path      = $request->path;

                $file->move($path.'/', $filename);

                $ldms_objDocumentModel = new Document();
                $userData = DB::table('users')->where('id', Auth::id())->first();
                $ldms_objDocumentModel->role_id = $userData->role_id;
                $ldms_objDocumentModel->title = $request->title;
                $ldms_objDocumentModel->category_id = $request->category_id;
                $ldms_objDocumentModel->expired_date = date('Y-m-d', $expiredDate);
                $ldms_objDocumentModel->email = $request->ldms_email;
                $ldms_objDocumentModel->mobile = $request->mobile;
                $ldms_objDocumentModel->file_path = $path.'/'.$filename;
                $ldms_objDocumentModel->tags_for_search = $request->tags_for_search;
                
                $ldms_objDocumentModel->file_name = $filename;

                if ($totalRemainingDays>30) {
                    $alarmDate = array(date('Y-m-d', strtotime('-30 day', strtotime($_POST["ldms_experiedDate"]))),
                                         date('Y-m-d', strtotime('-15 day', strtotime($_POST["ldms_experiedDate"]))),
                                         date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                         date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
                } elseif ($totalRemainingDays>15) {
                    $alarmDate = array(date('Y-m-d', strtotime('-15 day', strtotime($_POST["ldms_experiedDate"]))),
                                         date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                         date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
                } elseif ($totalRemainingDays>7) {
                    $alarmDate = array(date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                         date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
                } elseif ($totalRemainingDays>1) {
                    $alarmDate = array(date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
                }
                $alarmDateList = implode(",", $alarmDate);
                $ldms_objDocumentModel->alarm = $alarmDateList;
                $status = $ldms_objDocumentModel->save();
                if ($status) {
                    echo 1;
                } else {
                    echo 0;
                }
                // return response()->json($path.'/'.$filename);
            } else {
                echo 2;
            }
        } else {
            echo 0;
        }
    }
    
    public function getDocumentInfo(Request $request)
    {
        $path = $request->path;
        $document = DB::table('documents')->where('file_path', $path)->first();
        return response()->json($document);
    }

    public function createFolder(Request $request)
    {
        $path = $request->path;
        $name = $request->name;
        if(is_dir($path.'/'.$name)) {
            return response()->json('exist');
        } else {
            mkdir($path.'/'.$name);
            return response()->json('done');
        }
    }

    public function updateDocument(Request $request)
    {
        $document = DB::table('documents')->where('id', $request->id)->first();
        $path = $document->file_path;
        $pathInfo = pathinfo($path);
        $basename = $pathInfo['basename'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        $path_temp = rtrim($path, $basename);
        $title = $request->title;
        $new_path = $path_temp.''.$title.'.'.$extension;
        if($path != $new_path) {
            rename($path, $new_path);
            $result = DB::table('documents')
                ->where('id', $request->id)
                ->update([
                    'title' => $request->title, 
                    'category_id' => $request->category_id, 
                    'expired_date' => $request->expired_date, 
                    'email' => $request->email, 
                    'mobile' => $request->mobile, 
                    'file_path' => $new_path,
                    'file_name' => $title.'.'.$extension,
                    'tags_for_search' => $request->tags_for_search,
                    ]);
                echo 1;
        }else {
            $result = DB::table('documents')
                ->where('id', $request->id)
                ->update([
                    'title' => $request->title, 
                    'category_id' => $request->category_id, 
                    'expired_date' => $request->expired_date, 
                    'email' => $request->email, 
                    'mobile' => $request->mobile, 
                    'tags_for_search' => $request->tags_for_search,
                    ]);
                echo 1;
        }
    }

    public function deleteOne(Request $request)
    {
        $path = $request->path;
        $real_path = str_replace('\\', '/', $path);
        if(is_dir($path)) {
            $exist = DB::table('documents')->where('file_path', 'LIKE', $real_path.'/%')->count();
            if($exist > 0) {
                $result = DB::table('documents')->where('file_path', 'LIKE', $real_path.'/%')->delete();
            }
            $this->deleteDirectory($path);

        } else {
            $exist = DB::table('documents')->where('file_path', $real_path)->count();
            if($exist > 0) {
                $result = DB::table('documents')->where('file_path', $real_path)->delete();
            }
            unlink($path);

        }
        echo 1;
    }
    
    public function deleteDirectory($dirPath) {

        if (is_dir($dirPath)) {

            $objects = scandir($dirPath);

            foreach ($objects as $object) {

                if ($object != "." && $object !="..") {

                    if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {

                        $this->deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);

                    } else {

                        unlink($dirPath . DIRECTORY_SEPARATOR . $object);

                    }

                }

            }

            reset($objects);

            rmdir($dirPath);

        }

    }
    public function mydirectory_table(Request $request, $path)
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $real_path = str_replace('*', '/', './'.$path);
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        $categories = DB::table('categories')->get();
        $role = $roleData->title;
        if ($role == 'admin') {
            $ldms_documents_all = DB::table('documents')->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
            if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('expired_date', [$start_date, $end_date])->get();
                $ldms_total_documents_number = count($document_list);
            }
            else {
                $document_list = DB::table('documents')->get();
                $ldms_total_documents_number = count($document_list);
            }

            $categories = Categories::all();
            return view('document.mydirectory_table', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list','categories', 'real_path', 'role'));
        } 
        else {
            if(!is_dir('./public/priv/'.$userData->email)) {
                mkdir('./public/priv/'.$userData->email);
            }
            $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id', '=' ,$userData->role_id],
                                        ['expired_date', '<', $todayDate],
                                        ]
                                    )->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
            if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('expired_date', [$start_date, $end_date])->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            }
            else {
                $document_list = DB::table('documents')->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            }

    
            return view('document.mydirectory_table', compact('ldms_documents_all','categories', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list', 'real_path', 'role'));
        }
    }
}
