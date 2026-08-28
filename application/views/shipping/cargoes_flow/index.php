<style>

	/* ini untuk css mapping (tracking) */
	.rows {
		background-color: #5E87B0;
	}

	.timeline {
        position: relative;
        margin: 50px auto;
        /* padding: 40px 0; */
        /* width: 1000px; */
        box-sizing: border-box;
    }

    .timeline:before {
        content: '';
        position: absolute;
        left: 50%;
        width: 2px;
        height: 100%;
        background: #5E87B0;
    }

    .timeline ul {
        padding: 0;
        margin: 0;
    }

    .timeline ul li {
        list-style: none;
        position: relative;
        width: 50%;
        padding: 0px 40px;
        box-sizing: border-box;
    }

	/* ini untuk tampilan ganjil genap */
    /* .timeline ul li:nth-child(odd) {
        float: left;
        text-align: right;
        clear: both;
    }

    .timeline ul li:nth-child(even) {
        float: right;
        text-align: left;
        clear: both;
    } */

	.timeline ul li.destination {
		float: left;
		text-align: right;
		clear: both;
	}

	.timeline ul li.origin {
		float: right;
		text-align: left;
		clear: both;
	}

    .content {
        padding-bottom: 20px;
    }

    .timeline ul li.destination:before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        top: 24px;
        right: -6px;
        background: rgba(233, 33, 99, 1);
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(233, 33, 99, 0.2);
    }

    .timeline ul li.origin:before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        top: 24px;
        left: -4px;
        background: rgba(233, 33, 99, 1);
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(233, 33, 99, 0.2);
    }

    .timeline ul li h3 {
        padding: 0;
        margin: 0;
        color: rgba(94, 135, 176, 1);
        font-weight: 600;
    }

    .timeline ul li p {
        margin: 3px 0 0;
        padding: 0;
    }

	.timeline hr{
		margin: 10px 0;
		border: 0;
		border-top: 1px solid #eee;
		border-bottom: 0;
	}

    .timeline ul li .time h4 {
        margin: 0;
        padding: 0;
        font-size: 14px;
    }

    .timeline ul li.destination .time {
        position: absolute;
        top: 12px;
        right: -165px;
        margin: 0;
        padding: 8px 16px;
        background: rgba(94, 135, 176, 1);
        color: #fff;
        border-radius: 18px;
        box-shadow: 0 0 0 3px rgba(94, 100, 190, 1);
    }

    .timeline ul li.origin .time {
        position: absolute;
        top: 12px;
        left: -123px;
        margin: 0;
        padding: 8px 16px;
        background: rgba(94, 135, 176, 1);
        color: #fff;
        border-radius: 18px;
        box-shadow: 0 0 0 3px rgba(94, 100, 190, 1);
    }

    @media(max-width:1000px) {
        .timeline {
            width: 100%;
        }
    }

    @media(max-width:767px) {
        .timeline {
            width: 100%;
            padding-bottom: 0;
        }

        h1 {
            font-size: 40px;
            text-align: center;
        }

        .timeline:before {
            left: 20px;
            height: 100%;
        }

        .timeline ul li.destination,
        .timeline ul li.origin {
            width: 100%;
            text-align: left;
            padding-left: 50px;
            padding-bottom: 50px;
        }

        .timeline ul li.destination:before,
        .timeline ul li.origin:before {
            top: -18px;
            left: 16px;
        }

        .timeline ul li.destination .time,
        .timeline ul li.origin .time {
            top: -30px;
            left: 50px;
            right: inherit;
        }
    }

	/* .flow-predicts {
    	font-weight: bold; 
		color: #007ba8!important;
		font-style: italic;
		background: url('assets/global/img/cargoflow.svg') no-repeat center center;
    	background-size: cover;
	} */

	.flow-predicts {
		position: relative;
		font-weight: bold;
		color: #007ba8!important;
		font-style: italic;
	}

	.flow-predicts::before {
		content: '';
		display: inline-block;
		width: 10px;
		height: 10px;
		background: url('assets/global/img/cargoflow.svg') no-repeat center center;
		background-size: contain;
		margin-right: 5px;
	}


	/* ini untuk css showDetails */
	.details{
		font-family: Arial, Helvetica, sans-serif;
	}
	.details button{
		font-size: 12px;
		font-weight: 600;
   	}

	.details tr th{
		font-size: 12px;
		text-align: left;
		padding: 5px 0px 5px 20px;
		font-weight: bolder;
	}

	.details tr td{
		padding: 5px 0px 5px 20px;
		font-size: 12px;
		text-align: left;
        width: 200px;
		/* padding-left: 20px; */
	}

	.details .weight{
		font-size: 12px;
		font-weight: bolder;
	}

	.details .text-mute{
		font-size: 12px;
		color: #9e9e9e;
	}

	.details .accordion {
		background-color: #fff;
		color: #444;
		cursor: pointer;
		padding: 12px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 13px;
		transition: 0.4s;
		border-bottom: 1px solid #BEBEC1;
	}

	.details .active, .accordion:hover {
		background-color: #ebebeb;
	}

	.details .accordion:after {
		content: '\002B';
		/* color: #777; */
		font-weight: bolder;
		float: right;
		margin-left: 5px;
		max-height: 0px;
		color: #007ba8;
		font-size: 16px;
	}

	.details .active:after {
		content: "\2212";
		color: #007ba8;
	}

	.details .panel {
		/* padding: 0 18px; */
		margin-bottom: 0px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
	}

	.details table{
		margin-bottom: 20px;
	}

	/* .details .default-open {
		max-height: initial;
	}	 */

	/* ini untuk css inTransit */
	.intransit{
		font-family: Arial, Helvetica, sans-serif;
	}

	.intransit table{
		/* font-family: arial, sans-serif; */
		font-family: Montserrat, sans-serif;
		border-collapse: collapse;
		width: 100%;
		padding: 5px 20px 5px 20px;
		margin-bottom: 20px;
	}
	.intransit th {
		border-bottom: 1px solid #007ba8;
		text-align: left;
		font-weight: bolder;
		color: #007ba8;
		height: 45px;
	}

	.intransit td {
		text-align: left;
		padding: 8px;
		height: 45px;
		color: #000;
	}

	.intransit tr:nth-child(odd) {
	background-color: #F2F2F2;
	}

	.intransit .accordion {
		background-color: #fff; 
		color: #444;
		cursor: pointer;
		padding: 12px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 13px;
		transition: 0.4s;
		border-bottom: 1px solid #BEBEC1;
		font-weight: bold;
	}

	.intransit .active, .accordion:hover {
		background-color: #ebebeb;
	}

	.intransit .accordion:after {
		content: '\002B';
		/* color: #777; */
		font-weight: bolder;
		float: right;
		margin-left: 5px;
		max-height: 0px;
		color: #007ba8;
		font-size: 16px;
	}

	.intransit .active:after {
		content: "\2212";
		color: #007ba8;
	}

	.intransit .panel {
		/* padding: 0 18px; */
		margin-bottom: 0px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
	}

	.intransit .text-mute{
		font-size: 12px;
		color: #9e9e9e;
	}

	.intransit span{
		color:  #000;
	}

	/* .intransit .default-open {
		max-height: initial;
	}	 */

	/* ini untuk css portdestination */
	.portdestination{
		font-family: Arial, Helvetica, sans-serif;
		/* margin-bottom: 20px; */
	}
	.portdestination button{
		font-size: 12px;
		font-weight: 600;
   	}

	.portdestination tr th{
		font-size: 12px;
		text-align: left;
		padding-left: 20px;
		font-weight: bolder;
	}

	.portdestination tr td{
		padding: 5px 0px 5px 20px;
		font-size: 12px;
		text-align: left;
        width: 200px;
		/* padding-left: 20px; */
	}

	.portdestination .weight{
		font-size: 12px;
		font-weight: bolder;
	}

	.portdestination .text-mute{
		font-size: 12px;
		color: #9e9e9e;
	}

	.portdestination .accordion {
		background-color: #fff;
		color: #444;
		cursor: pointer;
		padding: 12px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 13px;
		transition: 0.4s;
		border-bottom: 1px solid #BEBEC1;
	}

	.portdestination .active, .accordion:hover {
		background-color: #ebebeb;
	}

	.portdestination .accordion:after {
		content: '\002B';
		/* color: #777; */
		font-weight: bolder;
		float: right;
		margin-left: 5px;
		max-height: 0px;
		color: #007ba8;
		font-size: 16px;
	}

	.portdestination .active:after {
		content: "\2212";
		color: #007ba8;
	}

	.portdestination .panel {
		/* padding: 0 18px; */
		margin-bottom: 0px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
	}

	.portdestination table{
		margin-bottom: 20px;
	}

	.portdestination .panel .default-open {
		max-height: initial;
	}

	/* ini untuk tracking */
	.tracking {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 5px;
      font-weight: bold;
	  margin: 7px 16px 10px 7px;
	}

    .location {
      padding: 0px 0px 0px 20px;
      text-align: left;
    }
    
    .date-time {
      padding: 0px 0px 0px 20px;
      text-align: center;
    }
    
    .duration {
      padding: 0px 0px 0px 20px;
      text-align: right;
    }

  	.info-update{
	  padding-left: 20px;
      font-size: 14px;
      color: #6A6A6D;
      margin-bottom: 20px;
	}

    .info-update span{
      font-size: 14px;
      color: #000;
      margin-bottom: 20px;
    }
    
    .tracking-info{
        border-left: 3px dashed #666;
        padding: 0px 0px 0px 20px;
		/* margin: 7px 7px 10px 7px; */
		margin: 15px 7px 15px 14px;
    }

	.tracking-info-intransit{
        border-left: 3px solid #666;
        padding: 0px 0px 20px 20px;
		/* margin: 7px 7px 10px 7px; */
		margin: 0px 7px 0px 7px;
    }

	.tracking-info-origin{
        /* border-left: 3px solid #666; */
        padding: 0px 0px 10px 20px;
		/* margin: 7px 7px 10px 7px; */
		margin: 0px 7px 0px 7px;
    }
    
    .content-activities {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 5px;
	}
    
    .location-activities {
      padding: 0px 0px 0px 0px;
      text-align: left;
	  align-self: center;
    }
    
    .date-activities {
      padding: 0px 0px 0px 0px;
      text-align: center;
    }
    
    .duration-activities {
       text-align: center;
       background-color: #ddd;
       padding: 3px 10px;
       border-radius: 3px;
       display: inline-block;
       width: 60%;
       justify-self: right;
    }

	.tracking-circle-destination{
       	content: '';
        position: relative;
        width: 10px;
        height: 10px;
        top: 0px;
        right: -3px;
        background: rgba(233, 33, 99, 1);
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(233, 33, 99, 0.2);
    }

	.tracking-circle-origin{
       	content: '';
        position: relative;
        width: 10px;
        height: 10px;
        /* top: 0px;
        right: -3px; */
		margin: 6px 15px 0px -26px;
        background: rgb(39 185 12);
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgb(39, 185, 12, 0.2)
    }

	.tracking-circle-portcall{
       	content: '';
        position: relative;
        width: 10px;
        height: 10px;
        top: 0px;
        right: -3px;
        background: rgb(0 174 193);
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgb(0, 176, 193, 0.2)
    }

	.port{
		padding: 4px 0px 4px 0px;
		margin-top: 0px;
		margin-bottom: -8px;
		font-weight: bold;
		font-size: 14px;
		color: #007ba8!important;
		font-family: helvetica;
		display: flex;
	}

	/* ini untuk modal update */
	.updateHeader{
		font-family: Arial, Helvetica, sans-serif;
	}

	.updateHeader .updateTittleHeader{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 14px;
		display: flex;
		justify-content: space-between;
		margin: 10px 165px 10px 165px;
	}

	.updateHeader .updateBodyHeader{
		font-family: Arial, Helvetica, sans-serif;
		/* display: grid; */
		/* grid-template-columns: repeat(3, 1fr); */
		/* gap: 5px; */
		/* margin: 7px 40px 10px 40px; */
		font-size: 14px;
		/* justify-items: center; */
		display: flex;
		justify-content: space-between;
		margin: 10px 165px 10px 165px;
	}

	.tittleHeader h2{
		font-size: 12px;
		font-weight: normal;
		font-family: Arial, Helvetica, sans-serif;
		color: #9e9e9e;
		width: 50%;
		margin-left: 18%;
	}

	/* ini untuk inputan update*/
	.wrapper {
		margin: 0px 20px 0px 20px;
		
	}

	.wrapper .side{
		font-family: sans-serif;
		display: flex;
		flex-wrap: wrap;
		background-color: transparent;
		color: #fff;
		padding: 20px;
		font-size: 14px;
		align-content: center;
		flex-direction: column;
		text-align: center;
		margin: 0px 0px 0px 0px;
		gap: 25px;
	}

	.wrapper .inputBox{
		position: relative;
		width: 70%;
	}

	.wrapper .note{
		margin-top: 12px;
		position: relative;
		color: #121212;
	}

	.wrapper .inputBoxRow{
		display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 5px;
	}

	.wrapper .inputBoxRow .inputBox{
		position: relative;
		width: 100%;
	}

	.wrapper .inputBox input{
		width: 100%;
		padding: 10px;
		border: 1px solid #9e9e9e;
		border-radius: 5px;
		outline: none;
		color: black;
		font-size: 1em;
		transition: 0.2s; 
	}

	.wrapper .inputBox span{
		position: absolute;
		left: 0;
		padding: 0px 10px 0px 10px;
		pointer-events: none;
		transform: translateX(5px) translateY(12px);
		font-size: 1em;
		color: #9e9e9e;
		text-transform: uppercase;
		transition: 0.2s; 
	}

	.wrapper .inputBox .spanDate{
		position: absolute;
		left: 0;
		padding: 0px 10px 10px 10px;
		pointer-events: none;
		/* transform: translateX(10px) translateY(-6px); */
		font-size: 0em;
		color: #9e9e9e;
		text-transform: uppercase;
		transition: 0.2s; 
	}

	.wrapper .inputBox input:focus ~ .spanDate {
		color: #9e9e9e;
		transform: translateX(10px) translateY(-5px);
		font-size: 0.65em;
		padding: 0 10px;
		background: #FFF;
		border-left: 1px solid #9e9e9e;
		border-right: 1px solid #9e9e9e;
		letter-spacing: 0.2em;
	}

	.wrapper .inputBox input:valid ~ span,
	.wrapper .inputBox input:focus ~ span {
		color: #9e9e9e;
		transform: translateX(10px) translateY(-5px);
		font-size: 0.65em;
		padding: 0 10px;
		background: #FFF;
		border-left: 1px solid #9e9e9e;
		border-right: 1px solid #9e9e9e;
		letter-spacing: 0.2em;
	}

	.wrapper .inputBox input:valid,
	.wrapper .inputBox input:focus{
		border: 1px solid #9e9e9e;
	}

	.wrapper .inputBox select{
		width: 100%;
		padding: 10px;
		border: 1px solid #9e9e9e;
		border-radius: 5px;
		outline: none;
		color: black;
		font-size: 1em;
		transition: 0.5s; 
	}


	/*ini untuk combobox*/ 
	.wrapper .inputBox .spanCombobox{
		position: absolute;
		left: 0;
		padding: 0px 10px 0px 10px;
		pointer-events: none;
		transform: translateX(10px) translateY(-6px);
		font-size: 0.65em;
		background: #FFF;
		border-left: 1px solid #9e9e9e;
		border-right: 1px solid #9e9e9e;
		color: #9e9e9e;
		text-transform: uppercase;
		transition: 0.2s; 
	}

	/* ini untuk document */
	.card{
		width: 100%;
		/* height: 260px; */
		background-color: #ffffff;
		/* padding: 10px 30px 40px; */
		padding: 20px 0px 0px;
	}

	.card h3 {
		font-size: 22px;
		font-weight: 600;
	}

	.drop_box {
		margin: 20px 0;
		padding: 30px;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: row;
		border: 3px dotted #007ba8!important;
		border-radius: 5px;
		width: 100%;
		align-items: center;
	}
	.drop_box .textUploadFiles{
		display: flex;
		flex-direction: column;
		width: 70%;
	}

	.drop_box .textUploadFiles h4 {
		font-size: 16px;
		font-weight: bold;
		color: #007ba8!important;
		font-family: helvetica;
	}

	.drop_box .textUploadFiles p {
		margin-bottom: 20px;
		text-align: left;
		font-size: 12px;
		color: #a3a3a3;
		width: 100%;
		padding: 0px 1px 0px 1px;
	}

	.btn-uploads {
		text-decoration: none;
		background-color: #005af0;
		color: #ffffff;
		padding: 10px 20px;
		border: none;
		outline: none;
		transition: 0.3s;
	}

	.btn-uploads:hover{
		text-decoration: none;
		background-color: #ffffff;
		color: #005af0;
		padding: 10px 20px;
		border: none;
		outline: 1px solid #010101;
	}
	.drop_box input {
		margin: 10px 0;
		width: 100%;
		background-color: #e2e2e2;
		border: none;
		outline: none;
		padding: 12px 20px;
		border-radius: 4px;
	}

	/* list document yang diupload */
	.file-list {
		margin-top: 20px;
	}

	.selected-items {
		color: #007ba8!important;
		font-size: 16px;
		font-weight: bold;
	}

	.file-list-item {
		display: flex;
		align-items: center;
		justify-content: space-between;
		border: 1px solid #a3a3a3;
		border-radius: 5px;
		padding: 10px;
		margin-bottom: 10px;
	}

	.file-list-item button {
		background-color: #ff5252;
		color: #ffffff;
		padding: 5px 10px;
		border: none;
		outline: none;
		cursor: pointer;
		margin-left: 10px;
	}
	@media (min-width: 768px){
		.container{
			width: 100%;
		}
	}
	/*ini tutup untuk document  */

