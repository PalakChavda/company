<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Exception;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'category_name' => 'company',
            'page_name' => 'company',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        );
        return view('company.index')->with($data);
    }

    /*
     *   AJAX request
     */
    public function getCompany(Request $request)
    {

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Company::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Company::select('count(*) as allcount')
            ->where('company.name', 'like', '%' . $searchValue . '%')
            ->orWhere('company.email', 'like', '%' . $searchValue . '%')
            ->orWhere('company.website', 'like', '%' . $searchValue . '%')
            ->orWhere('company.license_no', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Company::orderBy($columnName, $columnSortOrder)
            ->where('company.name', 'like', '%' . $searchValue . '%')
            ->orWhere('company.email', 'like', '%' . $searchValue . '%')
            ->orWhere('company.website', 'like', '%' . $searchValue . '%')
            ->orWhere('company.license_no', 'like', '%' . $searchValue . '%')
            ->select('company.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $name = $record->name;
            $email = $record->email;
            $website = $record->website;
            $license_no = $record->license_no;
            $status = $record->status == 1 ? 'checked' : '';
            $status_class = $record->status == 1 ? 'primary' : 'danger';
            
            $data_arr[] = array(
                "name" => $name,
                "email" => $email,
                "website" => $website,
                "license_no" => $license_no,
                "status" => '<label class="switch s-icons s-outline s-outline-warning mr-2">
                <input type="checkbox" data-id="' . $record->id . '" class="checkbox" name="status[' . $record->id . ']" ' . $status . ' > <span class="slider"></span></label>',

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => "company",
            'page_name' => 'company_add',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        return view('company.create', ['company' => Company::all()])->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'website' => 'required',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
            ]);

            if ($validator->fails()) {

                $data = array(
                    'category_name' => 'company',
                    'page_name' => 'company_add',
                    'has_scrollspy' => 0,
                    'scrollspy_offset' => '',
                );

                $request->session()->flash('message.level', 'danger');
                $request->session()->flash('message.background', '#e7515a');
                $request->session()->flash('message.content', $validator->errors());
                return redirect()->route('company.create')->with($data);
            }

            
            if (!empty($request->email)) {
                $company = Company::where('email', '=', $request->email)->first();
                
                if ($company != null) {
                    $data = array(
                        'category_name' => 'company',
                        'page_name' => 'company_add',
                        'has_scrollspy' => 0,
                        'scrollspy_offset' => '',
                    );

                    // email exist
                    $request->session()->flash('message.level', 'danger');
                    $request->session()->flash('message.background', '#e7515a');
                    $request->session()->flash('message.content', Lang::get('alert.user_email_already_exist'));

                    return redirect()->route('company.create')->with($data);
                }
            }


            if (!empty($request)) {
                $insert = Company::create($request->all());
                // $token = Str::random(12);
                // $mail_data = array(
                //     "to_name" => ucfirst($request->name),
                //     "to_email" => $request->email,
                //     "token" => $token,
                //     "email_type" => "welcome"
                // );

                    $request->session()->flash('message.level', 'success');
                    $request->session()->flash('message.background', '#8dbf42');
                    $request->session()->flash('message.content', Lang::get("alert.record_created_successfully"));
                } else {
                    $request->session()->flash('message.level', 'danger');
                    $request->session()->flash('message.background', '#e7515a');
                    $request->session()->flash('message.content',  Lang::get('alert.somthing_wrong'));
                }
           
            $data = array(
                'category_name' => 'company',
                'page_name' => 'company_add',
                'has_scrollspy' => 0,
                'scrollspy_offset' => '',
            );

            return redirect()->route('company.index')->with($data);
        } catch (Exception $ex) {

            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.background', '#e7515a');
            $request->session()->flash('message.content', $ex->getMessage());
        }
    }

    public function change_status_by_id(Request $request)
    {
        $check_exist = Company::find($request->id);

        if (empty($check_exist)) {
            $response = array(
                'status' => 'failed',
                'message' => Lang::get('alert.somthing_wrong'),
                'background' => '#e7515a'
            );
        }
        $check_exist->status = $request->status;
        if ($check_exist->save()) {

            $response = array(
                'status' => 'success',
                'message' => Lang::get('alert.change_status'),
                'background' => '#8dbf42'
            );
        } else {
            $response = array(
                'status' => 'failed',
                'message' => Lang::get('alert.somthing_wrong'),
                'background' => '#e7515a'
            );
        }
        return response()->json($response);
    }

}
