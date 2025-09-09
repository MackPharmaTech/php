<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Temprature_model extends CI_Model 
{
	public function get_temprature($lsChamber,$lsFromDate,$lsToDate)
	{
		$select="Select concat((record_date_time),'.'),temperature_value FROM controller_details WHERE chamber_seq =  '".$lsChamber."' AND record_date_time >=  '".$lsFromDate."' AND record_date_time <= '".$lsToDate."' order by record_date_time";
		$query =$this->db->query($select);
		return $query->result_array();
	}
	public function get_alarm($lsChamber,$lsFromDate,$lsToDate)
	{
		$select="Select cd.record_date_time as RecordDate
					,cd.temperature_value
					,cd.temperature_setpoint
					,cd.temperature_setpoint+cs.temp_alarm_band temp_alarm_band
					,cd.temperature_setpoint-cs.temp_alarm_band temp_alert_band
					FROM
					controller_details cd ,channel_settings cs
					Where
					 cs.chamber_seq=cd.chamber_seq
					 and cs.chamber_seq='".$lsChamber."'
					 and cd.record_date_time between '".$lsFromDate."'
					 and '".$lsToDate."'";
 		$query =$this->db->query($select);
 		//echo $this->db->last_query();
  	    //   exit;
		return $query->result_array();

	}
	public function get_humedity($lsChamber,$lsFromDate,$lsToDate)
	{
		$select="Select cd.record_date_time as RecordDate
					,cd.Humidity_Value
					,cd.Humidity_SetPoint
					,cd.Humidity_SetPoint+cs.humidity_alarm_band humidity_alarm_band
					,cd.Humidity_SetPoint-cs.humidity_alarm_band humidity_alert_band
					FROM
					controller_details cd ,channel_settings cs
					Where
						cs.chamber_seq=cd.chamber_seq
					 and cs.chamber_seq='".$lsChamber."'
					 and cd.record_date_time between '".$lsFromDate."'
					 and '".$lsToDate."'";
 		$query =$this->db->query($select);
 		
		return $query->result_array();
	}
	public function get_sv($lsChamber,$lsFromDate)
	{
	//	$sql="select temperature_setpoint, humidity_setpoint From controller_details Where chamber_seq= '".$lsChamber."' AND record_date_time = '".$lsFromDate."' order by record_date_time";
		$sql="select Temperature_setpoint, Humidity_setpoint From scanner_details Where chamber_seq= '".$lsChamber."' AND Record_Date_Time = '".$lsFromDate."' order by Record_Date_Time asc";
		$query =$this->db->query($sql);
		return $query->row_array();

	}
	public function get_header($lsChamber,$lsFromDate,$lsToDate,$No_Channel)
	{   
	    
		$sql="SELECT distinct component_cd AS CHANNEL, MIN(temperature_value) TMINIMUM, MAX(temperature_value) TMAXIMUM,AVG(temperature_value) TAVERAGE,MIN(humidity_value) HMINIMUM, MAX(humidity_value) HMAXIMUM,AVG(humidity_value) HAVERAGE FROM scanner_details Where chamber_seq= '".$lsChamber."' AND record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' Group by component_cd Order by LENGTH(component_cd),component_cd asc";
		$query =$this->db->query($sql);
	
		return $query->result_array();
		
	}
	
	public function scanner_data($lsChamber,$lsFromDate,$lsToDate,$report_type)
	{
		$where="";
// 		echo $report_type;
		//exit;
		if($report_type=="Temperature 4 CH")
		{
			$where="AND component_cd BETWEEN 'CH1' and 'CH4'";
		}
		if($report_type=="Temperature 8 CH")
		{
			$where="AND component_cd BETWEEN 'CH1' and 'CH8'";
		}
		if($report_type=="Temperature 9 CH")
		{
			$where="AND component_cd BETWEEN 'CH1' and 'CH9'";
		}
		if($report_type=="Temperature 12 CH")
		{
			$where="AND component_cd BETWEEN 'CH1' and 'CH12'";
		}
		if($report_type=="Temperature 14 CH")
		{
			$where="AND component_cd BETWEEN 'CH1' and 'CH14'";
		}
		if($report_type=="Temperature 16 CH")
		{
			$where="AND component_cd BETWEEN 'CH1' and 'CH16'";
		}
		if($report_type=="Temperature And Humidity 4 CH + 4 CH")
		{
				$where="AND component_cd BETWEEN 'CH1' and 'CH4'";
		}
		if($report_type=="Temperature And Humidity 8 CH + 8 CH")
		{
				$where="AND component_cd BETWEEN 'CH1' and 'CH8'";
		}
		if($report_type=="Temperature And Humidity 9 CH + 9 CH")
		{
		    	$where="AND component_cd BETWEEN 'CH1' and 'CH9'";	
		}
		if($report_type=="Temperature And Humidity 12 CH + 12 CH")
		{
				$where="AND component_cd BETWEEN 'CH1' and 'CH12'";
		}
		if($report_type=="Temperature And Humidity 16 CH + 16 CH")
		{
		    	$where="AND component_cd BETWEEN 'CH1' and 'CH16'";	
		}
		$sql="SELECT Record_Date_Time,chamber_seq,component_cd,Temperature_Value,humidity_value,component_cd From scanner_details Where chamber_seq= '".$lsChamber."' AND record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' ".$wh." ";
		$query =$this->db->query($sql);
		$new_array=array();
		foreach ($query->result_array() as $value) {
			//$new_array['Record_Date_Time']=
		}
		//return 
	}

	public function get_scanner($lsChamber,$lsFromDate,$lsToDate)
	{
		   $sql="SELECT
				Record_Date_Time,
				temperature_setpoint,
				temp_alarm_band,
				temp_alert_band,
				max(ch1) as CH1,
				max(ch2) as CH2,
				max(ch3) as CH3,
				max(ch4) as CH4,
				max(ch5) as CH5,
				max(ch6) as CH6,
				max(ch7) as CH7,
				max(ch8) as CH8,
				max(ch9) as CH9,
				max(ch10) as CH10,
				max(ch11) as CH11,
				max(ch12) as CH12,
				max(ch13) as CH13,
				max(ch14) as CH14,
				max(ch15) as CH15,
				max(ch16) as CH16
				from
				(
				SELECT
				sd.Record_Date_Time,
				sd.temperature_setpoint,
				sd.temperature_setpoint+cs.temp_alarm_band as temp_alarm_band,
				sd.temperature_setpoint-cs.temp_alarm_band as temp_alert_band,
				case when sd.component_cd='CH1' then sd.Temperature_value Else 0 End as ch1,
				case when sd.component_cd='CH2' then sd.Temperature_value Else 0 End as ch2,
				case when sd.component_cd='CH3' then sd.Temperature_value Else 0 End as ch3,
				case when sd.component_cd='CH4' then sd.Temperature_value Else 0 End as ch4,
				case when sd.component_cd='CH5' then sd.Temperature_value Else 0 End as ch5,
				case when sd.component_cd='CH6' then sd.Temperature_value Else 0 End as ch6,
				case when sd.component_cd='CH7' then sd.Temperature_value Else 0 End as ch7,
				case when sd.component_cd='CH8' then sd.Temperature_value Else 0 End as ch8,
				case when sd.component_cd='CH9' then sd.Temperature_value Else 0 End as ch9,
				case when sd.component_cd='CH10' then sd.Temperature_value Else 0 End as ch10,
				case when sd.component_cd='CH11' then sd.Temperature_value Else 0 End as ch11,
				case when sd.component_cd='CH12' then sd.Temperature_value Else 0 End as ch12,
				case when sd.component_cd='CH13' then sd.Temperature_value Else 0 End as ch13,
				case when sd.component_cd='CH14' then sd.Temperature_value Else 0 End as ch14,
				case when sd.component_cd='CH15' then sd.Temperature_value Else 0 End as ch15,
				case when sd.component_cd='CH16' then sd.Temperature_value Else 0 End as ch16

				 FROM
				 scanner_details  as sd
				inner join channel_settings as cs on cs.chamber_seq =sd.chamber_seq and cs.chamber_seq=sd.chamber_seq
				 Where sd.chamber_seq= '".$lsChamber."' and sd.Record_Date_time >= '".$lsFromDate."' and  sd.Record_Date_time <= '".$lsToDate."' ) as ss  group by Record_Date_Time,temperature_setpoint,temp_alarm_band";
				$query =$this->db->query($sql);
// 				echo $this->db->last_query();
// 			exit;
				 return $query->result_array();

	}
    public function get_scannerH($lsChamber,$lsFromDate,$lsToDate)
	{
		   $sql="SELECT
					Record_Date_Time,
					humidity_setpoint as temperature_setpoint,
					temp_alarm_band,
					temp_alert_band,
					max(ch1) as CH1,
					max(ch2) as CH2,
					max(ch3) as CH3,
					max(ch4) as CH4,
					max(ch5) as CH5,
					max(ch6) as CH6,
					max(ch7) as CH7,
					max(ch8) as CH8,
					max(ch9) as CH9,
					max(ch10) as CH10,
					max(ch11) as CH11,
					max(ch12) as CH12,
					max(ch13) as CH13,
					max(ch14) as CH14,
					max(ch15) as CH15,
				    max(ch16) as CH16

					  from
					(
					SELECT
					sd.Record_Date_Time,
					sd.humidity_setpoint ,
					sd.humidity_setpoint+cs.humidity_alarm_band as temp_alarm_band,
					sd.humidity_setpoint-cs.humidity_alarm_band as temp_alert_band,
					case when sd.component_cd='CH1' then sd.Humidity_Value Else 0 End as ch1,
					case when sd.component_cd='CH2' then sd.Humidity_Value Else 0 End as ch2,
					case when sd.component_cd='CH3' then sd.Humidity_Value Else 0 End as ch3,
					case when sd.component_cd='CH4' then sd.Humidity_Value Else 0 End as ch4,
					case when sd.component_cd='CH5' then sd.Humidity_Value Else 0 End as ch5,
					case when sd.component_cd='CH6' then sd.Humidity_Value Else 0 End as ch6,
					case when sd.component_cd='CH7' then sd.Humidity_Value Else 0 End as ch7,
					case when sd.component_cd='CH8' then sd.Humidity_Value Else 0 End as ch8,
					case when sd.component_cd='CH9' then sd.Humidity_Value Else 0 End as ch9,
					case when sd.component_cd='CH10' then sd.Humidity_Value Else 0 End as ch10,
					case when sd.component_cd='CH11' then sd.Humidity_Value Else 0 End as ch11,
					case when sd.component_cd='CH12' then sd.Humidity_Value Else 0 End as ch12,
					case when sd.component_cd='CH13' then sd.Humidity_Value Else 0 End as ch13,
					case when sd.component_cd='CH14' then sd.Humidity_Value Else 0 End as ch14,
					case when sd.component_cd='CH15' then sd.Humidity_Value Else 0 End as ch15,
				    case when sd.component_cd='CH16' then sd.Humidity_Value Else 0 End as ch16

					 FROM
					 scanner_details  as sd
					inner join channel_settings as cs on cs.chamber_seq =sd.chamber_seq and cs.chamber_seq=sd.chamber_seq
					 Where sd.chamber_seq= '".$lsChamber."' and sd.Record_Date_time >= '".$lsFromDate."' and  sd.Record_Date_time <= '".$lsToDate."') as ss
					 group by
					Record_Date_Time,
					temperature_setpoint,
					temp_alarm_band,
					temp_alert_band";
				$query =$this->db->query($sql);
				// $this->db->last_query();
				return $query->result_array();

	}

	public function get_lux($lsChamber,$lsFromDate,$lsToDate,$lszone,$lsluxuv,$lsluxuvb)
	{
		// echo "from_date".$lsFromDate;echo "<br>";
		// echo "to_date".$lsToDate;echo "<br>";
		// echo "chamber".$lsChamber;echo "<br>";
		// echo "zone".$lszone;echo "<br>";
		// echo "lsluxuv".$lsluxuv;echo "<br>";
		// echo "luxuvb".$lsluxuvb;echo "<br>";
		if($lsluxuv == 'A' && $lsluxuvb == '0' && $lszone == "0")
		{
			$select="SELECT DATE_FORMAT( Record_Date_Time , '%d-%m-%Y %H:%i:%s')  Record_Date_Time, Flourescent_Current_LUX, Flourescent_SET_LUX, Flourescent_Total_LUX , Flourescent_remaining_Time FROM  photostability_details  Where chamber_seq = '".$lsChamber."' And record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' And lux_uv_type = 'A' order by cast(record_date_time as DateTime)";
	 		$query =$this->db->query($select);
			// echo $this->db->last_query();exit;
			
 		} elseif($lsluxuv == '0' && $lsluxuvb == 'B'  && $lszone == "0")
 		{
 			$select="SELECT DATE_FORMAT( Record_Date_Time , '%d-%m-%Y %H:%i:%s')  Record_Date_Time, Flourescent_Current_LUX, Flourescent_SET_LUX, Flourescent_Total_LUX , Flourescent_remaining_Time FROM  photostability_details  Where chamber_seq = '".$lsChamber."' And record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' And lux_uv_type = 'B' order by cast(record_date_time as DateTime)";
	 		$query =$this->db->query($select);
			
 		} elseif($lszone == "A" || $lszone == "B")
 		{
 			$select="SELECT DATE_FORMAT( Record_Date_Time , '%d-%m-%Y %H:%i:%s')  Record_Date_Time, Flourescent_Current_LUX, Flourescent_SET_LUX, Flourescent_Total_LUX , Flourescent_remaining_Time FROM  photostability_details  Where chamber_seq = '".$lsChamber."' And record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' And lux_uv_type = '".$lszone."' order by cast(record_date_time as DateTime)";
	 		$query =$this->db->query($select);
			
 		} 
 		else {
 			$select="SELECT DATE_FORMAT( Record_Date_Time , '%d-%m-%Y %H:%i:%s')  Record_Date_Time, Flourescent_Current_LUX, Flourescent_SET_LUX, Flourescent_Total_LUX , Flourescent_remaining_Time FROM  photostability_details  Where chamber_seq = '".$lsChamber."' And record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' order by cast(record_date_time as DateTime)";
	 		$query =$this->db->query($select);
			
 		}
		return $query->result_array();

	}
	public function get_uv($lsChamber,$lsFromDate,$lsToDate,$lszone,$lsluxuv,$lsluxuvb)
	{
	

		if($lsluxuv == 'A' && $lsluxuvb == '0' && $lszone == "0")
		{
		$select="SELECT DATE_FORMAT( Record_Date_Time , '%d-%m-%Y %H:%i:%s') Record_Date_Time, UV_Current_LUX, UV_SET_LUX, UV_Total_LUX, UV_remaining_Time FROM  photostability_details  Where chamber_seq = '".$lsChamber."'
                And record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' And lux_uv_type = 'A'
                order by cast(record_date_time as DateTime)";
 		$query =$this->db->query($select);
 	}elseif($lsluxuv == '0' && $lsluxuvb == 'B' && $lszone == "0"){
 		$select="SELECT DATE_FORMAT( Record_Date_Time , '%d-%m-%Y %H:%i:%s') Record_Date_Time, UV_Current_LUX, UV_SET_LUX, UV_Total_LUX, UV_remaining_Time FROM  photostability_details  Where chamber_seq = '".$lsChamber."'
                And record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' And lux_uv_type = 'B'
                order by cast(record_date_time as DateTime)";
 		$query =$this->db->query($select);
 	}elseif($lszone == "A" || $lszone == 'B')
 		{
 			$select="SELECT DATE_FORMAT( Record_Date_Time , '%d-%m-%Y %H:%i:%s') Record_Date_Time, UV_Current_LUX, UV_SET_LUX, UV_Total_LUX, UV_remaining_Time FROM  photostability_details  Where chamber_seq = '".$lsChamber."'
                And record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' And lux_uv_type = '".$lszone."'
                order by cast(record_date_time as DateTime)";
	 		$query =$this->db->query($select);
 		} 
 	else
 	{
 		$select="SELECT DATE_FORMAT( Record_Date_Time , '%d-%m-%Y %H:%i:%s') Record_Date_Time, UV_Current_LUX, UV_SET_LUX, UV_Total_LUX, UV_remaining_Time FROM  photostability_details  Where chamber_seq = '".$lsChamber."'
                And record_date_time >='".$lsFromDate."' AND record_date_time <= '".$lsToDate."' order by cast(record_date_time as DateTime)";
 		$query =$this->db->query($select);
 	}
		return $query->result_array();
 	}

	
	public function mktgraphicalweeklydates($form_date,$to_date)
	{
		do
		{
			$sql="INSERT INTO mktgraphicalweeklydates (WeekStart, WeekEnd) 
					VALUES 
					  (
					    '".$form_date."', 
					    AddDate(AddDate('".$form_date."', Interval 1 Week),interval -1 Day)
					  )";
					  $this->db->query($sql);
			$form_date=date('Y-m-d H:i:s',strtotime($form_date .' +1 week'));
		}while ($form_date <= $to_date);
	}
	public function mktgraphicalMonthlydates($form_date,$to_date)
	{
		do
		{
			$sql="INSERT INTO mktgraphicalweeklydates (WeekStart, WeekEnd) 
					VALUES 
					  (
					    '".$form_date."', 
					    AddDate('".$form_date."', Interval 1 month)
					  )";
					  $this->db->query($sql);
					//  $time = strtotime($to_date .' -1 day');
			//$to_date = date("Y-m-01 H:i:s", strtotime("+1 month", $time));
			$form_date=date('Y-m-d H:i:s',strtotime($form_date .' +1 month'));
		}while ($form_date <= $to_date);
	}
	public function temp($lsChamber,$lsFromDate,$lsToDate,$Rtype)
	{

		if($Rtype=="D")
		{

		  $select="SELECT  min(temperature_value) as minTemp,max(temperature_value) as maxTemp,( (min(temperature_value) + max(temperature_value) )/2) 
		  as meantemp, DATE_FORMAT(record_date_time,'%Y-%m-%d 00:00:00') as startDate,DATE_FORMAT(record_date_time,'%Y-%m-%d 23:59:59') as EndDate ,
		  (SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 
		  MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND 
		  date('".$lsToDate."')) as MKt_value From controller_details WHERE chamber_seq = '".$lsChamber."' AND 
		  record_date_time >= '".date('Y-m-d',strtotime($lsFromDate))." 00:00:00' AND record_date_time <= '".date('Y-m-d',strtotime($lsToDate))." 23:59:59' 
		  GROUP BY DATE(record_date_time) ORDER BY startDate ASC";
	    }
	    if($Rtype=="W")
		{
		 $sql="truncate Table mktgraphicalweeklydates";	
		 $this->db->query($sql);	
		 $this->mktgraphicalweeklydates($lsFromDate,$lsToDate);
		 
		  $select="SELECT  Date(mt.WeekStart) TempDate,Date(mt.WeekStart) startDate,Date(mt.WeekEnd) EndDate,min(ifnull(temperature_value, 0)) minTemp,max(ifnull(temperature_value, 0)) maxTemp,((min(ifnull(temperature_value, 0)) + max(ifnull(temperature_value, 0))) / 2) meantemp,(SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."')) as MKt_value FROM  mktgraphicalweeklydates mt LEFT JOIN controller_details cd ON Date(cd.record_Date_Time) between Date(mt.WeekStart) 
  and Date(mt.WeekEnd) and chamber_seq = '".$lsChamber."' AND temperature_value !=''  AND (record_date_time) BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."') GROUP BY DATE(mt.WeekStart) ORDER BY DATE(mt.WeekStart)";
 
	    }
	    if($Rtype=="M")
		{

		 $sql="truncate Table mktgraphicalweeklydates";	
		 $this->db->query($sql);	
		 $this->mktgraphicalMonthlydates($lsFromDate,$lsToDate);
		 $select="SELECT  Date(mt.WeekStart) TempDate,Date(mt.WeekStart) startDate,Date(mt.WeekEnd) EndDate,min(ifnull(temperature_value, 0)) minTemp,max(ifnull(temperature_value, 0)) maxTemp,((min(ifnull(temperature_value, 0)) + max(ifnull(temperature_value, 0))) / 2) meantemp,(SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."')) as MKt_value FROM  mktgraphicalweeklydates mt LEFT JOIN controller_details cd ON Date(cd.record_Date_Time) between Date(mt.WeekStart) 
  and Date(mt.WeekEnd) and chamber_seq = '".$lsChamber."' AND temperature_value !='' AND (record_date_time) BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."') GROUP BY DATE(mt.WeekStart) ORDER BY DATE(mt.WeekStart)";
	    }
	    $query =$this->db->query($select);
	    // echo $this->db->last_query();exit;
		return $query->result_array();				
	}
	public function temprh($lsChamber,$lsFromDate,$lsToDate,$Rtype)
	{

		if($Rtype=="D")
		{
			$select="SELECT  min(temperature_value) as minTemp,max(temperature_value) as maxTemp,( (min(temperature_value) + max(temperature_value) )/2) as meantemp,min(Humidity_Value) as minRH,max(Humidity_Value) as maxRH,( (min(Humidity_Value) + max(Humidity_Value) )/2) as meanRH, DATE_FORMAT(record_date_time,'%Y-%m-%d 00:00:00') as startDate,DATE_FORMAT(record_date_time,'%Y-%m-%d 23:59:59') as EndDate ,(SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."')) as MKt_value From controller_details WHERE chamber_seq = '".$lsChamber."' AND record_date_time >= '".date('Y-m-d',strtotime($lsFromDate))." 00:00:00' AND record_date_time <= '".date('Y-m-d',strtotime($lsToDate))." 23:59:59' GROUP BY DATE(record_date_time) ORDER BY startDate ASC";
	    }
	    if($Rtype=="W")
		{
		 $sql="truncate Table mktgraphicalweeklydates";	
		 $this->db->query($sql);	
		 $this->mktgraphicalweeklydates($lsFromDate,$lsToDate);
		 
		  $select="SELECT  Date(mt.WeekStart) TempDate,Date(mt.WeekStart) startDate,Date(mt.WeekEnd) EndDate,min(ifnull(temperature_value, 0)) minTemp,max(ifnull(temperature_value, 0)) maxTemp,((min(ifnull(temperature_value, 0)) + max(ifnull(temperature_value, 0))) / 2) meantemp,min(ifnull(Humidity_Value,0)) as minRH,max(ifnull(Humidity_Value,0)) as maxRH,( (min(ifnull(Humidity_Value,0)) + max(ifnull(Humidity_Value,0)) )/2) as meanRH,(SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."')) as MKt_value FROM  mktgraphicalweeklydates mt LEFT JOIN controller_details cd ON Date(cd.record_Date_Time) between Date(mt.WeekStart) 
  and Date(mt.WeekEnd) and chamber_seq = '".$lsChamber."' AND temperature_value !=''  AND (record_date_time) BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."') GROUP BY DATE(mt.WeekStart) ORDER BY DATE(mt.WeekStart)";
 
	    }
	    if($Rtype=="M")
		{

		 $sql="truncate Table mktgraphicalweeklydates";	
		 $this->db->query($sql);	
		 $this->mktgraphicalMonthlydates($lsFromDate,$lsToDate);
		 $select="SELECT  Date(mt.WeekStart) TempDate,Date(mt.WeekStart) startDate,Date(mt.WeekEnd) EndDate,min(ifnull(temperature_value, 0)) minTemp,max(ifnull(temperature_value, 0)) maxTemp,((min(ifnull(temperature_value, 0)) + max(ifnull(temperature_value, 0))) / 2) meantemp,min(ifnull(Humidity_Value,0)) as minRH,max(ifnull(Humidity_Value,0)) as maxRH,( (min(ifnull(Humidity_Value,0)) + max(ifnull(Humidity_Value,0)) )/2) as meanRH,(SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."')) as MKt_value FROM  mktgraphicalweeklydates mt LEFT JOIN controller_details cd ON Date(cd.record_Date_Time) between Date(mt.WeekStart) 
  and Date(mt.WeekEnd) and chamber_seq = '".$lsChamber."' AND temperature_value !='' AND (record_date_time) BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."') GROUP BY DATE(mt.WeekStart) ORDER BY DATE(mt.WeekStart)";
	    }
	    $query =$this->db->query($select);
	    // echo $this->db->last_query();exit;
		return $query->result_array();				
	}
	public function mktgraphic($lsChamber,$lsFromDate,$lsToDate,$rtype)
	{
		
		if($rtype=="D")
		{
		   $select="SELECT record_date_time as TempDate, min( ifnull(temperature_value, 0) ) MIn_Value, max( ifnull(temperature_value, 0) ) Max_Value, ( ( min( ifnull(temperature_value, 0) ) + max( ifnull(temperature_value, 0) ) ) / 2 ) AvgTemp ,(SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."')) as MKt_value FROM controller_details WHERE chamber_seq = '".$lsChamber."' AND temperature_value !=''  AND date(record_date_time) BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."') GROUP BY DATE(record_date_time) ";
	    }

		if($rtype=="W")
		{
		 $sql="truncate Table mktgraphicalweeklydates";	
		 $this->db->query($sql);	
		 $this->mktgraphicalweeklydates($lsFromDate,$lsToDate);
		 $select="SELECT  Date(mt.WeekStart) TempDate,min(ifnull(temperature_value, 0)) MIn_Value,max(ifnull(temperature_value, 0)) Max_Value,((min(ifnull(temperature_value, 0)) + max(ifnull(temperature_value, 0))) / 2) AvgTemp,(SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."')) as MKt_value FROM  mktgraphicalweeklydates mt LEFT JOIN controller_details cd ON Date(cd.record_Date_Time) between Date(mt.WeekStart) 
  and Date(mt.WeekEnd) and chamber_seq = '".$lsChamber."' AND temperature_value !=''  AND (record_date_time) BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."') GROUP BY DATE(mt.WeekStart) ORDER BY DATE(mt.WeekStart)";
		}
		if($rtype=="M")
		{
		 $sql="truncate Table mktgraphicalweeklydates";	
		 $this->db->query($sql);	
		 $this->mktgraphicalMonthlydates($lsFromDate,$lsToDate);
		 $select="SELECT  Date(mt.WeekStart) TempDate,min(ifnull(temperature_value, 0)) MIn_Value,max(ifnull(temperature_value, 0)) Max_Value,((min(ifnull(temperature_value, 0)) + max(ifnull(temperature_value, 0))) / 2) AvgTemp,(SELECT ( (83.144 / 8.314472) / ( - log( Sum( exp( -83.144 / ( 8.31 * (cd.Temperature_Value + 273.15) ) ) ) / COUNT(cd.Temperature_Value) ) ) ) -273.15 MktValue FROM controller_details cd WHERE chamber_seq = '".$lsChamber."' AND date(record_date_time)  BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."')) as MKt_value FROM  mktgraphicalweeklydates mt LEFT JOIN controller_details cd ON Date(cd.record_Date_Time) between Date(mt.WeekStart) 
  and Date(mt.WeekEnd) and chamber_seq = '".$lsChamber."' AND temperature_value !='' AND (record_date_time) BETWEEN date('".$lsFromDate."') AND date('".$lsToDate."') GROUP BY DATE(mt.WeekStart) ORDER BY DATE(mt.WeekStart)";
		}
	    $query =$this->db->query($select);
		return $query->result_array();	
	}

}
