<html>
  <head>
    <title>規劃行程系統</title>
  </head>
  <!-- jQuery v1.9.1 -->
<script src="jquery-3.3.1.js"></script>
<!-- DataTables v1.10.16 -->
<link href="jquery.dataTables.min.css" rel="stylesheet" />
<script src="jquery.dataTables.min.js"></script>
<?php session_start();
    include("mysql.php"); 

    $us_admin = $_SESSION['us_admin'];
    if(!empty($us_admin)){
        include("select_random.php"); 
    }

    $pt_usid = $_SESSION['us_id'];
    $pt_usname = $_SESSION['us_name'];

 ?>
  <body>
    <style>
        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
    
    <form name="showForm" method="post">
        <input type="hidden" name="admin" value="<?=$us_admin?>"/>
        <input type="button" value="活動列表" onClick="show('activity')"/>
        <input type="button" value="行程列表" onClick="show('plan')"/>
        <input type="button" value="設定" onClick="show('setting')"/>
        &nbsp&nbsp
        Hi!<?php echo $_SESSION['us_name'];?>
        <input type="button" value="登出" onClick="show('sign_out')"/>
        <br/><br/>
        <H2>隨機行程</H2>
        <br/><br/>

        天數: <input type="text" name="day" value="" size="2"/>天<br/><br/>
        
        類型: 
        <?php
            foreach($types as $key => $value){
                $type_id = $value['type_id'];
                $name = $value['name'];
        ?>
            <input type="checkbox" name="typeid" value="<?=$type_id?>"><?php echo $name ?></input>
        <?php
            }
        ?>
        <br/><br/>

        天數小時:<input type="text" name="day_time" value="" size="2">小時<br/><br/>

        時段選項:
            <select name="time_type">
        <?php
            foreach($time as $key => $value){
                $ty_type = $value['ty_type'];
                $ty_name = $value['ty_name'];
        ?>
            <option value="<?=$ty_type?>"><?php echo $ty_name ?></option>
        <?php
            }
        ?>
            </select>
            <br/><br/> 
        <input type="button" name="addplans" value="送出" onClick="add_plan()"/>
        <table id="example1">
	        <thead>
               
	        </thead>
	        <tbody>
                
	        </tbody>
            <tfoot>
            </tfoot>
        </table>
    </form>
  </body>
  <script language="JavaScript">
    $(document).ready(function() {
        $('#example1').DataTable();
    } );


    function format (ac_name,ac_type,ac_weather,ac_drive,ac_carry,ac_spend,ac_hours,type) {

    var length = ac_name.length;
    var table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>活動項目</td>'+
            '<td>類型</td>'+
            '<td>天氣</td>'+
            '<td>車程(小時)</td>'+
            '<td>攜帶物品</td>'+
            '<td>花費</td>'+
            '<td>時間(小時)</td>'+
            '<td style="display:none;">類型ID</td>'+
        '</tr>';
    for(i=0;i<length;i++){
        table = table + '<tr>';
        table = table + '<td>' + ac_name[i] + '</td>';
        table = table + '<td>' + ac_type[i] + '</td>';
        table = table + '<td>' + ac_weather[i] + '</td>';
        table = table + '<td>' + ac_drive[i] + '</td>';
        table = table + '<td>' + ac_carry[i] + '</td>';
        table = table + '<td>' + ac_spend[i] + '</td>';
        table = table + '<td>' + ac_hours[i] + '</td>';
        table = table + '<td style="display:none;">' + type[i] + '</td>';
        table = table + '</tr>';
    }

    table = table + '</table>';

    // `d` is the original data object for the row
    return table;
    }

    function edit(obj){
        var tr = $(obj).closest('tr');
        var pt_status = $(tr).find(".pt_status").text().trim();
        if(pt_status!="V"){
            var ac_name = [],ac_type = [],ac_weather = [],ac_drive = [],ac_carry = [],ac_spend = [],ac_hours = [],type = [];
            var pt_usid = $(tr).find(".pt_usid").text().trim();
            var pt_usname = $(tr).find(".pt_usname").text().trim();  
            var pt_name = $(tr).find(".pt_name").text().trim();
            var pt_date = $(tr).find(".pt_date").text().trim();

            $(tr).find("td input[name='ac_name']").each(function(){
                ac_name.push($(this).val());
            })

            $(tr).find("td input[name='ac_type']").each(function(){
                ac_type.push($(this).val());
            })

            $(tr).find("td input[name='ac_weather']").each(function(){
                ac_weather.push($(this).val());
            })

            $(tr).find("td input[name='ac_drive']").each(function(){
                ac_drive.push($(this).val());
            })

            $(tr).find("td input[name='ac_carry']").each(function(){
                ac_carry.push($(this).val());
            })

            $(tr).find("td input[name='ac_spend']").each(function(){
                ac_spend.push($(this).val());
            })

            $(tr).find("td input[name='ac_hours']").each(function(){
                ac_hours.push($(this).val());
            })

            $(tr).find("td input[name='type']").each(function(){
                type.push($(this).val());
            })

            $(tr).find("td input[name='pt_usid']").each(function(){
                pt_usid.push($(this).val());
            })

            $(tr).find("td input[name='pt_usname']").each(function(){
                pt_usname.push($(this).val());
            })

            var from = $("form[name='submitForm']");
        
            $(from).find("input[name='pt_usid']").val(pt_usid);
            $(from).find("input[name='pt_usname']").val(pt_usname);
            $(from).find("input[name='pt_name']").val(pt_name);
            $(from).find("input[name='pt_date']").val(pt_date);
            $(from).find("input[name='ac_name']").val(ac_name);
            $(from).find("input[name='ac_type']").val(ac_type);
            $(from).find("input[name='ac_weather']").val(ac_weather);
            $(from).find("input[name='ac_drive']").val(ac_drive);
            $(from).find("input[name='ac_carry']").val(ac_carry);
            $(from).find("input[name='ac_spend']").val(ac_spend);
            $(from).find("input[name='ac_hours']").val(ac_hours);
            $(from).find("input[name='type']").val(type);  

            $(from).submit();
        }else{
            return alert("已完成不能編輯!");
        }
    }

    function Cancel(obj){
        $(obj).parent().parent().remove();    
    }

    function show(page){
        if($("input[name='admin']").val()=="Y" && page!="activity" && page!="sign_out"){
            page = page + "_admin";
        }
        document.showForm.action=page+".php"; 
        document.showForm.submit();
    }

   
  </script>
</html>

