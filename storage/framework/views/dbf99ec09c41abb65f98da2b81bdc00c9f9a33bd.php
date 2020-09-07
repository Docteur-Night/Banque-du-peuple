
<div>
      <form enctype="multipart/form-data">
            <div class="form-group row ml-3"> 
                <div  class="col-md-3 col-lg-3">  
                    <?php if($avatar): ?>
                        <img src="<?php echo e($avatar->temporaryUrl()); ?>" width="100" class="rounded" alt="">
                    <?php else: ?>
                        <img src="<?php echo e(asset('images/avatar.png')); ?>" width="70" alt="">
                    <?php endif; ?>              
                        <input type="file" wire:model="avatar" id="avatar" accept="jpg, jpeg, png" hidden>
                        <label for="avatar"><a role="button" class="btn btn-secondary btn-sm rounded-circle text-light" style="font-size:20px"><i class="fas fa-camera"></i></a></label>
                </div>
                    <div class="col-md-9 col-lg-9">
                        <ul type="none" class="d-block mr-5">
                        <p class="font-weight-bold">Mon compte</p>
                            <li class="mb-2"><b>Nom:</b><?php echo e(Auth::user()->nom); ?></li>
                            <li class="mb-2"><b>Prenom:</b> <?php echo e(Auth::user()->prenom); ?></li>
                            <li><b>ID:</b> <?php echo e(Auth::user()->identifiant); ?></li>
                        </ul>
                    </div>
            </div>
            <div class="form-group row">
                <div class="offset-lg-4">
                    <button class="btn btn-success btn-sm">Confirmer</button>
                </div>
            </div>
        </form> 
</div> 

<?php /**PATH C:\laragon\www\BDP\resources\views/livewire/avatar.blade.php ENDPATH**/ ?>