</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYdGw9exOCnJo2HnCoj1cymm3kHO9WnqU&callback=initMap" async defer></script>
<!-- //set coordinat -->
<?php
$locations = [
	['lat' => 1.24753630161285, 'lng' => 103.7164306640625],
	['lat' => -34.398, 'lng' => 150.645],
	['lat' => -34.399, 'lng' => 150.646],
	['lat' => -34.400, 'lng' => 150.647],
	['lat' => -34.401, 'lng' => 150.648],
	['lat' => -34.402, 'lng' => 150.649],
	['lat' => -34.403, 'lng' => 150.650],
	['lat' => -34.404, 'lng' => 150.651],
	['lat' => -34.405, 'lng' => 150.652],
	['lat' => 21.461389541625977, 'lng' => 39.11595916748047],
	// Tambahkan lebih banyak lokasi sesuai kebutuhan
];
?>
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h5 style="font-weight: Bold; font-size: 20px;"><?= $title ?></h5>

				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Shipping / </a></li>
						<li class="breadcrumb-item"><a href="#">Monitoring / </a></li>
						<li class="breadcrumb-item active" aria-current="page">Track Container</li>
					</ol>
				</nav>

				<div class="portlet light">

					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Filter <?= $title ?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="javascript:;" class="reload">
							</a>
							<a href="javascript:;" class="fullscreen"></a>
						</div>
					</div>
					<form class="filter-shipment">
						<div class="portlet-body form">
							<div class="form-body row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="panel-title"><i class='fa fa-filter'></i> Filter Data</h5>
										</div>
										<div class="panel-body">
											<div class="col-md-12 row">
												<div class="form-group">
													<label class="col-md-2 control-label" for="varchar">Shipment Type</label>
													<div class="col-md-4 col-lg-3">
														<select class="form-control select2me" name="shipmentType" data-placeholder="Please select" required>
															<option value=""></option>
															<option value="INTERMODAL_SHIPMENT">Ocean Shipment</option>
															<option value="TRUCK_SHIPMENT">Road Shipment</option>
															<option value="AIR_SHIPMENT">Air Shipment</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-12 row">
												<div class="form-group">
													<label class="col-md-2 control-label" for="varchar">Shipment Status</label>
													<div class="col-md-4 col-lg-3">
														<select class="form-control select2me" name="shipmentStatus" data-placeholder="Please Select">
															<option value=""></option>
															<option value="NEW">New</option>
															<option value="PENDING">Pending</option>
															<option value="ACTIVE">Active</option>
															<option value="DELIVERED">Delivered</option>
															<option value="COMPLETED">Completed</option>
															<option value="UNTRACKABLE">Untrackable</option>
														</select>
													</div>
												</div>
											</div>

											<div class="col-md-12 row">
                                                <div class="form-group">
													<label class="col-md-2 control-label" for="varchar">Search</label>
                                                    <div class="col-md-4 col-lg-3">
                                                        <input class="form-control input-sm" type="text" value="" id="containerNumber" name="containerNumber" placeholder="Container Number">
                                                    </div>
                                                </div>
                                            </div>

											<div class="col-md-12 row">
												<div class="form-group">
													<div class="col-md-4 col-md-offset-2">
														<button type="submit" class="btn blue fontawesome-font btn-refresh"><span class="fa fa-refresh"></span> Refresh</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="">
										<div class="doc-scroll" style="height: 360px;">
											<table class="table table-bordered table-data" id="">
												<thead>
													<tr style=" position: sticky; top: -6; background-color: blue !important; z-index: 1;">
														<th class="rows">#</th>
														<th class="rows">Tracking No</th>
														<th class="rows">Container Number</th>
														<th class="rows">Container Size</th>
														<th class="rows">Booking Ref</th>
														<th class="rows">Mbl No</th>
														<th class="rows">Carrier</th>
														<th class="rows">Current Location</th>
														<th class="rows">Last Status</th>
														<th class="rows">Orgin Port</th>
														<th class="rows">Destination Port</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
										<div class="row">
											<div class="col-md-2">
												<form id="rowSelectorForm">
													<!-- <select id="rowSelector" onchange="changeLimit()" class="form-control col-md-2" style="width: 100px; margin-top: 10px;"> -->
													<div class="pagination" style="display: flex;align-items: center;">
														<select id="rowSelector" onchange="changeLimit()" class="form-control col-md-2" style="width: 100px; margin-top: 10px;">
															<option value="10">10</option>
															<option value="50">50</option>
															<option value="100">100</option>
															<option value="1000">1000</option>
														</select>
														
														<!-- <i class="fa fa-info-circle" title="Please refresh back when changed the limit" style="padding-left: 10px;"></i> -->
													</div>
												</form>
											</div>
											<!-- <div class="col-md-10 text-right" id="pagination-container"> -->

										</div>
									</div>

								</div>
							</div>
						</div>
				</div>
			</div>
			</form>

		</div>

		<?php echo form_close() ?>
	</div>
