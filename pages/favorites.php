<?php
requireLogin();

// Simple placeholder for favorites (can be extended later)
$favorites = $_SESSION['favorites'] ?? [];
?>

<style>
    .premium-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .premium-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
    }
    
    .btn-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .btn-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-premium:hover::before {
        left: 100%;
    }
    
    .service-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>

<div class="container mx-auto px-4 py-8 mt-20">
    <div class="flex items-center gap-3 mb-8">
        <div class="text-red-600">
            <?php echo getIcon('heart', 32); ?>
        </div>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-red-500 to-pink-600 bg-clip-text text-transparent">علاقه‌مندی‌ها</h2>
    </div>

    <div class="premium-card hover-lift rounded-2xl overflow-hidden">
        <div class="p-6">
            <?php if (empty($favorites)): ?>
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <?php echo getIcon('heart', 48); ?>
                </div>
                <h6 class="text-xl font-semibold text-gray-600 mb-2">مورد علاقه‌ای ثبت نشده است</h6>
                <p class="text-gray-500 mb-6">هنوز هیچ خدمتی را به علاقه‌مندی‌ها اضافه نکرده‌اید</p>
                <a href="?page=services" class="btn-premium text-white px-8 py-3 rounded-2xl font-semibold hover-lift shadow-lg">
                    مشاهده خدمات
                </a>
            </div>
            <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($favorites as $serviceId): ?>
                <?php $service = getServiceById($serviceId); if (!$service) continue; ?>
                <div class="service-card rounded-2xl overflow-hidden">
                    <div class="aspect-video bg-gradient-to-br from-blue-400 to-purple-500 relative overflow-hidden">
                        <img src="<?php echo $service['image'] ?? 'assets/images/default-service.jpg'; ?>" 
                             class="w-full h-full object-cover" 
                             alt="<?php echo htmlspecialchars($service['title']); ?>">
                        <div class="absolute top-4 right-4">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white">
                                <?php echo getIcon('heart', 16); ?>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h5 class="text-lg font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($service['title']); ?></h5>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo htmlspecialchars($service['description']); ?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600"><?php echo formatPrice($service['price']); ?></span>
                            <a class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-xl font-medium transition-colors" 
                               href="?page=service-detail&id=<?php echo $service['id']; ?>">
                                مشاهده
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


