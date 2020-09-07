

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12 col-lg-12">
                <p class="h3">Formulaire du compte client</p>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        
                         <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('clients.formulaire-client', [])->dom;
} elseif ($_instance->childHasBeenRendered('XFfNYYY')) {
    $componentId = $_instance->getRenderedChildComponentId('XFfNYYY');
    $componentTag = $_instance->getRenderedChildComponentTagName('XFfNYYY');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('XFfNYYY');
} else {
    $response = \Livewire\Livewire::mount('clients.formulaire-client', []);
    $dom = $response->dom;
    $_instance->logRenderedChild('XFfNYYY', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app',['titre'=>'compte-client'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\BDP\resources\views/banque/clients/createCompte.blade.php ENDPATH**/ ?>