</div>
</div>
</div>


<div class="modal fade" id="detailShipment" tabindex="-1" aria-labelledby="detailShipmentLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width: 75%; padding-bottom: 100px;" >
		<div class="modal-content">
			<div class="modal-header">
				<div style="display: flex;">
					<h2 class="modal-title" id="detailShipmentLabelText" style="font-weight: bold;"></h2>
					<img src="assets/global/img/co2.svg" style="width: 3%; padding: 5px;">
					<div style="align-self: center; font-family: montserrat; color: #7c7c7c;" id="detailEmisionText"></div>
				</div>
				<!-- <table>
					<tr>
						<th style="font-weight: bold; color: #007ba8!important;">Container Number</th>
						<th style="font-weight: bold;">MBL Number</th>
						<th style="font-weight: bold;">Booking No.</th>
					</tr>
					<tr>
						<td class="modal-title" id="detailContainerNumberLabelText" style="font-weight: bold;"></td>
						<td class="modal-title" id="detailMblNumberLabelText" style="font-weight: bold;"></td>
						<td class="modal-title" id="detailBookingNoLabelText" style="font-weight: bold;"></td>
					</tr>
				</table>		 -->
				<div fxlayout="row" fxlayoutgap="16px" class="hScrollable ng-star-inserted" style="flex-direction: row; box-sizing: border-box; display: flex;">

					<div fxflex="1 1 auto" style="margin-right: 16px; flex: 1 1 auto; box-sizing: border-box;">
					<label class="text-primary-ocean" style="font-weight: bold; color: #007ba8!important;">Container No.</label>
					<div class="mt-4" id="detailContainerNumberLabelText"></div></div>
					
					<div fxflex="1 1 auto" style="margin-right: 16px; flex: 1 1 auto; box-sizing: border-box;">
					<label class="text-primary-ocean" style="font-weight: bold; color: #007ba8!important;">MBL Number</label>
					<div class="mt-4" id="detailMblNumberLabelText"></div></div>

					<div fxflex="1 1 auto" style="margin-right: 16px; flex: 1 1 auto; box-sizing: border-box;">
					<label class="text-primary-ocean" style="font-weight: bold; color: #007ba8!important;">Booking No.</label>
					<div class="mt-4" id="detailBookingNoLabelText"></div></div>

					<div fxflex="1 1 auto" style="margin-right: 16px; flex: 1 1 auto; box-sizing: border-box;">
					<label class="text-primary-ocean" style="font-weight: bold; color: #007ba8!important;">Carrier</label>
					<div class="mt-4" id="detailCarrierLabelText"></div></div>

					<div fxflex="1 1 auto" style="margin-right: 16px; flex: 1 1 auto; box-sizing: border-box;">
					<label class="text-primary-ocean" style="font-weight: bold; color: #007ba8!important;">Last Update</label>
					<div class="mt-4" id="detailLastUpdateLabelText"></div></div>
				</div>		
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-5">
						<span class="map-detail"></span>
					</div>
					<div class="col-md-7">
						<span class="tab-list"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- ini untuk modal Update Shimpent -->
