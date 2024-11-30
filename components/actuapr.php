<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Actualizar Producto</h1>
        <form action="actualizar_producto.php" method="post" enctype="multipart/form-data">
            <div class="field">
                <label class="label" for="id">ID</label>
                <div class="control">
                    <input class="input" type="text" id="id" name="id" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="nombre">Nombre</label>
                <div class="control">
                    <input class="input" type="text" id="nombre" name="nombre" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="marca">Marca</label>
                <div class="control">
                    <input class="input" type="text" id="marca" name="marca" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="precio">Precio</label>
                <div class="control">
                    <input class="input" type="number" id="precio" name="precio" step="0.01" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="stock">Stock</label>
                <div class="control">
                    <input class="input" type="number" id="stock" name="stock" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="imagen">Imagen</label>
                <div class="control">
                    <input class="input" type="file" id="imagen" name="imagen" accept="image/*">
                </div>
            </div>
            <div class="control">
                <button class="button is-primary" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
