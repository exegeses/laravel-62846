<?php $__env->startSection('contenido'); ?>

    <h1 class="mb-4">Baja de una marca</h1>

    <div class="alert shadow text-danger col-6 mx-auto p-4">

        Se eliminará la marca:
        <span class="lead">
                <?php echo e($Marca->mkNombre); ?>

            </span>
        <form action="/marca/destroy" method="post">
        <?php echo method_field('delete'); ?>
        <?php echo csrf_field(); ?>
            <input type="hidden" name="mkNombre"
                   value="<?php echo e($Marca->mkNombre); ?>">
            <input type="hidden" name="idMarca"
                   value="<?php echo e($Marca->idMarca); ?>">
            <button class="btn btn-danger btn-block my-3">
                Confirmar baja
            </button>
            <a href="/marcas" class="btn btn-light btn-block">
                volver a panel
            </a>
        </form>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marcos/Documents/Cursos/Laravel/laravel-62846/catalogo/resources/views/marcaDelete.blade.php ENDPATH**/ ?>