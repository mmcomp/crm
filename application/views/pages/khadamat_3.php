<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = $user_id;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    if(isset($_REQUEST['khadamat']))
    {
        //var_dump($_REQUEST);
    }
 
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $this->profile_model->loadUser($user_id1);
    $user_obj = $this->profile_model->user;
    $menu_links = '';
    foreach($men as $title=>$href)
    {
        $tmp = explode('/', $href);
        $active = ($tmp[2]==$page_addr);
        $active2 = TRUE;
        if(isset($tmp[3]) && trim($p1)!='' && $tmp[3]!=$p1)
            $active2 = FALSE;
        $active = ($active & $active2);
        $menu_links .= "<li role='presentation'".(($active)?" class='active'":"")."><a href='$href'>$title</a></li>";
    }
       
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
    <form action="khadamat_4">
    <div class="col-sm-10" >
        <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
            تامین کنندگان
        </div>
        <div class="row hs-border" >
            <div class="hs-default hs-padding hs-border">
                پرواز
            </div>
            <div id="all_tamin" >
                <div id="parvaz_box_0" style="display: none;" >
                    <div class="col-sm-2 hs-padding" >
                        <span style="width: 10%;" class="glyphicon glyphicon-remove-circle pointer" onclick="remove_own(this);" ></span>
                        <select class="sel_2" style="width: 85%;" name="taminkonande" >
                            <option>داخلی</option>  
                            <option>مارکو پلو</option>
                            <option>هتل قصر</option>
                            <option>رسپینا</option>
                        </select>
                    </div>
                    <div class="col-sm-3 hs-padding" >
                        <input  class="form-control" type="text" name="ghimat-kharid[]" placeholder="قیمت خرید"  >
                    </div>
                    <div class="col-sm-2 hs-padding" >
                        <select class="sel_2" style="width: 100%;" name="vahed_pool[]">
                            <option>واحد پول</option>  
                            <option>ریال</option>
                            <option>دلار آمریکا </option>
                            <option>یورو</option>
                        </select>
                    </div>
                    <div class="col-sm-5 hs-padding" >
                        <input type="text" placeholder="توضیحات" name="toz[]" class="form-control" >
                    </div>
                </div>
                <div id="parvaz_box_1" >
                    <div class="col-sm-2 hs-padding" >
                        <span style="width: 10%;" class="glyphicon glyphicon-remove-circle pointer" onclick="remove_own(this);" ></span>
                        <select style="width: 85%;" name="taminkonande[]" >
                            <option>داخلی</option>  
                            <option>مارکو پلو</option>
                            <option>هتل قصر</option>
                            <option>رسپینا</option>
                        </select>
                    </div>
                    <div class="col-sm-3 hs-padding" >
                        <input  class="form-control" type="text" name="ghimat-kharid[]" placeholder="قیمت خرید"  >
                    </div>
                    <div class="col-sm-2 hs-padding" >
                        <select style="width: 100%;" name="vahed_pool[]">
                            <option>واحد پول</option>  
                            <option>ریال</option>
                            <option>دلار آمریکا </option>
                            <option>یورو</option>
                        </select>
                    </div>
                    <div class="col-sm-5 hs-padding" >
                        <input type="text" placeholder="توضیحات" name="toz[]" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="text-left hs-padding" style="font-size:150%;">
                <span class="glyphicon glyphicon-plus-sign pointer" onclick="addParvazBox()" ></span>
            </div>
        </div>
        <div class="row hs-border" >
            <div class="hs-default hs-padding hs-border">
                هتل
            </div>
            <div id="all_tamin_hotel" >
                <div id="hotel_box_0" style="display: none;" >
                    <div class="col-sm-2 hs-padding" >
                        <span style="width: 10%;" class="glyphicon glyphicon-remove-circle pointer" onclick="remove_own(this);" ></span>
                        <select class="sel_2" style="width: 85%;" name="taminkonande[]" >
                            <option>داخلی</option>  
                            <option>مارکو پلو</option>
                            <option>هتل قصر</option>
                            <option>رسپینا</option>
                        </select>
                    </div>
                    <div class="col-sm-3 hs-padding" >
                        <input  class="form-control" type="text" name="ghimat-kharid[]" placeholder="قیمت خرید"  >
                    </div>
                    <div class="col-sm-2 hs-padding" >
                        <select class="sel_2" style="width: 100%;" name="vahed_pool[]">
                            <option>واحد پول</option>  
                            <option>ریال</option>
                            <option>دلار آمریکا </option>
                            <option>یورو</option>
                        </select>
                    </div>
                    <div class="col-sm-5 hs-padding" >
                        <input type="text" placeholder="توضیحات" name="toz[]" class="form-control" >
                    </div>
                </div>
                <div id="hotel_box_1" >
                    <div class="col-sm-2 hs-padding" >
                        <span style="width: 10%;" class="glyphicon glyphicon-remove-circle pointer" onclick="remove_own(this);" ></span>
                        <select style="width: 85%;" name="taminkonande[]" >
                            <option>داخلی</option>  
                            <option>مارکو پلو</option>
                            <option>هتل قصر</option>
                            <option>رسپینا</option>
                        </select>
                    </div>
                    <div class="col-sm-3 hs-padding" >
                        <input  class="form-control" type="text" name="ghimat-kharid[]" placeholder="قیمت خرید"  >
                    </div>
                    <div class="col-sm-2 hs-padding" >
                        <select style="width: 100%;" name="vahed_pool[]">
                            <option>واحد پول</option>  
                            <option>ریال</option>
                            <option>دلار آمریکا </option>
                            <option>یورو</option>
                        </select>
                    </div>
                    <div class="col-sm-5 hs-padding" >
                        <input type="text" placeholder="توضیحات" name="toz[]" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="text-left hs-padding" style="font-size:150%;">
                <span class="glyphicon glyphicon-plus-sign pointer" onclick="addHotelBox()" ></span>
            </div>
        </div>
        
        <div class="hs-float-left hs-margin-up-down">
        <button href="" class="btn hs-btn-default btn-lg" >
            ادامه
            <span class="glyphicon glyphicon-chevron-left"></span>
        </button>
    </div>
    </div>    
    </form>
