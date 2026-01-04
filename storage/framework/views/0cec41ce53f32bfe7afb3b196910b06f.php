<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasPages()): ?>

        <div class="flex flex-col items-center justify-between mt-6 md:flex-row">
            <div class="mb-2 text-sm text-gray-700 dark:text-gray-400 sm:mb-0">
                <span><?php echo __('Showing'); ?></span>
                <span class="font-medium"><?php echo e($paginator->firstItem()); ?></span>
                <span><?php echo __('to'); ?></span>
                <span class="font-medium"><?php echo e($paginator->lastItem()); ?></span>
                <span><?php echo __('of'); ?></span>
                <span class="font-medium"><?php echo e($paginator->total()); ?></span>
                <span><?php echo __('results'); ?></span>
            </div>

            <div class="mb-2 text-sm text-gray-700 dark:text-gray-400 sm:mb-0">
                <label class="inline-flex items-center cursor-pointer">
                    <span class="block">
                        <select wire:model.live="perPage" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm pl-3 pr-8 py-1.5 focus:outline-none focus:ring-2 focus:ring-cyan-500 appearance-auto">
                            <option value="8">8</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                        </select>
                    </span>
                    <span
                        class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300"><?php echo __('Itens'); ?></span>
                </label>
            </div>

            <div class="mb-1 space-x-2 sm:mb-0">
                <nav aria-label="Page navigation example">
                    <ul class="flex items-center h-8 -space-x-px text-sm">
                        <li>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->onFirstPage()): ?>
                                <button disabled
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 ms-0 border-e-0 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                </button>
                            <?php else: ?>
                                <button wire:click="previousPage('<?php echo e($paginator->getPageName()); ?>')"
                                    dusk="previousPage<?php echo e($paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName()); ?>.after"
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 ms-0 border-e-0 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </li>

                        <?php
                            // Quantidade de páginas a mostrar antes e depois da página atual
                            $sidePages = 2;
                            $currentPage = $paginator->currentPage();
                            $lastPage = $paginator->lastPage();
                        ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentPage > $sidePages + 1): ?>
                            <li>
                                <button wire:click="gotoPage(1)"
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</button>
                                
                            </li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentPage > $sidePages + 2): ?>
                                <li>
                                    <button disabled
                                        class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 ">...</button>
                                </li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = max(1, $currentPage - $sidePages); $i <= min($currentPage + $sidePages, $lastPage); $i++): ?>
                            <li>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i == $currentPage): ?>
                                    <button aria-current="page" disabled
                                        class="z-10 flex items-center justify-center h-8 px-3 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"><?php echo e($i); ?></button>
                                <?php else: ?>
                                    <button wire:click="gotoPage(<?php echo e($i); ?>)"
                                        class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?php echo e($i); ?></button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </li>
                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentPage < $lastPage - $sidePages): ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentPage < $lastPage - $sidePages - 1): ?>
                                <li>
                                    <button disabled
                                        class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">...</button>
                                </li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <li>
                                <button wire:click="gotoPage(<?php echo e($lastPage); ?>)"
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?php echo e($lastPage); ?></button>
                            </li>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                        
                        <li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasMorePages()): ?>
                                <button wire:click="nextPage('<?php echo e($paginator->getPageName()); ?>')"
                                    dusk="nextPage<?php echo e($paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName()); ?>.after"
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                </button>
                            <?php else: ?>
                                <button disabled
                                    class="flex items-center justify-center h-8 px-3 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-between mt-6 md:flex-row">
            <div class="mb-2 text-sm text-gray-700 dark:text-gray-400 sm:mb-0">
                <span><?php echo __('Showing'); ?></span>
                <span class="font-medium"><?php echo e($paginator->firstItem()); ?></span>
                <span><?php echo __('to'); ?></span>
                <span class="font-medium"><?php echo e($paginator->lastItem()); ?></span>
                <span><?php echo __('of'); ?></span>
                <span class="font-medium"><?php echo e($paginator->total()); ?></span>
                <span><?php echo __('results'); ?></span>
            </div>

            <div class="mb-2 text-sm text-gray-700 dark:text-gray-400 sm:mb-0">
                <label class="inline-flex items-center cursor-pointer">
                    <span class="block">
                        <select wire:model.live="perPage" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm pl-3 pr-8 py-1.5 focus:outline-none focus:ring-2 focus:ring-cyan-500 appearance-auto">
                            <option value="8">8</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                        </select>
                    </span>
                    <span
                        class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300"><?php echo __('Itens'); ?></span>
                </label>
            </div>

            <div class="mb-1 space-x-2 sm:mb-0">
                <nav aria-label="Page navigation example">
                    <ul class="flex items-center h-8 -space-x-px text-sm">

                    </ul>
                </nav>

            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/vendor/livewire/paginate.blade.php ENDPATH**/ ?>