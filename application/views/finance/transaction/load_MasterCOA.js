function viewModalMCOA(){
//        alert('sdsd');
    $("#modalMasterCOA").html("<div class='portlet-body'>\n\
                            <div class='col-md-12'>\n\
                                <form role='form' class='form-horizontal'>\n\
                                    <div class='form-group'>\n\
                                        <label class='col-md-2 control-label text-right'>Find</label>\n\
                                        <div class='col-md-5'>\n\
                                            <div class='input-group'>\n\
                                                <div class='input-icon'>\n\
                                                    <input class='form-control' id='txtFilter'>\n\
                                                </div>\n\
                                                <span class='input-group-btn'>\n\
                                                    <button type='button' class='btn btn-sm btn-success' onclick='ajaxMCOA()'><i class='fa fa-search'></i> Search</button>\n\
                                                </span>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                </form>\n\
                            </div>\n\
                            <div id='tblMasterCOA-forAjax' class='col-md-12 table-responsive table-scrollable' style='overflow: auto; height:300px;'>\n\
                                <table id='tbl-MasterCOA' class='table table-bordered table-striped'>\n\
                                    <thead>\n\
                                        <tr>\n\
                                            <th>COA Number</th>\n\
                                            <th>Account Name</th>\n\
                                            <th>COA Group</th>\n\
                                            <th>Reg Number</th>\n\
                                        </tr>\n\
                                    </thead>\n\
                                    <tbody>\n\
                                        <tr ondblclick='addRow(this)'>\n\
                                            <td></td><td></td><td></td><td></td>\n\
                                        </tr>\n\
                                    </tbody>\n\
                                </table>\n\
                            </div>\n\
                        </div>");
    // Define the Dialog and its properties.
    $("#modalMasterCOA").dialog({
        resizable: false,
        modal: true,
        title: "Select Master COA",
        position: ["middle"],
        height: 500,
        width: 1200
    });
}