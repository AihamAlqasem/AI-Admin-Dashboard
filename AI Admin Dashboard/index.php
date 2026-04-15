<?php
session_start();
include 'init.php'; // تأكد أن هذا الملف يحتوي على الاتصال بقاعدة البيانات $con

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // استلام البيانات من النموذج
    $phones = $_POST['phones'];
    $pass = $_POST['password'];

    // التحقق من وجود المستخدم في جدول users
    $stmt = $con->prepare("SELECT * FROM users WHERE phones = ? AND password = ? LIMIT 1");
    $stmt->execute([$phones, $pass]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // تسجيل الجلسة
        $_SESSION['Sessionid'] = $user['user_id']; // تأكد أن لديك حقل user_id في الجدول
        header('Location: dashboard.php');
        exit();
    } else {
        // رسالة خطأ عند عدم تطابق البيانات
        echo '<script>alert("رقم الهاتف أو كلمة المرور غير صحيحة!");</script>';
    }
}
?>

<!-- نموذج تسجيل الدخول -->
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container" style="direction: rtl;">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">تسجيل الدخول</h3>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputPhone" autocomplete="off" type="text" placeholder="+967*********" name="phones" required />
                                        <label for="inputPhone">رقم الهاتف</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputPassword" autocomplete="off" type="password" placeholder="كلمة المرور" name="password" required />
                                        <label for="inputPassword">كلمة السر</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                        <label class="form-check-label" for="inputRememberPassword">تذكر كلمة السر</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
