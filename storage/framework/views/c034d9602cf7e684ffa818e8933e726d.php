<div class="flex flex-col min-h-[calc(100vh-4rem)] pb-3 pl-6 pr-6 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-100 rounded-md shadow-md shadow-black/5">
    <div x-init="$dispatch('bradcrumb', { menu: ['Gestão', 'Produtos/Serviços'] })"></div>

    <div class="container flex-grow mx-auto">
        <div class="flex flex-col items-center justify-between my-4 sm:flex-row">
            <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200 sm:mb-0">
                Produtos e Serviços por Cliente
            </h3>
        </div>

        <!-- Busca -->
        <div class="mb-6">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar cliente..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200"
            >
        </div>

        <!-- Tabela de Clientes -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Cliente</th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Produtos Ativos</th>
                            <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        <?php echo e($customer->nomefantasia ?? $customer->razaosocial); ?>

                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->nomefantasia && $customer->razaosocial): ?>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            <?php echo e($customer->razaosocial); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full <?php echo e($customer->produtos_ativos_count > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400'); ?>">
                                        <?php echo e($customer->produtos_ativos_count); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="<?php echo e(route('customers.products', $customer->id)); ?>"
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        Gerenciar Produtos
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum cliente encontrado
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="mt-4">
                <?php echo e($customers->links('vendor.livewire.paginate')); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/customers/products/list-customers.blade.php ENDPATH**/ ?>