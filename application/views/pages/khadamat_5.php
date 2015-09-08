<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$msg = '';
$factor_id = -1;
if (trim($p1) != '')
    $factor_id = (int) $p1;
factor_class::marhale((int) $p1, 'khadamat_3');
$out = '';
$fac = new factor_class((int) $p1);
if (isset($_REQUEST['khadamat_id'])) {
    //var_dump($_REQUEST);
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    $this->form_validation->set_rules('khadamat_id[]', 'خدمات ', 'required|is_natural_no_zero');
    $this->form_validation->set_rules('khadamat_tamin_id[]', 'خدمات گرفته شده', 'required|is_natural_no_zero');
    $this->form_validation->set_rules('taminkonande_id[]', 'تأمین کننده ', 'required|is_natural_no_zero');
    $this->form_validation->set_rules('mablagh[]', 'مبلغ', 'required|is_natural_no_zero');
    $this->form_validation->set_rules('vahed_mablagh_id[]', 'واحد', 'required|is_natural_no_zero');
    if ($this->form_validation->run() == FALSE) {
        $valid = FALSE;
    } else {
        taminkonande_class::add($p1, $_REQUEST);
        redirect('khadamat_3/' . $p1);
    }
}
if (isset($_REQUEST['khadamat_id_j'])) {
    $out = '';
    $out .= khadamat_tamin_class::loadByKhadamat((int) $_REQUEST['khadamat_id_j']);
    die($out);
}
if (isset($_REQUEST["new_tamin"])) {
    $out = "-1";
    $my = new mysql_class;
    $ln = $my->ex_sqlx("insert into taminkonande (name) values ('" . $_REQUEST["new_tamin"] . "')", FALSE);
    $out = (string) $my->insert_id($ln);
    $my->close($ln);
    die($out);
}
$this->profile_model->loadUser($user_id);
$men = $this->profile_model->loadMenu();
$this->profile_model->loadUser($user_id);
$user_obj = $this->profile_model->user;
$menu_links = '';
foreach ($men as $title => $href) {
    $tmp = explode('/', $href);
    $active = ($tmp[2] == $page_addr);
    $active2 = TRUE;
    if (isset($tmp[3]) && trim($p1) != '' && $tmp[3] != $p1)
        $active2 = FALSE;
    $active = ($active & $active2);
    $menu_links .= "<li role='presentation'" . (($active) ? " class='active'" : "") . "><a href='$href'>$title</a></li>";
}
//$taminkonande = new taminkonande_class;
$f = new factor_class($factor_id);
$my = new mysql_class;
$jam_khadamat = 0;
$jam_commision = 0;
$jam_jayeze = 0;
$my->ex_sql("select sum(mablagh) as mab,sum(comission) comm,sum(jayeze)  `jayz` from `khadamat_factor` where factor_id=$factor_id", $q);
if (isset($q[0])) {
    $jam_khadamat = (int) $q[0]['mab'];
    $jam_commision = (int) $q[0]['comm'];
    $jam_jayeze = (int) $q[0]['jayz'];
}
$jam_pardakht = (int) $f->mablagh - ($jam_commision + $jam_jayeze);
?>
<div class="row" >
    <div class="col-sm-2" >
        <div class="hs-margin-up-down hs-gray hs-padding hs-border" >
            امکانات
        </div>
        <div class="hs-margin-up-down hs-padding hs-border" >
            <ul class="nav nav-pills nav-stacked">
                <?php
                echo $menu_links;
                ?>
            </ul>
        </div>
    </div>
    <form action="" method="POST" id="frm_tamin">
        <div class="col-sm-10" >
            <?php
            echo $this->inc_model->loadProgress(5, $p1);
            echo validation_errors();
            echo "<div class='text-center hs-margin-up-down' ><div class='label label-danger' style='font-size:100%' >شماره فاکتور: $p1</div></div>";
            ?>
            <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
                قابل پرداخت
            </div>
            <div class="row" >
                <div class="col-sm-2">جمع خدمات</div>
                <div class="col-sm-2"><?php echo $this->inc_model->monize($jam_khadamat); ?></div>
                <div class="col-sm-2">جمع کمیسیون/تخفیف</div>
                <div class="col-sm-2"><?php echo $this->inc_model->monize($jam_commision); ?></div>
                <div class="col-sm-2">جمع جایزه ها</div>
                <div class="col-sm-2"><?php echo $this->inc_model->monize($jam_jayeze); ?></div>
            </div>
            <div class="row" >         
                <div class="col-sm-2 col-sm-offset-4">مبلغ</div>
                <div class="col-sm-2"><?php echo $this->inc_model->monize($f->mablagh); ?></div>
                <div class="col-sm-2"> قابل پرداخت</div>
                <div class="col-sm-2"><?php echo $this->inc_model->monize($jam_pardakht); ?></div>
            </div>
            <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
                تامین کنندگان
            </div>
            <div class="row" >
                <?php
                echo $out;
                ?>
            </div>
            <div class="row hs-border" >
                <div class="col-sm-12">
                    <div class="hs-float-left" >
                        <span class="glyphicon glyphicon-plus-sign" onclick='addV()' ></span>
                    </div>
                </div>
                <div id="all_tamin" >
                    <?php
                    echo taminkonande_class::loadLast((int) $p1);
                    ?>
                </div>
            </div>
            <div class="hs-float-left hs-margin-up-down">
                <a class="btn hs-btn-default btn-lg" onclick="contin()" >
                    ادامه
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
            </div>

    </form>
    <div class="hs-float-right hs-margin-up-down">
        <a href="<?php echo site_url() . 'khadamat_2/' . $p1; ?>" class="btn hs-btn-default btn-lg" >
            <span class="glyphicon glyphicon-chevron-right"></span>
            مرحله قبلی
        </a>
    </div>
