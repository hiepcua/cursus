<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#txt_name_err").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tên nhóm tin').fadeTo(900,1);
            });
            $("#txt_name").focus();
            return false;
        }
        return true;
    }
</script>

<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo ROOTHOST_ADMIN;?>">Admin</a></li>
        <li><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách loại hình đất</a></li>
        <li class="active">Thêm mới loại hình đất</li>
    </ol>
</div>

<div class="com_header color">
    <h1>Thêm mới loại hình đất</h1>
    <div class="pull-right">
        <form id="frm_menu" name="frm_menu" method="post" action="">
            <input type="hidden" name="txtorders" id="txtorders" />
            <input type="hidden" name="txtids" id="txtids" />
            <input type="hidden" name="txtaction" id="txtaction" />

            <ul class="list-inline">
                <li><a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</a></li>
                <li><a class="btn btn-default"  href="<?php echo ROOTHOST_ADMIN.COMS;?>" title="Đóng"><i class="fa fa-sign-out" aria-hidden="true"></i> Đóng</a></li>
            </ul>
        </form>
    </div>
</div>
<div class="clearfix"></div>

<form id="frm_action" name="frm_action" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
    <div class="tab-content">
        <div class="tab-pane fade active in" id="info">
            <div class="form-group">
                <div class="col-md-6">
                    <label>Tên loại hình đất<small class="cred"> (*)</small><span id="txt_name_err" class="mes-error"></span></label>
                    <input type="text" name="txt_name" class="form-control" placeholder="Tên loại hình đất" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <label>Sapo</label>
                    <textarea class="form-control" name="txt_comment" rows="5" placeholder="Nội dung ..."></textarea>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
        <div class="text-center toolbar">
            <div style="height: 20px;"></div>
            <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</a>
        </div>
    </div>
</form>
