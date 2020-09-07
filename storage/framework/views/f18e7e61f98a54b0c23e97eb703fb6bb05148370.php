<div>
    <div class="form-group row mb-3">
        <div class="col-lg-4 mb-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label for="search" class="input-group-text bg-white">
                     <i class="fal fa-search"></i>
                    </label>
                </div>
                <input type="text" wire:model="search_compte" style="border-left:1px solid #fff" class="form-control shadow-none " id="search" placeholder="rechercher un compte">
            </div>
        </div>
            <div class="col-lg-8 text-right">
                <a href="<?php echo e(route('gestion.comptes',['id'=>Auth::user()->id, 'numAgence'=> Auth::user()->numAgence])); ?>" class="text-decoration badge badge-light">voir mes comptes
                      <span>
                          <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-credit-card" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                            <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                        </svg>
                    </span>
                </a>
            </div>
    </div>
    <table class="table table-dark">
        <thead>
            <tr>
                <th class="scope text-center"><i class="far fa-user"></i></th>
                <th class="scope">Identifiant</th>
                <th class="scope">Nom</th>
                <th class="scope">Prenom</th>
                <th class="scope">email</th>
                <th class="scope">adresse</th>
                <th class="scope">Profession</th>
                <th class="scope">Compte</th>

            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                    <td>
                        <?php if($client->avatar !=NULL): ?>
                            <img src="<?php echo e(asset('storage/clients').'/'.Str::substr($client->avatar, 15)); ?>" class="rounded" width="55" alt="">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/avatar.png')); ?>" width="55" alt="">
                        <?php endif; ?>
                    </td>
                    <td>
                        <span ><?php echo e($client->identifiant); ?></span>
                    </td>
                   
                    <td>
                        <span>
                            <?php echo e($client->nom); ?>

                        </span>
                    </td>
                 
                    <td>
                        <span >
                            <?php echo e($client->prenom); ?>

                        </span>
                    </td>
                    <td>
                        <span >
                            <?php echo e($client->email); ?>

                        </span>
                    </td>
                    <td>
                            <span >
                                <?php echo e($client->adresse); ?>

                            </span>
                    </td>
                    <td>
                            <span >
                                <?php echo e($client->profession); ?>

                            </span>
                    </td>
                        <td>
                            <?php if($this->takeAccount($client->id) !=null): ?>
                                <p style="color:orange"><?php echo e($this->takeAccount($client->id)['numCompte']); ?></p>
                            <?php endif; ?>
                        </td>
                </tr>  
                
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH C:\laragon\www\BDP\resources\views/livewire/responsable/show-client.blade.php ENDPATH**/ ?>