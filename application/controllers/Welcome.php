<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
	{
		$this->load->view('welcome_message');
	}

	public function daksh(){

        // getData Method or function Location (Application/models/Data_model.php)
        $data['employee'] = $this->Data_model->getData('emp');
        //print_r($data);

        // template location Application/views/template (folder or directory)
        // demo it's file name demo.php in template folder
        $this->load->view('template/demo',$data);
        //echo "Lochawala";
    }

    public function insertData(){
	    //$_POST['emoName']; old method
        //$this->input->post('empName'); ci method
        // $empndame new method
        extract($_POST);

        // Array Bunch add data to table
        $data = [
            'emp_name'=>$empName,
            'emp_dob'=>date('Y-m-d',strtotime($empDob))
        ];
        // insertData Method or function Location (Application/models/Data_model.php)
        $this->Data_model->insertData('emp',$data);

        // Redirect Controller welcome.php (self class)
        // pratik is method for current class or welcome controller method
        redirect(base_url('Welcome/daksh'));

    }

    public function deleteData(){
        extract($_GET);
        // Array Bunch table condition
        $con = [
            'emp_id'=>$did
        ];
        // deleteData Method or function Location (Application/models/Data_model.php)
        $this->Data_model->deleteData('emp',$con);
        redirect(base_url('Welcome/daksh'));

    }

    public function getSelectedData($id){
        $con=[
            'emp_id'=>$id
        ];
        // getSelectedData Method or function Location (Application/models/Data_model.php)
        $data['editData'] = $this->Data_model->getSelectedData('emp',$con);
        $this->load->view('template/edit',$data);

    }

    public function updateData(){
        extract($_POST);
        $con=['emp_id'=>$hid];
        $data= ['emp_name'=>$empName, 'emp_dob'=>$empDob ];
        // updateData Method or function Location (Application/models/Data_model.php)
        $this->Data_model->updateData('emp',$data,$con);
        redirect(base_url('Welcome/daksh'));
    }

    public function getData(){
        $requestData = $_POST;

        $id = $requestData['columns'][1]['search']['value'];
        $dt = explode(' - ', $id);

        $columns = array(
            0 => 'bm.bill_master_id',
            1 => 'gbm.invoice_no',
            2 => 'bm.invoice_date',
            3 => 'cm.party_name',
            4 => 'cm.days',
            5 => 'bm.created_date',
        );


        $sql = 'SELECT * FROM bill_master_item bmi, customer_master cm, bill_master bm where bmi.bill_master_item_id=bm.bill_master_item_id and cm.customer_master_id=bm.customer_master_id and bmi.is_delete="N" and cm.is_delete="N" and bm.is_delete="N"';

        $query = $this->Data_Model->Custome_query($sql);

        $totalData = count($query);
        $totalFiltered = $totalData;


        if (!empty($requestData['search']['value'])) {
            $searchString = "'" . str_replace(",", "','", $requestData['search']['value']) . "%'";
            $sql .= " and ( bm.bill_master_id  LIKE " . $searchString;
            $sql .= " or pm.company_name  LIKE " . $searchString;
            $sql .= " or gbm.invoice_no  LIKE " . $searchString;
            $sql .= " or bm.invoice_date  LIKE " . $searchString;
            $sql .= " or cm.party_name  LIKE " . $searchString;
            $sql .= " or cm.days  LIKE " . $searchString;
            $sql .= " or bm.created_date  LIKE " . $searchString . ")";
        }
        $query = $this->Data_Model->Custome_query($sql);

        $totalFiltered = count($query);


        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
        $query = $this->Data_Model->Custome_query($sql);

        $data = array();
        $cnts = $requestData['start'] + 1;
        foreach ($query as $row) {
            if ($row['payment_status'] == 'U') {
                $sts = "<a href='javascript:void(0);' class='btn btn-xs btn-danger btn-icon-anim btn-circle status' onclick='sts(" . $row['bill_master_id'] . ",\"" . $row['payment_status'] . "\",\"" . $row['remark'] . "\")' >Unpaid</a>";
            } else {
                $sts = "<a href='javascript:void(0);' class='btn btn-xs btn-success btn-icon-anim btn-circle status' onclick='sts(" . $row['bill_master_id'] . ",\"" . $row['payment_status'] . "\",\"" . $row['remark'] . "\")'>Paid</i></a>";
            }
            $bill = "<a href='javascript:void(0);' class='btn btn-xs btn-info btn-icon-anim btn-circle edit' onclick='editdata(" . $row['bill_master_id'] . ")'><i class='fa fa-file-text'></i></a> ";


            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = $row["company_name"];
            $nestedData[] = $row["invoice_no"];
            $nestedData[] = $row["invoice_date"];
            $nestedData[] = $row["party_name"];
            $nestedData[] = $row["days"];
            $nestedData[] = date('Y-m-d', strtotime($row["created_date"]));
            $nestedData[] = $sts;
            $nestedData[] = $bill;
            $nestedData['DT_RowId'] = "r" . $row['bill_master_id'];
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
}
