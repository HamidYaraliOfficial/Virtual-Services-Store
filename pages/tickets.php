<?php
requireLogin();

$error = '';
$success = '';
$tickets = loadTickets();
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    if (empty($subject) || empty($message)) {
        $error = 'تمام فیلدها اجباری هستند';
    } else {
        $new = [
            'id' => generateId($tickets),
            'user_id' => $userId,
            'subject' => $subject,
            'message' => $message,
            'status' => 'open',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $tickets[] = $new;
        if (saveTickets($tickets)) {
            $success = 'تیکت با موفقیت ثبت شد';
        } else {
            $error = 'خطا در ثبت تیکت';
        }
    }
}

$myTickets = array_values(array_filter($tickets, function($t) use ($userId) { return $t['user_id'] == $userId; }));
usort($myTickets, function($a, $b) { return strtotime($b['created_at']) - strtotime($a['created_at']); });
?>

<div class="container py-5">
    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="bi bi-chat-dots text-primary" style="font-size: 1.5rem;"></i>
        <h2 class="mb-0">تیکت ها</h2>
    </div>

    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>

    <div class="row">
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center gap-2"><i class="bi bi-plus-circle text-primary"></i><h6 class="mb-0">ارسال تیکت جدید</h6></div>
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate>
                        <?php echo csrfInput(); ?>
                        <div class="mb-3">
                            <label class="form-label">موضوع</label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">پیام</label>
                            <textarea class="form-control" rows="4" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> ارسال</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2"><i class="bi bi-inbox text-primary"></i><h6 class="mb-0">تیکت های شما</h6></div>
                <div class="card-body">
                    <?php if (empty($myTickets)): ?>
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <h6 class="text-muted mt-3">تیکتی ثبت نشده است</h6>
                    </div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>کد</th>
                                    <th>موضوع</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($myTickets as $t): ?>
                                <tr>
                                    <td>#<?php echo $t['id']; ?></td>
                                    <td><?php echo htmlspecialchars($t['subject']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $t['status'] === 'open' ? 'warning' : 'success'; ?>">
                                            <?php echo $t['status'] === 'open' ? 'باز' : 'بسته'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('Y/m/d H:i', strtotime($t['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


