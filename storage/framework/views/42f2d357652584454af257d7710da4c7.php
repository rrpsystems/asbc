<?php if (isset($component)) { $__componentOriginal93360b397272e82c601608cfc5cba0d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93360b397272e82c601608cfc5cba0d9 = $attributes; } ?>
<?php $component = TallStackUi\View\Components\Modal::resolve(['title' => 'Detalhes da Chamada','size' => '4xl','persistent' => true,'wire' => 'detailsModal'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\TallStackUi\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="space-y-3 min-h-72">
        <div class="grid grid-cols-3 gap-3">

            <div class="col-span-3">
                <strong class="font-semibold text-gray-900 dark:text-white">Cliente:</strong>
                <?php echo e($details->customer->razaosocial ?? ''); ?>

            </div>

            <div class="col-span-3">
                <strong class="font-semibold text-gray-900 dark:text-white">Operadora:</strong>
                <?php echo e($details->carrier->operadora ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white"><span
                        class="text-strong">Data:</strong></span>
                <?php echo e(date('d/m/Y', strtotime($details->calldate ?? '0'))); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Hora:</strong>
                <?php echo e(date('H:i:s', strtotime($details->calldate ?? '0'))); ?>

            </div>

            <div class="col-span-1">
            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">DID:</strong> <?php echo e($details->did_id ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Numero:</strong>
                <?php echo e($details->numero ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Ramal:</strong> <?php echo e($details->ramal ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Tipo:</strong> <?php echo e($details->tipo ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Tarifa:</strong>
                <?php echo e($details->tarifa ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Disposição:</strong>
                <?php echo e($details->disposition ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Duração:</strong>
                <?php echo e(\Carbon\Carbon::createFromFormat('U', $details->duration ?? '0')->format('H:i:s')); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Tempo Falado:</strong>
                <?php echo e(\Carbon\Carbon::createFromFormat('U', $details->billsec ?? '0')->format('H:i:s')); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Tempo Cobrado:</strong>
                <?php echo e(\Carbon\Carbon::createFromFormat('U', $details->tempo_cobrado ?? '0')->format('H:i:s')); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Valor Compar:</strong> R$
                <?php echo e(number_format($details->valor_compra ?? '0', 2, ',', '.')); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Valor Venda:</strong> R$
                <?php echo e(number_format($details->valor_venda ?? '0', 2, ',', '.')); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Profit:</strong> R$
                <?php echo e(number_format(($details->valor_venda ?? '0') - ($details->valor_compra ?? '0'), 2, ',', '.')); ?>

            </div>


            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Desconexão:</strong>
                <?php echo e($details->desligamento ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Ch. Ocup. Cliente:</strong>
                <?php echo e($details->customer_channels ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Ch. Ocup. Operadora:</strong>
                <?php echo e($details->carrier_channels ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Qualidade TX:</strong>
                <?php echo e($details->mes_tx ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Qualidade RX:</strong>
                <?php echo e($details->mes_rx ?? ''); ?>

            </div>

            <div class="col-span-1">

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">IP SRC:</strong>
                <?php echo e($details->ip_src ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">IP DST:</strong>
                <?php echo e($details->ip_dst ?? ''); ?>

            </div>

            <div class="col-span-1">

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">IP RTP SRC:</strong>
                <?php echo e($details->ip_rtp_src ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">IP RTP DST:</strong>
                <?php echo e($details->ip_rtp_dst ?? ''); ?>

            </div>

            <div class="col-span-1">

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Codec Nativo:</strong>
                <?php echo e($details->codec_nativo ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Codec In:</strong>
                <?php echo e($details->codec_in ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Codec Out:</strong>
                <?php echo e($details->codec_out ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Status:</strong>
                <?php echo e($details->status ?? ''); ?>

            </div>

            <div class="col-span-1">
                <strong class="font-semibold text-gray-900 dark:text-white">Causa ISDN:</strong>
                <?php echo e($details->hangup ?? ''); ?>

            </div>

            <div class="col-span-1">
            </div>

            <div class="col-span-2">
                <strong class="font-semibold text-gray-900 dark:text-white">Gravação:</strong>
                <?php echo e($details->recordingfile ?? ''); ?>

            </div>

            <div class="col-span-1">

            </div>

        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal93360b397272e82c601608cfc5cba0d9)): ?>
<?php $attributes = $__attributesOriginal93360b397272e82c601608cfc5cba0d9; ?>
<?php unset($__attributesOriginal93360b397272e82c601608cfc5cba0d9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal93360b397272e82c601608cfc5cba0d9)): ?>
<?php $component = $__componentOriginal93360b397272e82c601608cfc5cba0d9; ?>
<?php unset($__componentOriginal93360b397272e82c601608cfc5cba0d9); ?>
<?php endif; ?>



<?php /**PATH C:\Users\Rafael Benedicto\Documents\Herd\asbc\resources\views/livewire/cdrs/details.blade.php ENDPATH**/ ?>