</div>
<script>
    var khadamat_3_indx=1;
    var par_0 = '<div class="col-sm-2 hs-padding" ><span style="width: 10%;" class="glyphicon glyphicon-remove-circle pointer" onclick="remove_own(this);" ></span>'+
                '<select class="sel_2" style="width: 85%;" name="taminkonande" >'+
                '<option>داخلی</option>'+
                '<option>مارکو پلو</option><option>هتل قصر</option><option>رسپینا</option>'+//TaminKonande Ha
                '</select></div><div class="col-sm-3 hs-padding" ><input  class="form-control" type="text" name="ghimat-kharid[]" placeholder="قیمت خرید"  >'+
                '</div>'+
                '<div class="col-sm-2 hs-padding" >'+
                '<select class="sel_2" style="width: 100%;" name="vahed_pool[]">'+
                '<option>واحد پول</option>'+  
                'option>ریال</option><option>دلار آمریکا </option><option>یورو</option>'+//Vahed pool Ha
                '</select>'+
                '</div><div class="col-sm-5 hs-padding" >'+
                '<input type="text" placeholder="توضیحات" name="toz[]" class="form-control" >'+
                '</div>';
    var hot_0 = '<div class="col-sm-2 hs-padding" ><span style="width: 10%;" class="glyphicon glyphicon-remove-circle pointer" onclick="remove_own(this);" ></span>'+
                '<select class="sel_2" style="width: 85%;" name="taminkonande" >'+
                '<option>داخلی</option>'+
                '<option>مارکو پلو</option><option>هتل قصر</option><option>رسپینا</option>'+//TaminKonande Ha
                '</select></div><div class="col-sm-3 hs-padding" ><input  class="form-control" type="text" name="ghimat-kharid[]" placeholder="قیمت خرید"  >'+
                '</div>'+
                '<div class="col-sm-2 hs-padding" >'+
                '<select class="sel_2" style="width: 100%;" name="vahed_pool[]">'+
                '<option>واحد پول</option>'+  
                'option>ریال</option><option>دلار آمریکا </option><option>یورو</option>'+//Vahed pool Ha
                '</select>'+
                '</div><div class="col-sm-5 hs-padding" >'+
                '<input type="text" placeholder="توضیحات" name="toz[]" class="form-control" >'+
                '</div>';
    function addParvazBox()
    {
        var tt = par_0;
        khadamat_3_indx++;
        $("#all_tamin").append("<div id='parvaz_box_"+khadamat_3_indx+"' >"+tt+"</div>");
        $("select").select2('destroy');
        $('select').select2({
                dir: "rtl"
        });
    }
    function addHotelBox()
    {
        var tt = hot_0;
        khadamat_3_indx++;
        $("#all_tamin_hotel").append("<div id='hotel_box_"+khadamat_3_indx+"' >"+tt+"</div>");
        $('select').select2({
                dir: "rtl"
        });
    }
    function remove_own(inp)
    {
        console.log($(inp).parent().parent().remove());
    }
</script>