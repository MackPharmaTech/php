		<!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title"><?php echo $this->lang->line('event_analysis');?></div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('welcome');?>"><?php echo $this->lang->line('HOME');?></a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                               
                                <li class="active"><?php echo $this->lang->line('event_analysis');?></li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header><?php echo $this->lang->line('event_analysis');?></header>
                                </div>
                                <?php if($this->session->flashdata('error')){ ?>
                         <div class="alert alert-danger " role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('error'); ?>
                          </div>
                          <?php } ?>
                                <div class="card-body " id="bar-parent2">
                                    <?php if($url!="") { ?>
                                   <iframe src="<?php echo $url; ?>" width="100%" height="900px" ></iframe>
                                    <!--<a href="<?php //echo $url; ?>" target="_blank">Download PDF</a>-->
                                            <?php }else{ ?>
                                <form method="post" id="addch" name="addch" action="" enctype="multipart/form-data" >
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
	                                        <div class="form-group">
	                                            <label><?php echo $this->lang->line('CHEMBER_ID');?> <span class="mark">*</span></label>
	                                            <select name="chamber_id" id="chamber_id" required="required" class="form-control">
                                                <option value=""><?php echo $this->lang->line('Select_Chamber_ID');?></option>
                                                <?php foreach ($chamber_details as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['chamber_seq'] ?>"><?php echo $value['Chamber_cd'];?>-<?php echo $value['Chamber_Name']; ?></option>
                                                    <?php 
                                                } ?>
                                                </select>
                                                <div class="red">
                                                   <?php if(form_error('chamber_id')){ echo form_error('chamber_id'); } ?>
                                                </div>
	                                        </div>
	                                    </div>
                                          <div class="col-md-6 col-sm-6">
                                             <div class="form-group">
                                            <label><?php echo $this->lang->line('From_Date');?><span class="mark">*</span></label>
                                            <label id="from_date-error" class="error" for="from_date"></label>
                                            <div class="input-group date form_datetime"  data-date-format="dd-mm-yyyy HH:ii:ss" data-link-field="dtp_input1">
                                                <input class="form-control" name="from_date" id="from_date" required="required" size="16" type="text" value="" autocomplete="off">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                            </div>
                                            <input type="hidden" id="dtp_input1" required="required" value="" />
                                            <br/>
                                            </div>
                                        </div>
                                         <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('To_Date');?><span class="mark">*</span></label>
                                                    <label id="from_date-error" class="error" for="to_date"></label>
                                                    <div class="input-group date form_datetime " data-date="" data-date-format="dd-mm-yyyy HH:ii:ss" data-link-field="dtp_input1">
                                                        <input class="form-control" name="to_date" id="to_date" required="required" size="16" type="text" value="" autocomplete="off">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    </div>
                                                    <input type="hidden" id="dtp_input1"  value="" />
                                                    <br/>
                                               </div>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12">
	                                        <div class="form-group">
	                                            <label><?php echo $this->lang->line('event');?>  </label>
	                                            <select name="event_id" id="user_id" class="form-control">
                                                <option value=""><?php echo $this->lang->line('select_events');?></option>
                                                <?php foreach ($event_details as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['event_cd'] ?>"><?php echo $value['event_description']; ?></option>
                                                    <?php 
                                                } ?>
                                                </select>
                                                <div class="red">
                                                   <?php if(form_error('event_id')){ echo form_error('event_id'); } ?>
                                                </div>
	                                        </div>
	                                    </div>
	                                    <div class="col-md-12 col-sm-12">
	                                        <div class="form-group">
	                                            <label><?php echo $this->lang->line('user');?> </label>
	                                            <select name="user_id_test" id="user_id_test"  class="form-control">
                                                <option value=""><?php echo $this->lang->line('select_users');?></option>
                                                <?php foreach ($user_details as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['user_id'] ?>"><?php echo $value['first_name']; ?></option>
                                                    <?php 
                                                } ?>
                                                </select>
                                                <div class="red">
                                                   <?php if(form_error('user_id')){ echo form_error('user_id'); } ?>
                                                </div>
	                                        </div>
	                                    </div>
                                        <div class="col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-round btn-info" name="btn_submit"><?php echo $this->lang->line('GEN_REP');?></button>
                                        </div>
                            </div>
                                    </form>
                                <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
              
                </div>
            </div>
            <!-- end page content -->
    