<div wire:poll.30s="loadCounts" class="relative">
    <a href="/alerts"
        class="relative flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 transition-colors rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
            <!-- Critical Badge (Red) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($criticalCount > 0): ?>
                <span
                    class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full animate-pulse">
                    <?php echo e($criticalCount > 9 ? '9+' : $criticalCount); ?>

                </span>
            <?php else: ?>
                <!-- Other Alerts Badge (Orange) -->
                <span
                    class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-orange-500 rounded-full">
                    <?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?>

                </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </a>
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/alerts/notification.blade.php ENDPATH**/ ?>