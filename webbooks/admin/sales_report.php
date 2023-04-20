<?php
    include 'db_connect.php';
    $month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
?>
<div class="container-fluid mg-bt-170">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
            <div class="row justify-content-center pt-4">
                <div class="col-sm-3">
                    <input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <table class="table table-bordered" id='report-list'>
                    <thead>
                        <tr>
                            <th class="text-center">STT</th>
                            <th class="text-center">Thời gian</th>
                            <th class="text-center">Khách hàng</th>
                            <th class="text-center">Sách</th>
                            <th class="text-center">Đơn giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Số tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $total = 0;
                      $orders = $conn->query("SELECT o.*,c.name FROM orders o inner join customers c on c.id = o.customer_id where o.status = 1 and date_format(o.date_created,'%Y-%m') = '$month' order by unix_timestamp(o.date_created) asc ");
                      if($orders->num_rows > 0):
                      while($row = $orders->fetch_array()):
                        $items = $conn->query("SELECT o.*,b.title  FROM order_list o inner join books b on b.id=o.book_id where o.order_id = {$row['id']}");
                      while($roww = $items->fetch_array()):
                        $total += $roww['price']*$roww['qty'];
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td>
                            <p class="text-center"> <?php echo date("M d,Y",strtotime($row['date_created'])) ?></p>
                        </td>
                        <td>
                            <p class="text-center"> <?php echo ucwords($row['name']) ?></p>
                        </td>
                        <td>
                            <p class="text-left"> <?php echo ucwords($roww['title']) ?></p>
                        </td>
                        <td>
                            <p class="text-center"> <?php echo number_format($roww['price']) ?>đ</p>
                        </td>
                        <td>
                            <p class="text-center"> <?php echo $roww['qty'] ?></p>
                        </td>
                        <td>
                            <p class="text-center"> <?php echo number_format($roww['price']*$roww['qty']) ?>đ</p>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    endwhile;
                        else:
                    ?>
                    <tr>
                            <th class="text-center" colspan="7">Không có dữ liệu.</th>
                    </tr>
                    <?php 
                        endif;
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-right" style="font-weight: 500;">Tổng cộng</th>
                            <th class="text-right" style="font-weight: 500;"><?php echo number_format($total) ?>đ</th>
                        </tr>
                    </tfoot>
                </table>
                <hr>
                <div class="col-md-12 mb-4">
                    <center>
                        <button class="btn btn-success btn-sm col-sm-3" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                    </center>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<noscript>
    <style>
        table#report-list{
            width:100%;
            border-collapse:collapse
        }
        table#report-list td,table#report-list th{
            border:1px solid
        }
        p{
            margin:unset;
        }
        .text-center{
            text-align:center
        }
        .text-right{
            text-align:right
        }
    </style>
</noscript>
<script>
$('#month').change(function(){
    location.replace('index.php?page=sales_report&month='+$(this).val())
})
$('#report-list').dataTable()
$('#print').click(function(){
            $('#report-list').dataTable().fnDestroy()
        var _c = $('#report-list').clone();
        var ns = $('noscript').clone();
            ns.append(_c)
        var nw = window.open('','_blank','width=900,height=600')
        nw.document.write('<p class="text-center"><b>Book Store Sales Report as of <?php echo date("F, Y",strtotime($month)) ?></b></p>')
        nw.document.write(ns.html())
        nw.document.close()
        nw.print()
        setTimeout(() => {
            nw.close()
            $('#report-list').dataTable()
        }, 500);
    })
</script>