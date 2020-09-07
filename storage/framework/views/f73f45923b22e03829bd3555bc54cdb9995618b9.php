

<?php $__env->startSection('content'); ?>
 <div class="container-fluid-lg">
    <div class="bg-background col-md-12" style="margin-top: -19px">
        <div class="row justify-content-center">
           
            <?php echo $__env->make('banque.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
            <div class="col-md-8 col-lg-10">
                <div class="card bg-dark text-light">
                    <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('caissier.retrait', [])->dom;
} elseif ($_instance->childHasBeenRendered('Q19dHVa')) {
    $componentId = $_instance->getRenderedChildComponentId('Q19dHVa');
    $componentTag = $_instance->getRenderedChildComponentTagName('Q19dHVa');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Q19dHVa');
} else {
    $response = \Livewire\Livewire::mount('caissier.retrait', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('Q19dHVa', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
                </div>
            </div>
        </div>
    </div>
 </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css_file'); ?>
 <style>
    .overflow-y{
      overflow-y:auto;
      height:250px;
    }
 </style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', ['titre'=>'retrait-compte'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\BDP\resources\views/banque/caissier/operations/retrait.blade.php ENDPATH**/ ?>