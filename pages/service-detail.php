<?php
$serviceId = $_GET['id'] ?? 0;
$service = getServiceById($serviceId);

if (!$service) {
    header('Location: ?page=404');
    exit;
}

// Get related services from same category
$relatedServices = array_filter($services, function($s) use ($service) {
    return $s['category'] === $service['category'] && $s['id'] !== $service['id'];
});
$relatedServices = array_slice($relatedServices, 0, 3);
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">خانه</a></li>
                    <li class="breadcrumb-item"><a href="?page=services">خدمات</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($service['title']); ?></li>
                </ol>
            </nav>
            
            <!-- Service Details -->
            <div class="card">
                <img src="<?php echo $service['image'] ?? 'assets/images/default-service.jpg'; ?>" 
                     class="card-img-top" alt="<?php echo htmlspecialchars($service['title']); ?>"
                     style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="card-title h3 d-flex align-items-center gap-2"><i class="bi bi-lightning-charge text-primary"></i><?php echo htmlspecialchars($service['title']); ?></h1>
                        <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($service['category']); ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span class="text-muted me-2">5.0 (25 نظر)</span>
                        </div>
                    </div>
                    
                    <p class="card-text lead"><?php echo htmlspecialchars($service['description']); ?></p>
                    
                    <!-- Features -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>ویژگی های خدمت</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle text-success me-2"></i> کیفیت تضمینی</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i> تحویل سریع</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i> پشتیبانی 24/7</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i> ضمانت بازگشت وجه</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>مزایای خدمت</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-arrow-left text-primary me-2"></i> افزایش محبوبیت</li>
                                <li><i class="bi bi-arrow-left text-primary me-2"></i> بهبود رتبه بندی</li>
                                <li><i class="bi bi-arrow-left text-primary me-2"></i> جذب مخاطب بیشتر</li>
                                <li><i class="bi bi-arrow-left text-primary me-2"></i> افزایش فروش</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reviews Section -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">نظرات کاربران</h5>
                </div>
                <div class="card-body">
                    <!-- Review Item -->
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="width: 50px; height: 50px;">
                                علی
                            </div>
                        </div>
                        <div class="flex-grow-1 me-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-1">علی احمدی</h6>
                                <small class="text-muted">2 روز پیش</small>
                            </div>
                            <div class="text-warning mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="mb-0">خدمات بسیار عالی و با کیفیت. پشتیبانی فوق العاده سریع و مفید.</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Review Item -->
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="width: 50px; height: 50px;">
                                سارا
                            </div>
                        </div>
                        <div class="flex-grow-1 me-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-1">سارا محمدی</h6>
                                <small class="text-muted">1 هفته پیش</small>
                            </div>
                            <div class="text-warning mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <p class="mb-0">تحویل سریع و کیفیت مناسب. توصیه می کنم.</p>
                        </div>
                    </div>
                    
                    <!-- Add Review Form -->
                    <?php if (isLoggedIn()): ?>
                    <hr>
                    <h6>نظر خود را بنویسید</h6>
                    <form class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label">امتیاز</label>
                            <div class="rating">
                                <input type="radio" name="rating" value="5" id="star5">
                                <label for="star5"><i class="bi bi-star"></i></label>
                                <input type="radio" name="rating" value="4" id="star4">
                                <label for="star4"><i class="bi bi-star"></i></label>
                                <input type="radio" name="rating" value="3" id="star3">
                                <label for="star3"><i class="bi bi-star"></i></label>
                                <input type="radio" name="rating" value="2" id="star2">
                                <label for="star2"><i class="bi bi-star"></i></label>
                                <input type="radio" name="rating" value="1" id="star1">
                                <label for="star1"><i class="bi bi-star"></i></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">نظر</label>
                            <textarea class="form-control" id="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">ارسال نظر</button>
                    </form>
                    <?php else: ?>
                    <div class="text-center py-3">
                        <p>برای ثبت نظر باید <a href="?page=login">وارد حساب کاربری</a> خود شوید</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Purchase Card -->
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body text-center">
                    <div class="price-tag fs-5 mb-3 d-inline-flex align-items-center gap-2"><i class="bi bi-tag"></i><?php echo formatPrice($service['price']); ?></div>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i>
                            تحویل: فوری تا 24 ساعت
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            ضمانت کیفیت
                        </small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg add-to-cart" 
                                data-service-id="<?php echo $service['id']; ?>"
                                data-service-name="<?php echo htmlspecialchars($service['title']); ?>">
                            <i class="bi bi-cart-plus"></i> افزودن به سبد خرید
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-chat-dots"></i> مشاوره رایگان
                        </button>
                    </div>
                    
                    <hr>
                    
                    <!-- Service Stats -->
                    <div class="row text-center">
                        <div class="col">
                            <div class="text-primary fs-4">156</div>
                            <small class="text-muted">فروش</small>
                        </div>
                        <div class="col">
                            <div class="text-success fs-4">5.0</div>
                            <small class="text-muted">امتیاز</small>
                        </div>
                        <div class="col">
                            <div class="text-warning fs-4">25</div>
                            <small class="text-muted">نظر</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Services -->
            <?php if (!empty($relatedServices)): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">خدمات مشابه</h6>
                </div>
                <div class="card-body">
                    <?php foreach ($relatedServices as $related): ?>
                    <div class="d-flex mb-3">
                        <img src="<?php echo $related['image'] ?? 'assets/images/default-service.jpg'; ?>" 
                             class="rounded" width="60" height="60" style="object-fit: cover;">
                        <div class="me-3 flex-grow-1">
                            <h6 class="mb-1">
                                <a href="?page=service&id=<?php echo $related['id']; ?>" 
                                   class="text-decoration-none">
                                    <?php echo htmlspecialchars($related['title']); ?>
                                </a>
                            </h6>
                            <div class="text-primary fw-bold"><?php echo formatPrice($related['price']); ?></div>
                        </div>
                    </div>
                    <?php if ($related !== end($relatedServices)): ?>
                    <hr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.rating {
    direction: ltr;
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating input {
    display: none;
}

.rating label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    transition: color 0.3s;
}

.rating label:hover,
.rating label:hover ~ label,
.rating input:checked ~ label {
    color: #ffc107;
}
</style>
