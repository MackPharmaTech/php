<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eventanalysis extends MY_Controller {
     public function __construct()
    {
        parent::__construct();
        $this->load->helper('pdf');
    }

	public function index()
	{
	      $url="";
	    if(isset($_POST['btn_submit']))
		{
		  
			$from_date=date('d-m-Y H:i:s',strtotime($_POST['from_date']));
			$to_date=date('d-m-Y H:i:s',strtotime($_POST['to_date']));
			$chamber=$_POST['chamber_id'];
			$event=$_POST['event_id'];
			$user_id=$_POST['user_id_test'];
			$current_date = date('d-m-Y H:i:s');
			$curdate=strtotime($_POST['from_date']);
            $mydate=strtotime($_POST['to_date']);
            $datediff = ($mydate/(60*60*24) - $curdate/(60*60*24));
            $days=abs($datediff);
	 		if ($curdate > $mydate ) {
	                $this->session->set_flashdata('error','Please select From Date smaller than To Date');
				    redirect(base_url('audit/eventanalysis'));
				}
			elseif($days>183)
			{
				$this->session->set_flashdata('error','Please select from date and to date between six months period only');
			    redirect(base_url('audit/eventanalysis'));

			}
			else
			{
			    if($this->session->userdata('user_permission')=='PREPARED'){
			 $getfooter = $this->common_model->get_records('manage_footer',array('active'),array('value'=>'CHECK'),TRUE);
                    $getactive_flg = $getfooter['active']; 
			$url=base_url('audit/eventanalysis/generat_pdf/'.$from_date.'/'.$to_date.'/'.$chamber.'/'.'?event='.$event.'&user_id='.$user_id.'&prepar_by='.$this->session->userdata('user_id').'&vr=&report_seq=&rt=gr');
			if($getactive_flg == 'Y')
        			{
			$insert_array = array(
								'from_date_time	'=>$this->input->post('from_date'),
								'to_date_time'=>$this->input->post('to_date'),
								'module'=>'Audit',
								'sub_module'=>'Event Analysis',
								'user_id'=>$this->session->userdata('user_id'),
								'assign_date_prepared_by'=>date('Y-m-d H:i:s'),
								'assign_to_prepared_by'=>$this->session->userdata('user_id'),
								'module_url'=>$url,
								'created_date_r' => date('Y-m-d H:i:s'),
								'chamber_seq'=>$chamber,
								);
			$this->common_model->add_records('report_log',$insert_array);
        			}
        			else
        			{
        			    $insert_array = array(
								'from_date_time	'=>$this->input->post('from_date'),
								'to_date_time'=>$this->input->post('to_date'),
								'module'=>'Audit',
								'sub_module'=>'Event Analysis',
								'user_id'=>$this->session->userdata('user_id'),
								'assign_date_prepared_by'=>date('Y-m-d H:i:s'),
								'assign_to_prepared_by'=>$this->session->userdata('user_id'),
									'assign_to_checked_by'=>'NA',
    								'assign_date_checked_by'=>'NA',
    								'checkedby_view_report_time'=>'NA',
								'module_url'=>$url,
								'created_date_r' => date('Y-m-d H:i:s'),
								'chamber_seq'=>$chamber,

								);
			$this->common_model->add_records('report_log',$insert_array);
        			}
			    }elseif($this->session->userdata('user_permission')=='CHECK'){
			        $url=base_url('audit/eventanalysis/generat_pdf/'.$from_date.'/'.$to_date.'/'.$chamber.'/'.'?event='.$event.'&user_id='.$user_id.'&check_by='.$this->session->userdata('user_id').'&vr=&report_seq=&rt=gr');
			
			$insert_array = array(
								'from_date_time	'=>$this->input->post('from_date'),
								'to_date_time'=>$this->input->post('to_date'),
								'module'=>'Audit',
								'sub_module'=>'Event Analysis',
								'user_id'=>$this->session->userdata('user_id'),
								'assign_date_checked_by'=>date('Y-m-d H:i:s'),
								'assign_to_checked_by'=>$this->session->userdata('user_id'),
								'module_url'=>$url,
								'created_date_r' => date('Y-m-d H:i:s'),
								'chamber_seq'=>$chamber,

								);
			$this->common_model->add_records('report_log',$insert_array);
			        
			    }elseif($this->session->userdata('user_permission')=='APPROVED'){
			          $url=base_url('audit/eventanalysis/generat_pdf/'.$from_date.'/'.$to_date.'/'.$chamber.'/'.'?event='.$event.'&user_id='.$user_id.'&approve_by='.$this->session->userdata('user_id').'&vr=&report_seq=&rt=gr');
			
			$insert_array = array(
								'from_date_time	'=>$this->input->post('from_date'),
								'to_date_time'=>$this->input->post('to_date'),
								'module'=>'Audit',
								'sub_module'=>'Event Analysis',
								'user_id'=>$this->session->userdata('user_id'),
								'assign_date_approved_by'=>date('Y-m-d H:i:s'),
								'assign_to_approved_by'=>$this->session->userdata('user_id'),
								'module_url'=>$url,
								'created_date_r' => date('Y-m-d H:i:s'),
										 'assign_to_prepared_by' => 'NA',
				                    'assign_to_checked_by' =>'NA',
				                    'assign_date_checked_by' =>'NA',
				                    'checkedby_view_report_time'=>'NA',
								'chamber_seq'=>$chamber,

								);
			$this->common_model->add_records('report_log',$insert_array);
			        
			    }else{
			         if($this->session->userdata('user_type')=='ADMIN'){
			             $url=base_url('audit/eventanalysis/generat_pdf/'.$from_date.'/'.$to_date.'/'.$chamber.'/'.'?event='.$event.'&user_id='.$user_id.'&approve_by='.$this->session->userdata('user_id').'&vr=&report_seq=&rt=gr');
			
			$insert_array = array(
								'from_date_time	'=>$this->input->post('from_date'),
								'to_date_time'=>$this->input->post('to_date'),
								'module'=>'Audit',
								'sub_module'=>'Event Analysis',
								'user_id'=>$this->session->userdata('user_id'),
								'assign_date_approved_by'=>date('Y-m-d H:i:s'),
								'assign_to_approved_by'=>$this->session->userdata('user_id'),
								'module_url'=>$url,
								'created_date_r' => date('Y-m-d H:i:s'),
										 'assign_to_prepared_by' => 'NA',
				                    'assign_to_checked_by' =>'NA',
				                    'assign_date_checked_by' =>'NA',
				                    'checkedby_view_report_time'=>'NA',
								'chamber_seq'=>$chamber,
				                    
								);
			$this->common_model->add_records('report_log',$insert_array);
			             
			         }else{
			             
			             	$urls=base_url('audit/eventanalysis/generat_pdf/'.$from_date.'/'.$to_date.'/'.$chamber.'/'.'?event='.$event.'&user_id='.$user_id);
			         }
			        
			    }
		
			}
		}
		$this->db->where("active_flg","1");
	    $chamber_details=$this->common_model->get_records('chamber_master','');
		$event_details=$this->common_model->get_records('event','');
		$this->db->where("user_status","1");
		$user_details=$this->common_model->get_records('tbl_user','');
		$data=array('middle_content'=>'event-analysis-view','chamber_details'=>$chamber_details,'event_details'=>$event_details,'user_details'=>$user_details,'url'=>$url);	
		$this->load->view('template',$data);
		
	}
	public function generat_pdf($from_date,$to_date,$chamber)
	{
		$event = $_GET['event'];
		$user_id = $_GET['user_id'];
		 $from_dates=str_replace('%20','', $from_date);
		 $to_dates=str_replace('%20','', $to_date);
		 if($_GET['report_seq'] !="" && $_GET['vr'] == "check")
		 {
		  $report_seq = $_GET['report_seq'];
		 $update_array = array(
		                    'checkedby_view_report_time'=>date('Y-m-d H:i:s'),
		                    );
		  $where_array=array('report_log_seq'=>$report_seq);
		 
		  $this->common_model->update_records('report_log',$update_array,$where_array);
		
		 }
		 if($_GET['report_seq'] !="" && $_GET['vr'] == "prepare")
		 {
		  $report_seq = $_GET['report_seq'];
		 $update_array = array(
		                    'preparedby_view_report_time'=>date('Y-m-d H:i:s'),
		                    );
		  $where_array=array('report_log_seq'=>$report_seq);
		 
		  $this->common_model->update_records('report_log',$update_array,$where_array);
		
		 }
		 if($_GET['report_seq'] !="" && $_GET['vr'] == "approve")
		 {
		  $report_seq = $_GET['report_seq'];
		 $update_array = array(
		                    'approvedby_view_report_time'=>date('Y-m-d H:i:s'),
		                    );
		  $where_array=array('report_log_seq'=>$report_seq);
		 
		  $this->common_model->update_records('report_log',$update_array,$where_array);
		
		 }
		$this->make($from_dates,$to_dates,$chamber,$event,$user_id);
	}
public function make($from_date,$to_date,$chamber,$event,$user_id)
	{
		//ob_start();
$from_date1=date('d-m-Y H:i:s',strtotime($from_date));
$to_date1=date('d-m-Y H:i:s',strtotime($to_date));
$company_details=$this->common_model->get_records('tbl_company','','',TRUE);
$chamber_details=$this->common_model->get_records('chamber_master','',array('chamber_seq'=>$chamber),TRUE);
$chambername=$chamber_details['Chamber_Name'];
$chambercode=$chamber_details['Chamber_cd'];
$report_seq = $_GET['report_seq'];
$getreport = $this->common_model->get_records('report_log','',array('report_log_seq'=>$report_seq),TRUE);
$getpid = $getreport['pid_remark'];
$getcid = $getreport['cid_remark'];
$getaid = $getreport['aid_remark'];
$getrid = $getreport['rejected_by'];
$getruserdetails = $this->common_model->get_records('tbl_user',array('first_name'),array('user_id'=>$getrid),TRUE);
$getrfirstname = $getruserdetails['first_name'];
$getauserdetails = $this->common_model->get_records('tbl_user',array('first_name'),array('user_id'=>$getaid),TRUE);
$getafirstname = $getauserdetails['first_name'];
$get_userdetails = $this->common_model->get_records('tbl_user',array('first_name'),array('user_id'=>$getpid),TRUE);
$getpfirstname = $get_userdetails['first_name'];
$getcuserdetails = $this->common_model->get_records('tbl_user',array('first_name'),array('user_id'=>$getcid),TRUE);
$getcfirstname = $getcuserdetails['first_name'];

		// create new PDF document
$pdf = new MYPDFS('l', PDF_UNIT, PDF_PAGE_FORMAT,  true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TMR');
$pdf->SetTitle($this->lang->line('event_a'));
$pdf->SetSubject('TMR');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$header_title=ucfirst($company_details['company_name']);
$address=nl2br($company_details['company_address']);
$header_string=<<<EOD
$address
Software Version :DAAS4.0
EOD;

// set font
$pdf->SetFont(load_font(), ' ', 9);

$getstat = $this->common_model->get_records('historydb','',array('historydb_seq'=>'1'),'TRUE');
$get_detailstat = $getstat['status'];

$event_a = $this->lang->line('event_a');
$date_time_format = $this->lang->line('date_time_format');
$for_period = $this->lang->line('for_the_period');
$to = $this->lang->line('to');
$softver = $this->lang->line('soft_ver');
$historydb = $this->lang->line('note_history_database');
$rejected_label = $this->lang->line('REJECTED_label');
$date_time = $this->lang->line('date/time');
$eventE = $this->lang->line('event');
$Reasons = $this->lang->line('Reasons');
$description = $this->lang->line('description');
$Type = $this->lang->line('Type');
$Active = $this->lang->line('Active');
$Action = $this->lang->line('Action');
$user = $this->lang->line('user');
$remark = $this->lang->line('remarks');
$username = $this->lang->line('u_n');

$selversion = $this->common_model->get_records('sw_version',array('sw_descp'),array('sw_ver'=>'1'),TRUE);
$version = $selversion['sw_descp'];

if(flagh == 0)
{
$txt=<<<EOD
<hr>
<table border="0" cellpadding="1" cellspacing="1"  >
<tr><td colspan="2"><b>$event_a: $chambercode - $chambername</b></td></tr>
<tr><td colspan="2"><b>$date_time_format</b></td></tr>
<tr><td colspan="2"><b>$for_period $from_date1 $to $to_date1</b> </td></tr>
<tr><td colspan="2"><b>$softver $version </b></td></tr>
<br>
</table>
EOD;
}else{
    $txt=<<<EOD
<hr>
<table border="0" cellpadding="1" cellspacing="1"  >
<tr><td>$historydb </td></tr>
<tr><td colspan="2"><b>$event_a: $chambercode - $chambername</b></td></tr>
<tr><td colspan="2"><b>$date_time_format</b></td></tr>
<tr><td colspan="2"><b>$for_period $from_date1 $to $to_date1</b> </td></tr>
<tr><td colspan="2"><b>$softver $version </b></td></tr>
<br>
</table>
EOD;
}
$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH,$header_title,$txt);
$pdf->SetFont(load_font(), '', 9);
$pdf->setHeaderFont(Array(load_font(), '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(load_font(), '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, 21);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 127);
$pdf->SetFillColor(255, 255, 215);
$txt1="";
$get_username = $this->common_model->get_records('report_log','',array('report_log_seq'=>$report_seq),TRUE);
if($get_username['status'] == "REJECTED")
{
$txt1="";
$txt1.='
<table border="0" cellpadding="1" cellspacing="1"  >
<tr><td color="red" style="font-size:25px;" align="center"><b>'.$rejected_label.'</b></td></tr>
</table>
';
}
$pdf->writeHTML($txt1, true, false, false, false, '');

$queryfetch = $this->common_model->get_records('tbl_user','',array('user_id'=>$user_id),TRUE);
 $hmiid = $queryfetch['hmi'];
if($event == '' && $user_id == '')
{
    
$html="";
$from_date=date('Y-m-d H:i',strtotime($from_date));
$to_date=date('Y-m-d H:i',strtotime( $to_date));
// Table with rowspans and THEAD
$query="SELECT distinct * FROM fired_event_log";
$this->db->distinct('fired_event_log.event_date_time');
$this->db->where('fired_event_log.event_date_time >=',$from_date);
$this->db->where('fired_event_log.event_date_time <=',$to_date);
$this->db->where('fired_event_log.fired_event_type =','E');
$this->db->where('fired_event_log.chamber_seq',$chamber);
$this->db->join('reason','reason.reason_seq=fired_event_log.reason_seq','LEFT');
$this->db->join('event','event.event_cd=fired_event_log.event_cd','LEFT');
$this->db->join('tbl_user','tbl_user.user_id=fired_event_log.user_id' ,'LEFT');
$this->db->order_by("fired_event_log.event_date_time", "asc");
// $this->db->group_by('fired_event_log.event_date_time');
$query=$this->db->get('fired_event_log');
$data = $query->result_array();

for($i=0;$i<count($data);$i++)
{
    $userid = $data[$i]['user_id'];
$getdetail = $this->common_model->get_records('tbl_user',array('username'),array('user_id'=>$userid),TRUE);
$getusername = $getdetail['username'];

 $html.='<tr nobr="true">
 <td align="center">'.date('d-m-Y H:i:s',strtotime($data[$i]['event_date_time'])).'</td>
 <td align="center">'.$data[$i]['event_description'].'</td>

 <td align="center">'.$getusername.'</td>
 <td align="center">'.$data[$i]['Reason_description'].'</td>
 <td align="center">'.$data[$i]['remarks'].'</td>

 </tr>';
}}
elseif($user_id == ''){
    $html="";
$from_date=date('Y-m-d H:i',strtotime($from_date));
$to_date=date('Y-m-d H:i',strtotime( $to_date));
// Table with rowspans and THEAD
$query="SELECT distinct * FROM fired_event_log";
$this->db->distinct('fired_event_log.event_date_time');
$this->db->where('fired_event_log.event_date_time >=',$from_date);
$this->db->where('fired_event_log.event_date_time <=',$to_date);
$this->db->where('fired_event_log.event_cd',$event);
$this->db->where('fired_event_log.chamber_seq',$chamber);
$this->db->where('fired_event_log.fired_event_type =','E');
$this->db->join('event','event.event_cd=fired_event_log.event_cd');

$this->db->join('reason','reason.reason_seq=fired_event_log.reason_seq','LEFT');
$this->db->join('tbl_user','tbl_user.user_id=fired_event_log.user_id','LEFT');
$this->db->order_by("fired_event_log.event_date_time", "asc");
// $this->db->group_by('fired_event_log.event_date_time');
$query=$this->db->get('fired_event_log');
$data = $query->result_array();


for($i=0;$i<count($data);$i++)
{
    $userid = $data[$i]['user_id'];
$getdetail = $this->common_model->get_records('tbl_user',array('username'),array('user_id'=>$userid),TRUE);
$getusername = $getdetail['username'];

 $html.='<tr nobr="true">
 <td align="center">'.date('d-m-Y H:i:s',strtotime($data[$i]['event_date_time'])).'</td>
 <td align="center">'.$data[$i]['event_description'].'</td>

 <td align="center">'.$getusername.'</td>
 <td align="center">'.$data[$i]['Reason_description'].'</td>
 <td align="center">'.$data[$i]['remarks'].'</td>

 </tr>';
}
}
elseif($event == '')
{$html="";
$from_date=date('Y-m-d H:i',strtotime($from_date));
$to_date=date('Y-m-d H:i',strtotime( $to_date));

// Table with rowspans and THEAD
$query="SELECT distinct * FROM fired_event_log";
$this->db->distinct('fired_event_log.event_date_time');
$this->db->where('fired_event_log.event_date_time >=',$from_date);
$this->db->where('fired_event_log.event_date_time <=',$to_date);
$this->db->where('fired_event_log.fired_event_type =','E');
$this->db->where('fired_event_log.chamber_seq',$chamber);
$this->db->where('fired_event_log.user_id',$user_id);

$this->db->join('reason','reason.reason_seq=fired_event_log.reason_seq','LEFT');
$this->db->join('event','event.event_cd=fired_event_log.event_cd','LEFT');
$this->db->join('tbl_user','tbl_user.user_id=fired_event_log.user_id','LEFT');
$this->db->order_by("fired_event_log.event_date_time", "asc");
// $this->db->group_by('fired_event_log.event_date_time');
$query=$this->db->get('fired_event_log');
$data = $query->result_array();

for($i=0;$i<count($data);$i++)
{

 $html.='<tr nobr="true">
 <td align="center">'.date('d-m-Y H:i:s',strtotime($data[$i]['event_date_time'])).'</td>
 <td align="center">'.$data[$i]['event_description'].'</td>
 <td align="center">'.$data[$i]['username'].'</td>
 <td align="center">'.$data[$i]['Reason_description'].'</td>
 <td align="center">'.$data[$i]['remarks'].'</td>

 </tr>';
}
}
else
{
    $html="";
$from_date=date('Y-m-d H:i',strtotime($from_date));
$to_date=date('Y-m-d H:i',strtotime( $to_date));
// Table with rowspans and THEAD
$query="SELECT distinct * FROM fired_event_log";
$this->db->distinct('fired_event_log.event_date_time');
$this->db->where('fired_event_log.event_date_time >=',$from_date);
$this->db->where('fired_event_log.event_date_time <=',$to_date);
$this->db->where('fired_event_log.event_cd',$event);
$this->db->where('fired_event_log.chamber_seq',$chamber);
$this->db->where('fired_event_log.user_id',$user_id);

$this->db->where('fired_event_log.fired_event_type =','E');
$this->db->join('event','event.event_cd=fired_event_log.event_cd','LEFT');
$this->db->join('reason','reason.reason_seq=fired_event_log.reason_seq','LEFT');
$this->db->join('chamber_master','chamber_master.chamber_seq=fired_event_log.chamber_seq');
$this->db->join('tbl_user','tbl_user.user_id=fired_event_log.user_id');
$this->db->order_by("fired_event_log.event_date_time", "asc");
// $this->db->group_by('fired_event_log.event_date_time');
$query=$this->db->get('fired_event_log');
$data = $query->result_array();



for($i=0;$i<count($data);$i++)
{

 $html.='<tr nobr="true">
 <td align="center">'.date('d-m-Y H:i:s',strtotime($data[$i]['event_date_time'])).'</td>
 <td align="center">'.$data[$i]['event_description'].'</td>

 <td align="center">'.$data[$i]['username'].'</td>
 <td align="center">'.$data[$i]['Reason_description'].'</td>
 <td align="center">'.$data[$i]['remarks'].'</td>

 </tr>';
}
}



$tbl = <<<EOF
<style>

th{
	border: 1px solid black;
	font-weight:bold;
	background-color: #DCDCDC;
}
td {
  border: 1px solid black;
}
</style>
<table class="first" border="0" cellpadding="1"  >
<thead>
 <tr>
  <th align="center"><b><br>$date_time<br></b></th>
  <th align="center"><b><br>$eventE<br></b></th>
  <th align="center"> <b><br>$user<br></b></th>
  <th align="center"> <b><br>$Reasons<br></b></th>
  <th align="center"> <b><br>$remark<br></b></th>
 </tr>
 </thead>
 <tbody>
 $html
 </tbody>
</table>
EOF;
if( $_GET['remark_id']!="" || $_GET['cremark_id']!="" || $_GET['aremark_id']!="" || $_GET['rejremark_id']!="")
{
	$rem="";
		 $remark_details=$get_username['remark'];
	$rem1="";
		 $cremark_details = $get_username['c_remark'];
 	$rem2="";
 		$aremark_details = $get_username['a_remark'];
	$rem3="";
		$rejremark_details = $get_username['rejected_remark'];
$rem.='
<tr>
<td align="left" colspan="2">'.$remark_details.'</td></tr>
';
$rem1.='
<tr>
<td align="left" colspan="2">'.$cremark_details.'</td></tr>
';
$rem2.='
<tr>
<td align="left" colspan="2">'.$aremark_details.'</td></tr>
';
$rem3.='
<tr>
<td align="left" colspan="2">'.$rejremark_details.'</td></tr>
';

if($get_username['remark'] == '')
{
	$tbl7= <<<EOF
	EOF;
}else{
	$tbl7= <<<EOF


<style>

th{
	border-bottom: 1px solid black;
	font-weight:bold;
	background-color: #C0C0C0;
}

table {
	border: 1px solid black;
	border-top: 3px solid black;
}

</style>
<table cellpadding="3" >
<thead>
 <tr>
  <th>$remark</th>
  <th align="right" style="width:50%;">$username - $getpfirstname</th>
 </tr>
</thead>
<tbody>
$rem
</tbody>
</table> 
EOF;
}
if($get_username['c_remark'] == '')
{
	$tbl8= <<<EOF
	EOF;
}else{
$tbl8= <<<EOF
<style>

th{
	border-bottom: 1px solid black;
	font-weight:bold;
	background-color: #C0C0C0;
}

table {
	border: 1px solid black;
	border-top: 3px solid black;
}

</style>
<table cellpadding="3" >
<thead>
 <tr>
  <th>$remark</th>
  <th align="right" style="width:50%;">$username - $getcfirstname</th>
 </tr>
</thead>
<tbody>
$rem1
</tbody>
</table> 
EOF;
}
if($get_username['a_remark'] == '')
{
	$tbl9= <<<EOF
	EOF;
}else{
$tbl9= <<<EOF
<style>

th{
	border-bottom: 1px solid black;
	font-weight:bold;
	background-color: #C0C0C0;
}

table {
	border: 1px solid black;
	border-top: 3px solid black;
}

</style>
<table cellpadding="3" >
<thead>
 <tr>
  <th>$remark</th>
  <th align="right" style="width:50%;">$username - $getafirstname</th>
 </tr>
</thead>
<tbody>
$rem2
</tbody>
</table> 
EOF;}
if($get_username['rejected_remark'] == '')
{
	$tbl10= <<<EOF
EOF;
}else
{
	$tbl10= <<<EOF
<style>

th{
	border-bottom: 1px solid black;
	font-weight:bold;
	background-color: #C0C0C0;
}

table {
	border: 1px solid black;
	border-top: 3px solid black;
}

</style>
<table cellpadding="3" >
<thead>
 <tr>
  <th>$remark</th>
  <th align="right" style="width:50%;">$username - $getrfirstname</th>
 </tr>
</thead>
<tbody>
$rem3
</tbody>
</table> 
EOF;
}
}else{
	$tbl7= <<<EOF
EOF;
$tbl8= <<<EOF
EOF;
$tbl9= <<<EOF
EOF;
$tbl10= <<<EOF
EOF;
}

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->lastPage();
$pdf->writeHTML($tbl7, true, false, true, false, '');
$pdf->writeHTML($tbl8, true, false, true, false, '');
$pdf->writeHTML($tbl9, true, false, true, false, '');
$pdf->writeHTML($tbl10, true, false, true, false, '');
$date=date('d-m-Y H:i:s');
ob_end_clean();
$pdf->Output('Event_Analysis_Audit_Report_'.$date.'.pdf', 'I');
	}

}
