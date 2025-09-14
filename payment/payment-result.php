<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتیجه پرداخت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-body text-center p-5">
                        <?php if (isset($success) && $success): ?>
                        <!-- Success -->
                        <div class="text-success mb-4">
                            <i class="bi bi-check-circle" style="font-size: 5rem;"></i>
                        </div>
                        <h2 class="text-success mb-3">پرداخت موفق</h2>
                        <p class="lead mb-4"><?php echo $successMessage; ?></p>
                        
                        <div class="bg-light rounded p-4 mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <strong>شماره سفارش:</strong>
                                </div>
                                <div class="col-6">
                                    #<?php echo $orderId; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>شماره پیگیری:</strong>
                                </div>
                                <div class="col-6">
                                    <?php echo $refId ?? 'نامشخص'; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>مبلغ پرداخت شده:</strong>
                                </div>
                                <div class="col-6">
                                    <?php echo formatPrice($order['total']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>تاریخ پرداخت:</strong>
                                </div>
                                <div class="col-6">
                                    <?php echo date('Y/m/d H:i'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            سفارش شما در حال پردازش است و به زودی تحویل داده خواهد شد.
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="../index.php?page=dashboard" class="btn btn-primary btn-lg">
                                <i class="bi bi-speedometer2"></i> مشاهده داشبورد
                            </a>
                            <a href="../index.php" class="btn btn-outline-secondary">
                                <i class="bi bi-house"></i> بازگشت به خانه
                            </a>
                        </div>
                        
                        <?php else: ?>
                        <!-- Error -->
                        <div class="text-danger mb-4">
                            <i class="bi bi-x-circle" style="font-size: 5rem;"></i>
                        </div>
                        <h2 class="text-danger mb-3">پرداخت ناموفق</h2>
                        <p class="lead mb-4"><?php echo $error ?? 'خطای نامشخص در پردازش پرداخت'; ?></p>
                        
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            در صورت کسر وجه از حساب شما، مبلغ تا 72 ساعت آینده بازگردانده خواهد شد.
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="../index.php?page=checkout" class="btn btn-primary btn-lg">
                                <i class="bi bi-arrow-clockwise"></i> تلاش مجدد
                            </a>
                            <a href="../index.php?page=cart" class="btn btn-outline-secondary">
                                <i class="bi bi-cart"></i> بازگشت به سبد خرید
                            </a>
                            <a href="../index.php" class="btn btn-outline-secondary">
                                <i class="bi bi-house"></i> بازگشت به خانه
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Support Card -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <h6>نیاز به کمک دارید؟</h6>
                        <p class="small text-muted mb-3">تیم پشتیبانی ما آماده کمک به شما هستند</p>
                        <div class="d-grid gap-2 d-md-block">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-chat-dots"></i> چت آنلاین
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-whatsapp"></i> واتساپ
                            </a>
                            <a href="mailto:support@shop.com" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-envelope"></i> ایمیل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
