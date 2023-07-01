<?php $__env->startSection('contenido'); ?>

        <h1>Baja de un producto</h1>

        <article class="card border-danger py-3 col-6 mx-auto">
            <div class="row">
                <div class="col">
                    <img src="/imagenes/productos/noDisponible.png" class="img-thumbnail">
                </div>
                <div class="col text-danger">
                    <h2><?php echo e($Producto->prdNombre); ?></h2>
                    <?php echo e($Producto->getMarca->mkNombre); ?> |
                    <?php echo e($Producto->getCategoria->catNombre); ?>

                    <br>
                    $<?php echo e($Producto->prdPrecio); ?>

                    <br>

                    <form action="" method="post">
                        <input type="hidden" name="idProducto"
                               value="<?php echo e('idProducto'); ?>">
                        <button class="btn btn-danger btn-block my-3">
                            Confirmar baja
                        </button>
                        <a href="/productos" class="btn btn-outline-secondary btn-block">
                            Volver a panel
                        </a>

                    </form>

                </div>
            </div>
        </article>

        <script>
           /* Swal.fire(
                'Advertencia',
                'Si pulsa el botón "Confirmar baja", se eliminará el producto.',
                'warning'
            )*/
        </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.plantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marcos/Documents/Cursos/Laravel/laravel-62846/catalogo/resources/views/productoDelete.blade.php ENDPATH**/ ?>