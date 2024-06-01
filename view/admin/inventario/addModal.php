
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel"><i class="fa-solid fa-plus"></i>Agregar Producto</h1>
        <button type="button" class="btn-close cerrar" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        
          <form action="save.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre del Producto: </label>
              <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="img" class="form-label">Imagen: </label>
              <input type="file" name="img" id="img" class="form-control" accept="image/jpeg, image/png, image/jpg">
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción: </label>
              <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
              <label for="precio" class="form-label">Precio: </label>
              <input type="text" name="precio" id="precio" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="proveedor" class="form-label">Proveedor: </label>
              <select name="proveedor" id="proveedor" class="form-control" required>
                 <option value="">Seleccionar...</option>
                  <?php while($row_proveedor = $proveedores->fetch_assoc()){ ?>
                    <option value="<?php echo $row_proveedor["nit"]; ?>"><?= $row_proveedor["razonsocial"]?></option>

                  <?php } ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="stock" class="form-label">Stock: </label>
              <input type="text" name="stock" id="stock" class="form-control" required>
            </div>

            <div class="modal-btn">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> Cerrar</button>
              <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
            </div>
          </form>

      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>