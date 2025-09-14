<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $price = intval($_POST['price'] ?? 0);
    $category = sanitize($_POST['category'] ?? '');
    $status = $_POST['status'] ?? 'active';
    
    // Validation
    if (empty($title) || empty($description) || empty($category)) {
        $error = 'لطفا تمام فیلدهای اجباری را پر کنید';
    } elseif ($price <= 0) {
        $error = 'قیمت باید بیشتر از صفر باشد';
    } else {
        $services = loadServices();
        
        $newService = [
            'id' => generateId($services),
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'category' => $category,
            'image' => 'assets/images/default-service.jpg', // Default image
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $services[] = $newService;
        
        if (saveServices($services)) {
            $success = 'خدمت جدید با موفقیت اضافه شد';
            // Clear form
            $title = $description = $category = '';
            $price = 0;
        } else {
            $error = 'خطا در ذخیره خدمت';
        }
    }
}

// Get existing categories for dropdown
$services = loadServices();
$existingCategories = array_unique(array_column($services, 'category'));
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>افزودن خدمت جدید</h2>
    <a href="?page=services" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-right"></i> بازگشت به لیست
    </a>
</div>

<?php if ($error): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان خدمت *</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($title ?? ''); ?>" 
                               placeholder="مثال: افزایش فالوور اینستاگرام" required>
                        <div class="invalid-feedback">
                            عنوان خدمت اجباری است
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">توضیحات *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" 
                                  placeholder="توضیحات کامل درباره خدمت..." required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                        <div class="invalid-feedback">
                            توضیحات اجباری است
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">قیمت (تومان) *</label>
                            <input type="number" class="form-control" id="price" name="price" 
                                   value="<?php echo $price ?? ''; ?>" 
                                   placeholder="50000" min="1" required>
                            <div class="invalid-feedback">
                                قیمت اجباری است و باید بیشتر از صفر باشد
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">دسته بندی *</label>
                            <input type="text" class="form-control" id="category" name="category" 
                                   value="<?php echo htmlspecialchars($category ?? ''); ?>" 
                                   placeholder="اینستاگرام" list="categories" required>
                            <datalist id="categories">
                                <?php foreach ($existingCategories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat); ?>">
                                <?php endforeach; ?>
                            </datalist>
                            <div class="invalid-feedback">
                                دسته بندی اجباری است
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">وضعیت</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" <?php echo ($status ?? 'active') === 'active' ? 'selected' : ''; ?>>فعال</option>
                            <option value="inactive" <?php echo ($status ?? 'active') === 'inactive' ? 'selected' : ''; ?>>غیرفعال</option>
                        </select>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> ذخیره خدمت
                        </button>
                        <a href="?page=services" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i> انصراف
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">راهنمای افزودن خدمت</h6>
            </div>
            <div class="card-body">
                <h6>نکات مهم:</h6>
                <ul class="small">
                    <li>عنوان خدمت باید واضح و مفهوم باشد</li>
                    <li>توضیحات کامل و دقیق ارائه دهید</li>
                    <li>قیمت را به تومان وارد کنید</li>
                    <li>دسته بندی مناسب انتخاب کنید</li>
                    <li>می توانید خدمت را ابتدا غیرفعال کنید</li>
                </ul>
                
                <hr>
                
                <h6>دسته بندی های موجود:</h6>
                <div class="d-flex flex-wrap gap-1">
                    <?php foreach ($existingCategories as $cat): ?>
                    <span class="badge bg-light text-dark"><?php echo htmlspecialchars($cat); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-body text-center">
                <i class="bi bi-lightbulb text-warning fs-1 mb-3"></i>
                <h6>نیاز به کمک؟</h6>
                <p class="small text-muted">
                    برای راهنمایی بیشتر با پشتیبانی تماس بگیرید
                </p>
            </div>
        </div>
    </div>
</div>
