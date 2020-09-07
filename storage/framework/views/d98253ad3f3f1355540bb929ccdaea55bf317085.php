<?php $__env->startComponent('mail::message'); ?>
# Reçu de <?php echo e($typeOperation); ?>


Salut <?php echo e($client['prenom'].' '.$client['nom']); ?>, votre recu de <?php echo e($typeOperation); ?> a été rédigé avec succès, veuillez donc consulter le recu.

<?php $__env->startComponent('mail::button', ['url' => 'http://127.0.0.1:1000/recu-pdf']); ?>
Voir le reçu
<?php if (isset($__componentOriginalb8f5c8a6ad1b73985c32a4b97acff83989288b9e)): ?>
<?php $component = $__componentOriginalb8f5c8a6ad1b73985c32a4b97acff83989288b9e; ?>
<?php unset($__componentOriginalb8f5c8a6ad1b73985c32a4b97acff83989288b9e); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
Merci de votre fidélité,<br>
<?php echo e(config('app.name')); ?>

<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\BDP\resources\views/email/sms.blade.php ENDPATH**/ ?>