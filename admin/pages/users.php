<?php
$users = loadUsers();

// Handle actions
$error='';$success='';
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $action=$_POST['action']??'';
    $userId=intval($_POST['user_id']??0);
    if($action==='toggle_status' && $userId>0){
        foreach($users as &$u){
            if($u['id']==$userId && $u['role']!=='admin'){
                $u['status']=$u['status']==='active'?'inactive':'active';
                break;
            }
        }
        if(saveUsers($users)){$success='وضعیت کاربر تغییر کرد';}else{$error='خطا در ذخیره تغییرات';}
    }
}

?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div class="flex items-center gap-3">
        <div class="text-blue-600">
            <?php echo getIcon('user', 32); ?>
        </div>
        <h2 class="text-3xl font-bold text-gradient">مدیریت کاربران</h2>
    </div>
</div>

<?php if($error):?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
    <?php echo $error; ?>
</div>
<?php endif; ?>

<?php if($success):?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
    <?php echo $success; ?>
</div>
<?php endif; ?>

<div class="premium-card hover-lift rounded-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
        <h5 class="text-white font-bold text-lg">لیست کاربران</h5>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-right py-4 px-4 font-bold text-gray-800">#</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">نام کاربری</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">ایمیل</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">نقش</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">وضعیت</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">تاریخ عضویت</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-800">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach($users as $u): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4 font-semibold text-blue-600"><?php echo $u['id']; ?></td>
                        <td class="py-4 px-4 font-semibold text-gray-800"><?php echo htmlspecialchars($u['username']); ?></td>
                        <td class="py-4 px-4 text-gray-600"><?php echo htmlspecialchars($u['email']); ?></td>
                        <td class="py-4 px-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $u['role']==='admin'?'bg-gray-800 text-white':'bg-gray-200 text-gray-800'; ?>">
                                <?php echo $u['role']==='admin'?'مدیر':'کاربر'; ?>
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo $u['status']==='active'?'bg-green-100 text-green-800':'bg-red-100 text-red-800'; ?>">
                                <?php echo $u['status']==='active'?'فعال':'غیرفعال'; ?>
                            </span>
                        </td>
                        <td class="py-4 px-4 text-gray-700"><?php echo date('Y/m/d', strtotime($u['created_at'])); ?></td>
                        <td class="py-4 px-4">
                            <?php if($u['role']!=='admin'): ?>
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="toggle_status">
                                <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                <button class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors" type="submit" title="تغییر وضعیت">
                                    <?php echo getIcon('settings', 16); ?>
                                </button>
                            </form>
                            <?php else: ?>
                            <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