<div class="modal fade" id="updateShipment" tabindex="-1" aria-labelledby="updateShipmentLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width: 50%; padding-bottom: 100px;" >
		<div class="modal-content">
			<div class="modal-header">
				<div style="display: flex;">
					<h2 class="modal-title" style="font-weight: bold; font-size: 16px;">Update Shipment</h2>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12" style="position: center;">
						<span class="update-cargoes"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-saveChanges" onclick="saveChanges()">Save changes</button>
			</div>
		</div>
	</div>
</div>
<!-- Paginasi akan ditampilkan di sini -->
</div>
<script>
	function initMap(loadLat, loadLng, dischargeLat, dischargeLng) {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: {
            lat: (loadLat + dischargeLat) / 2,
            lng: (loadLng + dischargeLng) / 2
        } // Center of the map
    });

    var flightPathCoordinates = [];

    // Add the loading point marker to the map
    var loadMarker = new google.maps.Marker({
        position: new google.maps.LatLng(loadLat, loadLng),
        map: map,
        label: 'L' // Text on the loading point
    });

	// Add the Latest point marker to the map
	// var latestMarker = new google.maps.Marker({
	// 	position: new google.maps.LatLng(latestLat, latestLng),
	// 	map: map,
	// 	label: 'C' // Text on the Latest point
	// });
	

    // Add the discharge point marker to the map
    var dischargeMarker = new google.maps.Marker({
        position: new google.maps.LatLng(dischargeLat, dischargeLng),
        map: map,
        label: 'D' // Text on the discharge point
    });

    // Add marker coordinates to flightPathCoordinates
    flightPathCoordinates.push(new google.maps.LatLng(loadLat, loadLng));
    // flightPathCoordinates.push(new google.maps.LatLng(latestLat, latestLng));
    flightPathCoordinates.push(new google.maps.LatLng(dischargeLat, dischargeLng));

    var flightPath = new google.maps.Polyline({
        path: flightPathCoordinates,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
    });

    flightPath.setMap(map);

    // Center the map on the midpoint of the line
    var bounds = new google.maps.LatLngBounds();
    bounds.extend(loadMarker.getPosition());
    // bounds.extend(latestMarker.getPosition());
    bounds.extend(dischargeMarker.getPosition());
    map.fitBounds(bounds);
}

</script>
<script>
	function generatePagination(currentPage, totalPages) {
		var paginationContainer = $("#pagination-container");
		paginationContainer.empty();

		if (totalPages > 1) {
			paginationContainer.append('<ul class="pagination"></ul>');
			var paginationList = paginationContainer.find(".pagination");


			if (currentPage > 1) {
				paginationList.append('<li><a href="#" onclick="changePage(' + (currentPage - 1) + ')">Previous</a></li>');
			}


			paginationList.append('<li class="active"><span>' + currentPage + '</span></li>');


			if (currentPage < totalPages) {
				paginationList.append('<li><a href="#" onclick="changePage(' + (currentPage + 1) + ')">Next</a></li>');
			}
		}
	}

	function changePage(newPage) {

		console.log("Change to page: " + newPage);
	}

	var currentPage = 30;
	var totalPages = 30;
	generatePagination(currentPage, totalPages);
</script>


