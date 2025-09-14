<?php
$services = loadServices();
$id = intval($_GET['id'] ?? 0);
$service = getServiceById($id);
$error='';$success='';
if(!$service){
    echo '<div class="alert alert-danger">خدمت یافت نشد</div>';
    return;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=sanitize($_POST['title']??'');
    $description=sanitize($_POST['description']??'');
    $price=intval($_POST['price']??0);
    $category=sanitize($_POST['category']??'');
    $status=$_POST['status']??'active';
    if(empty($title)||empty($description)||empty($category)||$price<=0){
        $error='همه فیلدهای اجباری را پر کنید';
    }else{
        foreach($services as &$s){
            if($s['id']==$id){
                $s['title']=$title;
                $s['description']=$description;
                $s['price']=$price;
                $s['category']=$category;
                $s['status']=$status;
                $s['updated_at']=date('Y-m-d H:i:s');
                break;
            }
        }
        if(saveServices($services)){$success='با موفقیت ذخیره شد'; $service=getServiceById($id);}else{$error='خطا در ذخیره';}
    }
}
?>

<div class="d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-pencil-square text-primary" style="font-size: 1.5rem;"></i>
    <h2 class="mb-0">ویرایش خدمت</h2>
</div>

<?php if($error):?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
<?php if($success):?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">عنوان *</label>
                        <input class="form-control" name="title" value="<?php echo htmlspecialchars($service['title']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">توضیحات *</label>
                        <textarea class="form-control" rows="4" name="description" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">قیمت *</label>
                            <input type="number" class="form-control" name="price" value="<?php echo $service['price']; ?>" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">دسته بندی *</label>
                            <input class="form-control" name="category" value="<?php echo htmlspecialchars($service['category']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">وضعیت</label>
                        <select class="form-select" name="status">
                            <option value="active" <?php echo $service['status']==='active'?'selected':''; ?>>فعال</option>
                            <option value="inactive" <?php echo $service['status']==='inactive'?'selected':''; ?>>غیرفعال</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit"><i class="bi bi-check"></i> ذخیره</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <img src="<?php echo $service['image'] ?? '../assets/images/default-service.jpg'; ?>" class="img-fluid rounded mb-3">
                <p class="text-muted mb-0">شناسه: #<?php echo $service['id']; ?></p>
                <p class="text-muted">ایجاد: <?php echo date('Y/m/d', strtotime($service['created_at'])); ?></p>
            </div>
        </div>
    </div>
</div>


