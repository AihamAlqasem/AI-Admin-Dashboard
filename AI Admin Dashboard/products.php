<?php
ob_start();
session_start();
if (isset($_SESSION['Sessionid'])) {

    $pagetitle = "المنتتجات";

    include 'init.php';

    $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';

    if ($action == "Manage") {

        $stmt = $con->prepare("SELECT *
        FROM products
        
        where pro_status=1

      ORDER BY pro_id  DESC
        
      ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
?>
        <div class="container">
            <div class="row">
                <div class="col-med-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3><a href="?action=Add" class="btn btn-primary"> <i class="fa fa-plus"></i> أضافة منتج </a></h3>

                            <h3 style="direction: rtl;">بيانات المنتجات </h3>
                        </div>
                        <!-- Search -->
                    </div>
                </div>
                <div class="col-med-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>التحكم</td>
                                        <td> الصورة</td>
                                        <td>أسم المنتج</td>
                                        <td>رقم المنتج</td>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <?php
                                        foreach ($rows as $rowfetch) {
                                            echo "<tr>";
                                            echo "<td>";
                                        ?>
                    
                                            <a href="?action=edit&proId=<?php echo $rowfetch['pro_id']  ?>" class="btn btn-success btn-sm">تعديل <i class="fa fa-edit"></i></a>
                                            <a href="?action=delete&pId=<?php echo $rowfetch['pro_id']  ?>" class="btn btn-danger btn-sm confirm">حذف <i class="fa fa-close"></i></a>
                                            <?php if ($rowfetch['pro_status'] == 1) {

                                            ?>
                                                <a href="?action=block&pId=<?php echo $rowfetch['pro_id']  ?>" class="btn btn-danger btn-sm">توقيف <i class="fa fa-hand-stop-o"></i></a>
                                            <?php } else { ?>
                                                <a href="?action=active&pId=<?php echo $rowfetch['pro_id']  ?>" class="btn btn-primary btn-sm">تفعيل <i class="fa fa-active"></i></a>
                                            <?php } ?>
                                            </td>
                                        <?php
                                            echo "<td>";
                                            echo "<a href='upload/" . $rowfetch['pro_img'] . "' target='_blank' class='btn btn-primary btn-sm'><i class='fa-regular fa-images'></i>فتح صورة </a>";
                                            echo "</td>";
                                            echo "<td>" . $rowfetch['pro_name'] . "</td>";
                                            echo "<td>" . $rowfetch['pro_id'] . "</td>";
                                        }

                                        ?>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    } elseif ($action == 'Add') { ?>

        <div class="bodyhead">
            <div class="container">
                <header class="headers">ادخل بيانات المنتج </header>
                <form action="?action=Insert" enctype="multipart/form-data" method="POST">
                    <div class="detales personal">
                        <div class="fields">
                            <div class="input-field">
                                <label>أسم القسم</label>
                                <input type="text" placeholder="ادخل اسم المنتج" name="pro_name" required>
                            </div>

                            <div class="input-field">
                                <label>رفع صورةالمنتج</label>
                                <input type="file" name="pro_img" required>
                            </div>

                            <button id="nextbtn">
                                <span class="btntext">حفظ البيانات </span>
                                <i class="fa fa-solid fa-cloud-arrow-up"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php
    } elseif ($action == 'Insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "<h1 class='text-center'> تم أضافة المنتج </h1>";
            echo "<div class='container'>";


            $pro_name    = $_POST['pro_name'];

            $premit_img = $_FILES['pro_img']['name'];
            $file_temp = $_FILES['pro_img']['tmp_name'];
            $file_size = $_FILES['pro_img']['size'];
            $file_type = $_FILES['pro_img']['type'];
            $date_uploaded = date("Y-m-d");
            $location = "upload/" . $premit_img;
            if ($file_size < 5242880) {
                if (copy($file_temp, $location)) {

                    $stmt = $con->prepare("INSERT INTO 
                                            products (pro_name,pro_img,pro_date)
                                        VALUES
                                            (:zpro_name,:zpro_img,now())");
                    $stmt->execute(array(
                        'zpro_name' => $pro_name,
                        'zpro_img' => $premit_img
                    ));

                    $themsg = "Insert Success";
                    redirectHome($themsg, '?action=Manage');
                }
            }
        } else {
            $themsg = 'Sorry You Cant Browes This Page Directly ';
            redirectHome($themsg, 4);
        }
    } elseif ($action == 'edit') {
        $p_Id = isset($_GET['proId']) && is_numeric($_GET['proId']) ? intval($_GET['proId']) : 0;
        //feach the data from database
        $stmt = $con->prepare("SELECT *
        FROM products
                                                    WHERE   
                                                    pro_id  = ?        
                                                ");
        $stmt->execute(array($p_Id));

        $not = $stmt->fetch();

        $count = $stmt->rowCount();
        //check and fetch data
    ?>
        <div class="bodyhead">
            <div class="container">
                <header class="headers">تعديل بيانات المنتج </header>
                <form action="?action=upload" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="proId" value="<?php echo $p_Id; ?>" />
                    <div class="detales personal">

                        <div class="fields">

                            <div class="input-field">
                                <label>أسم المنتج</label>
                                <input type="text" value="<?php echo $not['pro_name'] ?>" placeholder="ادخل اسم المنتج  " name="pro_name" required>
                                
                            </div>

                            <div class="input-field">
                                <label>الصورة السابقة</label><br>
                                <img src="upload/<?php echo $not['pro_img']; ?>" width="150" alt="الصورة الحالية"><br><br> 
                                <input type="file" name="pro_img" required>
                           </div>


                            <button id="nextbtn">
                                <span class="btntext">حفظ بيانات التعديل</span>
                                <i class="fa fa-solid fa-cloud-arrow-up"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


<?php
    } elseif ($action == 'upload') {

        echo "<h1 class='text-center'> تعديل المنتج </h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $proId   = $_POST['proId'];
            $pro_name    = $_POST['pro_name'];

            $premit_img = $_FILES['pro_img']['name'];
            $file_temp = $_FILES['pro_img']['tmp_name'];
            $file_size = $_FILES['pro_img']['size'];
            $file_type = $_FILES['pro_img']['type'];
            $date_uploaded = date("Y-m-d");
            $location = "upload/" . $premit_img;
            if ($file_size < 5242880) {
                    // fetch the old image name
                $stmt = $con->prepare("SELECT pro_img FROM products WHERE pro_id = ?");
                $stmt->execute(array($proId));
                $old_image = $stmt->fetchColumn();

                // delete old image if exists
                if ($old_image && file_exists("upload/" . $old_image)) {
                    unlink("upload/" . $old_image);
                }
                if (copy($file_temp, $location)) {
                    $stmt = $con->prepare("UPDATE 
                products 
            SET 
            pro_name = ?,
            pro_img = ?
            WHERE 
            pro_id  = ?");
                    $stmt->execute(array(
                        $pro_name,
                        $premit_img,
                        $proId
                    ));
                    $themsg = $stmt->rowCount() . ' record update';
                    redirectHome($themsg, "?action=Manage");
                }
            }
        } else {
            $themsg = 'Sorry You Cant Browes This Page Directly ';
            redirectHome($themsg, '?action=Manage', 4);
        }
    } elseif ($action == 'block') {
        echo "<h1 class='text-center'>تم ايقاف المنتج من التطبيق</h1>";

        echo "<div class='container'>";

        //check if userid numeric  & get the integer value of it
        $p_Id = isset($_GET['pId']) && is_numeric($_GET['pId']) ? intval($_GET['pId']) : 0;

        //feach the data from database
        $check = checkitem('pro_id ', 'products', $p_Id);


        //check and fetch data
        if ($check > 0) {

            $stmt = $con->prepare("UPDATE products SET pro_status = 0 WHERE pro_id = ?");

            $stmt->execute(array($p_Id));

            $themsg = $stmt->rowCount() . 'توقيف المنتج';

            redirectHome($themsg, '?action=Manage');
        } else {

            $themsg = "لا تستطيع تصفح هذه الصفحة";
            redirectHome($themsg, '?action=Manage');
        }
        echo "</div>";
    } elseif ($action == 'active') {
        echo "<h1 class='text-center'>تم تفعيل المنتج </h1>";

        echo "<div class='container'>";

        //check if userid numeric  & get the integer value of it
        $p_Id = isset($_GET['pId']) && is_numeric($_GET['pId']) ? intval($_GET['pId']) : 0;

        //feach the data from database
        $check = checkitem('pro_id ', 'products', $p_Id);


        //check and fetch data
        if ($check > 0) {

            $stmt = $con->prepare("UPDATE products SET pro_status = 1 WHERE pro_id = ?");

            $stmt->execute(array($p_Id));

            $themsg = $stmt->rowCount() . 'تم تفعيل المنتج';

            redirectHome($themsg, '?action=Manage');
        } else {

            $themsg = "لا تستطيع تصفح هذه الصفحة";
            redirectHome($themsg, '?action=Manage');
        }
        echo "</div>";
    } elseif ($action == "delete") {

        echo "<h1 class='text-center'>تم حذف المنتج</h1>";
        echo "<div class='container'>";
        //check if userid numeric  & get the integer value of it
        $p_Id = isset($_GET['pId']) && is_numeric($_GET['pId']) ? intval($_GET['pId']) : 0;
        //feach the data from database
        $check = checkitem('pro_id', 'products', $p_Id);
        //check and fetch data
        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM products WHERE pro_id = :zpro_id");

            $stmt->bindparam(":zpro_id", $p_Id);

            $stmt->execute();
          
            $themsg = $stmt->rowCount() . 'تم حذف ';
          
            redirectHome($themsg, "?action=Manage");
          
        } else {

            $themsg = "NO Delete Record";
            // echo "Id". $p_Id;
            redirectHome($themsg, "?action=Manage");
        }
        echo "</div>";
    }
} else {
    header('Location: index.php');
    exit();
}
include 'include/template/footer.php';

?>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="actioncument">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">تأكيد الحذف</h5>
      
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>هل أنت متأكد سيتم حذف جميع المنتجات  </p>
      </div>
      <div class="modal-footer">
     
        <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
      </div>
    </div>
  </div>
</div>