</div> 
</div>
<script>
    var tmp = '<?php echo taminkonande_class::loadView($p1); ?>';
    function addV()
    {
        $("#all_tamin").append(tmp);
        $('select').each(function (id, feild) {
            if (!$(feild).data('select2'))
            {
                $(feild).select2({
                    dir: "rtl"
                });
            }
        });
    }
    function loadKhadamat_tamin(inp)
    {
        var khadamat_id = parseInt($(inp).val(), 10);
        if (!isNaN(khadamat_id) && khadamat_id > 0)
        {
            //$($(inp).parent().parent().parent().find("select")[1]).hide();
            $($(inp).parent().parent().parent().find("select")[1]).before("<img src='<?php echo asset_url() . 'img/stat.gif'; ?>' id='khoon_" + khadamat_id + "'/>");
            $.get("<?php echo site_url() . "khadamat_5" ?>", {"khadamat_id_j": khadamat_id}, function (res) {
                console.log(res);
                /*
                 $('select').select2({
                 dir: "rtl"
                 });
                 */
                $("#khoon_" + khadamat_id).remove();
                $($(inp).parent().parent().parent().find("select")[1]).html(res);
                //$($(inp).parent().parent().parent().find("select")[1]).show();
                $('select').each(function (id, feild) {
                    if (!$(feild).data('select2'))
                    {
                        $(feild).select2({
                            dir: "rtl"
                        });
                    }
                });
            }).fail(function () {
                $("#khoon_" + khadamat_id).remove();
            });
        }
    }
    function contin()
    {
        $("#frm_tamin").submit();
    }
    var add_tamin_obj;
    function addTamin(dobj)
    {
        add_tamin_obj = $(dobj).prev().prev();
        $("#taminModal").modal("show");
    }
    function saveTamin()
    {
        var new_tamin = $("#new_tamin").val().trim();
        var p = {
            "new_tamin": new_tamin
        };
        if (new_tamin !== '')
        {
            $.get("<?php echo site_url() ?>khadamat_5", p, function (res) {
                var tamin_id = parseInt(res, 10);
                if (!isNaN(tamin_id) && tamin_id > 0)
                {
                    add_tamin_obj.select2('destroy');
                    add_tamin_obj.append("<option value='" + tamin_id + "'>" + new_tamin + "</option>");
                    add_tamin_obj.select2({
                        dir: "rtl"
                    });
                    add_tamin_obj.select2("val", tamin_id);
                    $("#taminModal").modal("hide");
                }
            });
        }
        else
        {
            alert('لطفا نام ایرلاین را وارد کنید');
        }
    }
</script>

<!-- Modal -->
<div class="modal fade" id="taminModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="taminModalLabel">ثبت تامین کننده</h4>
            </div>
            <div class="modal-body" id="taminModalBody">
                <input class="form-control" id="new_tamin" placeholder="نام تامین کننده" />
            </div>
            <div class="modal-footer">
                <button type="button" id="taminModalCancel" class="btn btn-default" data-dismiss="modal">انصراف</button>
                <button type="button" id="taminModalOk" onclick="saveTamin();" class="btn btn-primary">ذخیره</button>
            </div>
        </div>
    </div>
</div>