<script>
	$(".filter-shipment").submit(function(e) {

		e.preventDefault();

		var shipmentType = $("select[name='shipmentType']").val();
		var shipmentStatus = $("select[name='shipmentStatus']").val();
		var containerNumber = $("input[name='containerNumber']").val();
		var selectElement = $('#rowSelector');

		var limit = selectElement.val();


		loadData(shipmentType, shipmentStatus, containerNumber, limit);

	})

	function changeLimit() {
		var shipmentType = $("select[name='shipmentType']").val();
		var shipmentStatus = $("select[name='shipmentStatus']").val();
		var containerNumber = $("input[name='containerNumber']").val();
		var selectElement = $('#rowSelector');

		var limit = selectElement.val();


		loadData(shipmentType, shipmentStatus, containerNumber, limit);

	}

	function loadData(shipmentType, shipmentStatus, containerNumber, limit = 10, page = 1) {
		$.ajax({
			url: "<?php echo base_url('C_FlowCargoes/getDataByParamAjax'); ?>",
			type: "GET",
			data: {
				'shipmentType': shipmentType,
				'shipmentStatus': shipmentStatus,
				'containerNumber': containerNumber,
				'limit': limit,
				'page': page
			},
			dataType: "JSON",
			beforeSend: function() {
				$('.btn-refresh').html("Loading ...").prop("disabled", true)
				$(".table-data tbody").empty();

			},
			success: function(data) {

				console.log(data)


				if(data.code != 200){
					// swal(`Warning`, `${data.message}`, `error`);
					Swal.fire({
						title: 'Warning!',
						text: `${data.message}`,
						icon: 'error',
					});
					$('.btn-refresh').html('<i class="fa fa-refresh"></i> Refresh').prop('disabled', false);
				}


					var row = '';
					


					$.each(data.response, function(i, val) {
						row += `<tr>`
						row += `<td style="text-align: center">
							<div class="btn-group">
								<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
									<i class="">...</i>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a href="javascript:;" onclick="showDetails('${val.containerNumber}')"> View Details </a>
									</li>
									<li>
										<a href="javascript:;" onclick="sharedLink('${val.containerNumber}')"> Get Link to Share </a>
									</li>
									<li>
										<a href="javascript:;" onclick="updateDetails('${val.containerNumber}')"> Update Shipment </a>
									</li>
								</ul>
							</div></td>`
						row += `<td>${i + 1}. ${val.shipmentNumber}</td>`
						row += `<td>${val.containerNumber}</td>`
						row += `<td>${val.containerType} ${val.containerSize}</td>`
						row += `<td>${val.bookingNumber}</td>`
						row += `<td>${val.mblNumber ?? ""}</td>`
						row += `<td>${val.carrierScac}</td>`
						row += `<td>${val.subStatus2}</td>`
						row += `<td>${val.subStatus1}</td>`
						row += `<td>${val.shipmentLegs.portToPort.firstPort}</td>`
						row += `<td>${val.shipmentLegs.portToPort.dischargePort}</td>`
						row += `</tr>`
					});


					// Append the containerNumber to the element with class "list-container"
					$(".table-data tbody").append(row);

			},
			complete: function() {
				setTimeout(() => {

					$('.btn-refresh').html('<i class="fa fa-refresh"></i> Refresh').prop('disabled', false);
					$('.timeline-shipment .loading').html("");

				}, 1500);

			}
		});
	}

	function sharedLink(containerNumber) {
		
		$.ajax({
			url: "<?php echo base_url('C_FlowCargoes/getGenerateSharedUrl'); ?>",
			type: "POST",
			data: {
				'containerNumber': containerNumber
			},
			dataType: "JSON",
			beforeSend: function(response) {
				console.log(response);
			},
			success: function(response) {
				console.log(response);
				setTimeout(() => {
					// if (response && response.response && response.response.url) {
					// 	const clipboardText = "TRACKING_SHIPMENT link copied to clipboard:\n" + response.response.url;

					// 	// Menampilkan alert standar
					// 	alert(clipboardText);

					// 	// Menyalin teks ke clipboard
					// 	const tempInput = document.createElement('textarea');
					// 	tempInput.value = response.response.url;
					// 	document.body.appendChild(tempInput);
					// 	tempInput.select();
					// 	document.execCommand('copy');
					// 	document.body.removeChild(tempInput);
					// }
					if (response && response.response && response.response.url) {
						const clipboardText = "TRACKING_SHIPMENT link copied to clipboard: ";
						// hapus fire di swal untuk menggunakan alert normal
						swal.fire({
							title: 'Shared Link',
							text: clipboardText,
							input: 'text',
							inputValue: response.response.url,
							showCancelButton: true,
							confirmButtonText: 'Copy Link',
							cancelButtonText: 'Close',
						}).then((result) => {
							if (result.isConfirmed) {
								// Salin ke clipboard jika pengguna menekan "Copy Link"
								const textarea = document.createElement('textarea');
								textarea.value = response.response.url;
								document.body.appendChild(textarea);
								textarea.select();
								document.execCommand('copy');
								document.body.removeChild(textarea);

								swal.fire('Link Copied!', '', 'success');
							}
						});
					} 
					else{
						Swal.fire({
							title: 'Warning!',
							text: `${data.message}`,
							icon: 'error',
						});
					}
				}, 1500);
			}
		});
	}

	function showDetails(containerNumber) {
		$("#detailShipment").modal('show')
		var shipmentType = $("select[name='shipmentType']").val();
		var shipmentStatus = $("select[name='shipmentStatus']").val();
		$.ajax({
			url: "<?php echo base_url('C_FlowCargoes/getDataByShipId'); ?>",
			type: "GET",
			data: {
				'shipmentType': shipmentType,
				'shipmentStatus': shipmentStatus,
				'limit': 1,
				'id': containerNumber
			},
			dataType: "JSON",
			beforeSend: function() {
				$(".tab-list").empty()
				$(".map-detail").empty()
				$(".tab-list").html("<span>Loading ...</span>")
				$(".timeline-cargoes .load-timeline").empty();
				$(".details-cargoes .load-details").empty();
				// $(".testing-cargoes .load-testing").empty();
				$(".testing-document .load-document").empty();
			},
			success: function(response) {
				console.log(response)
				// Ini untuk map yang tracking left and right
				// setTimeout(() => {
                //     if (response) {
                //         var data = '<div class="timeline">'; // Initialize outside the loop
                //         data += `<ul>`
						
				// 		// mengambil data berdasarkan location yang sama dengan lastport
				// 		const lastPort = response.shipmentLegs.portToPort.lastPort;
				// 		const vesselArrivalIndex = response.shipmentEvents.findIndex(event => event.location.includes(lastPort));

				// 		if (vesselArrivalIndex !== -1) {
				// 			const numberOfEventsToTake = 5;

				// 			const dataVesselArrivalAndAfter = response.shipmentEvents
				// 				.slice(vesselArrivalIndex, vesselArrivalIndex + numberOfEventsToTake)
				// 				.reverse();

				// 			dataVesselArrivalAndAfter.forEach((event, index, array) => {
				// 				data += `<li class="destination">`;
				// 				data += `<div class="content">`;
				// 				data += `<h3>${event.location}</h3><hr>`;
				// 				data += `<p>Activities : ${event.name}</p>`;
				// 				data += `<p>${event.actualTime ? 'Date & time' : 'Estimate Time'} : ${event.actualTime ? dateFormatHoursMinutes(event.actualTime) : dateFormat(event.estimateTime)}</p>`;

				// 				if (index > 0) {
				// 					const previousEvent = array[index - 1];
				// 					const currentDate = new Date();
				// 					const eventDate = event.actualTime ? new Date(event.actualTime) : new Date(event.estimateTime);
				// 					const timeDifference = Math.abs(eventDate - (previousEvent.actualTime ? new Date(previousEvent.actualTime) : currentDate));
				// 					const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
				// 					const timeDiffDescription = `${daysDifference === 1 ? '1 day' : `${daysDifference} days`}`;
				// 					data += `<p>Duration : ${timeDiffDescription}</p>`;
				// 				}

				// 				data += `<hr>`;
				// 				data += `</div>`;
				// 				data += `<div class="time">`;
				// 				data += `<h4>Destination Port</h4>`;
				// 				data += `</div>`;
				// 				data += `</li>`;
				// 			});
				// 		}

				// 		const firstPort = response.shipmentLegs.portToPort.dischargePort;
				// 		const beforeVesselArrivalIndex = response.shipmentEvents.findIndex(event => event.location.includes(firstPort));

				// 		if (beforeVesselArrivalIndex !== -1) {
				// 			const reversedEvents = response.shipmentEvents
				// 				.slice(0, beforeVesselArrivalIndex)
				// 				.reverse();

				// 			let previousDate = null;

				// 			for (let i = 0; i < reversedEvents.length; i++) {
				// 				const currentDate = new Date();
				// 				const eventDate = reversedEvents[i].actualTime ? new Date(reversedEvents[i].actualTime) : new Date(reversedEvents[i].estimateTime);
								
				// 				let daysDifference = 0;
				// 				let timeDiffDescription = '';

				// 				if (reversedEvents[i].actualTime !== null) {
				// 					if (previousDate !== null) {
				// 						daysDifference = Math.ceil(Math.abs(eventDate - previousDate) / (1000 * 60 * 60 * 24));
				// 						timeDiffDescription = `${daysDifference === 1 ? '1 day' : `${daysDifference} days`}`;
				// 					} else {
				// 						if (i !== 0) {
				// 							timeDiffDescription = 'Initial day';
				// 						}
				// 					}

				// 					previousDate = eventDate;
				// 				} else if (reversedEvents[i].estimateTime !== null) {
				// 					daysDifference = Math.ceil(Math.abs(eventDate - currentDate) / (1000 * 60 * 60 * 24));
				// 					timeDiffDescription = `${daysDifference === 1 ? '1 day' : `${daysDifference} days`} from now`;
				// 				}

				// 				if (reversedEvents[i].actualTime || reversedEvents[i].estimateTime) {
				// 					data += `<li class="origin">`;
				// 					data += `<div class="content">`;
				// 					data += `<h3>${reversedEvents[i].location}</h3><hr>`;
				// 					data += `<p>Activities : ${reversedEvents[i].name}</p>`;
				// 					data += `<p> ${reversedEvents[i].actualTime ? 'Date & time' : 'Estimate Time'} : ${reversedEvents[i].actualTime ? dateFormatHoursMinutes(reversedEvents[i].actualTime) : dateFormat(reversedEvents[i].estimateTime)}</p>`;
				// 					data += `${timeDiffDescription ? `<p>Duration : ${timeDiffDescription}</p>` : ''}`;
				// 					data += `</div>`;
				// 					data += `<div class="time">`;
				// 					data += `<h4>Origin Port</h4>`;
				// 					data += `</div>`;
				// 					data += `</li>`;
				// 				}
				// 			}
				// 		}
                //         data += `<div style="clear:both;"></div>`
                //         data += `</ul>`
                //         data += `</div>`

                //         $(".testing-cargoes .load-testing").append(data);
                //     }
                // }, 1500);

				setTimeout(() => {
					if (response) {
						// ini untuk mendapatkan actual Get In
						const actlGetIn = response.shipmentEvents.findIndex(event => event.code === 'gateInWithContainerFull');
						let actualTime = actlGetIn !== -1 ? response.shipmentEvents[actlGetIn].actualTime : '';
						// Ini untuk details
						var details = `<div class="details">`
						// ini untuk tampil summary
							details += `<button class="accordion default-open">Summary</button>`
							details += `<div class="panel">`
							details += `<table>`
							details += `<tr>`
							if(response.createdAt !== null){
								details += `<td class="text-mute">Created At</td>`
								details += `<td class="weight">${dateFormat(response.createdAt)}</td>`
							}
							details += `</tr>`
							details += `<tr>`
							if(response.shippingMode !== null){
								details += `<td class="text-mute">Mode</td>`
								details += `<td class="weight">${response.shippingMode}</td>`
							}
							details += `</tr>`
							details += `<tr>`
							if(response.containerSize !== null && response.containerType !== null){
								details += `<td class="text-mute">Ctnr Type</td>`
								details += `<td class="weight">${response.containerSize} ${response.containerType}</td>`
							}
							details += `</tr>`
							details += `<tr>`
							if (response.totalNumberOfPackages !== null && response.packageType !== null) {
								details += `<td class="text-mute">Total # of packages</td>`;
								details += `<td class="weight">${response.totalNumberOfPackages} ${response.packageType}</td>`;
							}
							details += `</tr>`
							details += `<tr>`
							if(response.containerSealNumber !== null){
								details += `<td class="text-mute">Seal #</td>`
								details += `<td class="weight">${response.containerSealNumber}</td>`
							}
							details += `</tr>`
							details += `<tr>`
							if(response.totalWeight !== null && response.totalWeightUom !== null){
								details += `<td class="text-mute">Total weight</td>`
								details += `<td class="weight">${parseFloat(response.totalWeight).toFixed(2)} ${response.totalWeightUom}</td>`
							}
							details += `</tr>`
							details += `</table>`
							details += `</div>`
						// ini tutup tampil summary
							// ini untuk view Port Of Origin
							details += `<button class="accordion default-open">Port Of Origin</button>`
							details += `<div class="panel">`
						 	details += `<table>`
							details += `<tr>`
							if(response.shipmentLegs.portToPort.firstPort !== null){
								details += `<td class="text-mute">Port Name</td>`
								details += `<td class="weight">${response.shipmentLegs.portToPort.firstPort}</td>`
							}
							details += `</tr>`
							details += `<tr>`
							if(actualTime !== null && actualTime !== ''){
								details += `<td class="text-mute">Actl gate in time</td>`
								details += `<td class="weight">${dateFormat(actualTime)}</td>`
							}
							details += `</tr>`
							details += `<tr>`
							if(response.shipmentLegs.portToPort.firstPortAtd !== null || response.shipmentLegs.portToPort.firstPortEtd !== null){
								details += `<td class="text-mute">Port ATD</td>`
								details += `<td class="weight">${dateFormat(response.shipmentLegs.portToPort.firstPortAtd ?? response.shipmentLegs.portToPort.firstPortEtd)}</td>`
							}
							details += `</tr>`
							details += `</table>`
							details += `</div>`
							details += `</div>`
							// ini untuk view transit
							details += `<div class="intransit">`
							details += `<button class="accordion default-open">In Transit</button>`
							details += `<div class="panel">`
							details += `<table>`
							details += `<tr>`
							details += `<th>From</th>`
							details += `<th>To</th>`
							details += `<th>Transport Name</th>`
							details += `<th>Trip #</th>`
							details += `<th>Departure</th>`
							details += `<th>Arrival</th>`
							details += `</tr>`
							$.each(response.shipmentLegs.portToPort.segments, function(i, val) {
								details += `<tr>`
								details += `<td>${val.origin}</td>`
								details += `<td>${val.destination}</td>`
								details += `<td>${val.transportName ?? ''}</td>`
								details += `<td>${val.tripNumber ?? ''}</td>`
								details += `<td class="${val.atd ? 'text-mute' : 'text-mute'}">${val.atd ? 'Actl.' : 'Estd.'} <span>${val.atd ? dateFormat(val.atd) : dateFormat(val.etd)}</span></td>`
								details += `<td class="${val.ata ? 'text-mute' : 'text-mute'}">${val.ata ? 'Actl.' : 'Estd.'} <span>${val.ata ? dateFormat(val.ata) : dateFormat(val.eta)}</span></td>`
								details += `</tr>`
							});
							details += `</table>`
							details += `</div>`
							details += `</div>`

							// ini untuk Port Of Destination
							details += `<div class="portdestination">`
							details += `<button class="accordion default-open">Port Of Destination</button>`
							details += `<div class="panel default-open">`
						 	details += `<table>`
							details += `<tr>`
							if(response.shipmentLegs.portToPort.lastPort !== null){
								details += `<td class="text-mute">Port Name</td>`
								details += `<td class="weight">${response.shipmentLegs.portToPort.lastPort}</td>`
							}
							details += `</tr>`
							details += `<tr>`
							if(response.shipmentLegs.portToPort.lastPortEta !== null || response.shipmentLegs.portToPort.lastPortAta !== null){
								details += `<td class="text-mute">Port ETA</td>`
								details += `<td class="weight">${dateFormat(response.shipmentLegs.portToPort.lastPortEta ?? response.shipmentLegs.portToPort.lastPortAta)}</td>`
							}
							details += `</tr>`
							details += `<tr>`
							if (response.shipmentLegs.portToPort.flowPredictedLastPortEta !== null) {
								details += `<td class="flow-predicts">Flow Predicts</td>`
								details += `<td class="weight">${dateFormat(response.shipmentLegs.portToPort.flowPredictedLastPortEta ?? '')}</td>`
							}
							details += `</tr>`
							details += `</table>`
							details += `</div>`
							details += `</div>`

						$(".details-cargoes .load-details").append(details);

						// ini untuk script tab diatas
						var acc = document.getElementsByClassName("accordion");
						var i;

						for (i = 0; i < acc.length; i++) {
							acc[i].addEventListener("click", function() {
							this.classList.toggle("active");
							var panel = this.nextElementSibling;
							if (panel.style.maxHeight) {
								panel.style.maxHeight = null;
							} else {
								panel.style.maxHeight = panel.scrollHeight + "px";
							} 
							});

							// ini untuk default open panel namun tidak work
							// if (acc[i].classList.contains("default-open")) {
							// 	acc[i].click();
							// }
						}
						// ini scrip untuk tutup tab
					}
				}, 1500);

				// ini untuk testing
				setTimeout(() => {
					if (response) {
						// Ini untuk details pada location destination
						var details = `<h2 class="info-update">`;
						details += `Last updated: <span><b>${hitungUpdateHours(response.trackingUpdatedAt)}</b></span>`;
						details += `</h2>`;
						details += `<div class="tracking">`;
						details += `<div class="location">Location activities</div>`;
						details += `<div class="date-time">Date & time</div>`;
						details += `<div class="duration">Duration</div>`;
						details += `</div>`;
						// =============================================================================
						const vesselArrivalIndex = response.shipmentEvents.findIndex(event => event.location);

						const vesselLocationPortIndex = response.shipmentEvents.location;
						const vesselFirstPortIndex = response.shipmentLegs.portToPort.firstPort;
						const vesselLastPortIndex = response.shipmentLegs.portToPort.lastPort;

						const displayedLocations = new Set();

							details += `<div class="tracking-info">`;
							details += `<div class="content-activities">`;

							const dataVesselArrivalAndAfter = response.shipmentEvents
								.slice(vesselArrivalIndex)
								.reverse();

							dataVesselArrivalAndAfter.forEach((event, index, array) => {

							const isDestinationDuplicate = displayedLocations.has(event.location);
								if(!isDestinationDuplicate || index === 0 || array[index - 1].location !== event.location){
									if(event.location === vesselFirstPortIndex){
										details += `<div class="port"><div class="tracking-circle-origin"></div><b>${event.location} </b> (Port Origin)</div>`;
									}else if(event.location === vesselLastPortIndex){
										details += `<div class="port"><div class="tracking-circle-origin"></div><b>${event.location} </b> (Port Destination)</div>`;
									}else{
										if(index === array.length - 1){
											details += `<div class="port"><div class="tracking-circle-origin"></div><b>${event.location}</b></div>`;
										}else{
											details += `<div class="port"><div class="tracking-circle-origin"></div><b>${event.location} </b> (Port Call)</div>`;
										}
									}
									details += `<div></div>`;
									details += `<div></div>`;
									displayedLocations.add(event.location);
								}

								details += `<div class="location-activities">${event.name}</div>`;
								details += `<div class="date-activities">${event.actualTime ? dateFormatHoursMinutes(event.actualTime) : dateFormat(event.estimateTime)}</div>`;
								if (event.actualTime !== null && index < array.length - 1) {
									const nextEvent = array[index + 1];
									const eventDate = new Date(event.actualTime);
									const nextEventDate = new Date(nextEvent.actualTime);

									const timeDifferenceMillis = nextEventDate - eventDate;

									const hoursDifference = Math.floor((timeDifferenceMillis * -1) / (1000 * 60 * 60));

									if (index === array.length - 1) {
										details += `<div class="duration-activities">Initial Days</div>`;
									} else {
										if (hoursDifference >= 12) {
											let daysDifference = Math.floor(hoursDifference / 24);
											const remainingHours = hoursDifference % 24;

											if (remainingHours >= 12) {
												daysDifference += 1;
											}

											const timeDiffDescription = `${daysDifference === 1 ? '1 day' : `${daysDifference} days`}`;
											details += `<div class="duration-activities">${timeDiffDescription}</div>`;
										} else {
											details += `<div class="duration-activities">${hoursDifference} hours</div>`;
										}
									}
								}
								 else if (event.estimateTime !== null) {
									const estimatedDate = new Date(event.estimateTime);
									const timeDifference = estimatedDate - new Date();
									
									if (timeDifference < 0) {
										details += `<div class="duration-activities">Waiting.. Actual Time</div>`;
									} else if (timeDifference < 11 * 60 * 60 * 1000) {
										const hoursDifferenceFromNow = Math.floor(timeDifference / (1000 * 60 * 60));
										details += `<div class="duration-activities">${hoursDifferenceFromNow} hours from now</div>`;
									} else {
										const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
										const timeDiffDescription = `${daysDifference === 1 ? '1 day' : `${daysDifference} days`}`;
										details += `<div class="duration-activities">${timeDiffDescription} from now</div>`;
									}
								}
							});

						details += `</div>`;
						details += `</div>`;
						$(".timeline-cargoes .load-timeline").append(details);

						// ini untuk script tab diatas
					}
				}, 1500);

				// ini untuk document 
				setTimeout(() => {
                    if (response) {
					var document = `<div class="container">`
						document += `<div class="card">`
						document += `<h3>Upload Files</h3>`
						document += `<div class="drop_box" ondragover="handleDragOver(event)" ondrop="handleFileDrop(event)">`
						document += `<header>`
						document += `<img src="assets/global/img/uploadIcon.svg" style="width: 40px; margin-right: 10px;">`
						document += `</header>`
						document += `<div class="textUploadFiles">`
						document += `<h4>Drag and drop files here</h4>`
						document += `<p>Max 5MB for each file and up to 10 files for each upload. Supported file formats: jpg, jpeg, png, pdf</p></div>`
						document += `<input type="file" multiple hidden accept=".png,.jpeg,.jpg" id="fileID" style="display:none;" onchange="handleFileSelect(event)"/>`
						document += `<button class="btn-uploads" onclick="document.getElementById('fileID').click()">BROWSE FILE</button>`
						document += `</div>`
						document += `<div class="selected-items" id="selectedItems"></div>`
						document += `<div class="file-list" id="fileList"></div>`
						document += `</div>`
						document += `</div>`
						document += `</div>`
						document += `<div class="wrapper"> `
						document += `<div class="note"> <b>Note : </b>API <b>get, delete, dan update</b> document belum tersedia di api <b>uploadDocument</b></div>` 
						document += `</div>`
                        $(".testing-document .load-document").append(document);

						
                    }
                }, 1500);

				// ini tutup untuk menampilkan map
				$(".map-detail").html('<div id="map" style="height: 50%; width: 100%;"></div>')
				$('#detailShipmentLabelText').text(response.shipmentNumber)
				$('#detailMblNumberLabelText').text(response.mblNumber ?? "")
				$('#detailContainerNumberLabelText').text(response.containerNumber)
				$('#detailBookingNoLabelText').text(response.bookingNumber ?? "")
				$('#detailCarrierLabelText').text(response.shipmentLegs.originToPort.carrier)
				$('#detailLastUpdateLabelText').text(hitungUpdateHours(response.trackingUpdatedAt))
				$('#detailEmisionText').text(parseFloat(response.emissions.co2e.value).toFixed(2) + ' ' + response.emissions.co2e.unit)

				var lastIndex = response.shipmentEvents.length - 1;
				var lastEventData = response.shipmentEvents[lastIndex];

				var lastTime = lastEventData.estimateTime;
				var lastActualTime = lastEventData.actualTime;	

				var estimatedTime = lastTime ? dateFormat(lastTime) : null;
				var actualLastTime = lastActualTime ? dateFormat(lastActualTime) : null;

				// var estimatedTime = dateFormat(lastTime);
				// var actualLastTime = dateFormat(lastActualTime);

				const actlGetIn = response.shipmentEvents.findIndex(event => event.code === 'gateInWithContainerFull');
				let actualTime = actlGetIn !== -1 ? response.shipmentEvents[actlGetIn].actualTime : '';
				
				var tab = `
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_1_1" data-toggle="tab"> Tracking </a>
					</li>
					<li>
						<a href="#tab_1_2" data-toggle="tab"> Details </a>
					</li>
					<li>
						<a href="#tab_1_3" data-toggle="tab"> Upload Document </a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active in" id="tab_1_1">
						<div style="display: grid; grid-template-columns: auto auto; grid-gap: 10px; border-bottom: 2px solid #eeeeee; padding: 5px 15px 5px 15px;">
							<table style="text-align: left;">
								<thead>
									<tr>
										<th style="text-align: left; padding: 0; border-bottom: none;">Shipping</th>
										<th style="border-bottom: none;"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Origin Port</td>
										<td style="text-align: left; font-weight: bold;">${response.shipmentLegs.portToPort.firstPort}</td>
									</tr>
									<tr>
										<td>Port Gate in</td>
										<td style="text-align: left; font-weight: bold;">${dateFormat(actualTime ?? "")}</td>
									</tr>
									<tr>
										<td style="padding-bottom: 5px;">${response.shipmentLegs.portToPort.firstPortAtd ? 'Port ATD' : 'Port ETD'}</td>
										<td style="text-align: left; font-weight: bold; padding-bottom: 5px;">${dateFormat(response.shipmentLegs.portToPort.firstPortAtd ?? response.shipmentLegs.portToPort.firstPortEtd)}</td>
									</tr>
								</tbody>
							</table>
							
							<table style="text-align: right;">
								<thead>
									<tr>
										<th style="text-align: right; border-bottom: none;">Consignee</th>
										<th style="border-bottom: none;"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Destination Port</td>
										<td style="text-align: right; font-weight: bold; width: 50%;">${response.shipmentLegs.portToPort.lastPort}</td>
									</tr>
									<tr>
										<td class="${estimatedTime ? 'flow-predicts' : ''}">${estimatedTime ? 'Flow Predicts' : 'Port Gate Out'}</td>
										<td style="text-align: right; font-weight: bold; width: 50%;">${estimatedTime ?? actualLastTime}</td>
									</tr>
									<tr>
										<td style="padding-bottom: 5px;">${response.shipmentLegs.portToPort.dischargePortAta ? 'Port ATA' : 'Port ETA'}</td>
										<td style="text-align: right; font-weight: bold; width: 50%; padding-bottom: 5px;">${dateFormat(response.shipmentLegs.portToPort.dischargePortAta ?? response.shipmentLegs.portToPort.lastPortEta)}</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="col-md-12">
							<div class="table-scrollable timeline-cargoes" style="overflow: auto; height: 550px;">
								<div class="load-timeline"></div>
							</div>
						</div>

					</div>
					<div class="tab-pane fade" id="tab_1_2">
						<div class="col-md-12">
							<div class="table-scrollable details-cargoes" style="overflow: auto; height: 550px;">
								<div class="load-details"></div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="tab_1_3">
						<div class="col-md-12">
							<div class="table-scrollable testing-document" style="overflow: auto; height: 550px;">
								<div class="load-document"></div>
							</div>
						</div>
					</div>

				</div>
				`;

			$(".tab-list").html(tab);
				initMap(
					response.shipmentLegs.portToPort.loadingPortCoordinates.latitude,
					response.shipmentLegs.portToPort.loadingPortCoordinates.longitude,
					// ini untuk current Coordinates
					// response.shipmentLegs.portToPort.latestLocation.latitude,
					// response.shipmentLegs.portToPort.latestLocation.longitude,
					// ini tutup untuk current Coordinates
					response.shipmentLegs.portToPort.dischargePortCoordinates.latitude,
					response.shipmentLegs.portToPort.dischargePortCoordinates.longitude
				)

			},
			complete: function() {
				
			}
		});
	}

	function saveChanges() {
		var shipmentType = $("select[name='shipmentType']").val();
		var shipmentStatus = $("select[name='shipmentStatus']").val();
		var containerNumber = $("input[name='containerNumber']").val();
		var selectElement = $('#rowSelector');

		var limit = selectElement.val();
		
    	let formData = $('#update-cargoes').serialize();

		$.ajax({
			type: "PUT",
			url: "<?php echo base_url('C_FlowCargoes/updateCargoes'); ?>",
			data: formData,
    		dataType: "json",
			beforeSend: function() {
				$('.btn-saveChanges').html("Loading ...").prop("disabled", true)
			},
			success: function(response) {
				console.log(response);
				$("#updateShipment").modal('hide');
				Swal.fire({
					title: 'Data berhasil diupdate!',
					text: `${response.message}`,
					icon: 'success',
				});
				// setInterval(() => {
					loadData(shipmentType, shipmentStatus, containerNumber, limit);
				// }, 3000);
			},
			error: function(error) {
				console.error(error);
				Swal.fire({
					title: 'Data gagal diupdate!',
					text: `${response.message}`,
					icon: 'error',
				});
			},
			complete: function() {
				setTimeout(() => {

					$('.btn-saveChanges').html('Save changes').prop('disabled', false);

				}, 1500);

			}
		});
	}

	function updateDetails(containerNumber){
		$("#updateShipment").modal('show');
		var shipmentType = $("select[name='shipmentType']").val();
		var shipmentStatus = $("select[name='shipmentStatus']").val();

		const getDatabyShipId = '<?php echo base_url('C_FlowCargoes/getDataByShipId'); ?>';
		const dataGetbyShipId = {
			'shipmentType': shipmentType,
			'shipmentStatus': shipmentStatus,
			'limit': 1,
			'id': containerNumber
		};

		$.ajax({
			url: getDatabyShipId,
			type: "GET",
			data: dataGetbyShipId,
			dataType: "JSON",
			beforeSend: function() {
				$(".update-cargoes").empty();
				$(".update-cargoes").html("<span>Load Data ...</span>")
			}, 
			success: function(response)  {
				$(".update-cargoes").empty();
				if(response){
					var details = `<div class="updateHeader">`
					details += `<div class="updateTittleHeader">`
					details += `<div>Tracking #</div>`
					details += `<div>Upload type </div>`
					details += `<div>Container #</div>`
					details += `</div>`

					details += `<div class="updateBodyHeader">`
					details += `<div><b>${response.shipmentNumber ?? ""}</b></div>`
					details += `<div><b>Container #</b></div>`
					details += `<div name="containerNumber" id="containerNumber"><b>${response.containerNumber ?? ""}</b></div>`
					details += `</div>`
					details += `</div>`
					details += `<div class="tittleHeader">`
					details += `<h2> Based on the upload type of this shipment, the below fields can be edited. </h2>`
					details += `</div>`
					details += `<div class="wrapper"> `
					details += `<form id="update-cargoes" name="update-cargoes method="POST">`
					details += `<div class="box side">`
					details += `<div class="inputBox">`
					details += `<input type="text" name="shipmentNumber" id="shipmentNumber" value="${response.shipmentNumber ?? ''}"> <span>Shipment Number #</span>`
					details += `</div>`
					// details += `<div class="inputBox">`
					// details += `<input type="text" name="mblNumber" id="mblNumber" value="${response.mblNumber ?? ''}"> <span>MBL #</span>`
					// details += `</div>`
					details += `<div class="inputBox">`
					details += `<input type="text" name="bookingNumber" id="bookingNumber" value="${response.bookingNumber ?? ''}"><span>Booking #</span></div>`
					// details += `<div class="inputBox">`
					// details += `<input type="text" name="referenceNumber" id="referenceNumber" value="${response.referenceNumber ?? ''}"><span>Shipment Reference</span></div>`
					details += `<div class="inputBox">`
					details += `<input type="text" name="shipper" id="shipper" value="${response.shipper ?? ''}"><span>Shipper</span></div>`
					details += `<div class="inputBox">`
					details += `<input type="text" name="consignee" id="consignee" value="${response.consignee ?? ''}"><span>Consignee</span></div>`
					// ini  tutup inputan
					details += `<div class="note"> <b>Note : </b>Parameter <b>mblNumber</b> tidak tersedia di API <b>/updateShipments</b></div>` 
					details += `</div>`
					details += `</div>`

					details += `</div>`
					details += `</form>`
				$(".update-cargoes").append(details);
				}
			}
		});
	}

	// function getHistoryShipment(containerNumber) {
	//         $.ajax({
	//             url: "<?php echo base_url('shipping_mon/filter_local_track_container'); ?>",
	//             type: "GET",
	//             data: {
	//                 'containerNumber': containerNumber,
	//                 'limit': 10
	//             },
	//             dataType: "JSON",
	//             beforeSend: function() {
	//                 $('.timeline-shipment .loading').html("<h2>Loading ...</h2>");
	//                 $(".timeline-shipment .load-timeline").empty();
	//             },
	//             success: function(response) {
	//                 console.log(response)
	//                 setTimeout(() => {
	//                     if (response) {

	//                         var data = '<div class="timeline">'; // Initialize outside the loop
	//                         data += `<ul>`


	//                         $.each(response, function(i, val) {
	//                             data += `<li>`
	//                             data += `<div class="content">`
	//                             data += `<h3>${val.container_number} <small class="badge badge-primary">${val.tipe == 1 ? "Outward" : "Inward "}</small></h3><hr>`
	//                             data += `<p>ETA : ${val.eta}</p>`
	//                             data += `<p>ETA DATE : ${dateFormat(val.etadate)}</p><hr>`
	//                             data += `<p>ETD : ${val.etd}</p>`
	//                             data += `<p>ETD DATE : ${dateFormat(val.etddate)}</p><hr>`
	//                             data += `<p>FROM : ${val.from}</p>`
	//                             data += `<p>TO : ${val.to}</p><hr>`
	//                             data += `</div>`
	//                             data += `<div class="time">`
	//                             data += `<h4>${dateFormat(val.shipmentdate)}</h4>`
	//                             data += `</div>`
	//                             data += `</li>`
	//                         });

	//                         data += `<div style="clear:both;"></div>`
	//                         data += `</ul>`
	//                         data += `</div>`

	//                         // Append the containerNumber to the element with class "list-container"
	//                         $(".timeline-shipment .load-timeline").append(data);

	//                     }
	//                 }, 1500);

	//             },
	//             complete: function() {
	//                 setTimeout(() => {

	//                     $('.btn-refresh').html('<i class="fa fa-refresh"></i> Refresh').prop('disabled', false);
	//                     $('.timeline-shipment .loading').html("");

	//                 }, 1500);

	//             }
	//         });
	//     }

	function dateFormat(date) {
		if (!date) return '';

        var specificDate = new Date(date);

        // Format the specific date to 'dd/mm/yyyy' format
        var day = specificDate.getDate();
        var month = specificDate.getMonth() + 1; // Months are zero-based
        // var year = specificDate.getFullYear();
		var year = specificDate.getFullYear().toString().substr(-2);

        // Ensure two-digit format for day and month
        day = (day < 10) ? '0' + day : day;
        month = (month < 10) ? '0' + month : month;

        var formattedSpecificDate = day + '/' + month + '/' + year;

        return formattedSpecificDate;
    }

	function dateFormatHoursMinutes(date) {
		if (!date) return '';

		var specificDate = new Date(date);

		// Format the specific date to 'dd/mm/yyyy hh:mm' format
		var day = specificDate.getDate();
		var month = specificDate.getMonth() + 1; // Months are zero-based
		var year = specificDate.getFullYear().toString().substr(-2);
		var hours = specificDate.getHours();
		var minutes = specificDate.getMinutes();

		// Ensure two-digit format for day, month, hours, and minutes
		day = (day < 10) ? '0' + day : day;
		month = (month < 10) ? '0' + month : month;
		hours = (hours < 10) ? '0' + hours : hours;
		minutes = (minutes < 10) ? '0' + minutes : minutes;

		var formattedSpecificDate = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;

		return formattedSpecificDate;
	}


	function hitungSelisihHari(tanggal1, tanggal2) {
		const satuHari = 24 * 60 * 60 * 1000; // Satu hari dalam milidetik

		// Ubah tanggal menjadi objek Date
		const date1 = new Date(tanggal1);
		const date2 = new Date(tanggal2);

		// Hitung selisih dalam milidetik
		const selisih = Math.abs(date2 - date1);

		// Hitung jumlah hari
		const jumlahHari = Math.round(selisih / satuHari);

		return jumlahHari;
	}

	// tambahkan keterangan waktu untuk update beberapa hari kemudian
	function hitungUpdateHours(actualTime) {
		const updateTime = new Date(actualTime);
		const timeDifference = new Date() - updateTime;
		const hoursDifference = Math.floor(timeDifference / (1000 * 60 * 60));
		const minutesDifference = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

		if (hoursDifference === 0) {
			if (minutesDifference === 0) {
				return "Less Than A Minute";
			} else if (minutesDifference === 1) {
				return "1 Minute";
			} else {
				return `${minutesDifference} Minutes Ago`;
			}
		} else if (hoursDifference === 1) {
			return "1 Hour";
		} else {
			return `${hoursDifference} Hours Ago`;
		}
	}

	// ini untuk upload file drop file dan select files
	function handleFileSelect(event) {
        const fileList = document.getElementById('fileList');
        const selectedItems = document.getElementById('selectedItems');
        fileList.innerHTML = ''; // Clear existing list

        const files = event.target.files;
        for (const file of files) {
          const listItem = document.createElement('div');
          listItem.className = 'file-list-item';
          listItem.innerHTML = `
            <span>${file.name} (${formatBytes(file.size)})</span>
            <button onclick="removeFile('${file.name}')">Remove</button>
          `;
          fileList.appendChild(listItem);
        }

        selectedItems.textContent = `Selected Items: `;
      }

	function removeFile(fileName) {
		const fileList = document.getElementById('fileList');
		const selectedItems = document.getElementById('selectedItems');
		const listItem = Array.from(fileList.children).find(item => item.textContent.includes(fileName));
		fileList.removeChild(listItem);

		// Update selected items
		const remainingItems = Array.from(fileList.children).map(item => item.textContent.split(' ')[0]);
		
		if (remainingItems.length > 0) {
			selectedItems.textContent = `Selected Items:`;
		} else {
			selectedItems.textContent = ``;
		}
	}

	function handleFileDrop(event) {
        event.preventDefault();

        const fileList = document.getElementById('fileList');
        const selectedItems = document.getElementById('selectedItems');
        fileList.innerHTML = ''; // Clear existing list

        const files = event.dataTransfer.files;
        for (const file of files) {
          const listItem = document.createElement('div');
          listItem.className = 'file-list-item';
          listItem.innerHTML = `
            <span>${file.name} (${formatBytes(file.size)})</span>
            <button onclick="removeFile('${file.name}')">Remove</button>
          `;
          fileList.appendChild(listItem);
        }

        // const selectedItemsList = Array.from(files).map(file => file.name);
        selectedItems.textContent = `Selected Items: `;
    }

    function handleDragOver(event) {
        event.preventDefault();
    }

	function formatBytes(bytes, decimals = 2) {
	if (bytes === 0) return '0 Bytes';
	const k = 1024;
	const dm = decimals < 0 ? 0 : decimals;
	const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

	const i = Math.floor(Math.log(bytes) / Math.log(k));

	return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	}
</script>