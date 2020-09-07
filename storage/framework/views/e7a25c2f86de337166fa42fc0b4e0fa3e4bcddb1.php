

<?php $__env->startSection('content'); ?>
    <div class="container-fluid-lg">
        <div class="bg-background col-md-12" style="margin-top: -19px">
            <?php echo $__env->make('banque.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row mt-2">
                <div class="col-md-12 col-lg-12">
                    <div class="mt-5">
                        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('responsable.create-card-bank', [])->dom;
} elseif ($_instance->childHasBeenRendered('r2ahh17')) {
    $componentId = $_instance->getRenderedChildComponentId('r2ahh17');
    $componentTag = $_instance->getRenderedChildComponentTagName('r2ahh17');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('r2ahh17');
} else {
    $response = \Livewire\Livewire::mount('responsable.create-card-bank', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('r2ahh17', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
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
    <link rel="stylesheet" href="<?php echo e(asset('css/bancaire.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js_file'); ?>
    <script type="text/javascript">
        $('document').ready(function(){
            $('#save').attr('disabled',true);

            $('#ep').on('click', function(){
                $('#save').attr('disabled',false);
            });

            $('#ct').on('click', function(){
                $('#save').attr('disabled',false);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app',['titre'=>'compte-bancaire'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\BDP\resources\views/banque/bancaire/create.blade.php ENDPATH**/ ?>