<?php
ob_start();
session_start();
if (isset($_SESSION['Sessionid'])) {

    $pagetitle = "الاعلانات";

    include 'init.php';

    $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';

    if ($action == "Manage") {

        $stmt = $con->prepare("SELECT *
        FROM banners
        
        where ban_status=1
       

      ORDER BY ban_id   DESC
        
      ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
?>
        <div class="container">
            <div class="row">
                <div class="col-med-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3><a href="?action=Add" class="btn btn-primary"> <i class="fa fa-plus"></i> أضافة قسم </a></h3>

                            <h3 style="direction: rtl;">بيانات الأقسام </h3>
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
                                        <td>أسم الاعلان</td>
                                        <td>رقم الاعلان</td>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <?php
                                        foreach ($rows as $rowfetch) {
                                            echo "<tr>";
                                            echo "<td>";
                                        ?>
                    
                                            <a href="?action=edit&banId=<?php echo $rowfetch['ban_id']  ?>" class="btn btn-success btn-sm">تعديل <i class="fa fa-edit"></i></a>
                                            <a href="?action=delete&pId=<?php echo $rowfetch['ban_id']  ?>" class="btn btn-danger btn-sm confirm">حذف <i class="fa fa-close"></i></a>
                                            <?php if ($rowfetch['ban_status'] == 1) {

                                            ?>
                                                <a href="?action=block&pId=<?php echo $rowfetch['ban_id']  ?>" class="btn btn-danger btn-sm">توقيف <i class="fa fa-hand-stop-o"></i></a>
                                            <?php } else { ?>
                                                <a href="?action=active&pId=<?php echo $rowfetch['ban_id']  ?>" class="btn btn-primary btn-sm">تفعيل <i class="fa fa-active"></i></a>
                                            <?php } ?>
                                            </td>
                                        <?php
                                            echo "<td>";
                                            echo "<a href='upload/" . $rowfetch['ban_img'] . "' target='_blank' class='btn btn-primary btn-sm'><i class='fa-regular fa-images'></i>فتح صورة </a>";
                                            echo "</td>";
                                            echo "<td>" . $rowfetch['ban_name'] . "</td>";
                                            echo "<td>" . $rowfetch['ban_id'] . "</td>";
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
                <header class="headers">ادخل بيانات الاعلان </header>
                <form action="?action=Insert" enctype="multipart/form-data" method="POST">
                    <div class="detales personal">
                        <div class="fields">
                            <div class="input-field">
                                <label>أسم الاعلان</label>
                                <input type="text" placeholder="ادخل اسم الاعلان  " name="ban_name" required>
                            </div>

                            <div class="input-field">
                                <label>رفع صورة الاعلان</label>
                                <input type="file" name="ban_img" required>
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
            echo "<h1 class='text-center'> تم أضافة الاعلان </h1>";
            echo "<div class='container'>";


            $ban_name    = $_POST['ban_name'];

            $premit_img = $_FILES['ban_img']['name'];
            $file_temp = $_FILES['ban_img']['tmp_name'];
            $file_size = $_FILES['ban_img']['size'];
            $file_type = $_FILES['ban_img']['type'];
            $date_uploaded = date("Y-m-d");
            $location = "upload/" . $premit_img;
            if ($file_size < 5242880) {
                if (copy($file_temp, $location)) {

                    $stmt = $con->prepare("INSERT INTO 
                                            banners(ban_name,ban_img,ban_date)
                                        VALUES
                                            (:zban_name,:zban_img,now())");
                    $stmt->execute(array(
                        'zban_name' => $ban_name,
                        'zban_img' => $premit_img
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
        $p_Id = isset($_GET['banId']) && is_numeric($_GET['banId']) ? intval($_GET['banId']) : 0;
        //feach the data from database
        $stmt = $con->prepare("SELECT *
        FROM banners
                                                    WHERE   
                                                    ban_id  = ?        
                                                ");
        $stmt->execute(array($p_Id));

        $not = $stmt->fetch();

        $count = $stmt->rowCount();
        //check and fetch data
    ?>
        <div class="bodyhead">
            <div class="container">
                <header class="headers">تعديل بيانات الاعلان </header>
                <form action="?action=upload" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="banId" value="<?php echo $p_Id; ?>" />
                    <div class="detales personal">

                        <div class="fields">

                            <div class="input-field">
                                <label>أسم الاعلان</label>
                                <input type="text" value="<?php echo $not['ban_name'] ?>" placeholder="ادخل اسم الاعلان  " name="ban_name" required>
                                
                            </div>

                            <div class="input-field">
                               <label>الصورة السابقة</label><br>
                                <img src="upload/<?php echo $not['ban_img']; ?>" width="150" alt="الصورة الحالية"><br><br>
                                <input type="file" name="ban_img" required>
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

        echo "<h1 class='text-center'> تعديل الاعلان </h1>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $banId   = $_POST['banId'];
            $ban_name    = $_POST['ban_name'];

            $premit_img = $_FILES['ban_img']['name'];
            $file_temp = $_FILES['ban_img']['tmp_name'];
            $file_size = $_FILES['ban_img']['size'];
            $file_type = $_FILES['ban_img']['type'];
            $date_uploaded = date("Y-m-d");
            $location = "upload/" . $premit_img;
            if ($file_size < 5242880) {
                    // fetch the old image name
                $stmt = $con->prepare("SELECT ban_img FROM banners WHERE ban_id = ?");
                $stmt->execute(array($banId));
                $old_image = $stmt->fetchColumn();

                // delete old image if exists
                if ($old_image && file_exists("upload/" . $old_image)) {
                    unlink("upload/" . $old_image);
                }
                if (copy($file_temp, $location)) {
                    $stmt = $con->prepare("UPDATE 
            banners 
        SET 
        ban_name = ?,
        ban_img = ?
        WHERE 
        ban_id  = ?");
                    $stmt->execute(array(
                        $ban_name,
                        $premit_img,
                        $banId
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
        echo "<h1 class='text-center'>تم ايقاف الاعلان من التطبيق</h1>";

        echo "<div class='container'>";

        //check if userid numeric  & get the integer value of it
        $p_Id = isset($_GET['pId']) && is_numeric($_GET['pId']) ? intval($_GET['pId']) : 0;

        //feach the data from database
        $check = checkitem('ban_id ', 'banners', $p_Id);


        //check and fetch data
        if ($check > 0) {

            $stmt = $con->prepare("UPDATE banners SET ban_status = 0 WHERE ban_id = ?");

            $stmt->execute(array($p_Id));

            $themsg = $stmt->rowCount() . 'توقيف الاعلان';

            redirectHome($themsg, '?action=Manage');
        } else {

            $themsg = "لا تستطيع تصفح هذه الصفحة";
            redirectHome($themsg, '?action=Manage');
        }
        echo "</div>";
    } elseif ($action == 'active') {
        echo "<h1 class='text-center'>تم تفعيل الاعلان </h1>";

        echo "<div class='container'>";

        //check if userid numeric  & get the integer value of it
        $p_Id = isset($_GET['pId']) && is_numeric($_GET['pId']) ? intval($_GET['pId']) : 0;

        //feach the data from database
        $check = checkitem('ban_id ', 'banners', $p_Id);


        //check and fetch data
        if ($check > 0) {

            $stmt = $con->prepare("UPDATE banners SET ban_status = 1 WHERE ban_id = ?");

            $stmt->execute(array($p_Id));

            $themsg = $stmt->rowCount() . 'تم تفعيل الاعلان';

            redirectHome($themsg, '?action=Manage');
        } else {

            $themsg = "لا تستطيع تصفح هذه الصفحة";
            redirectHome($themsg, '?action=Manage');
        }
        echo "</div>";
    } elseif ($action == "delete") {

        echo "<h1 class='text-center'>تم حذف الاعلان</h1>";
        echo "<div class='container'>";
        //check if userid numeric  & get the integer value of it
        $p_Id = isset($_GET['pId']) && is_numeric($_GET['pId']) ? intval($_GET['pId']) : 0;
        //feach the data from database
        $check = checkitem('ban_id', 'banners', $p_Id);
        //check and fetch data
        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM banners WHERE ban_id = :zban_id");

            $stmt->bindparam(":zban_id", $p_Id);

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
        <p>هل أنت متأكد سيتم حذف جميع الاعلانات</p>
      </div>
      <div class="modal-footer">
     
        <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
      </div>
    </div>
  </div>
</div>